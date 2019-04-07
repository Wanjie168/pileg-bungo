@extends('layouts.app')

@section("konten")
<div class="content-section">
    <div class="container-liquid">
        <div class="row">
            <div class="col-xs-2">
                <div class="stat-box colorone">
                    <i class="idCard">&nbsp;</i>
                    <h4>Jumlah Dapil</h4>
                    <h1 class="small-text">
                        {{number_format($dapil)}} Dapil
                    </h1>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="stat-box colorsix">
                    <i class="laporan">&nbsp;</i>
                    <h4>Jumlah Kecamatan</h4>
                    <h1 class="capitalize small-text">
                        {{number_format($kecamatan)}} Kec.
                    </h1>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="stat-box colorfive">
                    <i class="magang">&nbsp;</i>
                    <h4>Jumlah Desa</h4>
                    <h1 class="capitalize small-text">
                        {{number_format($desa)}} Desa
                    </h1>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="stat-box coloreight">
                    <i class="users">&nbsp;</i>
                    <h4>Jumlah TPS</h4>
                    <h1 class="small-text">
                        {{number_format($tps)}} TPS
                    </h1>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="stat-box colortweleve">
                    <i class="fakultas">&nbsp;</i>
                    <h4>Jumlah Partai</h4>
                    <h1 class="capitalize small-text">
                        {{number_format($partai)}} Partai
                    </h1>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="stat-box coloreleven">
                    <i class="pages">&nbsp;</i>
                    <h4>Jumlah Calon DPR</h4>
                    <h1 class="capitalize small-text">
                        {{number_format($calon_dpr)}} Orang
                    </h1>
                </div>
            </div>
        </div>
        <!-- Row End -->
        <div class="row">
            <div class="col-xs-6">
                <div class="sec-box">
                    <a class="closethis">Close</a>
                    <header>
                        <h2 class="heading">Suara TPS Masuk</h2>
                    </header>
                    <div class="contents boxpadding">
                        <a class="togglethis">Toggle</a>
                        <div class="charts-box">
                            <div id="donutchart"></div>
                            <script>
                                Morris.Donut({
                                  element: 'donutchart',
                                  data: [
                                    @if($submitted_tps==$tps)
                                    {value: {{$submitted_tps}}, label: 'Suara Masuk'}
                                    @else
                                    {value: {{$submitted_tps}}, label: 'Suara Masuk'},
                                    {value: {{$tps-$submitted_tps}}, label: 'Suara Belum Masuk'}
                                    @endif
                                  ],
                                  formatter: function (x) { return x + " TPS"}
                                }).on('click', function(i, row){
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="sec-box">
                    <a class="closethis">Close</a>
                    <header>
                        <h2 class="heading">Suara Partai</h2>
                    </header>
                    <div class="contents boxpadding">
                        <a class="togglethis">Toggle</a>
                        <div class="charts-box">
                            <div id="bars"></div>
                            <script>
                                // Use Morris.Bar
                                Morris.Bar({
                                  element: 'bars',
                                  data: [
                                  @foreach($spartai as $data)
                                    {x: '{{$data->nama_partai}}', s:{{$data->hitung_suara_partai($data->id_partai)}}},
                                  @endforeach
                                  ],
                                  xkey: 'x',
                                  ykeys: ['s'],
                                  labels: ['Suara Masuk'],
                                  barColors: function (row, series, type) {
                                    if (type === 'bar') {
                                      var warna = Math.ceil(255 * row.y / this.ymax);
                                      return 'rgb(' + warna + ',100,50)';
                                    }
                                    else {
                                      return '#000';
                                    }
                                  },
                                }).on('click', function(i, row){
                                  console.log(i, row);
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script type="text/javascript" src="assets/js/raphael-2.1.0.min.js"></script>
<script type="text/javascript" src="assets/js/morris-0.4.1.min.js"></script>
@endsection