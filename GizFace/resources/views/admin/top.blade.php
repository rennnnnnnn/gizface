<!-- レイアウトを継承 -->
@extends('layouts.app')

<!-- ページタイトルを入力 -->
@section('title', '管理画面TOP')

@section('content')

<div class="container">
    <div class="row auto">
        <div class="panel box" id="accordion">
            <div class="box-header with-border search">
                <a data-toggle="collapse" data-parent="#accordion" href="#search" aria-expanded="false" class="">
                    <i class="">絞り込み項目</i>
                </a>
            </div>
            <div id="search" class="panel-collapse collapse" aria-expanded="false" style="margin-top: 15px;">
                <form name="f1" id="form1" action="" target="_self" method="get">
                    <div class="box-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="">名前</label>
                                <input class="form-control input-sm" type="text" name="name" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="">性別</label>
                                <input class="form-control input-sm" type="text" name="name" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="">タイプ</label>
                                <input class="form-control input-sm" type="text" name="name" value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="">生年月日</label>
                                <input class="form-control input-sm" type="text" name="name" value="">
                            </div>
                            <div class="col-md-4">
                                <label for="">待機中</label>
                                <input class="form-control input-sm" type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="text-right" style="margin-right: 20px">
                        <button type="button" class="btn btn-sm btn-default" id="refresh">クリア</button>
                        <button type="button" class="btn btn-sm btn-primary" id="searchButton">絞り込む</button>
                        <button type="button" class="btn btn-sm btn-warning" id="tabOpenButton">別タブで開く</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row auto">
        <div class="pagination pagination-sm" style="height: 50px;">
            {{$userList->links()}}
        </div>
        <div class="text-right" style="margin-bottom: 20px">
            <button type="button" class="btn btn-sm btn-default" id="changeFlg">待機中フラグ一括更新</button>
        </div>
        <div class="box" style="border-top-style:none;">
            <form name="f2" id="form2" action="" target="_self" method="get">
                {{csrf_field()}}
                <div class="box-body no-padding scrolling">
                    <table id ="" class="list table table-bordered tablesorter">
                        <thead>
                        <tr>
                            <th rowspan="2" style="width:5px;">
                                <input type="checkbox" class="all-check" id="check-group"/></th>
                            <th rowspan="2">社員ID</th>
                            <th rowspan="2">名前</th>
                            <th rowspan="2">性別</th>
                            <th rowspan="2">タイプ</th>
                            <th rowspan="2">生年月日</th>
                            <th rowspan="2">待機中</th>
                            <th rowspan="2">PDF出力</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($userList))
                            @foreach( $userList as $key=>$value)
                            <tr class="edit manual-hover" data-id="{{$value->profile_id}}">
                                <td><input type="checkbox" data-id ="{{$value->profile_id}}" class="check-group" name="check_id[]" value="{{$value->profile_id}}"></td>
                                <td class="">{{$value->profile_id}}</td>
                                <td class="" title="{{$value->name}}">{{$value->name}}</td>
                                @if(($value->gender === 0))
                                <td>男性</td>
                                @else
                                <td>女性</td>
                                @endif
                                <td class="" title="{{$value->job_type}}">{{$value->job_type}}</td>
                                <td class="" title="{{date('Y/m/d',strtotime($value->birthday))}}">{{date('Y/m/d',strtotime($value->birthday))}}</td>
                                @if(($value->waiting_flg === 0))
                                <td>待機中</td>
                                @else
                                <td></td>
                                @endif
                                <td class=""> <button type="button" class="btn btn-sm btn-default" id="pdfDl" data-id="{{$value->profile_id}}">PDF出力</button></td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="id" name="id" value="">
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>

        .headerbtn {
            margin-top: 5px;
        }

        .list {
            border: 1px solid black;
        }

        .list>thead>tr>th {
            vertical-align: middle;
            background-color: lightgray;
            border: 1px solid black;
            text-align: center;
        }

        .list>tbody>tr>td {
            border: 1px solid black;
            vertical-align: middle;
            text-align: center;
            width: 100px;
        }

        .auto{
            width: 90%;
            margin: 0 auto;
        }

        .pagination nav{
            position: initial;
        }

        .tablesorter th{
            position: relative;
            cursor: pointer;
            text-align: left;
        }
        .tablesorter th::before, .tablesorter th::after{
            content: '';
            position: absolute;
            z-index: 2;
            right: 7px;
            width: 0;
            height: 0;
            border: 4px dashed;
            border-color: #333 transparent;
            pointer-events: none;
        }
        .tablesorter th::before{
            border-bottom-style: solid;
            border-top: none;
            top: 30%;
        }
        .tablesorter th::after{
            border-top-style: solid;
            border-bottom: none;
            bottom: 30%;
        }
        .tablesorter th.tablesorter-headerAsc:after{
            border: none;
        }
        .tablesorter th.tablesorter-headerAsc:before{
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
        }
        .tablesorter th.tablesorter-headerDesc:before{
            border: none;
        }
        .tablesorter th.tablesorter-headerDesc:after{
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
        }
        .tablesorter th.sorter-false:before, .tablesorter th.sorter-false:after{
            border: none;
        }
</style>
@stop

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">

$(function(){

    $(function(){
        $('.flash-message').fadeOut(3000);
        $('.tablesorter').tablesorter({
            textExtraction: function(node){
                var attr = $(node).attr('data-value');
                if(typeof attr !== 'undefined' && attr !== false){
                    return attr;
                }
                return $(node).text();
            }
        });
         //すべてのチェックボックスon/off
        $('.all-check').on('change', function () {
            $('.' + this.id).prop('checked', this.checked);
        });

        $('.manual-hover').hover(function(){
            $(this).css('border-radius','20px');
            $(this).css('background','linear-gradient(-135deg, #E4A972, #9941D8)');
        }, function(){
            $(this).css('border-radius','');
            $(this).css('background','');
        });
    });
    // datepicker
    $(".datepicker").datepicker({
        format: "yyyy/mm/dd",
        language: "ja",
        autoclose: true
    });

    //行をダブルクリック
    $('.edit').dblclick(function () {
        var id = $(this).data('id');
        $('#id').val(id);
        $('#form2').attr("action","{{ route('profile.show') }}");
        $('#form2').attr("target","_blank");
        $('#form2').submit();
    });
});
</script>
@stop

