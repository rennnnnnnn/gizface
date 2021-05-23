<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '投稿・編集')


@section('content')

<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
       <p class="text-center">正しく入力されていない項目があります。メッセージをご確認の上、もう一度ご入力下さい。</p>
    </div>
    @endif
    <div class="row" style="margin-left: 160px;margin-top:40px; width:70%;">
        <form name="f1" id="form1" action="" target="_self" class="post-form" method="get" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title" class="control-label required">タイトル</label>
                @if ($errors->first('title'))
                <p class="validation">※{{$errors->first('title')}}</p>
                @endif
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title',$postInfo->title)}}" placeholder="タイトル">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="file" class="control-label">画像アップロード</label>
                <div class="image-field-wrapper">
                    <div class="thumb-wrapper" style="display: flex">
                        <img class="media-object" id="image" src="{{$postInfo->image_path}}">
                    </div>
                    <div class="image-input-wrapper">
                        <input type="file" id="selectFile" name="selectFile" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="category" class="control-label required">カテゴリー</label>
                @if ($errors->first('category'))
                <p class="validation">※{{$errors->first('category')}}</p>
                @endif
                <div class="category-select-area">
                    <div class="row category-block">
                        <div class="col-xs-4">
                            <select class="form-control" name="category" id="category">
                                <option value="0">選択してください</option>
                                    @foreach ($categoryList as $key => $value)
                                    <option value="{{ $key }}"
                                    @if ($key == old('category', $postInfo->post_category_id))
                                        selected="selected"
                                    @endif
                                    >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" id="mdrender">
                <label for="body" class="control-label required">内容</label>
                @if ($errors->first('body'))
                <p class="validation">※{{$errors->first('body')}}</p>
                @endif
                <div id="mdraw">
                <textarea class="form-control row-10" rows="10" name="body" id="markdown_editor_textarea" placeholder="markdownに対応しています">{{$postInfo->body}}</textarea>
                </div>
                <div style="margin-top:20px;">
                    <button type="button" class="btn" id="preview">プレビューが表示されます</button>
                    <div id="preview_area" style="border:1px solid #ccc;">
                        <div id="markdown_preview"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="postId" value="{{$postInfo->id}}">
            <input type="hidden" name="profileId" value="{{$postInfo->profile_id}}">
        </form>
    </div>
    <div class="text-center">
        <button type="button" class="btn" id="update">更新</button>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/solarized-dark.min.css">
<link rel="stylesheet" href="{{ asset('css/post/create.css') }}">
<style>
    /* 登録ボタン */
    #update {
        background-color: gray;
        color: white;
        border-radius: 0 !important;
    }

    #update:hover {
        background-color: #fff;
        border-color: #59b1eb;
        color: #59b1eb;
    }

    #preview{
        color: #24292e;
        background-color: #fff;
        border-color: #d1d5da;
        border-radius: 3px 3px 0 0;
        pointer-events: none;
    }

    /* マークダウンテキスト装飾 */
    h1 {
        background: #dfefff;
        box-shadow: 0px 0px 0px 5px #dfefff;
        border: dashed 1px #96c2fe;
        padding: 0.2em 0.5em;
        color: #454545;
        margin-bottom: 20px;
    }

    h2 {
    background: linear-gradient(transparent 70%, #a7d6ff 70%);
    margin-bottom: 20px;
    }

    h3 {
    color: #010079;
    text-shadow: 0 0 5px white;
    padding: 0.3em 0.5em;
    background: -webkit-repeating-linear-gradient(-45deg, #cce7ff, #cce7ff 3px, #e9f4ff 3px, #e9f4ff 7px);
    background: repeating-linear-gradient(-45deg, #cce7ff, #cce7ff 3px, #e9f4ff 3px, #e9f4ff 7px);
    margin-bottom: 20px;
    }

    pre {
    padding: 20px;
    }

</style>
@stop

@section('js')
<script src="https://cdn.rawgit.com/chjj/marked/master/marked.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.16.2/build/highlight.min.js"></script>
<script type="text/javascript">

$(function(){

    // アバター画像更新
    $('#selectFile').change(function(){
        $('#image').remove();
        var file = $(this).prop('files')[0];
        var fileReader = new FileReader();
        fileReader.onloadend = function() {
            $('.thumb-wrapper').html('<img src="' + fileReader.result + '"/>');
        }
        fileReader.readAsDataURL(file);
        $('.thumb-wrapper').css('display','block');

    });

    // 登録ボタン
    $('#update').on('click',function(){
        $('#form1').attr("action","{{ route('post.update') }}");
        $('#form1').attr("target","_self");
        $('#form1').attr("method","post");
        $('#form1').submit();
    });

    $(function(){
        marked.setOptions({
            // code要素にdefaultで付くlangage-を削除
            langPrefix: '',
            // highlightjsを使用したハイライト処理を追加
            highlight: function (code, lang) {
            return hljs.highlightAuto(code, [lang]).value
            }
        });
            var html = marked($('#markdown_editor_textarea').val());
            $('#markdown_preview').html(html);

        $('#markdown_editor_textarea').keyup(function () {
            var html = marked($(this).val());
            $('#markdown_preview').html(html);
        });
    })


});
</script>
@stop
