let app = JSON.parse(app_data);

let mapData = app.map;

/**
 * Google Maps Styles Override.
 * @link https://stackoverflow.com/a/4024762/1743124
 * @link https://mapstyle.withgoogle.com/
 */
let googleMapsStyles = [
    {
    "elementType": "labels",
    "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
    "featureType": "administrative.land_parcel",
    "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
    "featureType": "administrative.neighborhood",
        "stylers": [
            {
            "visibility": "off"
            }
        ]
    },
    {
    "featureType": "poi",
    "elementType": "labels.text",
    "stylers": [
            {
            "visibility": "off"
            }
        ]
    },
    {
    "featureType": "road",
    "stylers": [
            {
            "visibility": "off"
            }
        ]
    },
    {
    "featureType": "road",
    "elementType": "labels.icon",
    "stylers": [
            {
            "visibility": "off"
            }
        ]
    },
    {
    "featureType": "transit",
    "stylers": [
            {
            "visibility": "off"
            }
        ]
    }
];

/**
 * Google Map Initialization.
 */
let initMap = function() {

    let { center, zoom, regions, label } = mapData;

    // Map options.
    let mapOptions = {
        zoom: zoom,
        center: center,
        mapTypeControl: false,
        streetViewControl: false,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_BOTTOM,
        },
        fullscreenControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP,
        },
    };

    // Target the map.
    let map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // Stylize the map to make it featureless.
    map.set('styles', googleMapsStyles);

    // Sub-regions are available.
    if (regions.length > 0) {
        // Mark the points.
        regions.forEach(data => {
            let { lat, lng } = data.coordinates;

            if (lat && lng) {
                // Map markers.
                let marker = new google.maps.Marker(
                    {
                        position: { lat: parseFloat(lat), lng: parseFloat(lng) },
                        map: map,
                        icon: {
                            url: app.asset_url + 'images/pin.svg',
                            labelOrigin: new google.maps.Point(15, 35) // https://stackoverflow.com/a/37442687/1743124
                        },
                        label: data.name,
                        item_id: data.id,
                        item_link: data.link
                    }
                );

                // Marker: Hover.
                google.maps.event.addListener(marker, 'mouseover', function(){
                    this.setOptions({
                        icon: {
                            url: app.asset_url + 'images/red-dot.png',
                            labelOrigin: new google.maps.Point(15, 35)
                        }
                    });
                });

                // Marker: Mouseout - Back to Default.
                google.maps.event.addListener(marker, 'mouseout', function(){
                    this.setOptions({
                        icon: {
                            url: app.asset_url + 'images/pin.svg',
                            labelOrigin: new google.maps.Point(15, 35)
                        }
                    });
                });

                // Marker: Click.
                google.maps.event.addListener(marker, 'click', function (event) {
                    // console.log(this);
                    window.location.href = this.item_link;
                });
            }
        });
    } else {
        // Sub-regions are not available, show a single marker.
        new google.maps.Marker(
            {
                position: center,
                map: map,
                icon: {
                    url: app.asset_url + 'images/pin.svg',
                    labelOrigin: new google.maps.Point(15, 35)
                },
                label: label
            }
        );
    }

}

// Finally, intiate the map.
google.maps.event.addDomListener(window, 'load', initMap);
