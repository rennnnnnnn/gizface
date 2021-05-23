<?php

namespace App\Http\Middleware;

use App\Models\PostCategory;
use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;
use App\Models\SkillMaster;
use App\Models\Profile;

class GetSkillOption
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $skillMaster = new SkillMaster();
        $skillList = $skillMaster->getSkillList();

        $postCategory = new PostCategory();
        $postCategoryOption = $postCategory->getAllRecord();

        $loginUser = unserialize($request->session()->get('loginUser'));
        $profileModel = new Profile();
        $avatar = $profileModel->getAvatar($loginUser['profileId']);

        // headerで使用
        $this->view->share([
            'skillOption' => $skillList,
            'postCategoryList' => $postCategoryOption,
            'avatar' => $avatar,
            'userName' => $loginUser['userName']
        ]);

        return $next($request);
    }
}
