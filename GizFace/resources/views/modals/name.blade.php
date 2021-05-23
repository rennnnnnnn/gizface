@section('content2')
<!-- モーダル・ダイアログ -->
<div class="modal fade" id="nameModal" tabindex="-1">
    @if ($errors->any())
    <div class="alert alert-danger">
       <p class="text-center">正しく入力されていない項目があります。メッセージをご確認の上、もう一度ご入力下さい。</p>
    </div>
    @endif
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <p class="modal-title">名前</p>
			</div>
			<div class="modal-body">
                <form name="nameEdit" id="nameEdit" action="" target="_self" class="" method="get">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="lastName" class="size-9 required">苗字</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="lastName" id="lastName" value="{{$profileInfo->last_name}}" placeholder="山田">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="firstName" class="size-9 required">名前</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="firstName" id="firstName" value="{{$profileInfo->first_name}}" placeholder="太郎">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="lastRomaName" class="size-9 required">苗字（英語表記）</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="lastRomaName" id="lastRomaName" value="{{$profileInfo->last_roma_name}}" placeholder="Yamada">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="firstRomaName" class="size-9 required">名前（英語表記）</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="firstRomaName" id="firstRomaName" value="{{$profileInfo->first_roma_name}}" placeholder="Taro">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="userId" value={{$profileInfo->user_id}}>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn update" id="nameUpdate">更新</button>
                </div>
			</div>
		</div>
	</div>
</div>
@stop
