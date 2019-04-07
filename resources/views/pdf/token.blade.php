@extends("layouts.pdf")

@section("konten")
<div class="padding-10">
	@include("layouts.pdf-cop")
	<hr class="lineBorder">
	<!-- Bagian Judul -->
	<div class="center">
		<p class="bold">REKAP KODE AKSES TPS (TOKEN)</p>
	</div>
	<!-- Bagian Konten Dibawah Judul -->
	<div>
		<table>
			<tr>
				
			</tr>
		</table>
	</div>
	<div class="margin-10"></div>
	<!-- Bagian Tabel -->
	<table class="full-table">
		<thead>
			<tr class="center">
				<th>No.</th>
				<th>Dapil</th>
				<th>Kecamatan</th>
				<th>Desa</th>
				<th>TPS</th>
				<th>Kode Akses</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tps as $index => $data)
			<tr>
				<td>{{$index+1}}</td>
				<td>{{$data->desa->kecamatan->dapil->nama_dapil}}</td>
				<td>{{$data->desa->kecamatan->kecamatan}}</td>
				<td>{{$data->desa->desa}}</td>
				<td>{{$data->nama_tps}}</td>
				@if($data->token!=null)
				<td class="bold">{{$data->token->token}}</td>
				@else
				<td class="bold">-</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script type="text/javascript">
	window.print();
</script>
@endsection