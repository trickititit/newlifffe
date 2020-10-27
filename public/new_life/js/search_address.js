//$('#obj_geo').val(result.geometry.getCoordinates());
//$('#obj_address').val(resString);

// Instantiate a map and platform object:
var platform = new H.service.Platform({
    'apikey': 'eK1Osb_OFha_gCR2O-aDpZp-LSAS-bOlkPlKyFOS5-Q'
});

// Get default map types from the platform object:
var defaultLayers = platform.createDefaultLayers({
    lg: 'ru'
});

// Instantiate the map:
var map = new H.Map(
    document.getElementById('HereMap'),
    defaultLayers.vector.normal.map,
    {
        zoom: 15,
        center: { lat: 48.7979, lng: 44.7462},
        pixelRatio: window.devicePixelRatio || 1
    });


console.log(map);
window.addEventListener('resize', () => map.getViewPort().resize());
window.addEventListener('DOMContentLoaded', () => map.getViewPort().resize());

var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

var ui = H.ui.UI.createDefault(map, defaultLayers, 'ru-RU');


$('#search-query').on( "keydown", function(event) {
    if(event.which == 13) {
        event.preventDefault();
        GeoCoding();
    }
});

$('#search-map').click(function (e) {
    e.preventDefault();
    GeoCoding();
});


function GeoCoding() {
    var query = $('#search-query').val();
    // Create the parameters for the geocoding request:
    var geocodingParams = {
        searchText: 'Волжский, ' + query
    };
    // Define a callback function to process the geocoding response:
    var onResult = function(result) {
        var locations = result.Response.View[0].Result,
            position,
            marker;
        // Add a marker for each location found
        for (i = 0;  i < locations.length; i++) {
            position = {
                lat: locations[i].Location.DisplayPosition.Latitude,
                lng: locations[i].Location.DisplayPosition.Longitude
            };
            marker = new H.map.Marker(position);
            marker.label = locations[i].Location.Address.Label;
            map.addObject(marker);
            map.setCenter({lat:locations[i].Location.DisplayPosition.Latitude, lng:locations[i].Location.DisplayPosition.Longitude});
            $('#obj_geo').val(locations[i].Location.DisplayPosition.Latitude + ', ' + locations[i].Location.DisplayPosition.Longitude);
            $('#obj_address').val(locations[i].Location.Address.Label);
        }
    };
// Get an instance of the geocoding service:
    var geocoder = platform.getGeocodingService();

// Call the geocode method with the geocoding parameters,
// the callback and an error callback function (called if a
// communication error occurs):
    geocoder.geocode(geocodingParams, onResult);
}


