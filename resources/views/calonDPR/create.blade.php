@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('calonDPR.index')}}">Calon DPR</a></li>
            <li class="active">Tambah</li>
        </ol>
     </section>
</div>
<form action="{{Route('calonDPR.store')}}" method="POST" enctype="multipart/form-data">
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Penambahan Calon DPR</h2>
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
                    		<td>Partai Asal</td>
                    		<td>
                    			<select class="selectize" required name="id_partai">
                    				@foreach($partai as $value)
                    				<option value="{{$value->id_partai}}">{{$value->nama_partai}}</option>
                    				@endforeach
                    			</select>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Nama Calon DPR</td>
                    		<td>
                    			<input type="text" name="nama_calon" value="" placeholder="Contoh: John Gilbert" class="form-control" id="nama_calon">
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Foto Calon Dapil</td>
                    		<td>
                    			<input type="file" name="foto_calon" accept="image/*" required>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Daerah Pemilihan (DAPIL)</td>
                    		<td>
                    			<select class="selectize" required name="id_dapil">
                    				@foreach($dapil as $value)
                    				<option value="{{$value->id_dapil}}">{{$value->nama_dapil}}</option>
                    				@endforeach
                    			</select>
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
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan Calon DPR</button>
</div>
<div class="token">{{csrf_field()}}</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$(".selectize").selectize();
	})
	function validasi() {
		$calonDPR = $("#nama_calon").val();
		if($calonDPR=="") {
			miniNotif("warning","Nama calonDPR belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection