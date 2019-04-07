<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
    <link href="{{asset('assets/login/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('assets/css/sweetalert2.css')}}" rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="{{asset('assets/js/sweetalert2.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/inputan.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/validasi/inputan.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.js')}}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Simple Login Form,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <h1>Login Page</h1>
    <div class="login"> 
        <div class="ribbon-wrapper h2 ribbon-red">
            <div class="ribbon-front">
                <h2>Welcome</h2>
            </div>
            <div class="ribbon-edge-topleft2"></div>
            <div class="ribbon-edge-bottomleft"></div>
        </div>
        <form action="{{ route('login') }}" method="POST" id="formlogin">
            {{csrf_field()}}
            <ul>
                <li>
                    <input type="text" class="text" value="{{ old('email') }}" placeholder="Alamat Email" name="email"><a href="#" class=" icon user"></a>
                </li>
                 <li>
                    <input type="password" value="{{ old('password') }}" placeholder="Kata Sandi" name="password"><a href="#" class=" icon lock"></a>
                </li>
            </ul>
            <input type="submit" name="" id="submitForm" style="display:none">
        </form>
        <div class="submit">
            <input type="submit" value="Log in" onclick="submit()">
        </div>
    </div>
    <script type="text/javascript">
        function submit() {
            $("#submitForm").click();
        }
        @if (session('status'))
          notif("success","Link untuk mereset kata sandi berhasil dikirim ke email Anda!");
        @elseif ($errors->has('email'))
            notif("error","Akun tidak ditemukan pada sistem!");
        @elseif ($errors->has('password'))
            notif("error","{{$errors->first('password')}}");
        @endif
    </script>
</body>
</html>