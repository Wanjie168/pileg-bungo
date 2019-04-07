@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Pemilihan Umum (Pemilu)</a></li>
            <li><a href="#">Pemungutan Suara</a></li>
            <li><a href="#">{{$infoTPS->desa->kecamatan->dapil->nama_dapil}}</a></li>
            <li><a href="#">{{$infoTPS->desa->kecamatan->kecamatan}}</a></li>
            <li><a href="#">{{$infoTPS->desa->desa}}</a></li>
            <li><a href="#">{{$infoTPS->nama_tps}}</a></li>
        </ol>
     </section>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Close</a>
        <header>
            <h2 class="heading">Informasi Penting</h2>
        </header>
        <div class="contents boxpadding">
            <a class="togglethis">Toggle</a>
            <div class="alert alert-info">
                <strong>Informasi!</strong>
                TPS ini memiliki maksimum suara sebanyak: {{$infoTPS->max_suara}} suara.
            </div>
            <div class="alert alert-warning">
                <strong>Ingat!</strong>
                Silahkan validasi jumlah suara terlebih dahulu sebelum mensubmit suara!
            </div>
            <div class="alert alert-warning">
                <strong>Ingat!</strong>
                Suara yang telah disubmit tidak dapat diubah kembali!
            </div>
        </div>
    </div>
</div>
@foreach($partai as $data)
<div class="col-xs-6">
    <div class="sec-box">
        <header>
            <h2 class="heading">
                {{$data->nama_partai}}
                <img src="{{asset('uploads')}}/{{$data->logo_partai}}" style="width:30px;height:30px;border-radius:10px;border:2px solid black;margin-left:10px;">
                <input type="number" id_partai="{{$data->id_partai}}" placeholder="0" min="0" class="suara_partai" onkeydown="return validasi_number(event)" style="width:50px;margin:5px;">
            </h2>
        </header>
        <div class="contents">
            <div class="table-box">
                <table class="display table">
                	<thead>
                		<tr>
                            <th>No</th>
                            <th>Calon</th>
                			<th class="col-sm-4">Jml. Suara</th>
                		</tr>
                	</thead>
                    <tbody>
                        @foreach($data->calon_dpr as $index => $calon)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td style="margin:0px">
                                <img src="{{asset('uploads')}}/{{$calon->foto_calon}}" style="width:40px;height:50px;border-radius:10px;border:2px solid grey;margin-right:10px;"> 
                                {{$calon->nama_calon}}
                            </td>
                            <td>
                                <input type="number" id_calon="{{$calon->id_calon}}" placeholder="0" min="0" class="form-control suara_calon" onkeydown="return validasi_number(event)">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endforeach
@foreach($partaiKosong as $data)
<div class="col-xs-6">
    <div class="sec-box">
        <header>
            <h2 class="heading">
                {{$data->nama_partai}}
                <img src="{{asset('uploads')}}/{{$data->logo_partai}}" style="width:30px;height:30px;border-radius:10px;border:2px solid black;margin-left:10px;">
                <input type="number" id_partai="{{$data->id_partai}}" placeholder="0" min="0" class="suara_partai" onkeydown="return validasi_number(event)" style="width:50px;margin:5px;">
            </h2>
        </header>
        <div class="contents">
            <div class="table-box">
                <table class="display table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Calon</th>
                            <th class="col-sm-4">Jml. Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">Tidak ada calon</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endforeach
<div class="col-xs-12">
    <div class="right">
        <button class="btn btn-md style2 btn-success" onclick="submitSuara()" data-confirm="<b>YAKIN SUBMIT SUARA SEKARANG?</b><br> <i>Sebelum submit suara, pastikan data suara yang diinputkan benar! Data yang telah disubmit tidak dapat diubah kembali!</i>">
            <i class="fa fa-save"></i> Submit Suara TPS
        </button>
    </div>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
    function submitSuara() {
        $validasiSuara = validasiSuara();
        showLoading("Validating...");
        if($validasiSuara.success) {
            hideLoading();
            setTimeout(function(){
                doSubmit();
            },1000);
        } else {
            hideLoading();
            miniNotif("warning",$validasiSuara.pesan);
        }
    }
    function doSubmit() {
        showLoading("Submitting...");
        $.ajax({
            url    : "{{Route('api')}}/submit/data_suara",
            method : "POST",
            data   : {
                "_token"        : $('.token input').val(),
                "id_tps"        : "{{Crypt::encrypt($infoTPS->id_tps)}}",
                "suara"         : generateSuara(),
                "suara_partai"  : generateSuaraPartai(),
            },
            success: function(res) {
                hideLoading();
                if(res.success) {
                    miniNotif("success",res.pesan);
                    redirect("{{Route('pemungutan_suara.index')}}",3000);
                } else
                    miniNotif("error",res.pesan);
            },
            error: function(){
                hideLoading();
                miniNotif("error","Data gagal disubmit! Periksa koneksi internet!");
            },
        });
    }
    function validasiSuara() {
        var response = function($success,$pesan) {
            this.success = $success;
            this.pesan   = $pesan;
        }
        $count = parseInt(getSuara());
        $max   = parseInt("{{$infoTPS->max_suara}}");
        if($count>$max) {
            return new response(false,"Jumlah suara melebihi batas! Batas kuota suara TPS ini adalah: "+$max+" suara!");
        } else {
        /*if($count<$max) {
            return new response(false,"Jumlah suara suara TPS ini ("+$count+") kurang dari kuota yang dijatahkan ("+$max+" suara)!");
        } else {*/
            return new response(true,NaN);
        };
    }
    function getSuara() {
        $count = 0;
        $('.suara_calon').each(function(){
            $val = handleSuara($(this).val());
            $count+=$val;
        });
        $('.suara_partai').each(function(){
            $val = handleSuara($(this).val());
            $count+=$val;
        });
        return $count;
    }
    function generateSuara() {
        $suara = [];
        $('.suara_calon').each(function(){
            $calon             = {};
            $calon['id_calon'] = $(this).attr("id_calon");
            $calon['suara']    = handleSuara($(this).val());
            $suara.push($calon);
        });
        return $suara;
    }
    function generateSuaraPartai() {
        $suara = [];
        $('.suara_partai').each(function(){
            $calon             = {};
            $calon['id_partai'] = $(this).attr("id_partai");
            $calon['suara']    = handleSuara($(this).val());
            $suara.push($calon);
        });
        return $suara;
    }
    function handleSuara($suara) {
        if($suara=="" || $suara==NaN || $suara==null)
            $suara = 0;
        else
            $suara = parseInt($suara);
        return $suara;
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection