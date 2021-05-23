<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
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

  <!--Bootstrap Datepicker-->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ja.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

  <!-- multiselect -->
  <link href="{{asset('css/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/js/bootstrap-multiselect.js') }}"></script>

  <!-- 共通css -->
  <link href="{{asset('css/common.css')}}" rel="stylesheet" type="text/css" />
  @yield('css')

</head>
<body>
    <div class="container">
        <div class="wrapper">
            @include('layouts.header')
            <!-- content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- Sub content -->
            <section class="content2">
                @yield('content2')
            </section>
            <section class="content3">
                @yield('content3')
            </section>
            <!-- end content -->
            @include('layouts.footer')
        </div>
    </div>
    <script src="{{ asset('/js/common.js') }}"></script>
    @yield('js')
</body>
</html>
