<?php

namespace App\Services;

use App\Models\CareerDetail;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class HeaderService
{
    private $careerDetailModel;
    private $postModel;

    function __construct(
        CareerDetail $careerDetailModel,
        Post $postModel
    ) {
        $this->careerDetailModel = $careerDetailModel;
        $this->postModel = $postModel;
    }

    /**
     * 検索条件をセッションに保存
     *
     * @param Request $request
     * @return array
     */
    public function saveSessionSearchWords(Request $request): array
    {
        if ($request->searchCategory === 'article') {
            if (isset($request->articleTitle) || isset($request->articleCategory)) {
                $request->flash();
                $articleCategory = !isset($request->articleCategory) ? null : $request->articleCategory;
                $articleTitle = $request->articleTitle;
                return [
                    'articleFlg' => true,
                    'articleCategory' => $articleCategory,
                    'articleTitle' => $articleTitle,
                ];
            } else {
                return [
                    'articleFlg' => true
                ];
            }
        } else {
            if (isset($request->searchSkill) || isset($request->userName) || isset($request->userAge)) {
                $request->flash();
                $skill = !isset($request->searchSkill) ? null : $request->searchSkill;
                $userName = empty($request->userName) ? null : $request->userName;
                $userBirthday = empty($request->userAge) ? null : $this->ageToBirthday($request->userAge);
                return [
                    'userNameFlg' => true,
                    'skill' => $skill,
                    'userName' => $userName,
                    'userBirthday' => $userBirthday,
                ];
            } else {
                return [
                    'userNameFlg' => true
                ];
            }
        }
    }

    /**
     * 年齢から生年月日に変換 header年齢検索
     *
     * @param integer $age
     * @return array
     */
    private function ageToBirthday(int $age): array
    {
        $start = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y') - $age - 1);
        $end = mktime(0, 0, 0, date('m'), date('d'), date('Y') - $age);
        return array(date('Y-m-d', $start), date('Y-m-d', $end));
    }


    /**
     * 検索ワードでユーザーリスト取得
     *
     * @param array $searchWords
     * @return Collection|null
     */
    public function getUserListBySearchWords(array $searchWords): ?Collection
    {
        return $this->careerDetailModel->getRecordBySearchWords($searchWords);
    }

    /**
     * 検索ワードで記事リスト取得
     *
     * @param array $searchWords
     * @return
     */
    public function getArticleListBySearchWords(array $searchWords)
    {
        return $this->postModel->getRecordBySearchWords($searchWords);
    }
}
