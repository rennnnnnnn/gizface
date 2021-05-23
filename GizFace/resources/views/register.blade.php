<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>新規登録</title>
        <!-- for responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Bootstrap本体 -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- Scripts（Jquery） -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Scripts（bootstrapのjavascript） -->

        <!-- jquery-ui -->
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>

        <!-- font-awesome -->
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

        <!-- validation -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="outer-box show" style="margin-left: 40px; margin-top:60px; width:45%;">
                    <form name="f1" id="form1" action="" target="_self" class="" method="get">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="lastName" class="size-9 required">苗字</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="lastName" id="lastName" value="{{old('lastName',$slackAccount->name)}}" placeholder="山田">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="firstName" class="size-9 required">名前</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="firstName" id="firstName" value="{{old('firstName')}}" placeholder="太郎">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="lastRomaName" class="size-9 required">苗字（英語表記）</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="lastRomaName" id="lastRomaName" value="{{old('lastRomaName')}}" placeholder="Yamada">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="firstRomaName" class="size-9 required">名前（英語表記）</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="firstRomaName" id="firstRomaName" value="{{old('firstRomaName')}}" placeholder="Taro">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <div>
                                    <label class="control-label size-9 required">性別</label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="gender" value="0" @if( old('gender')=='0' || !$errors->any()) checked @endif>
                                        男性
                                    </label>
                                    <label style="margin-left:30px;">
                                        <input type="radio" name="gender" value="1" @if( old('gender')=='1' )checked @endif>
                                        女性
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="birthday" class="size-9 required">生年月日</label>
                                <div class="birthday">
                                    <select id="year" name="year"></select>年
                                    <select id="month" name="month"></select>月
                                    <select id="day" name="day"></select>日​
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="email" value="{{old('email',$slackAccount->email)}}">
                        <input type="hidden" name="avatar" value="{{old('avatar',$slackAccount->avatar)}}">
                        <input type="hidden" name="userId" value="{{old('userId',$userId ?? '')}}">
                    </form>
                    <div class="text-right">
                        <button type="button" class="btn" id="register">登録</button>
                    </div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="{{ asset('css/auth/top.css') }}">
        <link rel="stylesheet" href="{{ asset('css/common.css') }}">
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
        <script type="text/javascript">
        $(function(){
            // 生年月日セレクトリスト
            var time = new Date();
            var year = time.getFullYear();
            var birthYear = @json(old('year'));
            var birthMonth = @json(old('month'));
            var birthDay = @json(old('day'));

            for (var i = year; i >= 1980; i--) {
                if(birthYear == i){
                    $('#year').append('<option selected value="' + i + '">' + i +'</option>');
                }else{
                    $('#year').append('<option value="' + i + '">' + i + '</option>');
                }
            }
            for (var i = 1; i <= 12; i++) {
                if(birthMonth == i){
                    $('#month').append('<option selected value="' + i + '">' + i +'</option>');
                }else{
                    $('#month').append('<option value="' + i + '">' + i + '</option>');
                }
            }
            for (var i = 1; i <= 31; i++) {
                if(birthDay == i){
                    $('#day').append('<option selected value="' + i + '">' + i +'</option>');
                }else{
                    $('#day').append('<option value="' + i + '">' + i + '</option>');
                }
            }

            // 登録ボタン
            $('#register').on('click',function(){
                 //validate実行 必須チェック
            $('#form1').validate({
            rules: {
                lastName: {
                required: true,
                },
                firstName: {
                required: true,
                },
                lastRomaName: {
                required: true,
                },
                firstRomaName: {
                required: true,
                },
            },
            messages: {
                lastName: {
                    required: '必須です。'
                },
                firstName: {
                    required: '必須です。'
                },
                lastRomaName: {
                    required: '必須です。'
                },
                firstRomaName: {
                    required: '必須です。'
                },
            }
        });
            // バリデーションエラーで戻る
            if (!$("#form1").valid()) {
                return false;
            };
                $('#form1').attr("action","{{ route('register.user') }}");
                $('#form1').attr("target","_self");
                $('#form1').attr("method","post");
                $('#form1').submit();
            });
        })

        </script>
    </body>
</html>
