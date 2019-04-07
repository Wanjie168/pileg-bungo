@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Data Master</a></li>
            <li class="active">Partai</li>
        </ol>
     </section>
</div>
<div class="col-xs-12">
    <div class="sec-box">
        <a class="closethis">Tutup</a>
        <header>
            <h2 class="heading">Daftar Partai</h2>
        </header>
        <div class="contents">
            <a class="togglethis">Toggle</a>
            <div class="table-box">
                <table class="display table" id="tabel-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="col-md-6">Nama Partai</th>
                            <th class="col-md-2">Logo Partai</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach ($data as $key => $value)
                    		<tr>
                    			<td>{{$key+1}}</td>
                                <td>{{$value->nama_partai}}</td>
                    			<td>
                                    @if($value->logo_partai!=null)
                                    <img src="{{asset('uploads')}}/{{$value->logo_partai}}" class="logo_partai">
                                    @endif
                                </td>
                    			<td>
                    				<a class="btn btn-sm btn-primary" href="{{Route('partai.edit',$value->id_partai)}}">
                    					<i class="fa fa-edit"></i> Update
                    				</a>
                    				<button class="btn btn-sm btn-danger" data-confirm="Yakin akan menghapus partai ini?" onclick="hapus('{{$value->id_partai}}')">
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
    <a href="{{Route('partai.create')}}" class="btn btn-md btn-success style2">Tambah Partai</a>
</div>
<div class="token">{{csrf_field()}}</div>
<script type="text/javascript">
	$(document).ready(function() {
        $(".table").DataTable();
    });
    function hapus($id) {
    	redirect("{{Route('partai.index')}}/hapus/"+$id);
    }
</script>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection