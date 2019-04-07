@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('dapil.index')}}">Daerah Pemilihan (DAPIL)</a></li>
            <li class="active">Tambah</li>
        </ol>
     </section>
</div>
<form action="{{Route('dapil.store')}}" method="POST">
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Penambahan Dapil</h2>
        </header>
        <div class="contents">
            <a class="togglethis">Toggle</a>
            <div class="table-box">
                <table class="display table" id="tabel-user">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th class="col-md-8">Value/Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<tr>
                    		<td>Nama Dapil</td>
                    		<td>
                    			<input type="text" name="nama_dapil" value="" placeholder="Contoh: Dapil-001" class="form-control" id="nama_dapil">
                    		</td>
                    	</tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="col-xs-12 right">
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan Dapil</button>
</div>
<div class="token">{{csrf_field()}}</div>
</form>
<script type="text/javascript">
	function validasi() {
		$dapil = $("#nama_dapil").val();
		if($dapil=="") {
			miniNotif("warning","Nama Dapil belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection