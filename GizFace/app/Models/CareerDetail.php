<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CareerDetail extends Model
{
    protected $guarded = ['id'];

    /**
     * 職歴存在チェック(初期登録時は存在しない)
     * @return bool
     */
    public function checkExistsRecord(int $profileId): bool
    {
        $result = \DB::table('career_details')
            ->where('profile_id', $profileId)
            ->exists();
        return $result;
    }

    /**
     * 社員一覧画面全件取得
     * @return Collection|null
     */
    public function getAllRecord(): ?Collection
    {
        $result = self::select(
            'profiles.id as profile_id',
            'profiles.profile_image_path',
            'profiles.joined_company_date',
            'users.name',
            'users.roma_name',
            'profiles.birthday',
            'careers.id as careers_id',
            'careers.to',
            'careers.from',
            'skill_masters.id as skill_master_id',
            'skill_masters.skill',
            'category_masters.category',
            'category_masters.id as category_master_id'
        )
            ->selectRaw('sum(DATEDIFF(IF(`to` is null, now(), `to`), `from`)) AS experience_dete')
            ->selectRaw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS age')
            ->Join('careers', 'career_details.career_id', 'careers.id')
            ->Join('profiles', 'career_details.profile_id', 'profiles.id')
            ->Join('users', 'users.id', 'profiles.user_id')
            ->Join('skill_masters', 'career_details.skill_master_id', 'skill_masters.id')
            ->Join('category_masters', 'skill_masters.category_id', 'category_masters.id')
            ->groupBy('skill_masters.id', 'profiles.birthday', 'profiles.id', 'careers.id', 'careers.to', 'careers.from')
            ->get();
        return $result;
    }

    /**
     * プロフィール詳細画面 プロフィール詳細情報取得
     *
     * @param integer $profileId
     * @return Collection
     */
    public function getRecordByProfileId(int $profileId): Collection
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
            'careers.id as careers_id',
            'careers.to',
            'careers.from',
            'skill_masters.id as skill_master_id',
            'skill_masters.skill',
            'category_masters.category',
            'category_masters.id as category_master_id'
        )
            ->selectRaw('sum(DATEDIFF(IF(`to` is null, now(), `to`), `from`)) AS experience_dete')
            ->selectRaw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS age')
            ->Join('careers', 'career_details.career_id', 'careers.id')
            ->Join('profiles', 'career_details.profile_id', 'profiles.id')
            ->Join('users', 'users.id', 'profiles.user_id')
            ->Join('skill_masters', 'career_details.skill_master_id', 'skill_masters.id')
            ->Join('category_masters', 'skill_masters.category_id', 'category_masters.id')
            ->groupBy('skill_masters.id', 'profiles.birthday', 'profiles.id', 'careers.id', 'careers.to', 'careers.from')
            ->where('profiles.id', $profileId)
            ->get();
        return $result;
    }

    /**
     * プロフィール.IDと職歴.IDに紐づくスキルを取得
     *
     * @param integer $profileId
     * @param integer $careerId
     * @return Collection
     */
    public function getRecordByProfileIdAndCareerId(int $profileId, int $careerId): Collection
    {
        $result  = self::select(
            'skill_masters.id as skill_master_id',
            'skill_masters.skill',
            'category_masters.category',
            'category_masters.id as category_master_id'
        )
            ->Join('skill_masters', 'career_details.skill_master_id', 'skill_masters.id')
            ->Join('category_masters', 'skill_masters.category_id', 'category_masters.id')
            ->where('profile_id', $profileId)
            ->where('career_id', $careerId)
            ->get();
        return $result;
    }

    /**
     * header ユーザー検索一覧取得
     *
     * @param array $searchWords
     * @return Collection|null
     */
    public function getRecordBySearchWords(array $searchWords): ?Collection
    {
        $query = self::select(
            'profiles.id as profile_id',
            'profiles.profile_image_path',
            'profiles.joined_company_date',
            'users.name',
            'users.roma_name',
            'profiles.birthday',
            'careers.id as careers_id',
            'careers.to',
            'careers.from',
            'skill_masters.id as skill_master_id',
            'skill_masters.skill',
            'category_masters.category',
            'category_masters.id as category_master_id'
        )
            ->selectRaw('sum(DATEDIFF(IF(`to` is null, now(), `to`), `from`)) AS experience_dete')
            ->selectRaw('TIMESTAMPDIFF(YEAR, `birthday`, CURDATE()) AS age')
            ->Join('careers', 'career_details.career_id', 'careers.id')
            ->Join('profiles', 'career_details.profile_id', 'profiles.id')
            ->Join('users', 'users.id', 'profiles.user_id')
            ->Join('skill_masters', 'career_details.skill_master_id', 'skill_masters.id')
            ->Join('category_masters', 'skill_masters.category_id', 'category_masters.id')
            ->groupBy('skill_masters.id', 'profiles.birthday', 'profiles.id', 'careers.id', 'careers.to', 'careers.from');
        if (isset($searchWords['userName']) && !is_null($searchWords['userName'])) {
            $query->where(function ($query) use ($searchWords) {
                $query->where('users.name', 'like', '%' . $searchWords['userName'] . '%')
                    ->orwhere('users.roma_name', 'like', '%' . $searchWords['userName'] . '%');
            });
        }
        if (isset($searchWords['userBirthday']) && !is_null($searchWords['userBirthday'])) {
            $query->whereBetween('profiles.birthday', [$searchWords['userBirthday'][0], $searchWords['userBirthday'][1]]);
        }

        if (isset($searchWords['skill']) && !is_null($searchWords['skill'])) {
            $query->where(function ($query) use ($searchWords) {
                foreach ($searchWords['skill'] as $skill) {
                    $query->orwhere('skill_masters.skill', $skill);
                }
            });
        }
        $result = $query
            ->get();
        return $result;
    }

    /**
     * レコードインサート
     *
     * @param array $saveList
     * @return void
     */
    public function insertRecord(array $saveList)
    {
        self::insert($saveList);
    }

    /**
     * レコードを物理削除
     */
    public function deleteRecordByCareerIdAndProfileId(int $careerId, int $profileId)
    {
        self::where('career_id', $careerId)
            ->where('profile_id', $profileId)
            ->delete();
    }
}
