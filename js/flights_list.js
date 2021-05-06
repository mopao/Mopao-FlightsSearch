/*jslint browser: true */
/*global window , google */
let worldMap;
let markers = [];
let flightPlanCoordinates = [];
let flightPath = null;
// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}
//remove lines
function removeLine() {
  flightPlanCoordinates = [];
  if (flightPath !== null) {
    flightPath.setMap(null);
  }
}
// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}
function initMap() {
    "use strict";
    let marker, myLatlng;
    let zoomNber = 2.4;
    myLatlng = {lat: 0, lng: 0};
    worldMap = new google.maps.Map(document.getElementById("map"), {
        center: myLatlng,
        zoom: zoomNber,
        minZoom: 1.9,
    });

    // Configure the click listener.
    worldMap.addListener("click", function (mapsMouseEvent) {
        // center the map on the geocode
        worldMap.setCenter(mapsMouseEvent.latLng);
        // zoom the map
        zoomNber += 0.2;
        worldMap.setZoom(zoomNber);
    });

    var forms = document.getElementsByName('f-map-airports');
    forms.forEach((item, i) => {
      item.elements[1].onclick = function () {
        //remove Markers
        deleteMarkers();
        // remove lines
        removeLine();
        /* fetch airports' geocode and set markers */
        var airportCodes = item.elements[0].value.split(",");
        let centerIndex = Math.ceil(airportCodes.length/2);
        airportCodes.forEach((code, i) => {
          var data = {
            "airportCode": code
          };
          //console.log(data);
          $.ajax({
            dataType: "json",
            async: false,
            url: "api/find_airports.php",
            data: data,
            type: "GET",
            success: function (result,status,xhr) {
            // if geocode exist, then we add it to the map
              if(result.length > 0){
                  // Create a marker on the map
                  var airportPosition = {lat: Number.parseFloat(result[0].latitude), lng: Number.parseFloat(result[0].longitude)};
                  //console.log( result);
                  flightPlanCoordinates.push(airportPosition);
                  marker = new google.maps.Marker({
                      position: airportPosition,
                      label: code,
                      map: worldMap
                  });
                  //set click event on marker
                  marker.addListener("click", () => {
                    zoomNber += 0.2;
                    worldMap.setZoom(zoomNber);
                    worldMap.setCenter(marker.getPosition());
                  });
                  markers.push(marker);
              }


            },
            error: function (xhr){ console.log(xhr.responseText);}

         });

        });
        //console.log(flightPlanCoordinates);
          flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: "#FF0000",
          strokeOpacity: 1.0,
          strokeWeight: 2,
        });
        flightPath.setMap(worldMap);
        worldMap.setCenter(flightPlanCoordinates[0]);
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        //worldMap.setZoom(2.4);

      };


    });

    new google.maps.event.addDomListener(window, "resize", function() {
    var center = worldMap.getCenter();
    new google.maps.event.trigger(worldMap, "resize");
    worldMap.setCenter(center);
   });
}
