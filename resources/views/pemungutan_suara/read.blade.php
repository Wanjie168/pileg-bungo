@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Pemilihan Umum (Pemilu)</a></li>
            <li class="active">Suara Tekumpul</li>
        </ol>
     </section>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Lokasi Pemungutan Suara</h2>
        </header>
        <div class="contents">
            <a class="togglethis">Toggle</a>
            <div class="table-box">
                <table class="display table">
                	<thead>
                		<tr>
                			<th>Parameter</th>
                			<th class="col-md-8">Value</th>
                		</tr>
                	</thead>
                    <tbody>
                    	<tr>
                    		<td>Lokasi Pemungutan Suara</td>
                    		<td>
                    			<select class="selectize" id="tps" onchange="chooseTPS(value)">
                    				<option value="all" selected>Seluruh TPS</option>
                                    @foreach($tps as $value)
                                    <option value="{{Crypt::encrypt($value->id_tps)}}">{{$value->nama_tps}}, {{$value->desa->desa}}, {{$value->desa->kecamatan->kecamatan}}, {{$value->desa->kecamatan->dapil->nama_dapil}}</option>
                                    @endforeach
                    			</select>
                    		</td>
                    	</tr>
                        <tr id="dapil-row">
                            <td>Daerah Pemilihan (Dapil)</td>
                            <td>
                                <select class="selectize" id="dapil">
                                    @foreach($dapil as $value)
                                    <option value="{{Crypt::encrypt($value->id_dapil)}}">{{$value->nama_dapil}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="right" style="padding:20px">
            	<button class="btn btn-md btn-success style2" id="btnFilter" onclick="tampilkanSuara()">
            		Tampilkan Suara Tekumpul
            	</button>
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".selectize").selectize();
    })
    function tampilkanSuara() {
        $tps   = $("#tps").val();
        $dapil = $("#dapil").val();
        //showLoading("Memuat...");
        if($tps=="all")
            redirect("{{Route('suara_terkumpul')}}/dapil/"+$dapil);
        else
            redirect("{{Route('suara_terkumpul')}}/"+$tps);
    }
    function chooseTPS($val) {
        if($val=="all") {
            $("#dapil-row").attr("style","display:table-row");
        } else {
            $("#dapil-row").attr("style","display:none");
        }
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection