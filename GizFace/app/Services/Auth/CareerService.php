<?php

namespace App\Services\Auth;

use App\Models\SkillMaster;
use App\Models\Career;
use App\Models\CareerDetail;
use App\Models\JobProcess;
use App\Models\View\CareerJobProcess;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CareerService
{
    private $skillMasterModel;
    private $careerModel;
    private $careerDetailModel;
    private $jobProcessModel;
    private $careerJobProcessModel;


    function __construct(
        SkillMaster $skillMasterModel,
        Career $careerModel,
        CareerDetail $careerDetailModel,
        JobProcess $jobProcessModel,
        CareerJobProcess $careerJobProcessModel
    ) {
        $this->skillMasterModel = $skillMasterModel;
        $this->careerModel = $careerModel;
        $this->careerDetailModel = $careerDetailModel;
        $this->jobProcessModel = $jobProcessModel;
        $this->careerJobProcessModel = $careerJobProcessModel;
    }

    public function getSkilllMaster()
    {
        return $this->skillMasterModel->getSkillList();
    }

    /**
     * 職歴関連TBLにインサート
     *
     * @param Request $request
     * @param string $userName
     * @return void
     */
    public function saveRecord(Request $request, string $userName)
    {
        $sort = 1;

        $result = $this->careerModel->checkExistsRecord($request->profileId);
        if ($result) {
            // ユーザーの最新のcareers.TBLのsortNoを取得
            $careerSort = $this->careerModel->checkLatestSortByProfileId($request->profileId);
            $sort = $careerSort->sort;
            $sort++;
        }

        // careers.TBL,career_details.TBL,job_processes.TBLにインサート
        \DB::transaction(function () use ($request, $sort, $userName) {
            // careers.TBLインサート
            $careerId = $this->careerModel->insertRecord($request, $sort);

            // career_details.TBL保存リスト作成
            $careerDetailSaveList = $this->createCareerDetailArrayForSave($request->profileId, $careerId, $request->language, $request->fw, $request->db, $request->os, $request->role, $request->tool, $userName);

            // career_details.TBLインサート
            if (!empty($careerDetailSaveList)) {
                $this->careerDetailModel->insertRecord($careerDetailSaveList);
            };

            // job_processes.TBL保存リスト作成
            $unique = array_unique($request->process);
            foreach ($unique as $row) {
                if (is_null($row)) {
                    continue;
                }
                $saveList[] = [
                    'career_id'  => $careerId,
                    'process'    => $row,
                ];
            }
            if (isset($saveList)) {
                // job_processes.TBLインサート
                $this->jobProcessModel->insertRecord($saveList);
            }
        });
    }

    /**
     * career_details.TBL保存リスト作成
     *
     * @param integer $profileId
     * @param integer $careerId
     * @param array $language
     * @param array $fw
     * @param array $db
     * @param array $os
     * @param array $role
     * @param array $tool
     * @param string $userName
     * @return array|null
     */
    private function createCareerDetailArrayForSave(int $profileId, int $careerId, array $language, array $fw, array $db, array $os, array $role, array $tool, string $userName): ?array
    {
        $saveList = [];
        $categoryMasterConf = config('consts.categoryMaster');
        // カテゴリーマスター.id = 1
        foreach ($language as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['LANGUAGE']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['LANGUAGE'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        foreach ($fw as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['FW']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['FW'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        foreach ($db as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['DB']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['DB'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        foreach ($os as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['OS']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['OS'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        foreach ($role as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['ROLE']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['ROLE'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        foreach ($tool as $row) {
            if (is_null($row)) {
                continue;
            }
            // skill_masters.TBLにレコードが存在するかチェック
            $result = $this->skillMasterModel->checkExistsRecordBySkill($row, $categoryMasterConf['TOOL']);
            //　レコードがない場合、skill_masters.TBLにインサート
            if (!$result) {
                $skillMasterId = $this->skillMasterModel->insertRecord($row, $categoryMasterConf['TOOL'], $userName);
            } else {
                $skillMasterId = $this->skillMasterModel->getIdBySkill($row)->id;
            }

            $saveList[] = [
                'career_id'  => $careerId,
                'profile_id'    => $profileId,
                'skill_master_id'   => $skillMasterId,
            ];
        }
        return $saveList;
    }

    /**
     * ユーザー.職歴詳細画面
     * profileIdとcareerIdに紐づくスキルを取得
     *
     * @param integer $profileId
     * @param integer $careerId
     */
    public function getProfileCareerSkill(int $profileId, int $careerId)
    {   // 職歴に紐づくスキルを取得
        $profileCareerSkill = $this->careerDetailModel->getRecordByProfileIdAndCareerId($profileId, $careerId);
        // カテゴリー別にスキルリストを整形(動的なinput用)
        $formatedSkillList = $this->formatSkillList($profileCareerSkill);
        return $formatedSkillList;
    }

    /**
     * ユーザー画面.職歴編集画面 json用にカテゴリー毎に配列を作成
     */
    private function formatSkillList($profileCareerSkill)
    {
        $language = [];
        $fw = [];
        $db = [];
        $os = [];
        $role = [];
        $tool = [];
        $categoryConf = config('consts.categoryMaster');
        foreach ($profileCareerSkill as $row) {
            switch ($row->category_master_id) {
                case $categoryConf['LANGUAGE']:
                    $language[] = [
                        $row->skill
                    ];
                    break;
                case $categoryConf['FW']:
                    $fw[] = [
                        $row->skill
                    ];
                    break;
                case $categoryConf['DB']:
                    $db[] = [
                        $row->skill
                    ];
                    break;
                case $categoryConf['OS']:
                    $os[] = [
                        $row->skill
                    ];
                    break;
                case $categoryConf['ROLE']:
                    $role[] = [
                        $row->skill
                    ];
                    break;
                case $categoryConf['TOOL']:
                    $tool[] = [
                        $row->skill
                    ];
                    break;
                default:
                    break;
            }
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
     * career_idをキーにcareers.TBL存在チェック
     *
     * @param integer $careerId
     * @return boolean
     */
    public function checkExistsCareerByProfileIdAndCareerId(int $careerId): bool
    {
        return $this->careerModel->checkExistsRecordByProfileIdAndId($careerId);
    }

    /**
     * career_idをキーにcareers.TBLからレコード一件取得
     *
     * @param integer $profileId
     * @param integer $careerId
     * @return void
     */
    public function getCareerInfoByCareerId(int $careerId)
    {
        return $this->careerModel->getRecordById($careerId);
    }

    /**
     * career_idをキーにjob_processes.TBLから取得
     *
     * @param integer $careerId
     * @return array|null
     */
    public function getJobProcessInfoByCareerId(int $careerId): ?array
    {
        return $this->jobProcessModel->getRecordByCareerId($careerId);
    }

    /**
     * 職歴関連TBLをアップデート
     *
     * @param Request $request
     * @param string $now
     * @param string $userName
     * @return void
     */
    public function updateCareerInfo(Request $request, string $now, string $userName)
    {
        // careers.TBL,career_details.TBL,job_processes.TBL アップデート
        \DB::transaction(function () use ($request, $now, $userName) {
            // careers.TBL アップデート
            $this->careerModel->updateRecord($request, $now);

            // career_details.TBL物理削除
            $this->careerDetailModel->deleteRecordByCareerIdAndProfileId($request->careerId, $request->profileId);

            // career_details.TBL保存リスト作成
            $careerDetailSaveList = $this->createCareerDetailArrayForSave($request->profileId, $request->careerId, $request->language, $request->fw, $request->db, $request->os, $request->role, $request->tool, $userName);

            // career_details.TBLインサート
            if (!empty($careerDetailSaveList)) {
                $this->careerDetailModel->insertRecord($careerDetailSaveList);
            };

            // job_processes.TBL物理削除
            $this->jobProcessModel->deleteRecordByCareerId($request->careerId);
            // job_processes.TBL保存リスト作成
            $unique = array_unique($request->process);
            foreach ($unique as $row) {
                if (is_null($row)) {
                    continue;
                }
                $saveList[] = [
                    'career_id'  => $request->careerId,
                    'process'    => $row,
                ];
            }
            if (isset($saveList)) {
                // job_processes.TBLインサート
                $this->jobProcessModel->insertRecord($saveList);
            }
        });
    }

    /**
     * 職歴関連TBLを削除
     *
     * @param Request $request
     * @return void
     */
    public function deleteCareerInfo(Request $request)
    {
        // careers.TBL,career_details.TBL,job_processes.TBL 削除
        \DB::transaction(function () use ($request) {
            // careers.TBL 論理削除
            $this->careerModel->deleteRecord($request->careerId);

            // career_details.TBL物理削除
            $this->careerDetailModel->deleteRecordByCareerIdAndProfileId($request->careerId, $request->profileId);

            // job_processes.TBL物理削除
            $this->jobProcessModel->deleteRecordByCareerId($request->careerId);
        });
    }
}
