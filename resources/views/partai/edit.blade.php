@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li><a href="{{Route('partai.index')}}">Partai</a></li>
            <li class="active">Update</li>
        </ol>
     </section>
</div>
<form action="{{Route('partai.update',$data->id_partai)}}" method="POST" enctype="multipart/form-data">
{{csrf_field()}}
{{method_field('PATCH')}}
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Form Pembaharuan Partai</h2>
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
                            <td>Nama Partai</td>
                            <td>
                                <input type="text" name="nama_partai" value="{{$data->nama_partai}}" placeholder="Contoh: Partai Kebanggan Kita (PKK)" class="form-control" id="nama_partai" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Logo Partai</td>
                            <td>
                                <img src="{{asset('uploads')}}/{{$data->logo_partai}}" class="logo_partai" alt="#Logo Belum Pernah Diunggah">
                                <input type="file" name="logo_partai" accept="image/*" required>
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
    <button class="btn btn-md btn-success style2" onclick="return validasi()">Simpan Partai</button>
</div>
</form>
<script type="text/javascript">
	function validasi() {
		$partai = $("#nama_partai").val();
		if($partai=="") {
			miniNotif("warning","Nama partai belum diinput!");
			return false;
		} else
			return true;
	}
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection