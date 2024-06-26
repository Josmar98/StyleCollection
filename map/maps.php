<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>
<body onload="options()">
    <div style="width:100%;text-align:center;">
        <h3>Location of my markers in Maps</h3>
        <span><small>Note: you must enable location permissions.</small></span>
        <p id="errorUbicacion"></p>
    </div>
    <div class="map" id="map" style="width:100%;height:80vh;"></div>
<script>
function options(){
    var result = confirm('Find my location');
    if(result){
        getLocation();
    }else{
        initMap();
    }
}

var zoomInitial = 7;
// var stringLocations = document.querySelectorAll('#locations');
// var locations = JSON.parse(stringLocations[0]['innerHTML']);
var stringLocations = '<?=json_encode($locations); ?>';
var locations = JSON.parse(stringLocations);
// var locations = [
//     {label:'a', coord:{ lat: -31.56391, lng: 147.154312 }},
//     {label:'b', coord:{ lat: -33.718234, lng: 150.363181 }},
//     {label:'c', coord:{ lat: -33.727111, lng: 150.371124 }},
//     {label:'d', coord:{ lat: -33.848588, lng: 151.209834 }},
//     {label:'e', coord:{ lat: -33.851702, lng: 151.216968 }},
//     {label:'f', coord:{ lat: -34.671264, lng: 150.863657 }},
//     {label:'g', coord:{ lat: -35.304724, lng: 148.662905 }},
//     {label:'h', coord:{ lat: -36.817685, lng: 175.699196 }},
//     {label:'i', coord:{ lat: -36.828611, lng: 175.790222 }},
//     {label:'j', coord:{ lat: -37.75, lng: 145.116667 }},
//     {label:'k', coord:{ lat: -37.759859, lng: 145.128708 }},
//     {label:'l', coord:{ lat: -37.765015, lng: 145.133858 }},
//     {label:'m', coord:{ lat: -37.770104, lng: 145.143299 }},
//     {label:'n', coord:{ lat: -37.7737, lng: 145.145187 }},
//     {label:'o', coord:{ lat: -37.774785, lng: 145.137978 }},
//     {label:'p', coord:{ lat: -37.819616, lng: 144.968119 }},
//     {label:'q', coord:{ lat: -38.330766, lng: 144.695692 }},
//     {label:'r', coord:{ lat: -39.927193, lng: 175.053218 }},
//     {label:'s', coord:{ lat: -41.330162, lng: 174.865694 }},
//     {label:'t', coord:{ lat: -42.734358, lng: 147.439506 }},
//     {label:'u', coord:{ lat: -42.734358, lng: 147.501315 }},
//     {label:'v', coord:{ lat: -42.735258, lng: 147.438 }},
//     {label:'w', coord:{ lat: -43.999792, lng: 170.463352 }},
// ];

var myIcon = L.icon({
    iconUrl: 'myIcon.png',
    iconSize: [45, 40],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
    // shadowUrl: 'my-icon-shadow.png',
    shadowSize: [68, 95],
    shadowAnchor: [22, 94]
});

var meCoord = {};
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(initMaps);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function initMap(){
    var posInit = locations[0]['coord'];
    var map = L.map('map', {zoomDelta: 0.25, zoomSnap: 0.25}).setView([posInit.lat, posInit.lng], zoomInitial);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    
    locations.map((array, i) => {
        var label = array.label;
        var position = array.coord;
        L.marker([position.lat, position.lng], {icon: myIcon}).addTo(map).bindPopup(label).openPopup();
        // L.marker([51.5, -0.09]).addTo(map).bindPopup('').openPopup();
    });
}

function initMaps(geoPosition){
    meCoord = {lat:geoPosition.coords.latitude, lng:geoPosition.coords.longitude}
    var newLocations=[]
    // newLocations[0]={label:'act', coord:{lat:meCoord.lat, lng: meCoord.lng}}
    for(i=0;i<locations.length;i++){
        newLocations[(i+1)]={label:locations[i]['label'], coord:{lat:locations[i]['coord']['lat'], lng:locations[i]['coord']['lng']}}
    }
    // alert(newLocations.length);
    newLocations[newLocations.length]={label:'Location', coord:{lat:meCoord.lat, lng: meCoord.lng}}
    var locationss = newLocations;

    var posInit = locationss[locationss.length-1]['coord'];
    var map = L.map('map', {zoomDelta: 0.25, zoomSnap: 0.25}).setView([posInit.lat, posInit.lng], zoomInitial);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    locationss.map((array, i) => {
        var last = locationss.length;
        var label = array.label;
        var position = array.coord;
        if((last-1) == i){
            L.marker([position.lat, position.lng]).addTo(map).bindPopup(label).openPopup();
            map.fitBounds([[position.lat, position.lng]])
        }else{
            L.marker([position.lat, position.lng], {icon: myIcon}).addTo(map).bindPopup(label).openPopup();
        }

        // L.marker([51.5, -0.09]).addTo(map).bindPopup('').openPopup();
    });
}
    
// window.initMap = initMap;
</script>

</body>
</html>