const MAPBOX_TOKEN = "pk.eyJ1Ijoia2FhbWRhYXIiLCJhIjoiY2wwNWhwNjl5MDhjMjNjbnoxajMxOXExMCJ9.KDuSWfD7invXCiRTg_WMfg";
mapboxgl.accessToken = MAPBOX_TOKEN;

function initMap(start)
{
	const map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: start,
		zoom: 15
	});

	map.addControl(new mapboxgl.NavigationControl({
			visualizePitch: true
		}),
		"bottom-right");

	let userLocControl = new mapboxgl.GeolocateControl({
		positionOptions: {
			enableHighAccuracy: true
		},
		trackUserLocation: true,
		showUserHeading: true
	});

	map.addControl(userLocControl, "bottom-right");

	var markerDetails = createMarker(map, start);
	var markerElem = document.getElementsByClassName(markerDetails[0])[0];
	var pin = markerDetails[1];

	let currentLocation = document.getElementsByClassName("pin-to-current")[0];
	currentLocation.addEventListener("click", (e) => {
		mapFlyTo(map, start);
		pin.setLngLat(start);
	});

	map.on("click", (e) => {
		let lonLat = e.lngLat;
		pin.setLngLat(lonLat);
		mapFlyTo(map, pin.getLngLat());
	});

	map.on("drag", (e) => {
		let lonLat = map.getCenter();
		pin.setLngLat(lonLat);
	});

	map.on("dragend", (e) => {
		currentLocation.style.animation = "ripple 1s ease-out";
	});

	pin.on("dragend", (e) => {
		mapFlyTo(map, pin.getLngLat());
	});
}

function mapFlyTo(map, loc)
{
	map.flyTo({
		center: loc,
		zoom: 15,
		speed: 0.2,
		curve: 1
	});
}

function animatePinDrop(pin)
{

}

function createMarker(map, latlong)
{
	const el = document.createElement('div');
	el.className = 'marker';
	el.style.backgroundSize = '100%';

	const marker = new mapboxgl.Marker(el, {
		draggable: true
	}).setLngLat(latlong).addTo(map);
	return [el.className, marker];
}

function onLocationAccessSuccess(pos)
{
	const userLoc = [pos.coords.longitude, pos.coords.latitude];
	initMap(userLoc);
}

function onLocationAccessError(err)
{
	console.warn(`ERROR(${err.code}): ${err.message}`);

	const ktmLatLong = [85.3240, 27.7172];
	initMap(ktmLatLong);
}

function requestAndLoadMap()
{
	if(navigator.geolocation)
	{
		let locOptions = {
			maximumAge: 0,
			timeout: 40000,
			enableHighAccuracy: true
		};

		navigator.geolocation.getCurrentPosition(
												onLocationAccessSuccess,
												onLocationAccessError,
												locOptions
											);
	}
	else
		console.log("Geolocation is not supported by this browser.");
}

requestAndLoadMap();