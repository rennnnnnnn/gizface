<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '投稿・詳細')

@section('content')
@if (session('flash_message'))
<div class="row">
    <div class="alert alert-info flash-message text-center">
        {{ session('flash_message') }}
    </div>
</div>
@endif
<div class="col-xs-8 col-xs-offset-2">
    <div class="category-tag">
        <div class="small">{{ $postInfo->category }}</div>
    </div>
    <h2>タイトル：{{ $postInfo->title }}
        <small style="padding-left:20px;">投稿日：{{ date("Y年 m月 d日",strtotime($postInfo->created_at)) }}</small>
    </h2>
    <div class="user-menu-wrapper" style="margin-left: 800px">
        <div class="user-profile-photo" id="profileIcon">
            <span>
                <a href="{{ asset('/profile/detail?id=').$postInfo->profile_id }}"><img class="thum" style="width:40px;height:40px;"src="{{$postInfo->profile_image_path}}" alt="プロフィール画像"></a>
            </span>
        </div>
    </div>
    <img class="img" src="{{$postInfo->image_path}}" alt="">
    <p>{!! $postInfo->markdown_body !!}</p>
    <hr />
    <h3>コメント一覧</h3>
    @if(!empty($commentList))
        @foreach($commentList as $key => $value)
            <div class="user-menu-wrapper" style="display: inline-block;">
                <div class="user-profile-photo" id="profileIcon">
                    <span>
                        <a href="{{ asset('/profile/detail?id=').$value->id }}"><img class="thum" style="width:40px;height:40px;"src="{{$value->profile_image_path}}" alt="プロフィール画像"></a>
                    </span>
                </div>
            </div>
            {{-- <a href="{{ asset('/profile/detail?id=').$value->created_profile_id }}"><h4>{{ $value->created_user }}</h4></a> --}}
            <small>{{ $value->created_at }}</small>
            <p style="margin-top: 30px">{!! nl2br(e($value->body)) !!}</p>
        @endforeach
    @endif
    <div class="">
        <button type="button" class="btn" id="comment">コメントする</button>
    </div>
    <div class="row outer-box show basic-show" style="display:none!important;">
        <form name="f1" id="form1" action="" target="_self" class="" method="get">
            {{csrf_field()}}
            <div class="row">
                <div class="form-group">
                    <label for="comment" class="">コメント</label>
                    <div id="mdraw">
                        <textarea class="form-control row-5" rows="5" name="body" placeholder="コメントを入力してください。"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" name="postId" value="{{ $postInfo->id }}">
        </form>
        <div class="text-right">
            <button type="button" class="btn" id="cancel">キャンセル</button>
            <button type="button" class="btn update" id="commentCreate">コメントする</button>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth/top.css') }}">
<link rel="stylesheet" href="{{ asset('css/post/top.css') }}">
<style>
    .img{
        max-width: 100%;
        height: 300px;
        object-fit: cover;
    }
   /* 登録ボタン */
   #comment {
        background-color: gray;
        color: white;
        border-radius: 0 !important;
    }

    #comment:hover {
        background-color: #fff;
        border-color: #59b1eb;
        color: #59b1eb;
    }

</style>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function(){

        $(function(){
            $('.flash-message').fadeOut(3000);
        });
        $('#comment').on('click',function(){
            $(this).css('display','none');
            $('.basic-show').removeClass('none');
            $('.basic-show').css('display','flex');
        });

        $('#cancel').on('click',function(){
            $('#comment').css('display','inline-block');
            $('.basic-show').addClass('none');
        });

        // 名前更新ボタン
        $(function() {
            $('#commentCreate').on('click', function() {
                //validate実行 必須チェック
                $('#form1').validate({
                rules: {
                    body: {
                    required: true,
                    },
                },
                messages: {
                    body: {
                        required: 'コメントを入力してください。'
                    },
                }
            });
                // バリデーションエラーで戻る
                if (!$("#form1").valid()) {
                    return false;
                };

                $(this).text("送信中...");
                $(this).css('background','#ccc');
                var form = $('#form1');
                var param = form.serializeArray();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('comment.save') }}",
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
    });
</script>
@stop

