<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Laravel</title>
        {{ Html::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
        {{ Html::style('bower_components/font-awesome/css/font-awesome.min.css') }}
        {{ Html::style('bower_components/Ionicons/css/ionicons.min.css') }}
        {{ Html::style('dist/css/AdminLTE.min.css') }}
        {{ Html::style('plugins/iCheck/square/blue.css') }}
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body class="hold-transition login-page">
   <div id="app">
    @yield('content');
   </div>
<!-- /.login-box -->

{{  Html::script('bower_components/jquery/dist/jquery.min.js') }}
{{  Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') }}
{{  Html::script('plugins/iCheck/icheck.min.js') }}
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
    </body>
</html>
