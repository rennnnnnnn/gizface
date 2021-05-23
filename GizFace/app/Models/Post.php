<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use cebe\markdown\Markdown as Markdown;
use Illuminate\Http\Request;

class Post extends Model
{
    protected $guarded = ['id'];

    public function getAllRecord(): ?Collection
    {
        $result = self::select(
            'posts.id',
            'posts.profile_id',
            'posts.title',
            'posts.body',
            'posts.image_path',
            'posts.reply_count',
            'posts.retweet_count',
            'posts.favorite_count',
            'posts.created_user',
            'posts.updated_user',
            'posts.created_at',
            'post_categories.category',
            'profiles.profile_image_path'
        )
            ->Join('post_categories', 'post_categories.id', 'posts.post_category_id')
            ->Join('profiles', 'profiles.id', 'posts.profile_id')
            ->whereNull('posts.deleted_at')
            ->whereNull('post_categories.deleted_at')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();
        return $result;
    }

    /**
     * 検索ワードでlike検索　TODO
     *
     * @param array $searchWords
     * @return void
     */
    public function getRecordBySearchWords(array $searchWords)
    {
        $query = self::select(
            'posts.id',
            'posts.profile_id',
            'posts.title',
            'posts.body',
            'posts.image_path',
            'posts.reply_count',
            'posts.retweet_count',
            'posts.favorite_count',
            'posts.created_user',
            'posts.updated_user',
            'posts.created_at',
            'post_categories.category'
        )
            ->Join('post_categories', 'post_categories.id', 'posts.post_category_id')
            ->whereNull('posts.deleted_at')
            ->whereNull('post_categories.deleted_at');
        if (isset($searchWords['articleTitle']) && !is_null($searchWords['articleTitle'])) {
            $query->where('posts.title', 'like', '%' . $searchWords['articleTitle'] . '%');
        }
        if (isset($searchWords['articleCategory']) && !is_null($searchWords['articleCategory'])) {
            $query->where(function ($query) use ($searchWords) {
                foreach ($searchWords['articleCategory'] as $category) {
                    $query->orwhere('posts.post_category_id', $category);
                }
            });
        }
        $result = $query
            ->orderBy('id', 'desc')
            ->get();
        return $result;
    }

    /**
     * プロフィール詳細画面
     *
     * @param integer $profileId
     * @return Collection|null
     */
    public function getRecordByProfileId(int $profileId): ?Collection
    {
        $result = self::select(
            'posts.id',
            'posts.profile_id',
            'posts.title',
            'posts.body',
            'posts.image_path',
            'posts.reply_count',
            'posts.retweet_count',
            'posts.favorite_count',
            'posts.created_user',
            'posts.updated_user',
            'posts.created_at',
            'post_categories.category'
        )
            ->Join('post_categories', 'post_categories.id', 'posts.post_category_id')
            ->where('posts.profile_id', $profileId)
            ->whereNull('posts.deleted_at')
            ->whereNull('post_categories.deleted_at')
            ->orderBy('id', 'asc')
            ->get();
        return $result;
    }

    public function parse()
    {
        $parser = new Markdown();

        return $parser->parse($this->body);
    }

    public function getMarkdownBodyAttribute()
    {
        return $this->parse();
    }

    /**
     * レコード保存
     *
     * @param [type] $filePath
     * @param Request $request
     * @param string $userName
     * @return void
     */
    public function saveRecord($filePath = null, Request $request, string $userName)
    {
        self::fill([
            'profile_id' => $request->profileId,
            'post_category_id' => $request->category,
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $filePath,
            'created_user' => $userName
        ])->save();
    }

    /**
     * コメント投稿時、reply_count更新
     *
     * @param integer $id
     * @param integer $replyCount
     * @param string $now
     * @return void
     */
    public function updateRecordForComment(int $id, int $replyCount, string $now)
    {
        \DB::table('posts')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->update([
                'reply_count' => $replyCount,
                'updated_at' => $now
            ]);
    }

    /**
     * レコード存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function checkExistsRecord(int $id): bool
    {
        $result = \DB::table('posts')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->exists();
        return $result;
    }

    /**
     * idをキーにレコードを一件取得
     *
     * @param integer $id
     * @return void
     */
    public function getRecordById(int $id)
    {
        $result = self::select(
            'posts.id',
            'posts.profile_id',
            'posts.title',
            'posts.body',
            'posts.image_path',
            'posts.reply_count',
            'posts.retweet_count',
            'posts.favorite_count',
            'posts.created_user',
            'posts.updated_user',
            'posts.created_at',
            'post_categories.category',
            'profiles.profile_image_path'
        )
            ->Join('post_categories', 'post_categories.id', 'posts.post_category_id')
            ->Join('profiles', 'profiles.id', 'posts.profile_id')
            ->where('posts.id', $id)
            ->whereNull('posts.deleted_at')
            ->whereNull('post_categories.deleted_at')
            ->first();
        return $result;
    }

    /**
     * 投稿アップデート時 画像パス 取得
     *
     * @param integer $id
     * @return string\null
     */
    public function getImagePathById(int $id): ?string
    {
        $result = self::select(
            'image_path'
        )
            ->where('id', $id)
            ->whereNull('posts.deleted_at')
            ->first();
        if (empty($result->image_path)) {
            return null;
        };
        return $result->image_path;
    }

    /**
     * レコード更新
     *
     * @param [type] $filePath
     * @param Request $request
     * @param string $now
     * @param string $userName
     * @return void
     */
    public function updateRecord($filePath = null, Request $request, string $now, string $userName)
    {
        \DB::table('posts')
            ->where('id', $request->postId)
            ->whereNull('deleted_at')
            ->update([
                'profile_id' => $request->profileId,
                'post_category_id' => $request->category,
                'title' => $request->title,
                'body' => $request->body,
                'image_path' => $filePath,
                'updated_user' => $userName,
                'updated_at' => $now
            ]);
    }
}
