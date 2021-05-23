<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ログイン画面
Route::get('/login', function () {
    return view('login');
});

// slack認証
Route::get('/redirect', 'Auth\OAuthController@redirectToProvider');
Route::get('/callback', 'Auth\OAuthController@handleProviderCallback');

// ユーザー登録
Route::post('/register/user', 'Auth\OAuthController@registerUser')->name('register.user');


Route::group(['middleware' => ['login']], function () {
    // middleware = header.skillOption取得
    Route::group(['middleware' => ['getSkillOption']], function () {
        // header検索
        Route::post('/header_search', 'HeaderController@search')->name('header.search');

        // 社員ページ
        Route::prefix('profile')->group(function () {
            // TOP 社員一覧画面
            Route::get('/top', 'ProfileController@index')->name('profile.index');

            // 社員詳細画面
            Route::get('/detail{id?}', 'ProfileController@show')->name('profile.show');
        });

        // コメント
        Route::prefix('comment')->group(function () {
            // コメント保存
            Route::post('/save', 'Auth\PostController@commentSave')->name('comment.save');
        });

        Route::prefix('admin')->group(function () {
            // コメント保存
            Route::get('/top', 'AdminController@index')->name('admin.index');
        });

        // ユーザーページ
        Route::prefix('user')->group(function () {
            // ユーザー画面.TOP
            Route::get('/top', 'Auth\TopController@index')->name('user.top');
            // ユーザー画面.名前更新
            Route::post('/name_update', 'Auth\TopController@nameUpdate')->name('name.update');
            // ユーザー画面.アバター更新
            Route::post('/file_upload', 'Auth\TopController@fileUpload')->name('file.upload');
            // ユーザー画面.基本情報更新
            Route::post('/profile_update', 'Auth\TopController@update')->name('profile.update');
            // ユーザー画面.自己紹介更新
            Route::post('/description_update', 'Auth\TopController@descriptionUpdate')->name('description.update');
            // ユーザー画面.職歴新規作成
            Route::get('/career_create', 'Auth\CareerController@create')->name('career.create');
            // ユーザー画面.職歴登録
            Route::post('/career_save', 'Auth\CareerController@save')->name('career.save');
            // ユーザー画面.職歴編集画面
            Route::get('/career_edit', 'Auth\CareerController@edit')->name('career.edit');
            // ユーザー画面.職歴更新
            Route::post('/career_update', 'Auth\CareerController@update')->name('career.update');
            // ユーザー画面.職歴削除
            Route::post('/career_delete', 'Auth\CareerController@delete')->name('career.delete');
            // ユーザー画面.投稿新規作成
            Route::get('/post_create', 'Auth\PostController@create')->name('post.create');
            // ユーザー画面.投稿登録
            Route::post('/post_save', 'Auth\PostController@save')->name('post.save');
            // ユーザー画面.投稿編集画面
            Route::get('/post_edit', 'Auth\PostController@edit')->name('post.edit');
            // ユーザー画面.投稿更新
            Route::post('/post_update', 'Auth\PostController@update')->name('post.update');
            // ユーザー画面.投稿詳細画面
            Route::get('/post_detail{id?}', 'Auth\PostController@show')->name('post.detail');
            // ログアウト
            Route::get('/logout', 'Auth\TopController@logout')->name('logout');

            // 経歴詳細画面 1つめ以降の職歴を取得
            Route::post('/get_skill', 'Ajax\CareerSkillGetController@getSkill')->name('ajax.getSkills');
        });
    });
});
