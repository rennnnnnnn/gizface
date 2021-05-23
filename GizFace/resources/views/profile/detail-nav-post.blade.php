<div role="tabpanel" class="tab-pane" id="post">
    <div class="nav-tab-content">
        <div class="col-md-12">
            <div class="post-list">
                <div class="slick">
                    @if(!empty($postInfo))
                        @foreach($postInfo as $key => $value)
                        <div class="row">
                            <div class="post-block" data-id="{{$value->id}}">
                                <div class="post-image">
                                    <a href="{{ asset('/user/post_detail?id=').$value->id }}"><img src="{{asset($value->image_path)}}"></a>
                                </div>
                                <div class="post-detail">
                                    <div class="category-tag">
                                        <div class="small">{{$value->category}}</div>
                                    </div>
                                    <h2 class="post-title">
                                        <a href="{{ asset('/user/post_detail?id=').$value->id }}">{{$value->title}}</a>
                                        <small style="padding-left: 20px;">投稿日：{{ date("Y年m月d日",strtotime($value->created_at)) }}</small>
                                        <small style="padding-left: 20px;">コメント数：{{ $value->reply_count }}</small>
                                    </h2>
                                    <div class="post-body">
                                        <span class="">{!! $value->markdown_body !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
