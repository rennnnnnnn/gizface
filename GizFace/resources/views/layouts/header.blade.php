<!-- header -->
<header class="main-header">
    <meta name="csrf-token" content="" />

    <!-- トップメニュー -->
    <nav class="navbar" role="navigation">
        <div class="logo-area">
            <a class="navbar-brand logo" href="{{ route('profile.index')}}">GizFace</a>
        </div>
        <div class="search-area">
            <form name="headerForm" id="headerForm" action="" target="_self" method="get" class="form-inline">
                {{ csrf_field() }}
                <div class="form-group category-list">
                  <label for="searchCategory">検索対象</label>
                  <select name="searchCategory" class="form-control" id="searchCategory">
                      <option value='' disabled selected style='display:none;'>選択して下さい</option>
                      <option value='user' @if(old('searchCategory')=='user') selected  @endif>ユーザー</option>
                      <option value='article' @if(old('searchCategory')=='article') selected  @endif>記事</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="searchSkill">スキル</label>
                    <select name="searchSkill[]" class="multiple form-control" id="searchSkill" multiple="multiple">
                        @foreach($skillOption as $value)
                        <option value="{{ $value->skill }}" @if (is_array(old("searchSkill")) && in_array("$value->skill" , old("searchSkill") , true)) selected @endif>
                            {{$value->skill}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="userName">名前</label>
                <input type="text" name="userName" class="form-control" id="userName" value="{{ old('userName')}}">
                </div>
                <div class="form-group">
                    <label for="userAge">年齢</label>
                <input type="number" name="userAge" class="form-control" id="userAge" placeholder="歳" value="{{ old('userAge')}}">
                </div>
                <div class="form-group">
                    <label for="articleCategory">記事カテゴリー</label>
                    <select name="articleCategory[]" class="multiple form-control" id="articleCategory" multiple="multiple">
                        @foreach ($postCategoryList as $key => $value)
                        <option value="{{ $key }}" @if (is_array(old("articleCategory")) && in_array("$value" , old("articleCategory") , true)) selected @endif>
                            {{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="articleTitle">記事タイトル</label>
                    <input type="text" name="articleTitle" class="form-control" id="articleTitle" disabled value="{{ old('articleTitle')}}">
                </div>
                {{-- <div class="form-group">
                    <label for="searchKeyword">フリーワード</label>
                    <input type="text" class="form-control" id="searchKeyword" name="searchKeyword" placeholder="キーワードを入力" size="50" style="margin-right: 20px;">
                </div> --}}
                <button type="submit" class="btn btn-default" id="headerSearch" ><span><i class="fa fa-search "></i> </span></button>
            </form>
        </div>
        <div class="user-menu-wrapper">
            <div class="user-profile-photo" id="profileIcon">
                <span>
                    <img src="{{$avatar}}" alt="プロフィール画像">
                </span>
            </div>
            <div class="user-account-menu" style="display: none;">
                <div class="user-account-links menu-list">
                    <ul>
                        <li>
                        <a href="{{route('user.top')}}" class="account-link">
                                <div class="name-area">
                                    <div class="name">{{$userName}}</div>
                                    <div class="edit-profile">プロフィールを編集</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="user-menu-list menu-list">
                    <ul>
                        <li>
                            <a href="{{route('logout')}}">ログアウト
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<script type="text/javascript">
$(function(){
    $('.multiple').multiselect({
        nonSelectedText: '選択して下さい'
    });
    // 遷移時、記事カテゴリー、記事タイトルdisabled
    $('#articleCategory+.btn-group >.multiselect').prop('disabled',true)

    $('#searchCategory').on('change',function(){
        if($(this).val()==='article'){
            $('#articleCategory+.btn-group >.multiselect').prop('disabled',false)
            $('#articleTitle').prop('disabled',false);
            $('#searchSkill+.btn-group >.multiselect').prop('disabled',true)
            $('#userName').prop('disabled',true);
            $('#userAge').prop('disabled',true);
        }  else{
            $('#articleCategory+.btn-group >.multiselect').prop('disabled',true)
            $('#articleTitle').prop('disabled',true);
            $('#searchSkill+.btn-group >.multiselect').prop('disabled',false)
            $('#userName').prop('disabled',false);
            $('#userAge').prop('disabled',false);
            }
    });

    $('#headerSearch').on('click',function(){
        $("#headerForm").attr("action", "{{ route('header.search') }}");
        $('#headerForm').attr("method","post");
        $("#headerForm").attr("target", "_blank");
        $("#headerForm").submit();
    });

    $(document).click(function(event) {
        if(!$(event.target).closest('.user-menu-wrapper').length) {
            $('.user-account-menu').css('display','none');
        }
    });

    $('#profileIcon').click(function(){
        // 表示されている場合の処理
        if ($('.user-account-menu').css('display') == 'block') {
            $('.user-account-menu').css('display','none');
        } else {
        // 非表示の場合の処理
        $('.user-account-menu').css('display','block');
        }
    });

});

</script>
<!-- end header -->
