<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\PostService;
use App\Services\FileService;
use App\Http\Requests\PostRequest;
use Carbon\Carbon;


class PostController extends Controller
{
    private $postService;
    private $fileService;

    //コンストラクタ
    function __construct(
        Request $request,
        PostService $postService,
        FileService $fileService
    ) {
        $this->request = $request;
        $this->postService = $postService;
        $this->fileService = $fileService;
    }

    public function create()
    {
        try {
            $postCategoryList = $this->postService->getPostCategoryList();
            return view('auth.post.create', [
                'profileId' => $this->request->profileId,
                'categoryList' => $postCategoryList
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function save(PostRequest $request)
    {
        try {
            $loginUser = unserialize($this->request->session()->get('loginUser'));
            $file = $this->request->file('selectFile');
            if (!empty($file)) {
                if (env('APP_ENV') === 'local') {
                    $filePath = $this->fileService->uploadFileForLocal($file);
                } else {
                    // s3にアップロード
                    $filePath = $this->fileService->uploadFile($file);
                }
                $this->postService->savePostRecord($filePath, $request, $loginUser['userName']);
            } else {
                $this->postService->savePostRecord(null, $request, $loginUser['userName']);
            }
            // ユーザー画面.topに遷移
            return redirect()->route('user.top')->withInput()->with(
                [
                    'profileId' => $_POST['profileId'],
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
            $postCategoryList = $this->postService->getPostCategoryList();
            // 投稿存在チェック
            $result = $this->postService->checkExistsPostByPostId($this->request->postId);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->with('error_message', __('message.DB.0003'));
            }
            // 投稿詳細情報取得
            $postInfo = $this->postService->getPostInfoByPostId($this->request->postId);
            return view('auth.post.edit', [
                'categoryList' => $postCategoryList,
                'postInfo' => $postInfo
            ]);
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    public function update(PostRequest $request)
    {
        try {
            $loginUser = unserialize($this->request->session()->get('loginUser'));
            // 投稿存在チェック
            $result = $this->postService->checkExistsPostByPostId($this->request->postId);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->with('error_message', __('message.DB.0003'));
            }
            $file = $this->request->file('selectFile');
            if (!empty($file)) {
                if (env('APP_ENV') === 'local') {
                    $filePath = $this->fileService->uploadFileForLocal($file);
                } else {
                    // s3にアップロード
                    $filePath = $this->fileService->uploadFile($file);
                }
                $this->postService->updatePostInfo($filePath, $request, Carbon::now(), $loginUser['userName']);
            } else {
                // 更新時に画像の変更がない場合 && アップロード済みの画像が存在する場合、アップロード済みのfile_path ,ない場合はnull
                $filePath = $this->postService->getImagePathByPostId($this->request->postId);
                $this->postService->updatePostInfo($filePath, $request, Carbon::now(), $loginUser['userName']);
            }
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

    public function show()
    {
        try {
            $postId =  $_GET['id'];
            // 投稿詳細情報取得
            $postInfo = $this->postService->getPostInfoByPostId($postId);
            $commentList = $this->postService->getCommentListByPostId($postId);
            return view('auth.post.detail', [
                'postInfo' => $postInfo,
                'commentList' => $commentList
            ]);
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
        } catch (\Exception $e) {
            \Session::flash('error_message', __('message.SYSTEM_ERROR'));
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
            return view('profile.top');
        }
    }

    // コメント -----------------------------------------------------------

    public function commentSave()
    {
        try {
            $loginUser = unserialize($this->request->session()->get('loginUser'));
            // 投稿存在チェック
            $result = $this->postService->checkExistsPostByPostId($this->request['postId']);
            // ユーザーTOPにリダイレクト
            if (!$result) {
                return redirect()->route('user.top')->with('error_message', __('message.DB.0003'));
            }
            // 投稿詳細情報取得
            $postInfo = $this->postService->getPostInfoByPostId($this->request['postId']);
            // コメント数が1プラス
            $postReplyCount = $postInfo->reply_count;
            ++$postReplyCount;
            $this->postService->saveComment($this->request, $loginUser, $postReplyCount);

            session()->flash('flash_message', __('message.COMMENT'));
        } catch (\Exception $e) {
            $exceptionMsg = $e->getFile() . ' ' . $e->getLine() . '行目' . $e->getMessage();
            \Log::Error($exceptionMsg);
        }
    }
}
