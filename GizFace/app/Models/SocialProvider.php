<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $guarded = ['id'];

    /**
     * 初ログイン時インサート
     *
     * @param integer $userId
     * @param [type] $slackAccount
     * @return bool
     */
    public function register(int $userId, $slack): bool
    {
        $result = self::fill([
            'user_id' => $userId,
            'provider_id' => $slack->user['team']['id'],
            'provider_name' => 'slack',
            'unique_key' => $slack->id
        ])->save();
        return $result;
    }
}
