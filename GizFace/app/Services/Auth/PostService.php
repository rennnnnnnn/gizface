<?php

namespace App\Services\Auth;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostCategory;
use Carbon\Carbon;


class PostService
{
    private $postModel;
    private $commentModel;
    private $postCategoryModel;

    function __construct(
        Post $postModel,
        Comment $commentModel,
        PostCategory $postcategoryModel
    ) {
        $this->postModel = $postModel;
        $this->commentModel = $commentModel;
        $this->postCategoryModel = $postcategoryModel;
    }

    /**
     * top画面 最新の20件取得
     *
     * @return Collection|null
     */
    public function getAllPostList(): ?Collection
    {
        return $this->postModel->getAllRecord();
    }

    /**
     * プロフィール詳細画面
     *
     * @param integer $profileId
     * @return Collection
     */
    public function getPostInfoByProfileId(int $profileId): ?Collection
    {
        return $this->postModel->getRecordByProfileId($profileId);
    }

    /**
     * 投稿フォーム カテゴリーリスト
     *
     * @return array|null
     */
    public function getPostCategoryList(): ?array
    {
        return $this->postCategoryModel->getAllRecord();
    }

    /**
     * 投稿保存
     *
     * @param string $filePath
     * @param Request $request
     * @param string $userName
     * @return void
     */
    public function savePostRecord($filePath = null, Request $request, string $userName)
    {
        $this->postModel->saveRecord($filePath, $request, $userName);
    }

    /**
     * 投稿編集画面 投稿存在チェック
     *
     * @param integer $postId
     * @return boolean
     */
    public function checkExistsPostByPostId(int $postId): bool
    {
        return $this->postModel->checkExistsRecord($postId);
    }

    /**
     * postIdをキーにposts.TBLからレコード一件取得
     *
     * @param integer $postId
     * @return void
     */
    public function getPostInfoByPostId(int $postId)
    {
        return $this->postModel->getRecordById($postId);
    }

    /**
     * 投稿一件に紐付くコメントを取得
     *
     * @param integer $postId
     * @return void
     */
    public function getCommentListByPostId(int $postId): ?Collection
    {
        return $this->commentModel->getRecordByPostId($postId);
    }

    /**
     * posts.TBL更新時 image_papath取得
     *
     * @param integer $postId
     * @return string\null
     */
    public function getImagePathByPostId(int $postId): ?string
    {
        return $this->postModel->getImagePathById($postId);
    }

    /**
     * 投稿TBLをアップデート
     *
     * @param [type] $filePath
     * @param Request $request
     * @param string $now
     * @param string $userName
     * @return void
     */
    public function updatePostInfo($filePath = null, Request $request, string $now, string $userName)
    {
        // posts.TBL アップデート
        $this->postModel->updateRecord($filePath, $request, $now, $userName);
    }

    /**
     * コメント保存
     *
     * @param Request $request
     * @param array $loginUser
     * @param int $replyCount
     */
    public function saveComment(Request $request, array $loginUser, int $replyCount)
    {
        $postId = $request['postId'];
        $record = [
            'post_id' =>  $postId,
            'body' => $request['body'],
            'created_profile_id' => $loginUser['profileId'],
            'created_at' => Carbon::now(),
            'created_user' => $loginUser['userName']
        ];
        \DB::transaction(function () use ($record, $postId, $replyCount) {
            // posts.TBL更新
            $this->postModel->updateRecordForComment($postId, $replyCount, Carbon::now());
            // comment.TBL保存
            $this->commentModel->saveRecord($record);
        });
    }
}
