<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '社員一覧')

@section('content')

<div class="container">
    @if (session('error_message'))
        <div class="row">
            <div class="alert alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> エラー</h4>
                {{ session('error_message') }}
            </div>
        </div>
    @endif
    @if (session('flash_message'))
        <div class="row">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('flash_message') }}
            </div>
        </div>
    @endif
    <div class="user-list">
        @if(!empty($profileRandomList))
            @foreach($profileRandomList as $key => $value)
            <div class="col row-eq-height">
                <div class="card" data-id="{{$value->profile_id}}">
                    <img src="{{asset($value->profile_image_path)}}">
                    <div class="card-content">
                        <div class="text">
                            <h4 class="">{{$value->name}}</h4>
                        </div>
                        <div class="text">
                            <span class="">{{$value->roma_name}}</span>
                        </div>
                        <div class="text">
                            <span class="">{{$value->age}}歳</span>
                        </div>
                        <div>
                            @if(!empty($value->joined_company_date))
                            <span class="">入社年: </span><span class="">{{date('Y/m',strtotime($value->joined_company_date))}}</span>
                            @else
                            <span class="">入社年: </span><span class=""></span>
                            @endif
                        </div>
                        @if(is_array($value->skillList['language']))
                            <div class="text-center">
                                @foreach($value->skillList['language'] as $language => $day)
                                <span class="">{{$language}}:</span> <span class="format-date">{{$day}}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    @include('post.top')
    <form name="f1" id="form1" action="" target="_self" method="get">
        <input type="hidden" id="id" name="id" value="">
    </form>
</div>
@stop

@section('css')
<!-- slick -->
<link href="{{asset('css/slick-theme.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('css/slick.css')}}" rel="stylesheet" type="text/css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/profile/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/top.css') }}">
@stop

@section('js')
<!-- slick -->
<script src="{{ asset('/js/slick.min.js') }}"></script>
<script src="{{ asset('/js/profile/top.js') }}"></script>
<script src="{{ asset('/js/post/top.js') }}"></script>
<script type="text/javascript">

 // プロフィール詳細画面
 $(".card").dblclick(function() {
        var id = $(this).data("id");
        $("#id").val(id);
        $("#form1").attr("action", "{{ route('profile.show') }}");
        $("#form1").attr("target", "_blank");
        $("#form1").submit();
    });

</script>
@stop
