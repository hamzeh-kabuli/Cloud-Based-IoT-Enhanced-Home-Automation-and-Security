<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
		@page {
			margin-top: 80px; 
			margin-bottom: 10px; 
		}

		body{
			font-family: DejaVu Sans, sans-serif;
		}

		header { position: fixed; top: -60px; left: 0px; right: 0px; height: 50px; }
		footer {
			position: fixed;
			bottom: 0cm;
			left: 0cm;
			right: 0cm;
			background-color: #eaeaea;
			text-align: center;
			padding: 5px;
		}
		footer .pagenum:before {
			content: counter(page);
		}
		.logo {
			width: 200px;
		}

		.heading-1 {
			font-size: 22px;
			text-align: center;
		}

		.heading-2 {
			font-size: 16px;
			margin: 0;
		}

		.no-boder: {
			border: none;
		}

		.w-100 {
			width: 100%;
		}

		.w-60 {
			width: 60%;
		}

		.w-50 {
			width: 50%;
		}

		.w-35 {
			width: 35%;
		}

		.w-25 {
			width: 25%;
		}

		.label {
			font-size: 15px;
			font-weight: bolder;
		}

		.info {
			font-weight: lighter;
			font-size: 13px;
		}

		.underline {
			text-decoration: underline;
		}

		table.border {
			border: 1px solid gray;
			border-collapse: collapse;
		}

		table.border td, table.border th {
			border: 1px solid gray;
		}

		.section td, .section th {
			padding: 5px;
			white-space: pre-line;
		}

		.border td, th {
			padding: 5px 10px;
		}

		.justify {
			text-align: justify;
		}

		.description {
			font-size: 13px;
		}

		.page-break {
			page-break-after: always;
		}

		.text-center {
			text-align: center;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.bg-ccc {
			background-color: #ccc;
		}

		td li span {
			font-family: DejaVu Sans, sans-serif;
		}

	</style>

	<title>{{ isset($request) ? $request->title : '' }}</title>
</head>
<body>
	
		
	<img 
		class="logo"
		src="{{ public_path('/assets/bdn-logo.png') }}" 
		style=""
	/>
	<br>
	
	@yield('content')

</body>
</html>