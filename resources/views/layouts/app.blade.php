<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" media="screen" />
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" media="screen" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" media="screen" />
    <link href="{{asset('assets/plugins/fontawesome/css/solid.css')}}" rel="stylesheet" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <script type="text/javascript" src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.accordion.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.custom-scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/selectnav.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/functions.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/fontawesome/js/fontawesome.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/fontawesome/js/solid.js')}}"></script>
    <!-- Tambahan Desember 2018 -->
    <script type="text/javascript" src="{{asset('assets/validasi/inputan.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/selectize.default.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/selectize.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/autocomplete/easy-autocomplete.themes.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/autocomplete/easy-autocomplete.min.css')}}">
    <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.easy-autocomplete.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/popup/jBox.all.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/popup/notif.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/popup/jBox.all.css')}}">
    <script type="text/javascript" src="{{asset('assets/js/jquery.toast.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/loading.js')}}"></script>
    <!-- Ditambahkan 30 Desember 2018 -->
    <!-- Ditambahkan 03 Februari 2018 -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/number/jquery.fs.stepper.css')}}">
    <script type="text/javascript" src="{{asset('assets/plugins/number/jquery.fs.stepper.js')}}"></script>
    <!-- Tambahan 23 Maret 2019 -->
    <script type="text/javascript" src="{{asset('assets/validasi/konversi_nilai.js')}}"></script>
    @yield("script")
</head>
<body>
<div class="wrapper">
    <div class="structure-row">
        @include("layouts.navigasi")
        <div class="right-sec">
            @include("layouts.header")
            <div class="content-section">
                <div class="container-liquid">
                    <div class="row">
                        <!-- Isi Konten -->
                        @yield("konten")
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield("plugin")
<script type="text/javascript">
    $(document).ready(function() {
        @if(Session::has('success'))
            miniNotif("success","{{Session::get('success')}}");
        @endif
        @if(Session::has('error'))
            miniNotif("error","{{Session::get('error')}}");
        @endif
        @if(Session::has('warning'))
            miniNotif("warning","{{Session::get('warning')}}");
        @endif
        @if(Session::has('info'))
            miniNotif("info","{{Session::get('info')}}");
        @endif
    });
</script>
</body>
</html>