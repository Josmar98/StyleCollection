<html>
	<head>
		<title>Location of my markers</title>
		<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

		<style type="text/css">
			#map { height: 100%; }
			html,
			body {height: 100%; margin: 0; padding:0; }
		</style>
	</head>
	<!-- <body onload="getLocation()"> -->
	<body style="margin:30px;">
		<div style="width:100%;text-align:center;">
			<h3>Location of my markers in Google Maps</h3>
			<span><small>Note: you must enable location permissions.</small></span>
			<br>
			<button onclick="getLocation()">Find my location</button>
			<p id="errorUbicacion"></p>
		</div>
		<div id="map" style="background:#ddd;"></div>
		<br>

		<script type="text/javascript">
			const x = document.getElementById("errorUbicacion");
			var locations = [
				{label:'a', coord:{ lat: -31.56391, lng: 147.154312 }},
				{label:'b', coord:{ lat: -33.718234, lng: 150.363181 }},
				{label:'c', coord:{ lat: -33.727111, lng: 150.371124 }},
				{label:'d', coord:{ lat: -33.848588, lng: 151.209834 }},
				{label:'e', coord:{ lat: -33.851702, lng: 151.216968 }},
				{label:'f', coord:{ lat: -34.671264, lng: 150.863657 }},
				{label:'g', coord:{ lat: -35.304724, lng: 148.662905 }},
				{label:'h', coord:{ lat: -36.817685, lng: 175.699196 }},
				{label:'i', coord:{ lat: -36.828611, lng: 175.790222 }},
				{label:'j', coord:{ lat: -37.75, lng: 145.116667 }},
				{label:'k', coord:{ lat: -37.759859, lng: 145.128708 }},
				{label:'l', coord:{ lat: -37.765015, lng: 145.133858 }},
				{label:'m', coord:{ lat: -37.770104, lng: 145.143299 }},
				{label:'n', coord:{ lat: -37.7737, lng: 145.145187 }},
				{label:'o', coord:{ lat: -37.774785, lng: 145.137978 }},
				{label:'p', coord:{ lat: -37.819616, lng: 144.968119 }},
				{label:'q', coord:{ lat: -38.330766, lng: 144.695692 }},
				{label:'r', coord:{ lat: -39.927193, lng: 175.053218 }},
				{label:'s', coord:{ lat: -41.330162, lng: 174.865694 }},
				{label:'t', coord:{ lat: -42.734358, lng: 147.439506 }},
				{label:'u', coord:{ lat: -42.734358, lng: 147.501315 }},
				{label:'v', coord:{ lat: -42.735258, lng: 147.438 }},
				{label:'w', coord:{ lat: -43.999792, lng: 170.463352 }},
			];

			var meCoord = {};
			function getLocation() {
			  if (navigator.geolocation) {
			    navigator.geolocation.getCurrentPosition(initMaps);
			  } else { 
			    x.innerHTML = "Geolocation is not supported by this browser.";
			  }
			}
			function initMap() {
				// meCoord = {lat:geoPosition.coords.latitude, lng:geoPosition.coords.longitude}
				// console.log(locations);

				// let map;
				var map = new google.maps.Map(document.getElementById("map"), {
					zoom: 5,
					center: locations[0]['coord'],
				});
				const infoWindow = new google.maps.InfoWindow({
					content: "",
					disableAutoPan: true,
				});

				const markers = locations.map((array, i) => {
					var label = array.label;
					var position = array.coord;
					const marker = new google.maps.Marker({
						map,
						position,
						label,
					});

					marker.addListener("click", () => {
						infoWindow.setContent(label);
						infoWindow.open(map, marker);
					});
					return marker;
				});

				new MarkerClusterer({ markers, map });
			}

			function initMaps(geoPosition) {
				meCoord = {lat:geoPosition.coords.latitude, lng:geoPosition.coords.longitude}
				newLocations=[]
				newLocations[0]={label:'act', coord:{lat:meCoord.lat, lng: meCoord.lng}}
				for(i=0;i<locations.length;i++){
					newLocations[(i+1)]={label:locations[i]['label'], coord:{lat:locations[i]['coord']['lat'], lng:locations[i]['coord']['lng']}}
				}
				locations = newLocations;
				// meCoord = {lat:geoPosition.coords.latitude, lng:geoPosition.coords.longitude}
				// console.log(locations);

				// let map;
				var map = new google.maps.Map(document.getElementById("map"), {
					zoom: 5,
					center: locations[0]['coord'],
				});
				const infoWindow = new google.maps.InfoWindow({
					content: "",
					disableAutoPan: true,
				});

				const markers = locations.map((array, i) => {
					var label = array.label;
					var position = array.coord;
					const marker = new google.maps.Marker({
						map,
						position,
						label,
					});

					marker.addListener("click", () => {
						infoWindow.setContent(label);
						infoWindow.open(map, marker);
					});
					return marker;
				});

				new MarkerClusterer({ markers, map });
			}

			window.initMap = initMap;
		</script>
		<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly" defer></script> -->
		
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiqxzh6S5RnEZtQ6Pn8_HpesdTohM7fvE&callback=initMap&v=weekly" defer></script>
		<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaZapXJQrG-PzLza-Ptd76kzlaQrdV3lU&callback=initMap&v=weekly" defer></script> -->
		
	</body>
</html>