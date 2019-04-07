@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li class="active">Calon DPR</li>
        </ol>
     </section>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Daftar Calon DPR</h2>
        </header>
        <div class="contents">
            <a class="togglethis">Toggle</a>
            <div class="table-box">
                <table class="display table" id="tabel-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Calon</th>
                            <th>Foto Calon</th>
                            <th>Partai Asal</th>
                            <th>Dapil</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach ($data as $key => $value)
                    		<tr>
                    			<td>{{$key+1}}</td>
                                <td>{{$value->nama_calon}}</td>
                    			<td>
                                    @if($value->foto_calon!=null)
                                    <img src="{{asset('uploads')}}/{{$value->foto_calon}}" class="foto_calon">
                                    @endif
                                </td>
                                <td>{{$value->partai->nama_partai}}</td>
                                <td>{{$value->dapil->nama_dapil}}</td>
                    			<td>
                    				<a class="btn btn-sm btn-primary" href="{{Route('calonDPR.edit',$value->id_calon)}}">
                    					<i class="fa fa-edit"></i> Update
                    				</a>
                    				<button class="btn btn-sm btn-danger" data-confirm="Yakin akan menghapus calon DPR ini?" onclick="hapus('{{$value->id_calon}}')">
                    					<i class="fa fa-times"></i> Hapus
                    				</button>
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
<div class="col-xs-12 right">
    <a href="{{Route('calonDPR.create')}}" class="btn btn-md btn-success style2">Tambah Calon DPR</a>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
	$(document).ready(function() {
        $(".table").DataTable();
    });
    function hapus($id) {
    	redirect("{{Route('calonDPR.index')}}/hapus/"+$id);
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection