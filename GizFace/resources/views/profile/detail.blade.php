<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '社員詳細')

@section('content')

<div class="container">
    <div class="media">
        <div class="media-left">
            <div class="card">
                <img class="media-object" src="{{$profileInfo->profile_image_path}}">
                <div class="card-content">
                    <div class="text">
                        <h4 class="">{{$profileInfo->name}}</h4>
                    </div>
                    <div class="text">
                        <span class="">{{$profileInfo->roma_name}}</span>
                    </div>
                    <div class="text">
                        <span class="">{{$profileInfo->age}}歳</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="media-body">
            <div class="outer-box table-responsive">
                <table class="table-box table-bordered">
                    <tr>
                        <td>
                            <table class="table table-bordered ellipsis">
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">社員ID</td>
                                    <td>{{$profileInfo->profile_id}}</td>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">性別</td>
                                    <?php $key = array_keys(config('consts.profile.GENDER'))?>
                                    @if($profileInfo->gender == $key[0])
                                        <td>{{Config::get('consts.profile.GENDER')[0]}}</td>
                                    @elseif($profileInfo->gender == $key[1])
                                        <td>{{Config::get('consts.profile.GENDER')[1]}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">生年月日</td>
                                    <td>{{date('Y/m/d',strtotime($profileInfo->birthday))}}</td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">入社日</td>
                                    @if(!empty($profileInfo->joined_company_date))
                                    <td>{{date('Y/m/d',strtotime($profileInfo->joined_company_date))}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">入職日</td>
                                    @if(!empty($profileInfo->joined_project_date))
                                    <td>{{date('Y/m/d',strtotime($profileInfo->joined_project_date))}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">所属</td>
                                    <td>{{$profileInfo->department}}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table table-bordered ellipsis">
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">役職</td>
                                    <td>{{$profileInfo->position}}</td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">タイプ</td>
                                    <td>{{$profileInfo->department}}</td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">在住地</td>
                                    <td>{{$profileInfo->address}}</td>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">現在勤務地</td>
                                    <td>{{$profileInfo->station}}</td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">GitHub</td>
                                    <td><a href="{{$profileInfo->github_url}}">{{$profileInfo->github_url}}</a></td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">Workplace</td>
                                    <td><a href="{{$profileInfo->workplace_url}}">{{$profileInfo->workplace_url}}</a></td>
                                <tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="description">
        <div>
            <h4>自己紹介</h4>
        </div>
        <div class="description-box">
        <textarea name="description" id="description" cols="30" rows="5" disabled>{{$profileInfo->description}}</textarea>
        </div>
    </div>
    <div style="margin-left:50px;">
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                 <a href="#skill" aria-controls="skill" role="tab" data-toggle="tab">スキル</a>
                </li>
                <li role="presentation">
                 <a href="#career" aria-controls="career" role="tab" data-toggle="tab">職歴</a>
                </li>
                <li role="presentation">
                 <a href="#post" aria-controls="post" role="tab" data-toggle="tab">投稿</a>
                </li>
              </ul>
        </div>
        <div class="tab-content" style="height:auto;">
            @include('profile.detail-nav-skill')
            @include('profile.detail-nav-career')
            @include('profile.detail-nav-post')
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile/detail.css') }}">
<link href="{{asset('css/slick-theme.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/slick.css')}}" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/post/top.css') }}">
@stop

@section('js')
<script src="{{ asset('/js/slick.min.js') }}"></script>
<script src="{{ asset('/js/profile/top.js') }}"></script>
<script src="{{ asset('/js/profile/detail.js') }}"></script>
<script src="{{ asset('/js/post/top.js') }}"></script>
<script>
    getSkills("{{ route('ajax.getSkills')}}");
</script>
@stop
