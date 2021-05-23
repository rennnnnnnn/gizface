<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use Illuminate\Http\Request;
use App\Services\Auth\CareerService;
use App\Services\ProfileService;
use Carbon\Carbon;

class CareerController extends Controller
{
    private $careerService;
    private $profileService;

    //コンストラクタ
    function __construct(
        Request $request,
        CareerService $careerService,
        ProfileService $profileService
    ) {
        $this->request = $request;
        $this->careerService = $careerService;
        $this->profileService = $profileService;
    }

    public function create()
    {
        try {
            $skillMasterInfo = $this->careerService->getSkilllMaster();
            $language = [];
            $fw = [];
            $db = [];
            $os = [];
            $role = [];
            $tool = [];

            $processConf = array_values(config('consts.jobProcess'));
            $categoryConf = config('consts.categoryMaster');
            foreach ($skillMasterInfo as $row) {
                if ($row->category_id === $categoryConf['LANGUAGE']) {
                    $language = array_merge($language, array($row->skill));
                } elseif ($row->category_id === $categoryConf['FW']) {
                    $fw = array_merge($fw, array($row->skill));
                } elseif ($row->category_id === $categoryConf['DB']) {
                    $db = array_merge($db, array($row->skill));
                } elseif ($row->category_id === $categoryConf['OS']) {
                    $os = array_merge($os, array($row->skill));
                } elseif ($row->category_id === $categoryConf['ROLE']) {
                    $role = array_merge($role, array($row->skill));
                } elseif ($row->category_id === $categoryConf['TOOL']) {
                    $tool = array_merge($tool, array($row->skill));
                }
            }
            return view('auth.career.create', [
                //TODO
                'profileId' => $this->request->profileId,
                'language' => json_encode($language), // 使用言語
                'fw' => json_encode($fw), // fw
                'db' => json_encode($db), // db
                'os' => json_encode($os), // os
                'role' => json_encode($role), // 役割
                'tool' => json_encode($tool), // ツール
                'process' => $processConf // 担当工程
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function save(CareerRequest $request)
    {
        try {
            $loginUser = unserialize($this->request->session()->get('loginUser'));
            $this->careerService->saveRecord($request, $loginUser['userName']);
            // ユーザー画面.topに遷移
            return redirect()->route('user.top')->withInput()->with(
                [
                    'profileId' => $request->profileId,
                    'flash_message' => __('message.DB.0002')
                ]
            );
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function edit()
    {
        try {
            $profileId = $this->request->profileId;
            $careerId = $this->request->careerId;
            // 職歴存在チェック
            $result = $this->careerService->checkExistsCareerByProfileIdAndCareerId($careerId);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->with('error_message', __('message.DB.0003'));
            }

            // 職歴詳細情報取得
            $careerInfo = $this->careerService->getCareerInfoByCareerId($careerId);

            // 職歴に紐づくスキルを取得
            $careerSkill = $this->careerService->getProfileCareerSkill($profileId, $careerId);
            // 職歴に紐づく工程を取得
            $processInfo = $this->careerService->getJobProcessInfoByCareerId($careerId);

            $skillMasterInfo = $this->careerService->getSkilllMaster();
            $language = [];
            $fw = [];
            $db = [];
            $os = [];
            $role = [];
            $tool = [];

            $processConf = array_values(config('consts.jobProcess'));
            $categoryConf = config('consts.categoryMaster');
            foreach ($skillMasterInfo as $row) {
                if ($row->category_id === $categoryConf['LANGUAGE']) {
                    $language = array_merge($language, array($row->skill));
                } elseif ($row->category_id === $categoryConf['FW']) {
                    $fw = array_merge($fw, array($row->skill));
                } elseif ($row->category_id === $categoryConf['DB']) {
                    $db = array_merge($db, array($row->skill));
                } elseif ($row->category_id === $categoryConf['OS']) {
                    $os = array_merge($os, array($row->skill));
                } elseif ($row->category_id === $categoryConf['ROLE']) {
                    $role = array_merge($role, array($row->skill));
                } elseif ($row->category_id === $categoryConf['TOOL']) {
                    $tool = array_merge($tool, array($row->skill));
                }
            }

            return view('auth.career.edit', [
                'profileId' => $profileId,
                'careerId' => $careerId,
                'language' => json_encode($language), // 使用言語
                'fw' => json_encode($fw), // fw
                'db' => json_encode($db), // db
                'os' => json_encode($os), // os
                'role' => json_encode($role), // 役割
                'tool' => json_encode($tool), // ツール
                'process' => $processConf, // 担当工程
                'careerInfo' => $careerInfo, // 職歴詳細情報取得
                'careerSkill' => json_encode($careerSkill), // 職歴に紐づくスキル
                'processInfo' => json_encode($processInfo), // 職歴に紐づく工程
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function update(CareerRequest $request)
    {
        try {
            $loginUser = unserialize($this->request->session()->get('loginUser'));
            // 職歴存在チェック
            $result = $this->careerService->checkExistsCareerByProfileIdAndCareerId($request->careerId);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->withInput()->with(
                    [
                        'profileId' => $request->profileId,
                        'error_message' => __('message.DB.0003')
                    ]
                );
            }

            $now = Carbon::now();
            $this->careerService->updateCareerInfo($request, $now, $loginUser['userName']);

            // ユーザー画面.topに遷移
            return redirect()->route('user.top')->withInput()->with(
                [
                    'profileId' => $request->profileId,
                    'flash_message' => __('message.DB.0002')
                ]
            );
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function delete()
    {
        try {
            // 職歴存在チェック
            $result = $this->careerService->checkExistsCareerByProfileIdAndCareerId($this->request->careerId);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->withInput()->with(
                    [
                        'profileId' => $this->request->profileId,
                        'error_message' => __('message.DB.0003')
                    ]
                );
            }

            $this->careerService->deleteCareerInfo($this->request);
            // ユーザー画面.topに遷移
            return redirect()->route('user.top')->withInput()->with(
                [
                    'profileId' => $this->request->profileId,
                    'flash_message' => __('message.DB.0004')
                ]
            );
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }
}
