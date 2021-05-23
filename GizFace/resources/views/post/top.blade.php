<div class="post-list">
    <div class="slick">
        @if(!empty($postList))
            @foreach($postList as $key => $value)
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
                        <div class="user-menu-wrapper">
                            <div class="user-profile-photo" id="profileIcon">
                                <span>
                                    <a href="{{ asset('/profile/detail?id=').$value->id }}"><img class="thum" style="width:40px;height:40px;"src="{{$value->profile_image_path}}" alt="プロフィール画像"></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>


