<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{ Html::style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
    {{Html::style('bower_components/font-awesome/css/font-awesome.min.css') }}
    {{ Html::style('bower_components/Ionicons/css/ionicons.min.css') }}
    {{ Html::style('bower_components/jvectormap/jquery-jvectormap.css') }}
    <!-- {{ Html::style('DataTables/datatables.min.css') }} -->
    {{ Html::style('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
    {{ Html::style('dist/css/AdminLTE.min.css') }}
    {{ Html::style('dist/css/skins/_all-skins.min.css') }}
    {{ Html::style('bower_components/select2/dist/css/select2.min.css') }}
    {{ Html::style('css/custom.css') }}
    {{ Html::style('plugins/iCheck/all.css') }}
    {{ Html::style('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}
    {{  Html::script('bower_components/jquery/dist/jquery.min.js') }}
    <!-- {{ Html::script('DataTables/datatables.min.js') }} -->
    {{ Html::script('bower_components/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
    {{  Html::script('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
    {{  Html::script('bower_components/select2/dist/js/select2.full.min.js') }}
    {{  Html::script('js/custom.js') }}
    @toastr_css
    @toastr_js
    <!-- @notifyCss -->
    <!-- Fonts -->
    <script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div id="app" style="opacity:0.2">
        <div class="wrapper">
            <header class="main-header">
                @include('backend.includes.header')
            </header>
            <aside class="main-sidebar">
                @include('backend.includes.sidebar')
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    {{ Breadcrumbs::render() }}
                </section>
                </br>
                @yield('content')
            </div>
            <footer class="main-footer">
                @include('backend.includes.footer')
            </footer>
        </div>
    </div>
    <div class="mesh-loader" style="z-index:9999">
        <div class="set-one">
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
        <div class="set-two">
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
    </div>
    @include('includes.confirm')
    {{  Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') }}
    {{  Html::script('bower_components/fastclick/lib/fastclick.js') }}
    {{  Html::script('dist/js/adminlte.min.js') }}
    {{  Html::script('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}
    {{  Html::script('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
    {{  Html::script('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
    {{  Html::script('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
</body>
</html>
