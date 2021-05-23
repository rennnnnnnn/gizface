<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '職歴・新規登録')


@section('content')

<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
       <p class="text-center">正しく入力されていない項目があります。メッセージをご確認の上、もう一度ご入力下さい。</p>
    </div>
    @endif
    <div class="row" style="margin-left: 160px;margin-top:40px;">
        <form name="f1" id="form1" action="" target="_self" class="form-horizontal career-form" method="get">
            {{csrf_field()}}
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="company">会社名</label>
                @if ($errors->first('company'))
                <p class="validation col-sm-6">※{{$errors->first('company')}}</p>
                @endif
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="company" name="company" value="{{old('company')}}" placeholder="会社名を入力して下さい。">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="jobTitle">業務概要</label>
                @if ($errors->first('jobTitle'))
                <p class="validation col-sm-6">※{{$errors->first('jobTitle')}}</p>
                @endif
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" value="{{old('jobTitle')}}" placeholder="業務概要を入力して下さい。">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="period">期間</label>
                @if ($errors->first('from'))
                <p class="validation col-sm-6">※{{$errors->first('from')}}</p>
                @endif
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group" id="datepicker-daterange">
                                <label class="col-sm-5 control-label required">開始年月</label>
                                <div class="col-sm-7 form-inline" style="padding-left:0;">
                                    <div class="input-group date">
                                      <input type="text" class="form-control datepicker" name="from" id="from" value="{{old('from')}}">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group" id="datepicker-daterange">
                                <label class="col-sm-5 control-label">終了年月</label>
                                <div class="col-sm-7 form-inline" style="padding-left:0;">
                                    <div class="input-group date">
                                      <input type="text" class="form-control datepicker" name="to" id="to" value="{{old('to')}}">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="jobDetail">業務内容</label>
                @if ($errors->first('jobDetail'))
                <p class="validation col-sm-6">※{{$errors->first('jobDetail')}}</p>
                @endif
                <div class="col-sm-6">
                <textarea class="row-5 form-control" id="jobDetail" name="jobDetail" placeholder="箇条書きで入力して下さい。">{{old('jobDetail')}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="scale">規模</label>
                @if ($errors->first('scale'))
                    <span class="validation">※{{$errors->first('scale')}}</span>
                @endif
                <div class="col-sm-1">
                    <div class="flex">
                    <input type="number" class="form-control" name="scale" id="scale" value="{{old('scale')}}">
                        <label class="control-label" style="padding-left:10px;">名</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label required" for="language">使用言語</label>
                @if ($errors->first('language.0'))
                <p class="validation col-sm-6">※{{$errors->first('language.0')}}</p>
                @endif
                <div class="col-sm-6" id="languageForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0">
                        <input type="text" name="language[0]" class="form-control language"  value="" data-input-count="0">
                        <button data-prefix="language" type="button" class="btn btn-xs create addForm languageAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="fw">FW</label>
                <div class="col-sm-6" id="fwForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0">
                        <input id="search" type="text" class="form-control fw" name="fw[0]" value="" data-input-count="0">
                        <button data-prefix="fw" type="button" class="btn btn-xs create addForm fwAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="db">DB</label>
                <div class="col-sm-6" id="dbForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0" >
                        <input type="text" class="form-control db" name="db[0]" value="" data-input-count="0">
                        <button data-prefix="db" type="button" class="btn btn-xs create addForm dbAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="os">OS</label>
                <div class="col-sm-6" id="osForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0">
                        <input type="text" class="form-control os" name="os[0]" value="" data-input-count="0">
                        <button data-prefix="os" type="button" class="btn btn-xs create addForm osAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="role">役割</label>
                <div class="col-sm-6" id="roleForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0" >
                        <input type="text" class="form-control role" name="role[0]" value="" data-input-count="0">
                        <button data-prefix="role" type="button" class="btn btn-xs create addForm roleAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="process">担当工程</label>
                <div class="col-sm-6" id="processForm">
                    <div class="flex mb-10 process-block" data-num="1">
                        <select class="form-control process" name="process[1]">
                            <option value=""></option>
                            @foreach($process as $index => $value)
                              <option value="{{ $value }}">{{$value}}</option>
                            @endforeach
                        </select>
                        <button data-prefix="process" type="button" class="btn btn-xs create processAddForm" id="processAdd">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="tool">ツール</label>
                <div class="col-sm-6" id="toolForm">
                    <div class="flex mb-10 pr-26" data-parent-input-count = "0">
                        <input type="text" class="form-control tool" name="tool[0]" value="" data-input-count="0">
                        <button data-prefix="tool" type="button" class="btn btn-xs create addForm toolAddForm" data-input-count="0">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="profileId" value="{{$profileId}}">
        </form>
    </div>
    <div class="text-center">
        <button type="button" class="btn" id="register">登録</button>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/career.css') }}">
<style>
    /* 登録ボタン */
    #register {
        background-color: gray;
        color: white;
        border-radius: 0 !important;
    }

    #register:hover {
        background-color: #fff;
        border-color: #59b1eb;
        color: #59b1eb;
    }
</style>
@stop

@section('js')

<script type="text/javascript">
$(function(){

    // 使用言語をサジェスト
    var languageData = JSON.parse(@json($language));
    autoComplete('language',languageData);
    // fwをサジェスト
    var fwData = JSON.parse(@json($fw));
    autoComplete('fw',fwData);
    // dbをサジェスト
    var dbData = JSON.parse(@json($db));
    autoComplete('db',dbData);
    // osをサジェスト
    var osData = JSON.parse(@json($os));
    autoComplete('os',osData);
    // 役割をサジェスト
    var roleData = JSON.parse(@json($role));
    autoComplete('role',roleData);
    // ツールをサジェスト
    var toolData = JSON.parse(@json($tool));
    autoComplete('tool',toolData);

    // inputサジェスト機能
    function autoComplete(category,data){
        $('.'+ category).autocomplete({
            source: data,
            delay: 20,
            autoFocus: true,
         });
    }

    // datepicker
    $(".datepicker").datepicker({
        format: "yyyy/mm/01",
        language: "ja",
        autoclose: true
    });


    //-- addForm ボタン押下 「+」ボタン------->
    $(document).on("click", ".addForm", function() {
        console.log($(this))
        var inputCount = $(this).data("inputCount");
        var prefix = $(this).data("prefix");

        $(this).css("visibility", "hidden");
        var nextNum = parseInt(inputCount) + 1;
        var temp =
            '<div class="flex mb-10" data-parent-input-count="' +
            nextNum +
            '">' +
            '<input type="text" name="' +
            prefix +
            "[" +
            nextNum +
            ']" value="" class="form-control ' +
            prefix +
            '" data-input-count="' +
            nextNum +
            '">' +
            '<button data-prefix="' +
            prefix +
            '" type="button" class="btn btn-xs create addForm ' +
            prefix +
            'AddForm" data-input-count="' +
            nextNum +
            '"><i class="fa fa-plus-circle"></i></button>' +
            '<button data-prefix="' +
            prefix +
            '" type="button" class="btn btn-xs delForm" data-input-count="' +
            nextNum +
            '"><i class="fa fa-minus-circle"></i></button>' +
            "</div>";

        $("#" + prefix + "Form").append(temp);
        // 追加したinputにサジェスト機能追加
        autoComplete(prefix,eval(prefix + 'Data'));
    });
    //-- delForm ボタン押下 「-」ボタン------->
    $(document).on("click", ".delForm", function() {
        prefix = $(this).data("prefix");
        inputCount = $(this).data("inputCount");

        var num = $("button[data-prefix='" + prefix + "'].addForm")
            .filter(":last")
            .data("inputCount");
        // inputCount = num　の場合、inputCount-1にaddForm追加
        if (inputCount === num) {
            $(this)
                .parent()
                .remove();
            $("." + prefix + "AddForm")
                .filter(":last")
                .css("visibility", "visible");
            // inoutCount < num の場合削除のみ
        } else {
            $(this)
                .parent()
                .remove();
        }
    });

     //-- 担当工程 ボタン押下 「+」ボタン------->
    $(document).on("click",'.processAddForm',function(){
        var prefix = $(this).data("prefix");
        var maxcnt = 0;
        $('.process-block').each(function(){
            var num = $(this).data('num');
            console.log(num)
            if(maxcnt < num){
                maxcnt = num;
            }
        });
        var nextcnt = maxcnt + 1;
        var original = $('.process-block[data-num = "1"]');
        // originalを複製
        var clone = original.clone();
        var html = '<button data-prefix="' +
            prefix +
            '" type="button" class="btn btn-xs delForm" data-input-count="' +
            nextcnt +
            '"><i class="fa fa-minus-circle"></i></button>';
        clone.attr('data-num',nextcnt)
        clone.find("select[name^='process']").attr('name','process[' + nextcnt + ']');
        clone.find('#processAdd').remove();
        clone.appendTo('#processForm');
        clone.append(html);
        clone.end();
    })

    // -- validationエラー時の処理------->　validationエラー時inputにold値を挿入
    onLoad();
    function onLoad(){
        var oldLanguage = @json(old('language'));
        var oldFw = @json(old('fw'));
        var oldDb = @json(old('db'));
        var oldOs = @json(old('os'));
        var oldRole = @json(old('role'));
        var oldProcess = @json(old('process'));
        var oldTool = @json(old('tool'));
        // inputの数
        var languageCount = 0;
        var fwCount = 0;
        var dbCount = 0;
        var osCount = 0;
        var roleCount = 0;
        var toolCount = 0;

        if(oldLanguage !== null){
            $.each(oldLanguage,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'language'
                var inputCount = languageCount;
                setInputList(prefix,inputCount,val);
                languageCount++;
            });
        }

        if(oldFw !== null){
            $.each(oldFw,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'fw'
                var inputCount = fwCount;
                setInputList(prefix,inputCount,val);
                fwCount++;
            });
        }

        if(oldDb !== null){
            $.each(oldDb,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'db'
                var inputCount = dbCount;
                setInputList(prefix,inputCount,val);
                dbCount++;
            });
        }

        if(oldOs !== null){
            $.each(oldOs,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'os'
                var inputCount = osCount;
                setInputList(prefix,inputCount,val);
                osCount++;
            });
        }

        if(oldRole !== null){
            $.each(oldRole,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'role'
                var inputCount = roleCount;
                setInputList(prefix,inputCount,val);
                roleCount++;
            });
        }

        if(oldTool !== null){
            $.each(oldTool,function(index,val){
                // 値がない場合、終了
                if(val === null){
                    return;
                }
                var prefix = 'tool'
                var inputCount = toolCount;
                setInputList(prefix,inputCount,val);
                toolCount++;
            });
        }

        if(oldProcess !== null){
            $.each(oldProcess,function(i,e){
                var num = parseInt(i)
                if(num > 1){
                    $('.processAddForm').trigger('click');
                }
                $('[name=process\\[' + num + '\\]] option[value="' + e + '"]').prop('selected','selected')
            })
        }

        // inputを追加し値をセットする
        function setInputList(prefix,inputCount,val){
            if(inputCount < 1){
                var input = $('input[name="'+ prefix +'\[0\]"]');
                input.val(val);
            } else{
                var clickButton = $('.' + prefix + 'AddForm').filter(function(){ return($(this).data('inputCount') === inputCount-1);});
                console.log(clickButton)
                clickButton.trigger('click');
                var input = $('input[name="'+ prefix +'\[' + inputCount +'\]"]');
                input.val(val);
            }
        }

    }

      // 登録ボタン
      $('#register').on('click',function(){
          $('#form1').attr("action","{{ route('career.save') }}");
          $('#form1').attr("target","_self");
          $('#form1').attr("method","post");
          $('#form1').submit();
        });
});
</script>
@stop
