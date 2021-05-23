<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

// careers.TBL,job_processes.TBLを結合したviewTBL(参照用)
class CareerJobProcess extends Model
{
    protected $guarded = ['id'];

    /**
     * プロフィール詳細画面 職歴詳細情報取得
     *
     * @param integer $profileId
     * @return Collection|null
     */
    public function getRecordByProfileId(int $profileId): ?Collection
    {
        $result = self::select(
            '*'
        )
            ->where('profile_id', $profileId)
            ->orderBy('sort', 'desc')
            ->get();
        return $result;
    }

    /**
     * ユーザー.職歴詳細画面 職歴詳細情報一件取得
     *
     * @param integer $profileId
     * @param integer $id
     * @return void
     */
    public function getRecordByProfileIdAndId(int $profileId, int $id)
    {
        $result = self::select(
            '*'
        )
            ->where('id', $id)
            ->where('profile_id', $profileId)
            ->first();
        return $result;
    }
}
