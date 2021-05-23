<?php

namespace App\Services;

use App\Models\CareerDetail;
use App\Models\View\CareerJobProcess;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;


class ProfileService
{
    private $careerDetailModel;
    private $careerJobProcessModel;
    private $profileModel;

    function __construct(
        CareerDetail $careerDetailModel,
        CareerJobProcess $careerJobProcessModel,
        Profile $profileModel
    ) {
        $this->careerDetailModel = $careerDetailModel;
        $this->careerJobProcessModel = $careerJobProcessModel;
        $this->profileModel = $profileModel;
    }

    /**
     * 社員一覧画面全件取得
     * @return Collection|null
     */
    public function getAllProfileList(): ?Collection
    {
        return $this->careerDetailModel->getAllRecord();
    }

    /**
     * 一覧画面.取得した社員データをフォーマット
     *
     * @param Collection $profileAllList
     * @return array
     */
    public function formatProfileList(Collection $profileAllList): array
    {
        $temp = [];

        foreach ($profileAllList as $profileData) {
            // 統合元データが存在しない 新規作成
            if (!isset($temp[$profileData->profile_id])) {
                $profileData->skillList = $this->setSkillList($profileData->skill, $profileData->category_master_id, $profileData->experience_dete);
                $temp[$profileData->profile_id] = $profileData;
                // 統合元データが存在する マージ
            } else {
                $list = $temp[$profileData->profile_id];
                // merge
                $profileData->skillList = $this->setSkillMerge($profileData->skill, $profileData->category_master_id, $profileData->experience_dete, $list);
                $temp[$profileData->profile_id] = $profileData;
            }
        }
        // TODO: 30に変える
        if (count($temp) < 30) {
            return $temp;
        };

        $randomKeyList = array_rand($temp, 30);

        $randomProfileList = [];
        foreach ($randomKeyList as $key) {
            $randomProfileList[] = $temp[$key];
        }

        return $randomProfileList;
    }

    /**
     * 社員スキルリスト作成
     *
     * @param string $skill
     * @param integer $categoryId
     * @param string $exDate
     * @return array
     */
    private function setSkillList(string $skill, int $categoryId, string $exDate): array
    {
        $language = '';
        $fw = '';
        $db = '';
        $os = '';
        $role = '';
        $tool = '';
        $categoryConf = config('consts.categoryMaster');


        switch ($categoryId) {
            case $categoryConf['LANGUAGE']:
                $language = [
                    $skill => (int) $exDate
                ];
                break;
            case $categoryConf['FW']:
                $fw = [
                    $skill => (int) $exDate
                ];
                break;
            case $categoryConf['DB']:
                $db = [
                    $skill => (int) $exDate
                ];
                break;
            case $categoryConf['OS']:
                $os = [
                    $skill => (int) $exDate
                ];
                break;
            case $categoryConf['ROLE']:
                $role = [
                    $skill => (int) $exDate
                ];
                break;
            case $categoryConf['TOOL']:
                $tool = [
                    $skill => (int) $exDate
                ];
                break;
            default:
                break;
        }

        $skillTemp = [
            'language' => $language,
            'fw'  => $fw,
            'db'     => $db,
            'os'  => $os,
            'role' => $role,
            'tool' => $tool
        ];

        return $skillTemp;
    }

    /**
     * 社員スキルリストをmerge
     *,
     * @param string $skill
     * @param integer $categoryId
     * @param string $exDate
     * @param Collection $list
     * @return array
     */
    private function setSkillMerge(string $skill, int $categoryId, string $exDate, CareerDetail $list): array
    {
        $temp = $list->skillList;
        $categoryConf = config('consts.categoryMaster');

        switch ($categoryId) {
            case $categoryConf['LANGUAGE']:
                if (empty($temp['language'])) {
                    $temp['language'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    // 同じキー(スキル)が存在する場合、経験年数をプラスする
                    if (isset($temp['language'][$skill])) {
                        $sumDate = $temp['language'][$skill] += (int) $exDate;
                        $temp['language'][$skill] = $sumDate;
                    } else {
                        $temp['language'] = array_merge($temp['language'], [$skill => (int) $exDate]);
                    }
                }
                break;
            case $categoryConf['FW']:
                if (empty($temp['fw'])) {
                    $temp['fw'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    if (isset($temp['fw'][$skill])) {
                        $sumDate = $temp['fw'][$skill] += (int) $exDate;
                        $temp['fw'][$skill] = $sumDate;
                    } else {
                        $temp['fw'] = array_merge($temp['fw'], [$skill => (int) $exDate]);
                    }
                }
                break;
            case $categoryConf['DB']:
                if (empty($temp['db'])) {
                    $temp['db'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    if (isset($temp['db'][$skill])) {
                        $sumDate = $temp['db'][$skill] += (int) $exDate;
                        $temp['db'][$skill] = $sumDate;
                    } else {
                        $temp['db'] = array_merge($temp['db'], [$skill => (int) $exDate]);
                    }
                }
                break;
            case $categoryConf['OS']:
                if (empty($temp['os'])) {
                    $temp['os'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    if (isset($temp['os'][$skill])) {
                        $sumDate = $temp['os'][$skill] += (int) $exDate;
                        $temp['os'][$skill] = $sumDate;
                    } else {
                        $temp['os'] = array_merge($temp['os'], [$skill => (int) $exDate]);
                    }
                }
                break;
            case $categoryConf['ROLE']:
                if (empty($temp['role'])) {
                    $temp['role'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    if (isset($temp['role'][$skill])) {
                        $sumDate = $temp['role'][$skill] += (int) $exDate;
                        $temp['role'][$skill] = $sumDate;
                    } else {
                        $temp['role'] = array_merge($temp['role'], [$skill => (int) $exDate]);
                    }
                }
                break;
            case $categoryConf['TOOL']:
                if (empty($temp['tool'])) {
                    $temp['tool'] = [
                        $skill => (int) $exDate
                    ];
                } else {
                    if (isset($temp['tool'][$skill])) {
                        $sumDate = $temp['tool'][$skill] += (int) $exDate;
                        $temp['tool'][$skill] = $sumDate;
                    } else {
                        $temp['tool'] = array_merge($temp['tool'], [$skill => (int) $exDate]);
                    }
                }
                break;
            default:
                break;
        }

        $result =  [
            'language' => $temp['language'],
            'fw'  => $temp['fw'],
            'db'     => $temp['db'],
            'os'  => $temp['os'],
            'role' => $temp['role'],
            'tool' => $temp['tool']
        ];
        return $result;
    }

    /**
     * 職歴存在チェック(初期登録時は存在しない)
     *
     * @param integer $profileId
     * @return bool
     */
    public function checkExistsCareerDetailRecordByProfileId(int $profileId): bool
    {
        return $this->careerDetailModel->checkExistsRecord($profileId);
    }

    /**
     *  プロフィール詳細画面　ユーザーに職歴が存在しない場合、プロフィール情報を取得
     *
     * @param integer $profileId
     * @return Collection
     */
    public function getProfileInfoByProfileId(int $profileId): Profile
    {
        return $this->profileModel->getRecordById($profileId);
    }

    /**
     * プロフィール詳細画面 プロフィール詳細情報取得
     *
     * @param integer $profileId
     * @return Collection
     */
    public function getProfileInfo(int $profileId): Collection
    {
        return $this->careerDetailModel->getRecordByProfileId($profileId);
    }

    /**
     * プロフィール詳細画面 職歴詳細情報取得
     *
     * @param integer $profileId
     * @return Collection|null
     */
    public function getProfileCareerInfo(int $profileId): ?Collection
    {
        return $this->careerJobProcessModel->getRecordByProfileId($profileId);
    }

    /**
     * プロフィール詳細画面
     * profileIdとcareerIdに紐づくスキルを取得
     *
     * @param integer $profileId
     * @param integer $careerId
     * @return Collection|null
     */
    public function getProfileCareerSkill(int $profileId, int $careerId): ?Collection
    {
        return $this->careerDetailModel->getRecordByProfileIdAndCareerId($profileId, $careerId);
    }


    /**
     * AdminUser一覧画面. profileList取得
     */
    public function getAllProfileListForAdminUser()
    {
        return $this->profileModel->getAllRecord();
    }
}
