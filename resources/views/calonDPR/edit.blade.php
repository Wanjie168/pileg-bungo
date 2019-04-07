@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('calonDPR.index')}}">Calon DPR</a></li>
            <li class="active">Update</li>
        </ol>
     </section>
</div>
<form action="{{Route('calonDPR.update',$data->id_calon)}}" method="POST" enctype="multipart/form-data">
{{csrf_field()}}
{{method_field('PATCH')}}
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Pembaharuan Calon DPR</h2>
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
                                    @if($value->id_partai == $data->id_partai)
                    				<option value="{{$value->id_partai}}" selected>{{$value->nama_partai}}</option>
                                    @else
                                    <option value="{{$value->id_partai}}">{{$value->nama_partai}}</option>
                                    @endif
                    				@endforeach
                    			</select>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Nama Calon DPR</td>
                    		<td>
                    			<input type="text" name="nama_calon" placeholder="Contoh: John Gilbert" class="form-control" id="nama_calon" value="{{$data->nama_calon}}">
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Foto Calon Dapil</td>
                    		<td>
                                <img src="{{asset('uploads')}}/{{$data->foto_calon}}" class="foto_calon" alt="#Foto Belum Pernah Diunggah">
                    			<input type="file" name="foto_calon" accept="image/*">
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Daerah Pemilihan (DAPIL)</td>
                    		<td>
                    			<select class="selectize" required name="id_dapil">
                    				@foreach($dapil as $value)
                                    @if($value->id_dapil == $data->id_dapil)
                    				<option value="{{$value->id_dapil}}" selected>{{$value->nama_dapil}}</option>
                                    @else
                                    <option value="{{$value->id_dapil}}">{{$value->nama_dapil}}</option>
                                    @endif
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