@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('desa.index')}}">Desa</a></li>
            <li class="active">Edit</li>
        </ol>
     </section>
</div>
<form action="{{Route('desa.update',$data->id_desa)}}" method="POST">
{{csrf_field()}}
{{method_field('PATCH')}}
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Pembaharuan Desa</h2>
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
                            <td>Kecamatan</td>
                            <td>
                                <select class="selectize" name="id_kecamatan">
                                @foreach($kecamatan as $val)
                                    @if($val->id_kecamatan==$data->id_kecamatan)
                                        <option value="{{$val->id_kecamatan}}" selected>{{$val->kecamatan}} (Dapil: {{$val->dapil->nama_dapil}})</option>
                                    @else
                                        <option value="{{$val->id_kecamatan}}">{{$val->kecamatan}} (Dapil: {{$val->dapil->nama_dapil}})</option>
                                    @endif
                                @endforeach
                                </select>
                            </td>
                        </tr>
                    	<tr>
                    		<td>Nama Desa</td>
                    		<td>
                    			<input type="text" name="desa" value="{{$data->desa}}" placeholder="Contoh: Purwokerto" class="form-control" id="desa">
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
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan Desa</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $(".selectize").selectize();
    });
	function validasi() {
		$desa = $("#desa").val();
		if($desa=="") {
			miniNotif("warning","Nama desa belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection