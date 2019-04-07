<aside class="sidebar">
    <div class="sidebar-in">
        <header>
            <div class="logo">
                <a href="{{Route('home')}}">
                    <img src="{{asset('assets/images/logo.png')}}" alt="SIPKJ" />
                </a>
            </div>
            <a href="#" class="togglemenu">&nbsp;</a>
            <div class="clearfix"></div>
        </header>

        <nav class="navigation">
            <ul class="navi-acc" id="nav2">
                @if(Route::currentRouteName() == "home" || Route::currentRouteName() == "dashboard")
                <li class="parentlist active">
                @else
                <li class="parentlist">
                @endif
                    <a href="{{Route('home')}}" class="dashboard">Dashboard</a>
                </li>
                <li class="parentlist">
                    <a href="#" class="forms">Pemilihan Umum</a>
                    <ul class="menu-1">
                        @if(Auth::user()->isAdmin)

                        @if(Route::currentRouteName() == "token_akses") <li class="active"> @else <li> @endif
                            <a href="{{Route('token_akses')}}">Token TPS</a>
                        </li>

                        @if(Route::currentRouteName() == "suara_terkumpul") <li class="active"> @else <li> @endif
                            <a href="{{Route('suara_terkumpul')}}">Suara Terkumpul</a>
                        </li>
                        @endif

                        @if(
                            Route::currentRouteName() == "pemungutan_suara.index" ||
                            Route::currentRouteName() == "pemungutan_suara.show" ||
                            Route::currentRouteName() == "pemungutan_suara.edit" ||
                            Route::currentRouteName() == "pemungutan_suara.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('pemungutan_suara.index')}}">Pemungutan Suara</a>
                        </li>


                        <!-- @if(
                            Route::currentRouteName() == "pemungutan_suara_partai.index" ||
                            Route::currentRouteName() == "pemungutan_suara_partai.show" ||
                            Route::currentRouteName() == "pemungutan_suara_partai.edit" ||
                            Route::currentRouteName() == "pemungutan_suara_partai.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('pemungutan_suara_partai.index')}}">Pemungutan Suara (Partai)</a>
                        </li> -->
                    </ul>
                </li>
                @if(Auth::user()->isAdmin)
                <li class="parentlist">
                    <a href="#" class="database">Data Master</a>
                    <ul class="menu-1">
                        @if(
                            Route::currentRouteName() == "dapil.index" ||
                            Route::currentRouteName() == "dapil.show" ||
                            Route::currentRouteName() == "dapil.edit" ||
                            Route::currentRouteName() == "dapil.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('dapil.index')}}">Data Daerah Pemilihan (DAPIL)</a>
                        </li>

                        @if(
                            Route::currentRouteName() == "kecamatan.index" ||
                            Route::currentRouteName() == "kecamatan.show" ||
                            Route::currentRouteName() == "kecamatan.edit" ||
                            Route::currentRouteName() == "kecamatan.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('kecamatan.index')}}">Data Kecamatan</a>
                        </li>

                        @if(
                            Route::currentRouteName() == "desa.index" ||
                            Route::currentRouteName() == "desa.show" ||
                            Route::currentRouteName() == "desa.edit" ||
                            Route::currentRouteName() == "desa.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('desa.index')}}">Data Desa</a>
                        </li>

                        @if(
                            Route::currentRouteName() == "tps.index" ||
                            Route::currentRouteName() == "tps.show" ||
                            Route::currentRouteName() == "tps.edit" ||
                            Route::currentRouteName() == "tps.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('tps.index')}}">Data Tempat P. Suara (TPS)</a>
                        </li>

                        @if(
                            Route::currentRouteName() == "partai.index" ||
                            Route::currentRouteName() == "partai.show" ||
                            Route::currentRouteName() == "partai.edit" ||
                            Route::currentRouteName() == "partai.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('partai.index')}}">Data Partai</a>
                        </li>

                        @if(
                            Route::currentRouteName() == "calonDPR.index" ||
                            Route::currentRouteName() == "calonDPR.show" ||
                            Route::currentRouteName() == "calonDPR.edit" ||
                            Route::currentRouteName() == "calonDPR.create"
                            )
                        <li class="active"> @else <li> @endif
                            <a href="{{Route('calonDPR.index')}}">Data Calon DPR</a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->isAdmin)
                <li class="parentlist">
                    <a href="#" class="prints">Cetak</a>
                    <ul class="menu-1">
                        <li><a href="{{Route('cetak')}}/{{Crypt::encrypt('laporan')}}" target="_BLANK">Laporan Pemilu 2019</a></li>
                    </ul>
                </li>
                @endif
            </ul>
            <div class="clearfix"></div>
        </nav>
        <span class="shadows"></span>
    </div>
</aside>
<script type="text/javascript">
    $(document).ready(function(){
        $("li.active").parent("ul").attr("style","display:block");
        $("li.active").parent("ul").parent("li").attr("class","active");
    });
</script>