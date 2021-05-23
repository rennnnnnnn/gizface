<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use App\Services\Auth\TopService;
use App\Services\ProfileService;
use App\Services\FileService;
use App\Services\Auth\PostService;
use Carbon\Carbon;

class TopController extends Controller
{
    private $topService;
    private $profileService;
    private $fileService;
    private $postService;
    //コンストラクタ
    function __construct(
        Request $request,
        TopService $topService,
        ProfileService $profileService,
        FileService $fileService,
        PostService $postService
    ) {
        $this->request = $request;
        $this->topService = $topService;
        $this->profileService = $profileService;
        $this->fileService = $fileService;
        $this->postService = $postService;
    }

    public function index()
    {
        try {
            // 職歴更新、削除後の場合
            if (!is_null(session('profileId'))) {
                $profileId = session('profileId');
                // 通常遷移時
            } else {
                $loginUser = unserialize($this->request->session()->get('loginUser'));
                $profileId = $loginUser['profileId'];
            }

            // ユーザーに職歴が存在するかチェック
            $result = $this->profileService->checkExistsCareerDetailRecordByProfileId($profileId);

            if ($result) {
                // profile_idをキーにprofiles.TBLから社員詳細情報取得(スキルjoin)
                $profileDetail = $this->profileService->getProfileInfo($profileId);
                // 複数のスキルが存在する場合は同一のprofileデータが複数件取得されるため統合する
                // 取得したデータの中のカテゴリーコード別にデータ配列を再作成
                $formatedProfileSkillInfo = $this->profileService->formatProfileList($profileDetail);
                $profileInfo = $formatedProfileSkillInfo[$profileId];

                $skillInfo = $formatedProfileSkillInfo[$profileId]->skillList;
                // 誕生日を年、月、日に分割
                $birthDayList = $this->formatBirthday($formatedProfileSkillInfo[$profileId]->birthday);
                // 職歴詳細情報取得
                $profileCareerInfo = $this->profileService->getProfileCareerInfo($profileId);
                // ユーザーの最新の職歴に紐づくスキルを取得
                $initialCareerId = $profileCareerInfo[0]->id;
                $profileCareerSkill = $this->profileService->getProfileCareerSkill($profileId, $initialCareerId);
            } else {
                // ユーザーに職歴が存在しない場合、プロフィール情報のみ取得
                $profileInfo = $this->profileService->getProfileInfoByProfileId($profileId);
                // 誕生日を年、月、日に分割
                $birthDayList = $this->formatBirthday($profileInfo->birthday);
                $profileCareerInfo = null;
                $profileCareerSkill = null;
                $skillInfo = null;
            }

            // ユーザーの投稿を取得
            $postInfo = $this->postService->getPostInfoByProfileId($profileId);
            return view('auth.top', [
                'profileId' => $profileId,
                'profileInfo' => $profileInfo, // プロフィール情報
                'year' => json_encode($birthDayList[0]), // 誕生日、年
                'month' => json_encode($birthDayList[1]), // 誕生日、月
                'day' => json_encode($birthDayList[2]), // 誕生日、日
                'skillInfo' => $skillInfo, // 全スキル
                'careerInfo' => $profileCareerInfo, // 職歴nav
                'careerSkillInfo' => $profileCareerSkill, // 職歴nav
                'postInfo' => $postInfo // 投稿
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    // 名前更新.ajax
    public function nameUpdate()
    {
        try {
            $this->topService->updateUserInfo($this->request, Carbon::now());
            session()->flash('flash_message', __('message.DB.0002'));
        } catch (\Exception $e) {
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
        }
    }

    // プロフィール画像更新
    public function fileUpload()
    {
        try {
            $file = $this->request->file('selectFile');
            if (env('APP_ENV') === 'local') {
                $filePath = $this->fileService->uploadFileForLocal($file);
            } else {
                // s3にアップロード
                $filePath = $this->fileService->uploadFile($file);
            }

            $this->topService->updateProfileImagePath($filePath, $_POST['profileId'], Carbon::now());
            // ユーザー画面.topに遷移
            return redirect()->route('user.top')->withInput()->with(
                [
                    'profileId' => $_POST['profileId'],
                    'flash_message' => __('message.DB.0002')
                ]
            );
        } catch (\Exception $e) {
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
        }
    }

    // 基本情報更新.ajax
    public function update()
    {
        try {
            $this->topService->updateProfileInfo($this->request, Carbon::now());
            session()->flash('flash_message', __('message.DB.0002'));
        } catch (\Exception $e) {
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
        }
    }


    // 自己紹介更新
    public function descriptionUpdate()
    {
        try {
            $this->topService->updateDescriptionInfo($this->request, Carbon::now());
            session()->flash('flash_message', __('message.DB.0002'));
        } catch (\Exception $e) {
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
        }
    }

    public function logout()
    {
        $this->request->session()->forget('loginUser');
        \Log::Info('logout');
        return redirect()->to('/login');
    }

    /**
     * 誕生日を年、月、日に分割
     *
     * @param string $birthday
     * @return array $birthdayList
     */
    private function formatBirthday(string $birthday): array
    {
        $birthday = date('Y-m-d', strtotime($birthday));
        $birthDayList = list($year, $month, $day) = explode('-', $birthday);
        return $birthDayList;
    }
}
