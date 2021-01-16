<?php

	setcookie('lang', 'pl', time() + (86400 * 30), '/');

?>

<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<title>Dojazdy Paderewski</title>

	<script src="map.js"></script>

	<link rel="stylesheet" type="text/css" href="../index.css?v=2">

	<style>
		.fullscreen {
			width: 100vw;
			height: 100vh;
			position: fixed;
			left: 0;
			top: 0;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-default navbar-inverse" role="navigation">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only"><!-- Toggle navigation --></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="..">Dojazdy Paderewski</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<!-- <li class="active"><a href="#">Link</a></li> -->
					<!-- <li><a href="#">Link</a></li> -->
					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help<span class="caret">&nbsp;</span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
							<!--
								info
								all users

								---

								contact
								report issue
							 -->
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active lang btn-li"><a href="#"><img src="https://image.flaticon.com/icons/png/128/197/197529.png" style="height: 1.5em;" alt="[PL]"></a></li>
					<li class="lang btn-li"><a href="../en/"><img src="https://image.flaticon.com/icons/png/128/197/197374.png" style="height: 1.5em;" alt="[EN]"></a></li>
				</ul>
			</div>
		</div>
	</nav>
</body>
</html>