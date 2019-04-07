@extends("layouts.app")

@section("konten")
<div class="col-xs-12">
    <section>
        <ol style="margin-bottom: 5px;" class="breadcrumb">
            <li><a href="{{Route('home')}}">Home</a></li>
            <li><a href="#">Pemilihan Umum (Pemilu)</a></li>
            <li><a href="{{Route('suara_terkumpul')}}">Suara Tekumpul</a></li>
            <li><a href="#">{{$infoTPS->desa->kecamatan->dapil->nama_dapil}}</a></li>
            <li><a href="#">{{$infoTPS->desa->kecamatan->kecamatan}}</a></li>
            <li><a href="#">{{$infoTPS->desa->desa}}</a></li>
            <li><a href="#">{{$infoTPS->nama_tps}}</a></li>
        </ol>
     </section>
</div>
@foreach($partai as $data)
<div class="col-xs-6">
    <div class="sec-box">
        <header>
            <h2 class="heading">
                {{$data->nama_partai}}
                <img src="{{asset('uploads')}}/{{$data->logo_partai}}" style="width:30px;height:30px;border-radius:10px;border:2px solid black;margin-left:10px;">
            </h2>
        </header>
        <div class="contents">
            <div class="table-box">
                <table class="display table">
                	<thead>
                		<tr>
                            <th>No</th>
                            <th>Calon</th>
                			<th class="col-sm-4">Jml. Suara</th>
                		</tr>
                	</thead>
                    <tbody>
                        @foreach($data->calon_dpr as $index => $calon)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td style="margin:0px">
                                <img src="{{asset('uploads')}}/{{$calon->foto_calon}}" style="width:40px;height:50px;border-radius:10px;border:2px solid grey;margin-right:10px;"> 
                                {{$calon->nama_calon}}
                            </td>
                            <td>
                                <input type="number" id_calon="{{$calon->id_calon}}" placeholder="0" min="0" class="form-control suara_calon" onkeydown="return validasi_number(event)" disabled value="{{$calon->hitungSuaraByTPS($calon->id_calon,$infoTPS->id_tps)}}">
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
@endforeach
<div class="token">{{csrf_field()}}</div>
@endsection

@section("script")
<script type="text/javascript" src="{{asset('assets/js/dataTables.min.js')}}"></script>
@endsection