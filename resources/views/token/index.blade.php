@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Pemilihan Umum (Pemilu)</a></li>
            <li><a href="#">Token Akses</a></li>
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
            <div class="alert alert-warning">
                <strong>Warning!</strong>
                Pastikan tombol regenerate token dibawah diklik ketika seluruh data TPS diinput dan sebelum pemilu dilakukan!
            </div>
            <div class="alert alert-info">
                <strong>Informasi!</strong>
                Agar operator TPS dapat menginputkan suara silahkan berikan kode token akses dibawah!
            </div>
            <div class="alert alert-info">
                <strong>Informasi!</strong>
                Apabila terdapat TPS yang tidak memiliki kode token silahkan klik tombol "Regenerate Token".
            </div>
            <div class="alert alert-danger">
                <strong>Perhatian!</strong>
                Tidak dianjurkan mengklik tombol "Regenerate Token" ketika pemilu sedang berlangsung!
            </div>
        </div>
        <div class="right" style="padding:10px">
            <a class="btn btn-md style2 btn-primary" target="_BLANK" href="{{Route('cetak')}}/{{Crypt::encrypt('token')}}">
                <i class="fa fa-print"></i> Cetak Rekap Token
            </a>
            <button class="btn btn-md style2 btn-warning" onclick="regenerate()" data-confirm="<b>YAKIN AKAN REGENERATE TOKEN?</b><br> <i>Sebelum aksi ini Anda lakukan, pastikan Anda yakin bahwa Anda mengeksekusi perintah ini sebelum pemilu pada tanggal 17 April 2019 dilaksanakan!</i>">
                <i class="fa fa-repeat"></i> Regenerate Token
            </button>
        </div>
    </div>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <header>
            <h2 class="heading">
                Token Akses
            </h2>
        </header>
        <div class="contents">
            <div class="table-box">
                <table class="display table" id="tabel-token">
                	<thead>
                		<tr>
                            <th>No</th>
                            <th>Dapil</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>TPS</th>
                            <th>Token</th>
                		</tr>
                	</thead>
                    <tbody>
                        @foreach($tps as $index => $value)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$value->desa->kecamatan->dapil->nama_dapil}}</td>
                            <td>{{$value->desa->kecamatan->kecamatan}}</td>
                            <td>{{$value->desa->desa}}</td>
                            <td>{{$value->nama_tps}}</td>
                            @if($value->token!=null)
                            <td>{{$value->token->token}}</td>
                            @else
                            <td>-</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".table").DataTable();
    })
    function regenerate() {
        showLoading("Regenerate...");
        $.ajax({
            url : "{{Route('api')}}/token/generate_token",
            success:function(res) {
                hideLoading();
                if(res.success) {
                    miniNotif("success",res.pesan);
                    redirect("{{Route('token_akses')}}",3000);
                } else
                    miniNotif("error",res.pesan);
            },
            error: function() {
                hideLoading();
                miniNotif("error","Regenerate token gagal dilakukan! Coba periksa koneksi internet!");
            }
        })
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection