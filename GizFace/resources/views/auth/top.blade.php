<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', 'ユーザーTOP')


@section('content')

<div class="container">
    @if (session('flash_message'))
    <div class="row">
        <div class="alert alert-info flash-message text-center">
            {{ session('flash_message') }}
        </div>
    </div>
    @endif
    <div class="media">
        <div class="media-left">
            <div class="card">
                <div class="profile-photo">
                    <span>
                        <img class="media-object" src="{{$profileInfo->profile_image_path}}" data-toggle="modal" data-target="#imageModal">
                    </span>
                </div>
                <div class="card-content">
                    <div class="text">
                        <h4 class="name"><a data-toggle="modal" data-target="#nameModal">{{$profileInfo->name}}</a></h4>
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
            <div class="text-right">
                <button type="button" class="btn edit" id="basicInformationEdit"> <span class="fa fa-pencil"></span> 編集する</button>
            </div>
            <div class="outer-box table-responsive basic-default">
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
                                    <td>{{$profileInfo->job_type}}</td>
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
                                <tr>
                                    <tr>
                                        <td class="col-xs-3 col-ms-3 col-md-4 col-lg-4">Workplace</td>
                                        <td><a href="{{$profileInfo->workplace_url}}">{{$profileInfo->workplace_url}}</a></td>
                                    <tr>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="row outer-box show basic-show" style="display:none!important;">
                <form name="f1" id="form1" action="" target="_self" class="" method="get">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div>
                                <label class="control-label size-9">性別</label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" name="gender" value="0" @if($profileInfo->gender == 0) checked @endif>
                                    男性
                                </label>
                                <label style="margin-left:30px;">
                                    <input type="radio" name="gender" value="1" @if($profileInfo->gender == 1) checked @endif>
                                    女性
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="birthday" class="size-9">生年月日</label>
                            <div class="birthday">
                                <select id="year" name="year"></select>年
                                <select id="month" name="month"></select>月
                                <select id="day" name="day"></select>日​
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="joinedCompany" class="size-9">入社日</label>
                            <div class="input-group date col-md-7">
                                @if(!empty($profileInfo->joined_company_date))
                                <input type="text" class="form-control datepicker" name="joinedCompany" id="joinedCompany" value="{{date('Y/m/d',strtotime($profileInfo->joined_company_date))}}">
                                @else
                                <input type="text" class="form-control datepicker" name="joinedCompany" id="joinedCompany" value="">
                                @endif
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="joinedProject" class="size-9">入職日</label>
                            <div class="input-group date col-md-7">
                                @if(!empty($profileInfo->joined_project_date))
                                <input type="text" class="form-control datepicker" name="joinedProject" id="joinedProject" value="{{date('Y/m/d',strtotime($profileInfo->joined_project_date))}}">
                                @else
                                <input type="text" class="form-control datepicker" name="joinedProject" id="joinedProject" value="">
                                @endif
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="department" class="size-9">所属</label>
                            <div class="input-group col-sm-10">
                            <input type="text" class="form-control" name="department" id="department" value="{{$profileInfo->department}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="position" class="size-9">役職</label>
                            <div class="input-group col-sm-10">
                                <input type="text" class="form-control" name="position" id="position" value="{{$profileInfo->position}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="jobType" class="size-9">タイプ</label>
                            <div class="input-group col-sm-10">
                                <input type="text" class="form-control" name="jobType" id="jobType" value="{{$profileInfo->department}}">
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="workPlace" class="size-9">現在勤務地</label>
                            <div class="input-group col-sm-10">
                                <input type="text" class="form-control" name="workPlace" id="workPlace" value="{{$profileInfo->station}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="living" class="size-9">在住地</label>
                            <div class="input-group col-sm-12">
                                <input type="text" class="form-control" name="address" id="address" value="{{$profileInfo->address}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="github" class="size-9">GitHub</label>
                            <div class="input-group col-sm-12">
                                <input type="text" class="form-control" name="github" id="github" value="{{$profileInfo->github_url}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="workPlaceUrl" class="size-9">Workplace</label>
                            <div class="input-group col-sm-12">
                                <input type="text" class="form-control" name="workPlaceUrl" id="workPlaceUrl" value="{{$profileInfo->workplace_url}}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="profileId" value={{$profileId}}>
                    <input type="hidden" name="userId" value={{$profileInfo->user_id}}>
                </form>
                <div class="text-right">
                    <button type="button" class="btn" id="basicCancel">キャンセル</button>
                    <button type="button" class="btn update" id="basicUpdate">更新</button>
                </div>
            </div>
        </div>
    </div>
    <div class="description">
        <div class="description-default">
            <div class="description-box">
                <h4 class="pull-left">自己紹介</h4>
                <div class="text-right description-box pull-left" style="width:100%;">
                    <button type="button" class="btn edit text-right" id="descriptionEdit"> <span class="fa fa-pencil"></span> 編集する</button>
                </div>

            </div>
            <div class="description-box">
                <textarea name="description" id="description" cols="30" rows="5" disabled>{{$profileInfo->description}}</textarea>
            </div>
        </div>
        <div class="description-box description-show" style="display: none!important">
            <div class="row outer-box show" style="width:100%;">
                <form name="f2" id="form2" action="" target="_self" class="" method="get">
                    {{csrf_field()}}
                    <textarea name="description" id="description" cols="30" rows="5">{{$profileInfo->description}}</textarea>
                    <input type="hidden" name="profileId" value="{{$profileId}}">
                 </form>
                 <div class="text-right">
                    <button type="button" class="btn" id="descriptionCancel">キャンセル</button>
                    <button type="button" class="btn update" id="descriptionUpdate">更新</button>
                </div>
            </div>
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
                    <form name="f3" id="form3" action="" target="_self" class="" method="get">
                    {{csrf_field()}}
                        <input type="hidden" name="profileId" value="{{$profileId}}">
                        <input type="hidden" name="careerId" id="careerId" value="">
                    </form>
                </li>
                <li role="presentation">
                    <a href="#post" aria-controls="post" role="tab" data-toggle="tab">投稿</a>
                    <form name="f4" id="form4" action="" target="_self" class="" method="get">
                    {{csrf_field()}}
                        <input type="hidden" name="postId" id="postId" value="">
                    </form>
                </li>
            </ul>
        </div>
        <div class="tab-content" style="height:auto;">
            @include('profile.detail-nav-skill')
            @include('auth.top-detail-nav-career')
            @include('auth.top-detail-nav-post')
        </div>
    </div>
</div>
@stop
@section('content2')
    @include('modals.name')
@stop
@section('content3')
    @include('modals.image')
@stop

@section('css')
<link href="{{asset('css/slick-theme.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/slick.css')}}" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profile/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/top.css') }}">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="{{ asset('/js/slick.min.js') }}"></script>
<script src="{{ asset('/js/profile/top.js') }}"></script>
<script src="{{ asset('/js/profile/detail.js') }}"></script>
<script src="{{ asset('/js/post/top.js') }}"></script>
<script>
    getSkills("{{ route('ajax.getSkills')}}");
</script>
<script type="text/javascript">
$(function(){

    $(function(){
        $('.flash-message').fadeOut(3000);
    });

    // datepicker
    $(".datepicker").datepicker({
        format: "yyyy/mm/01",
        language: "ja",
        autoclose: true
    });

    $('#basicInformationEdit').on('click',function(){
        $(this).css('display','none')
        $('.basic-default').css('display','none');
        $('.basic-show').removeClass('none');
        $('.basic-show').css('display','flex');
    });

    $('#basicCancel').on('click',function(){
        $('#basicInformationEdit').css('display','inline-block');
        $('.basic-default').css('display','block');
        $('.basic-show').addClass('none');
    });

    $('#descriptionEdit').on('click',function(){
        $(this).css('display','none')
        $('.description-default').css('display','none');
        $('.description-show').removeClass('none');
        $('.description-show').css('display','flex');
    });

    $('#descriptionCancel').on('click',function(){
        $('#descriptionEdit').css('display','inline-block');
        $('.description-default').css('display','block');
        $('.description-show').addClass('none');
    });

    // 職歴 編集ボタン
    $('.careerEdit').on('click',function(){
        var id = $(this).data('id');
        $('#careerId').val(id);
        $('#form3').attr("action","{{ route('career.edit') }}");
        $('#form3').attr("target","_self");
        $('#form3').submit();
    });
    // 職歴 追加するボタン
    $('#careerCreate').on('click',function(){
        $('#form3').attr("action","{{ route('career.create') }}");
        $('#form3').attr("target","_self");
        $('#form3').submit();
    });

    // 投稿　追加するボタン
    $('#postCreate').on('click',function(){
        $('#form3').attr("action","{{ route('post.create') }}");
        $('#form3').attr("target","_blank");
        $('#form3').submit();
    });

     // 投稿 編集ボタン
     $('.postEdit').on('click',function(){
        var id = $(this).data('id');
        $('#postId').val(id);
        $('#form4').attr("action","{{ route('post.edit') }}");
        $('#form4').attr("target","_self");
        $('#form4').submit();
    });

    // 名前更新ボタン
    $(function() {
        $('#nameUpdate').on('click', function() {
            //validate実行 必須チェック
            $('#nameEdit').validate({
            rules: {
                lastName: {
                required: true,
                },
                firstName: {
                required: true,
                },
                lastRomaName: {
                required: true,
                },
                firstRomaName: {
                required: true,
                },
            },
            messages: {
                lastName: {
                    required: '入力必須です。'
                },
                firstName: {
                    required: '入力必須です。'
                },
                lastRomaName: {
                    required: '入力必須です。'
                },
                firstRomaName: {
                    required: '入力必須です。'
                },
            }
        });
            // バリデーションエラーで戻る
            if (!$("#nameEdit").valid()) {
                return false;
            };

            $(this).text("送信中...");
            $(this).css('background','#ccc');
            var form = $('#nameEdit');
            var param = form.serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('name.update') }}",
                type: 'POST',
                data: param
            })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(data) {
                alert('更新失敗しました。');
            });
        });
    });

    // アバター画像更新
    $(function() {
        $('#selectFile').change(function(){
            $('#image').remove();
            var file = $(this).prop('files')[0];
            var fileReader = new FileReader();
            fileReader.onloadend = function() {
                $('.thumb-wrapper').html('<img src="' + fileReader.result + '"/>');
            }
            fileReader.readAsDataURL(file);
        });
        $('#imageUpdate').on('click', function() {
            //validate実行 必須チェック
            $('#uploadForm').validate({
            rules: {
                selectFile: {
                required: true,
                },
            },
            messages: {
                selectFile: {
                    required: 'ファイルを選択して下さい。'
                },
            }
            });
            // バリデーションエラーで戻る
            if (!$("#uploadForm").valid()) {
                return false;
            };

            $(this).text("送信中...");
            $(this).css('background','#ccc');

            $('#uploadForm').attr("action","{{ route('file.upload') }}");
            $('#uploadForm').attr("target","_self");
            $('#uploadForm').attr("method","post");
            $('#uploadForm').submit();
        });
    });

    // 基本情報更新ボタン
    $(function() {
        $('#basicUpdate').on('click', function() {
            $(this).text("送信中...");
            $(this).css('background','#ccc');
            var form = $('#form1');
            var param = form.serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('profile.update') }}",
                type: 'POST',
                data: param
            })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(data) {
                alert('更新失敗しました。');
            });
        });
    });

     // 自己紹介更新ボタン
     $(function() {
        $('#descriptionUpdate').on('click', function() {
            $(this).text("送信中...");
            $(this).css('background','#ccc');
            var form = $('#form2');
            var param = form.serializeArray();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('description.update') }}",
                type: 'POST',
                data: param
            })
            .done(function(data) {
                window.location.reload();
            })
            .fail(function(data) {
                alert('更新失敗しました。');
            });
        });
    });

    // 生年月日フォーム
    var time = new Date();
    var year = time.getFullYear();
    var birthYear = JSON.parse(@json($year));
    var birthMonth = JSON.parse(@json($month));
    var birthDay = JSON.parse(@json($day));


    for (var i = year; i >= 1980; i--) {
        if(birthYear == i){
            $('#year').append('<option selected value="' + i + '">' + i +'</option>');
        }else{
            $('#year').append('<option value="' + i + '">' + i + '</option>');
        }
    }
    for (var i = 1; i <= 12; i++) {
        if(birthMonth == i){
            $('#month').append('<option selected value="' + i + '">' + i + '</option>');
        }else{
            $('#month').append('<option value="' + i + '">' + i + '</option>');
        }
    }
    for (var i = 1; i <= 31; i++) {
        if(birthDay == i){
            $('#day').append('<option selected value="' + i + '">' + i + '</option>');
        }else{
            $('#day').append('<option value="' + i + '">' + i + '</option>');
        }
    }
});
</script>
@stop

