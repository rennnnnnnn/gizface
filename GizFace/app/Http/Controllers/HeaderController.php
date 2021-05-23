<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HeaderService;
use App\Services\ProfileService;

class HeaderController extends Controller
{
    private $headerService;
    private $profileService;

    //コンストラクタ
    function __construct(
        Request $request,
        HeaderService $headerService,
        ProfileService $profileService
    ) {
        $this->request = $request;
        $this->headerService = $headerService;
        $this->profileService = $profileService;
    }


    public function search()
    {
        try {

            $searchWords = $this->headerService->saveSessionSearchWords($this->request);

            // 検索対象が記事の場合
            if (isset($searchWords['articleFlg'])) {
                $articleSearchList = $this->headerService->getArticleListBySearchWords($searchWords);
                return view('profile.top', [
                    'postList' => $articleSearchList
                ]);
                // 検索対象がユーザーの場合
            } else {
                $userSearchList = $this->headerService->getUserListBySearchWords($searchWords);
                $formatedProfileList = null;
                if (!empty($userSearchList)) {
                    // 複数のスキルが存在する場合は同一のprofileデータが複数件取得されるため統合する
                    // 取得したデータの中のカテゴリーコード別にデータ配列を再作成
                    $formatedProfileList = $this->profileService->formatProfileList($userSearchList);
                }
                return view('profile.top', [
                    'profileRandomList' => $formatedProfileList,
                ]);
            }
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }
}
