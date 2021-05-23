<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Comment extends Model
{
    protected $guarded = ['id'];

    /**
     * 投稿一件にに紐付くコメントを取得
     *
     * @param integer $postId
     * @return void
     */
    public function getRecordByPostId(int $postId): ?Collection
    {
        $result = self::select(
            '*',
            'profiles.profile_image_path'
        )
            ->Join('profiles', 'profiles.id', 'comments.created_profile_id')
            ->where('post_id', $postId)
            ->get();
        return $result;
    }

    /**
     * コメント保存
     *
     * @param array $record
     */
    public function saveRecord(array $record)
    {
        self::insert($record);
    }
}
