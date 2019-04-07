@extends("layouts.pdf")
@php
	date_default_timezone_set("Asia/Jakarta");
@endphp

@section("css")
	th {padding:10px}
	td {padding:5px}
@endsection
<!-- Bagian Rekap Setiap Dapil -->
@section("konten")
@foreach($dapil as $index => $data_dapil)
<div class="padding-10 center" style="font-size:20px;">
	@include("layouts.pdf-cop")
	<hr class="lineBorder">
	<!-- Bagian Judul -->
	<div class="center">
		<p class="bold uppercase">Rekap Suara - {{$data_dapil->nama_dapil}}</p>
	</div>
	<!-- Bagian Partai -->
	<div style="display:flex;flex-wrap:wrap;">
	@foreach($data_dapil->partaiAll($data_dapil->id_dapil) as $data_partai)
	<div class="border padding-10" style="border-radius:10px;flex-grow:1;width:40%;margin:10px;">
		@php $count = 0; @endphp
		<div class="center bold uppercase" style="margin-bottom:5px;display:flex;align-items:center;justify-content:center;">
			<span>{{$data_partai->nama_partai}}</span>
			<img src="{{asset('uploads')}}/{{$data_partai->logo_partai}}" style="width:30px;height:30px;border-radius:10px;border:2px solid black;margin-left:10px;">
			 <span style="margin-left:10px">[{{$count+= $data_partai->hitung_suara_coblos_partai($data_partai->id_partai,$data_dapil->id_dapil)}}]</span>
		</div>
		<hr>
		<table style="margin-bottom: 10px">
			<thead>
				<tr>
					<th>No</th>
					<th class="left">Nama Calon</th>
					<th class="left">Jumlah Suara</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data_partai->calon_dpr2($data_partai->id_partai,$data_dapil->id_dapil) as $index_calon_dpr => $data_calon_dpr)
				<tr>
					<td class="center">{{$index_calon_dpr+1}}</td>
					<td class="left" style="display: flex;align-items:center;">
						<img src="{{asset('uploads')}}/{{$data_calon_dpr->foto_calon}}" style="width:40px;height:50px;border-radius:10px;border:2px solid grey;margin-right:10px;"> 
						{{$data_calon_dpr->nama_calon}}
					</td>
					<td class="left">
						@php
						$tmp = $data_calon_dpr->hitungSuaraByDapil($data_calon_dpr->id_calon,$data_dapil->id_dapil);
						$count+=$tmp;
						@endphp
						{{$tmp}}
					</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="3">
						<hr>
						Jumlah suara: {{$count}}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	@endforeach
	</div>
	<!-- Bagian Partai -->
</div>
<div style="clear:both;"></div>
<br>
<div style="margin-left:70%;margin-top:10px">
	<table>
		<tr><td>Jambi, {{date("d-m-Y")}}</td></tr>
		<tr><td>Mengetahui, </td></tr>
		<tr><td style="padding-top:100px;">(_____________________)</td></tr>
	</table>
</div>
<div class="page_break"></div>
@endforeach
@endsection
<!-- Bagian Rekap Setiap Dapil -->