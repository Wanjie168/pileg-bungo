<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Sistem informasi ini dikembangkan oleh Ahmad Saparudin">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link rel="stylesheet" href="{{asset('assets\landing\css\normalize.css')}}">        
        <link rel="stylesheet" href="{{asset('assets\landing\css\pageloader.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\fonts\opensans\stylesheet.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\fonts\geosans\stylesheet.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\css\ionicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\css\foundation.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\js\vendor\jquery.fullPage.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\js\vegas\vegas.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\css\main.css')}}">
        <link rel="stylesheet" href="{{asset('assets\landing\css\main_responsive.css')}}">
        <script src="{{asset('assets\landing\js\vendor\modernizr-2.7.1.min.js')}}"></script>
    </head>
    <body id="menu" class="alt-bg">
        <div class="page-loader" id="page-loader">
            <div><i class="ion ion-load-c ion-spin"></i><p>loading</p></div>
        </div>
        <header class="header-top">
            <a class="menu-icon clearfix">
                <div class="bars">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="txt">Menu</div>
            </a>
            <ul class="menu clearfix">
                <li>
                    @if(Auth::user())
                    <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                    <a href="{{ url('/login') }}">Login ke Sistem</a>
                    @endif
                </li>
                
                <li>
                    <a href="#contact">Kontak Admin</a>
                </li>
            </ul>
        </header>
        <nav class="page-nav">
            <div>
                <a href="#home"><i class="ion icon ion-ios-home"></i>
                    <span class="title">Home page</span>
                </a>
                <a href="#contact"><i class="ion icon ion-ios-email"></i>
                    <span class="title">Kontak</span>
                </a>
            </div>
        </nav>
        <div class="page-cover">
            <div class="cover-bg pos-abs full-size bg-img" data-image-src="{{asset('assets/landing/img/bg-default.jpg')}}"></div>
            <div id="particles-js" class="cover-bg pos-abs full-size bg-color" data-bgcolor="rgba(37, 38, 42, 0.81)"></div>
        </div>
        <div class="pane-when " id="s-when">
            <div class="content clearfix">
                <header class="header">
                    <p>Jumlah Suara Masuk</p>
                </header> 
                <div class="clock">
                    <div class="site-config" data-date="01/01/2020 00:00:00" data-date-timezone="+0"></div>
                    <div class="medium clearfix">
                        <span>{{number_format($suara_masuk)}}</span>
                    </div>
                    <div class="small">
                        <span class="thin"> suara</span>
                    </div>
                </div>
            </div> 
        </div>
        <main class="page-main" id="mainpage">             
            <div class="section page-home page page-cent" data-section="home">
                <h3 class="s-title">E-Quck Count</h3>
                <div class="s-fixed-content">
                    <ul>
                        <li>
                            <h4>Lihat hasil Quick Count <a href="{{Route('cetak')}}/{{Crypt::encrypt('laporan')}}" target="_BLANK">disini!</a></h4>
                        </li>
                    </ul>
                </div>
                <section class="content">
                    <header class="header">
                        <div class="p-title">
                            <img class="h-logo" src="{{asset('assets\landing\img\logo.png')}}" alt="Logo">
                        </div>
                        <div class="h-right">
                            <h3>Selamat <br>datang</h3>
                            <h4 class="subhead"><a href="#register">DI SISTEM INFORMASI PEMILU 2019 PROVINSI JAMBI</a></h4>
                            <p>Sistem informasi ini menangani suara masyarakat di berbagai TPS di Provinsi Jambi untuk tanggal 17 April 2019.</p>
                        </div>
                    </header>
                </section>
                <footer class="p-footer p-scrolldown">
                    <a class="down btn">
                        <div> 
                        </div>
                    </a>  
                </footer>
            </div>
            <div class="section page-contact page page-cent" data-section="contact">
                <h3 class="s-title">Kontak
                </h3>
                <div class="s-fixed-content">
                    <ul>
                        <li>
                            <h4>Find us on</h4>
                            <div class="socialnet">
                                <a href="#"><i class="ion ion-social-facebook"></i>
                                    <span class="title">Facebook</span>
                                </a>
                                <a href="#"><i class="ion ion-social-instagram"></i>
                                    <span class="title">Instagram</span>
                                </a>
                                <a href="#"><i class="ion ion-social-twitter"></i>
                                    <span class="title">Twitter</span>
                                </a>
                                <a href="#"><i class="ion ion-social-pinterest"></i>
                                    <span class="title">Pinterest</span>
                                </a>
                                <a href="#"><i class="ion ion-social-tumblr"></i>
                                    <span class="title">Tumblr</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="slide" id="s-information">
                    <section class="content">
                        <div class="contact">
                            <div class="row">
                                <div class="medium-12 columns left">
                                    <ul>
                                        <li>
                                            <p><strong>Email : </strong><a href="mailto://circledeveloperid@gmail.com">circledeveloperid@gmail.com</a></p>
                                        </li>
                                        <li>
                                            <p><strong>Ponsel : </strong>0823-0202-5552</p>
                                        </li>
                                        <li>
                                            <p>&copy A-Tech Software Solution, 2019</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>  
                </div>
                <footer class="p-footer p-scrolldown">
                    <a class="up btn">
                        <div> 
                        </div>
                    </a>                        
                </footer>
            </div>
        </main>
        <script src="{{asset('assets\landing\js\vendor\jquery-1.11.2.min.js')}}"></script>
        <script src="{{asset('assets\landing\js\vendor\all.js')}}"></script>
        <script src="{{asset('assets\landing\js\particlejs\particles.min.js')}}"></script>
        <script src="{{asset('assets\landing\js\particlejs\particles-init.js')}}"></script>
        <script src="{{asset('assets\landing\js\jquery.downCount.js')}}"></script>
        <script src="{{asset('assets\landing\js\form_script.js')}}"></script>
        <script src="{{asset('assets\landing\js\main.js')}}"></script>
    </body>
</html>