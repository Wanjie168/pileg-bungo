@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('kecamatan.index')}}">Kecamatan</a></li>
            <li class="active">Tambah</li>
        </ol>
     </section>
</div>
<form action="{{Route('kecamatan.store')}}" method="POST">
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Penambahan Kecamatan</h2>
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
                            <td>Daerah Pemilihan (DAPIL)</td>
                            <td>
                                <select class="selectize" name="id_dapil">
                                @foreach($dapil as $val)
                                    <option value="{{$val->id_dapil}}">{{$val->nama_dapil}}</option>
                                @endforeach
                                </select>
                            </td>
                        </tr>
                    	<tr>
                    		<td>Nama Kecamatan</td>
                    		<td>
                    			<input type="text" name="kecamatan" value="" placeholder="Contoh: Rimbo Bujang" class="form-control" id="kecamatan">
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
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan kecamatan</button>
</div>
<div class="token">{{csrf_field()}}</div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $(".selectize").selectize();
    });
	function validasi() {
        $id_dapil = $("#id_dapil").val();
		$kecamatan = $("#kecamatan").val();
        if($id_dapil=="") {
            miniNotif("warning","Dapil belum dipilih!");
            return false;
        } else
        if($kecamatan=="") {
			miniNotif("warning","Nama kecamatan belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection