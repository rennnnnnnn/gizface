<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialProvider;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Socialite;
use Carbon\Carbon;

class OAuthController extends Controller
{

    private $user;
    private $profile;
    private $social;

    public function __construct(User $user, Profile $profile, SocialProvider $social)
    {
        $this->user = $user;
        $this->profile = $profile;
        $this->social = $social;
    }

    // Slack認証へ遷移
    public function redirectToProvider(Request $request)
    {
        // 検証用
        // $request->session()->forget('loginUser');

        // sessionが残っている場合リダイレクトなしでログイン
        if ($request->session()->has('loginUser')) {
            return redirect()->route('profile.index');
        }
        return Socialite::driver('slack')->redirect();
    }

    // Slackからのリダイレクト
    public function handleProviderCallback(Request $request)
    {
        try {
            $slackAccount = Socialite::driver('slack')->stateless()->user();

            // $slackAcount.user[‘id’] をキーにsocial_providers.TBL(unique_key)存在チェック
            $result = SocialProvider::where('unique_key', $slackAccount->id)->exists();
            // 二度目以降のログインの場合
            if ($result) {
                // $slackAcount.user[‘id’] をキーにsocial_providers.TBLレコード取得
                $socialProvider = SocialProvider::where('unique_key', $slackAccount->id)->first();
                // 取得したsocial_providers.TBLのuser_idをキーにusers.TBLのmember_status取得
                $user = User::where('id', $socialProvider->user_id)->first();
                // member_status = 1 (登録済み) の場合、ログイン完了(トップページへ遷移)[完了]
                if ($user->member_status) {
                    $this->setSession($request, $user->id, $user->name);
                    return redirect()->route('profile.index');
                    // member_status = 0 (仮登録)の場合、新規登録画面に遷移
                } else {
                    \Log::Info('secondLogin:新規登録開始');
                    return view('register', [
                        'slackAccount' => $slackAccount,
                        'userId' => $user->id
                    ]);
                }
                // social_providers.TBLにレコードが存在しない(初ログインユーザーの場合)
            } else {
                \Log::Info('firstLogin');

                $resultInfo = \DB::transaction(function () use ($slackAccount) {
                    // users.TBLを仮登録(member_statusカラムのみ0でインサート)
                    $userId = $this->user->proRegister();
                    // social_providers.TBLをインサート
                    $result = $this->social->register($userId, $slackAccount);
                    return [
                        'userId' => $userId,
                        'result' => $result,
                    ];
                });
                // インサート失敗時　login画面に戻る
                if (!$resultInfo['result']) {
                    \Session::flash('error_message', __('message.LOGIN_ERROR'));
                    $exceptionMsg = __('message.DB.0001');
                    \Log::Error($exceptionMsg);

                    return redirect()->to('/login');
                    // インサート成功時 新規登録画面に遷移
                } else {
                    \Log::Info('仮登録完了');
                    return view('register', [
                        'slackAccount' => $slackAccount,
                        'userId' => $resultInfo['userId']
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.LOGIN_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            // login画面に戻る
            return redirect()->to('/login');
        }
    }

    // user登録
    public function registerUser(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $this->user->register($request, Carbon::now());
                $this->profile->register($request);
            });
            \Log::Info('新規登録完了');
            $user = User::where('id', $request->userId)->first();
            $this->setSession($request, $request->userId, $user->name);

            return redirect()->route('profile.index');
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.LOGIN_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            // login画面に戻る
            return redirect()->to('/login');
        }
    }

    /**
     * ユーザー情報をセッションに格納
     * @param integer $userId
     * @param string $userName
     * @param request $request
     * @return void
     */
    private function setSession(Request $request, int $userId, string $userName)
    {
        $profileId = $this->profile->getIdByUserId($userId);
        $loginUser = [
            'userId' => $userId,
            'profileId' => $profileId,
            'userName' => $userName
        ];
        $request->session()->put('loginUser', serialize($loginUser));
        //ログインユーザ
        \Log::Info('ユーザーログイン: ' . json_encode($loginUser));
    }
}
