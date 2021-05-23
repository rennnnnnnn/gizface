<?php

namespace App\Services\Auth;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

class TopService
{
    private $profileModel;
    private $userModel;
    function __construct(
        Profile $profileModel,
        User $userModel
    ) {
        $this->profileModel = $profileModel;
        $this->userModel = $userModel;
    }

    /**
     * プロフィールアバター更新
     *
     * @param array $filePath
     * @param integer $profileId
     * @param string $now
     * @return void
     */
    public function updateProfileImagePath(string $filePath, int $profileId, string $now)
    {
        $this->profileModel->updateRecordForImagePath($filePath, $profileId, $now);
    }

    /**
     * プロフィール名前編集
     *
     * @param Request $request
     * @param string $now
     * @return void
     */
    public function updateUserInfo(Request $request, string $now)
    {
        $name = $request->lastName . ' ' . $request->firstName;
        $romaName = $request->lastRomaName . ' ' . $request->firstRomaName;
        $this->userModel->updateRecord($request, $name, $romaName, $now);
    }

    /**
     * プロフィール基本情報編集
     *
     * @param Request $request
     * @param array $loginUser
     * @param string $now
     * @return void
     */
    public function updateProfileInfo(Request $request, string $now)
    {
        $birthday = $request->year . '-' . $request->month . '-' . $request->day;
        $this->profileModel->updateRecord($request, $birthday, $now);
    }

    /**
     * プロフィール自己紹介編集
     *
     * @param Request $request
     * @param string $now
     * @return void
     */
    public function updateDescriptionInfo(Request $request, string $now)
    {
        $this->profileModel->updateRecordForDescription($request, $now);
    }
}
