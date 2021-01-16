const paderewski = latLong(51.2693461, 22.5547316);

let map;

let routes = [
	{
		username : 'Dziadek Olesiaka',
		telephone : '123',
		start : '51.2906902,22.5283778',
		point_2 : 'lublin, bohaterów września',
		point_3 : 'lublin, miejski żłobek nr 9',
		point_4 : '51.2739464,22.5560556',
	},
	{
		username : 'Jes',
		telephone : '1234',
		start : 'Lublin, Araszkiewicza 50',
		point_2 : 'Lublin, rondo krwiodawców',
		point_3 : 'lublin, plac litewski',
		point_4 : 'lublin, witolda chodźki',
	},
	{
		username : 'Tata Kacpra',
		telephone : '420',
		start : 'jastków 78l',
		point_2 : 'lublin, warszawska',
	},
	{
		username : 'Maks',
		telephone : '112',
		start : 'zemborzyce dolne 82',
		// point_2 : 'lublin, warszawska',
	},
];

let polylineOptions = {
	strokeOpacity: .8,
	strokeWeight: 6,
};

let polylines = [];

function latLong(lat, lng) {
	return { lat, lng };
}

function initMap() {

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

	let directionsService = new google.maps.DirectionsService;

	for(route of routes) {
		let directionsDisplay = new google.maps.DirectionsRenderer;
		directionsDisplay.setMap(map);
		calculateAndDisplayRoute(directionsService, directionsDisplay, route);
	}

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
		} else
			alert('no');
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

	infowindow.setContent('<img style="width: 50px; height: 50px; clip-path: circle(50% at center);" src="https://eu.ui-avatars.com/api/?&name=' + username + '&size=64&rounded=true&background=' + clr + '&color=fff&bold=true">' + username + '<br>tel. nr. ' + telephone);
	// infowindow.setContent('<iframe src="https://en.wikipedia.org/wiki/Special:Random">')
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