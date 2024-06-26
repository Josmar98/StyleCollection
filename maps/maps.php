<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location of my markers</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body onload="options()" style="background:#fefefe;color:#000;">
    <div style="width:100%;text-align:center;">
        <h3>Location of my markers in Maps</h3>
        <span><small>Note: you must enable location permissions.</small></span>
        <p id="errorUbicacion"></p>
    </div>
    <div class="map" id="map" style="border:1px solid #000;width:100%;height:80vh;"></div>
<script>
function options(){
    Swal.fire({
      title: "I want to find my position?",
      text: "Press yes, to find your position on the map.",
      showConfirmButton: true,
      showDenyButton: true,
      showCancelButton: false,
      icon: "question",
      confirmButtonText: "Yes",
      denyButtonText: `No`
    }).then((result) => {
      if (result.isConfirmed) {
        getLocation();
      } else if (result.isDenied) {
        initMap();
      }
    });
}

var zoomInitial = 7;
var stringLocations = '<?=json_encode($locations); ?>';
var locations = JSON.parse(stringLocations);

var myIcon = L.icon({
    iconUrl: 'myIcon.png',
    iconSize: [45, 40],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
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
    }).addTo(map);
    
    
    locations.map((array, i) => {
        var label = array.label;
        var position = array.coord;
        L.marker([position.lat, position.lng], {icon: myIcon}).addTo(map).bindPopup(label).openPopup().on('click', (e)=>{ map.fitBounds([[position.lat, position.lng]]) });
    });

}

function initMaps(geoPosition){
    meCoord = {lat:geoPosition.coords.latitude, lng:geoPosition.coords.longitude}
    var newLocations=[]
    for(i=0;i<locations.length;i++){
        newLocations[(i+1)]={label:locations[i]['label'], coord:{lat:locations[i]['coord']['lat'], lng:locations[i]['coord']['lng']}}
    }
    newLocations[newLocations.length]={label:'Location', coord:{lat:meCoord.lat, lng: meCoord.lng}}
    var locationss = newLocations;

    var posInit = locationss[locationss.length-1]['coord'];
    var map = L.map('map', {zoomDelta: 0.25, zoomSnap: 0.25}).setView([posInit.lat, posInit.lng], zoomInitial);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);

    locationss.map((array, i) => {
        var last = locationss.length;
        var label = array.label;
        var position = array.coord;
        if((last-1) == i){
            L.marker([position.lat, position.lng]).addTo(map).bindPopup(label).openPopup().on('click', (e)=>{ map.fitBounds([[position.lat, position.lng]]) });
            map.fitBounds([[position.lat, position.lng]])
        }else{
            L.marker([position.lat, position.lng], {icon: myIcon}).addTo(map).bindPopup(label).openPopup().on('click', (e)=>{ map.fitBounds([[position.lat, position.lng]]) });
        }

    });
}
    
</script>

</body>
</html>