@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('tps.index')}}">TPS</a></li>
            <li class="active">Edit</li>
        </ol>
     </section>
</div>
<form action="{{Route('tps.update',$data->id_tps)}}" method="POST">
{{csrf_field()}}
{{method_field('PATCH')}}
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Pembaharuan TPS</h2>
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
                            <td>Desa / Kecamatan / Dapil</td>
                            <td>
                                <select class="selectize" name="id_desa" required>
                                @foreach($desa as $val)
                                    @if($val->id_desa==$data->id_desa)
                                        <option value="{{$val->id_desa}}" selected>{{$val->desa}} / {{$val->kecamatan->kecamatan}} / {{$val->kecamatan->dapil->nama_dapil}}</option>
                                    @else
                                        <option value="{{$val->id_desa}}">{{$val->desa}} / {{$val->kecamatan->kecamatan}} / {{$val->kecamatan->dapil->nama_dapil}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Maksimum Jumlah Suara</td>
                            <td>
                                <input type="number" name="max_suara" placeholder="300" class="form-control" onkeypress="return validasi_number(event)" min="1" max="300" required value="{{$data->max_suara}}">
                            </td>
                        </tr>
                    	<tr>
                    		<td>Nama tps</td>
                    		<td>
                    			<input type="text" name="tps" value="{{$data->nama_tps}}" placeholder="Contoh: Purwokerto" class="form-control" id="tps" required>
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
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan TPS</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $(".selectize").selectize();
    });
	function validasi() {
		$tps = $("#tps").val();
		if($tps=="") {
			miniNotif("warning","Nama tps belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection