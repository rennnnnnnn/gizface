<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class AdminController extends Controller
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

    public function index()
    {

        try {
            // profiles.TBLから全件取得
            $userList = $this->profileService->getAllProfileListForAdminUser();

            return view('admin.top', [
                'userList' => $userList,
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }
}
