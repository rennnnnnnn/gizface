<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use App\Services\Auth\PostService;
use Carbon\Carbon;

class ProfileController extends Controller
{
    private $profileService;
    private $postService;

    //コンストラクタ
    function __construct(
        Request $request,
        ProfileService $profileService,
        PostService $postService
    ) {
        $this->request = $request;
        $this->profileService = $profileService;
        $this->postService = $postService;
    }

    public function index()
    {
        try {
            // profiles.TBLから全件取得
            $profileAllList = $this->profileService->getAllProfileList();

            $formatedProfileList = null;
            if (!empty($profileAllList)) {
                // 複数のスキルが存在する場合は同一のprofileデータが複数件取得されるため統合する
                // 取得したデータの中のカテゴリーコード別にデータ配列を再作成
                $formatedProfileList = $this->profileService->formatProfileList($profileAllList);
            }
            // posts.TBLから最新の記事20件取得
            $postList = $this->postService->getAllPostList();

            return view('profile.top', [
                'profileRandomList' => $formatedProfileList,
                'postList' => $postList,
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function show()
    {

        try {
            $profileId = (int) $_GET['id'];
            // profile_idをキーにprofiles.TBLから社員詳細情報取得
            $profileInfo = $this->profileService->getProfileInfo($profileId);

            if (empty($profileInfo)) {
                \Session::flash('error_message', __('message.DB.0003'));
                return view('profile.top');
            }
            // 複数のスキルが存在する場合は同一のprofileデータが複数件取得されるため統合する
            // 取得したデータの中のカテゴリーコード別にデータ配列を再作成
            $formatedProfileSkillInfo = $this->profileService->formatProfileList($profileInfo);

            $profileCareerSkill = null;
            // 職歴詳細情報取得
            $profileCareerInfo = $this->profileService->getProfileCareerInfo($profileId);
            if (!empty($profileCareerInfo)) {
                $initialCareerId = $profileCareerInfo[0]->id;

                // 個人が持つ一つ目の職歴に紐づくスキルを取得
                $profileCareerSkill = $this->profileService->getProfileCareerSkill($profileId, $initialCareerId);
            }
            // ユーザーの投稿を取得
            $postInfo = $this->postService->getPostInfoByProfileId($profileId);
            return view('profile.detail', [
                'profileInfo' => $formatedProfileSkillInfo[$profileId], // プロフィール情報
                'skillInfo' => $formatedProfileSkillInfo[$profileId]->skillList, // 全スキル
                'careerInfo' => $profileCareerInfo, // 職歴nav
                'careerSkillInfo' => $profileCareerSkill, // 職歴nav
                'postInfo' => $postInfo
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }
}
