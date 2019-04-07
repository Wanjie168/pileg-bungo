@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Pemilihan Umum (Pemilu)</a></li>
            <li class="active">Pemungutan Suara Partai</li>
        </ol>
     </section>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Input Data Suara TPS</h2>
        </header>
        <div class="contents">
            <a class="togglethis">Toggle</a>
            <div class="table-box">
                <div class="alert alert-info margin-10">
                    <strong>Informasi!</strong>
                    Untuk menignput suara TPS silahkan masukkan kode token terlebih dahulu!
                </div>
                <div class="alert alert-warning margin-10">
                    <strong>Himbauan!</strong>
                    Kode token dapat diminta kepada Admin.
                </div>
                <hr>
                <div class="margin-10">
                    <p class="center bold underline uppercase">Kode Token:</p>
                    <input type="text" name="" maxlength="10" class="form-control center" style="height:40px;" id="token">
                </div>
                <div class="center" style="padding:20px">
            	<button class="btn btn-md btn-primary style2" id="btnFilter" onclick="submitToken()">
            		Submit Token
            	</button>
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
    function submitToken() {
        $myToken = $("#token").val();
        $token   = $(".token input").val();
        if($myToken=="" || $myToken==NaN || $myToken==null)
            miniNotif("warning","Kode token belum diinput!");
        else {
            showLoading("Memuat...");
            $.ajax({
                url    : "{{Route('api')}}/submit/token",
                method : "POST",
                data   : {
                    "_token" : $token,
                    "token"  : $myToken,
                },
                success: function(res) {
                    hideLoading();
                    if(res.success) {
                        redirect("{{Route('pemungutan_suara.index')}}/"+res.token);
                    } else
                        miniNotif("error",res.pesan);
                },
                error: function() {
                    hideLoading();
                    miniNotif("error","Koneksi ke server bermasalah! Periksa koneksi internet!");
                }
            })
        }
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection