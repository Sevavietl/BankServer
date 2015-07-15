<html>
	<head>
		@section('head')
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/monopoly-logo.jpg') }}">
        	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/monopoly-logo.jpg') }}">
			<title>Bank Server</title>
			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
			<!-- Optional theme -->
			<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
			<!-- Latest compiled and minified JavaScript -->
			<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		@show
	</head>
	<body>
		@include('partials.menu.navbar')

		<div class="container">
		    <div class="row">
		        <div class="col-md-10 col-md-offset-1">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>
