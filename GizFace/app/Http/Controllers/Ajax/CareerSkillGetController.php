<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfileService;

class CareerSkillGetController extends Controller
{
    private $profileService;

    //コンストラクタ
    function __construct(
        Request $request,
        ProfileService $profileService
    ) {
        $this->request = $request;
        $this->profileService = $profileService;
    }

    public function getSkill()
    {
        try {
            $skillList = $this->profileService->getProfileCareerSkill($this->request->profileId, $this->request->careerId);
            \Log::debug($skillList);
            if (!empty($skillList)) {
                $response['status'] = config('const.RESULT_CODE')['S0000'];
            }
            $response['skillList'] = $skillList;
            return json_encode($response);
        } catch (\Exception $e) {
            $response['status']    = config('const.RESULT_CODE')['E0000'];
            $exceptionMessage      = 'resultCode : [' . $response['status'] . ']' . $e->getFile() . ' ' . $e->getLine() . '行目 ' . $e->getMessage();
            $response["message"]   = 'エラーコード : [' . $response['status'] . ']';
            \Log::error($exceptionMessage);
            return json_encode($response);
            exit;
        }
    }
}
