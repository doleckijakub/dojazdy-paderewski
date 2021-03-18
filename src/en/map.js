const paderewski = latLong(51.2693461, 22.5547316);

let map;

let polylineOptions = {
	strokeOpacity: .8,
	strokeWeight: 6,
};

let polylines = [];

function latLong(lat, lng) {
	return { lat, lng };
}

function initMap() {

	// routes = JSON.parse(document.querySelector('data#routes').innerHTML);

	map = new google.maps.Map(document.getElementById("map"), {
		center: paderewski,
		zoom: 12,
		fullscreenControl: false,
		streetViewControl: false,
		clickableLabels: false,
	});

	let paderewski_info = new google.maps.InfoWindow();

	paderewski_info.setContent('<b>Paderewski');
	paderewski_info.setPosition(paderewski);
	paderewski_info.open(map);

	fetch('../routes.php')
	.then(q => q.json())
	.then(routes => {

		// alert(JSON.stringify(routes))

		let directionsService = new google.maps.DirectionsService;

		for(i in routes) {
			let route = routes[i];
			// alert(JSON.stringify(route))
			let directionsDisplay = new google.maps.DirectionsRenderer;
			directionsDisplay.setMap(map);
			calculateAndDisplayRoute(directionsService, directionsDisplay, route);
		}

		setTimeout(map.setCenter(paderewski), 1000);

	});

	map.setCenter(paderewski);
	map.setZoom(12);

}

function calculateAndDisplayRoute(directionsService, directionsDisplay, { start, point_2, point_3, point_4, username, telephone }) {

	waypoints = [];

	for(p of [point_2, point_3, point_4]) if(p) waypoints.push({ location: p });

	directionsService.route({
		origin: start,
		destination: paderewski,
		waypoints,
		travelMode: 'DRIVING'
	}, function(res, status) {
		// console.log({ status, res });
		if(status === 'OK') {
			renderPolylines(res, { username, telephone });
		} else {
			// alert('no');
		}
	})
}

function hslToHex(h, s, l) {
	l /= 100;
	const a = s * Math.min(l, 1 - l) / 100;
	const f = n => {
		const k = (n + h / 30) % 12;
		const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
		return Math.round(255 * color).toString(16).padStart(2, '0');
	};
	return `${f(0)}${f(8)}${f(4)}`;
}

function renderPolylines(res, { username, telephone }) {

	let infowindow = new google.maps.InfoWindow();
	let clr = hslToHex(Math.floor(Math.random() * 240) + 120, 100, 50);
	polylineOptions.strokeColor = '#' + clr;

	let profile_img_src = 'https://eu.ui-avatars.com/api/?&name=' + username + '&size=64&rounded=true&background=' + clr + '&color=fff&bold=true';

	infowindow.setContent(`

		<style>

		.profile-img {
			width: 50px;
			height: 50px;
			clip-path: circle(50% at center);
		}

		</style>

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

		<div class="col-sm-6">
			<div class="media">
				<div class="media-left">
					<img class="media-object profile-img" src="` + profile_img_src + `">
				</div>
				<div class="media-body">
					<b>` + username + `</b>
					<span>Call: <a href="tel:` + telephone + `" target="_blank">` + telephone + `</a></span>
				</div>
			</div>
		</div>

	`);

	infowindow.setPosition(res.routes[0].legs[0].steps[0].path[0]);
	infowindow.open(map);

	for(leg of res.routes[0].legs) {
		for(step of leg.steps) {
			let stepPolyline = new google.maps.Polyline(polylineOptions);
			for(k of step.path) {
				stepPolyline.getPath().push(k);
			}
			polylines.push(stepPolyline);
			stepPolyline.setMap(map);

			google.maps.event.addListener(stepPolyline, 'click', evt => {
				infowindow.setPosition(evt.latLng);
				infowindow.open(map);
			});
		}
	}

}