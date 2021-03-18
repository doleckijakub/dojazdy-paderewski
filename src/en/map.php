<?php

	$GOOGLE_API_KEY = getenv('GOOGLE_API_KEY');
	if(!$GOOGLE_API_KEY) exit();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Map</title>
	<script src="map.js?v=4"></script>
	<style>
		.fullscreen {
			width: 100vw;
			height: 100vh;
			position: fixed;
			left: 0;
			top: 0;
		}

		#map {
			width: 100%;
			height: 100%;
			z-index: 0;
		}

		.gm-svpc .gmnoprint {
			display: none;
		}


		/*.gm-ui-hover-effect {display: none;}*/
	</style>
</head>
<body>

	<div class="fullscreen">
		<div id="map"></div>
		<!-- <div id="panel"></div> -->
	</div>
	
</body>
</html>

<?php echo '<script async defer src="https://maps.google.com/maps/api/js?key='.$GOOGLE_API_KEY.'&callback=initMap"></script>'; ?>