<!DOCTYPE html>
<html>
<head>
	<title>Print Preview</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom.css')}}">
	<style>
	p {
		margin:5px;
	}
	.page-break {
		page-break-after: always;
	}
	table {
		width: 100%;
	}
	.vertical-table thead, .vertical-table tfoot {
		border-top:1px solid black;
		border-bottom:1px solid black;
	}
	table.full-table td, table.full-table th {
		border:1px solid black;
	}
	table {
		border-collapse: collapse;
	}
	td, th {
		padding: 1.5px;
	}
	th {
		padding: auto 2px;
	}
	th {
		font-weight:bold;
	}
	.lineBorder {
		margin: 10px 0px 6px 0px;
	}
	.page_break {
		page-break-before: always;
	}
	@media print {
	    div { display: block } 
	}
	@yield("css")
</style>
</head>
<body>
	@yield("konten")
</body>
</html>