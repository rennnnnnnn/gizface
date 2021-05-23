@section('content3')
<!-- モーダル・ダイアログ -->
<div class="modal fade" id="imageModal" tabindex="-1">
    @if ($errors->any())
    <div class="alert alert-danger">
       <p class="text-center">正しく入力されていない項目があります。メッセージをご確認の上、もう一度ご入力下さい。</p>
    </div>
    @endif
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <p class="modal-title">アバター写真</p>
			</div>
			<div class="modal-body">
                    <div class="image-field-wrapper">
                        <div class="thumb-wrapper">
                            <img class="media-object" id="image" src="{{$profileInfo->profile_image_path}}">
                        </div>
                        <div class="image-input-wrapper">
                            <form name="uploadForm" id="uploadForm" action="" target="_self" class="" method="get" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="file" id="selectFile" name="selectFile" accept="image/*">
                                <input type="hidden" name="profileId" id="profileId" value={{$profileInfo->profile_id}}>
                            </form>
                        </div>
                    </div>
                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn update" id="imageUpdate">更新</button>
                </div>
			</div>
		</div>
	</div>
</div>
@stop
