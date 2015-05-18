<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>MyGame</title>

<link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}" media="all" />
<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>


<script type="text/javascript" src="{{ asset('/js/jquery-1.6.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.jcarousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/carousel.js') }}"></script>

</head>
<body>
<!-- Begin Wrapper -->
<div id="wrapper">
	<!-- Begin Sidebar -->
	<div id="sidebar">
		
		 
	<!-- Begin Menu -->
  	@include('menu')
  	<!-- End Menu -->
   
	</div>
	<!-- End Sidebar -->
	
	<!-- Begin Content -->
	<div id="content">
 	@yield('content')
	</div>
	<!-- End Content -->
	
</div>
<!-- End Wrapper -->

<script type="text/javascript" src="style/js/scripts.js"></script>
<!--[if !IE]> -->
<script type="text/javascript" src="style/js/jquery.corner.js"></script>

<!-- <![endif]-->
</body>
</html>