<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Profile extends Model
{
    protected $guarded = ['id'];
    protected $dates = [
        'joined_company_date',
        'joined_project_date'
    ];

    /**
     * AdminUser一覧画面 .全件取得
     *
     * @return void
     */
    public function getAllRecord()
    {
        $result = self::select(
            'profiles.id as profile_id',
            'profiles.user_id',
            'profiles.gender',
            'profiles.birthday',
            'profiles.description',
            'profiles.profile_image_path',
            'profiles.joined_company_date',
            'profiles.joined_project_date',
            'profiles.address',
            'profiles.github_url',
            'profiles.workplace_url',
            'profiles.department',
            'profiles.position',
            'profiles.job_type',
            'profiles.station',
            'profiles.waiting_flg',
            'users.name',
            'users.last_name',
            'users.first_name',
            'users.roma_name',
            'users.last_roma_name',
            'users.first_roma_name',
        )
            ->selectRaw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS age')
            ->Join('users', 'users.id', 'profiles.user_id')
            ->whereNull('profiles.deleted_at')
            ->whereNull('users.deleted_at')
            ->paginate(20);
        return $result;
    }


    /**
     * ログイン時プロフィール情報登録
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $birthday = $request->year . '-' . $request->month . '-' . $request->day;
        self::fill([
            'user_id' => $request->userId,
            'birthday' => $birthday,
            'gender' => $request->gender,
            'profile_image_path' => $request->avatar,
        ])->save();
    }

    /**
     * ログイン成功時、取得(sessionに格納)
     *
     * @param integer $userId
     * @return int
     */
    public function getIdByUserId(int $userId): int
    {
        $result = self::select('id')
            ->where('user_id', $userId)
            ->first();
        return $result->id;
    }

    /**
     * header avatar　取得
     *
     * @param integer $id
     * @return null\string
     */
    public function getAvatar(int $id): ?string
    {
        $result = self::select('profile_image_path')
            ->where('id', $id)
            ->first();
        if (empty($result->profile_image_path)) {
            return null;
        }
        return $result->profile_image_path;
    }


    /**
     * プロフィール詳細画面 プロフィール情報取得
     *
     * @param integer $id
     * @return Collection
     */
    public function getRecordById(int $id): Profile
    {
        $result = self::select(
            'profiles.id as profile_id',
            'profiles.user_id',
            'profiles.gender',
            'profiles.birthday',
            'profiles.description',
            'profiles.profile_image_path',
            'profiles.joined_company_date',
            'profiles.joined_project_date',
            'profiles.address',
            'profiles.github_url',
            'profiles.workplace_url',
            'profiles.department',
            'profiles.position',
            'profiles.job_type',
            'profiles.station',
            'users.name',
            'users.last_name',
            'users.first_name',
            'users.roma_name',
            'users.last_roma_name',
            'users.first_roma_name',
        )
            ->selectRaw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS age')
            ->Join('users', 'users.id', 'profiles.user_id')
            ->where('profiles.id', $id)
            ->first();
        return $result;
    }

    /**
     * プロフィール基本情報更新
     *
     * @param Request $request
     * @param string $birthday
     * @param string $now
     * @return void
     */
    public function updateRecord(Request $request, string $birthday, string $now)
    {
        if (is_null($request->joinedCompany)) {
            $joinedCompany = null;
        } else {
            $joinedCompany = new Carbon($request->joinedCompany);
            $joinedCompany = $joinedCompany->format('Y-m-d');
        }
        if (is_null($request->joinedProject)) {
            $joinedProject = null;
        } else {
            $joinedProject = new Carbon($request->joinedProject);
            $joinedProject = $joinedProject->format('Y-m-d');
        }

        \DB::table('profiles')
            ->where('id', $request->profileId)
            ->whereNull('deleted_at')
            ->update([
                'user_id' => $request->userId,
                'gender' => $request->gender,
                'birthday' => $birthday,
                'joined_company_date' => $joinedCompany,
                'joined_project_date' => $joinedProject,
                'address' => $request->address,
                'station' => $request->workPlace,
                'department' => $request->department,
                'position' => $request->position,
                'job_type' => $request->jobType,
                'github_url' => $request->github,
                'workplace_url' => $request->workPlaceUrl,
                'updated_at' => $now
            ]);
    }

    /**
     * プロフィール画像パス更新
     *
     * @param string $imgPath
     * @param integer $id
     * @param string $now
     * @return void
     */
    public function updateRecordForImagePath(string $imgPath, int $id, string $now)
    {
        \DB::table('profiles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->update([
                'profile_image_path' => $imgPath,
                'updated_at' => $now
            ]);
    }

    /**
     * プロフィール自己紹介更新
     *
     * @param Request $request
     * @param string $now
     * @return void
     */
    public function updateRecordForDescription(Request $request, string $now)
    {
        \DB::table('profiles')
            ->where('id', $request->profileId)
            ->whereNull('deleted_at')
            ->update([
                'description' => $request->description,
                'updated_at' => $now
            ]);
    }
}
