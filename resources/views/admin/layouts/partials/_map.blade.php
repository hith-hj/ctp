<script>
    var lat = parseFloat('{{ isset($latitude) ? $latitude : 30.059501644912803 }}');
    var lng = parseFloat('{{ isset($longitude) ? $longitude : 31.25846434999999}}');
    var position = [lat, lng];

    function initMap() {
        var latlng = new google.maps.LatLng(position[0], position[1]);

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat:lat, lng:lng },
            zoom: 13
        });

        marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: "Latitude:"+position[0]+" | Longitude:"+position[1]
        });

        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        google.maps.event.addDomListener(input, 'keydown', function(event) {
            // marker.setPosition(map.getCenter());
            if (event.keyCode === 13) {
                event.preventDefault();
            }
        });

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);

        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(map.getCenter());

            $('input[name="latitude"]').attr('value',marker.position.lat());
            $('input[name="longitude"]').attr('value',marker.position.lng());
            $('input[name="location]"]').attr('value', place.formatted_address);
            $('#location').val(place.formatted_address);


            infowindowContent.children['place-name'].textContent = place.name;
            // infowindowContent.children['place-id'].textContent = place.place_id;
            infowindowContent.children['place-address'].textContent =
                place.formatted_address;
            infowindow.open(map, marker);
        });
        google.maps.event.addListener(map, 'click', function(event) {
            var result = [event.latLng.lat(), event.latLng.lng()];
            MyLatLng = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng());
            transition(result);
        });

        var numDeltas = 100;
        var delay = 10;
        var i = 0;
        var deltaLat;
        var deltaLng;
        function transition(result){
            position = [marker.position.lat(),marker.position.lng()];

            i = 0;
            deltaLat = (result[0] - position[0])/numDeltas;
            deltaLng = (result[1] - position[1])/numDeltas;
            const geocoder = new google.maps.Geocoder();
            geocodeLatLng(geocoder, map, infowindow, position[0], position[1]);
            moveMarker();
        }

        function moveMarker(){
            // console.log(position);

            position[0] += deltaLat;
            position[1] += deltaLng;
            var latlng = new google.maps.LatLng(position[0], position[1]);
            marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);

            $('input[name="latitude"]').attr('value',position[0]);
            $('input[name="longitude"]').attr('value',position[1]);
            marker.setPosition(latlng);
            if(i!=numDeltas){
                i++;
                setTimeout(moveMarker, delay);
            }
        }

        function geocodeLatLng(geocoder, map, infowindow, latitude, longitude) {
            // const input = document.getElementById("latlng").value;
            // const latlngStr = input.split(",", 2);
            const latlng = {
                lat: parseFloat(latitude),
                lng: parseFloat(longitude),
            };
            geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === "OK") {
                    if (results[0]) {
                        $('#location').val(results[0].formatted_address)
                    } else {
                        // window.alert("No results found");
                    }
                } else {
                    // window.alert("Geocoder failed due to: " + status);
                }
            });
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfqfNvE-Tof6EFFrTuHobGrUzUq_lQNSQ&libraries=places&callback=initMap"></script>
