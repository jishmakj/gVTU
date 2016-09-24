
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Roads API Demo</title>
    <style>
      html, body, #map {
        height: 100%;
        margin: 0px;
        padding: 0px
      }

      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }

      #bar {
        width: 240px;
        background-color: rgba(255, 255, 255, 0.75);
        margin: 8px;
        padding: 4px;
        border-radius: 4px;
      }

      #autoc {
        width: 100%;
        box-sizing: border-box;
      }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg&libraries=drawing,places"></script>

<script src="/gps/moment.js"></script>
  </head>

  <body>
  <?php
$no="";
$no=$_GET['link'];
$dt=$_GET['link2'];
$tm=$_GET['link3'];
?>
<form action="#">
<input type="hidden" id="h_regid" value="<?php echo $no;?>">
<input type="hidden" id="h_date" value="<?php echo $dt;?>">
<input type="hidden" id="h_time" value="<?php echo $tm;?>">
</form>
    <div id="map"></div>
  <!--   <div id="bar">
      <p class="auto"><input type="text" id="autoc"/></p>
      <p><a id="clear" href="#">Click here</a> to clear map.</p>
    </div> -->
<!-- =============== -->



      <script>

var apiKey = 'AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg';

var map;
var drawingManager;
var placeIdArray = [];
var polylines = [];
var snappedCoordinates = [];
var arr=[];
var zoomedOnce = 0;

function initialize() {
  var mapOptions = {
    zoom: 17,
    center: {lat: 10.0111079, lng: 76.3376786}
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);


  // Adds a Places search box. Searching for a place will center the map on that
  // location.
  // map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
  //     document.getElementById('bar'));
  // var autocomplete = new google.maps.places.Autocomplete(
  //     document.getElementById('autoc'));
  // autocomplete.bindTo('bounds', map);
  // autocomplete.addListener('place_changed', function() {
  //   var place = autocomplete.getPlace();
  //   if (place.geometry.viewport) {
  //     map.fitBounds(place.geometry.viewport);
  //   } else {
  //     map.setCenter(place.geometry.location);
  //     map.setZoom(17);
  //   }
  // });

  // Enables the polyline drawing control. Click on the map to start drawing a
  // polyline. Each click will add a new vertice. Double-click to stop drawing.
  // drawingManager = new google.maps.drawing.DrawingManager({
  //   drawingMode: google.maps.drawing.OverlayType.POLYLINE,
  //   drawingControl: true,
  //   drawingControlOptions: {
  //     position: google.maps.ControlPosition.TOP_CENTER,
  //     drawingModes: [
  //       google.maps.drawing.OverlayType.POLYLINE
  //     ]
  //   },
  //   polylineOptions: {
  //     strokeColor: '#696969',
  //     strokeWeight: 2
  //   }
  // });
  // drawingManager.setMap(map);

  // // Snap-to-road when the polyline is completed.
  // drawingManager.addListener('polylinecomplete', function(poly) {
  //   var path = poly.getPath();
  //   console.log(path);
  //   polylines.push(poly);
  //   placeIdArray = [];
  //   runSnapToRoad(path);
  // });

  // Clear button. Click to remove all polylines.
  // $('#clear').click(function(ev) {
  //   for (var i = 0; i < polylines.length; ++i) {
  //     polylines[i].setMap(null);
  //   }
  //   polylines = [];
  //   ev.preventDefault();
  //   return false;
  // });
}

// Snap a user-created polyline to roads and draw the snapped path
function runSnapToRoad(path) {
  var pathValues = [];
  for (var i = 0; i < path.getLength(); i++) {
    pathValues.push(path.getAt(i).toUrlValue());
  }

  $.get('https://roads.googleapis.com/v1/snapToRoads', {
    interpolate: true,
    key: apiKey,
    path: pathValues.join('|')
  }, function(data) {
    processSnapToRoadResponse(data);
    drawSnappedPolyline();
    //getAndDrawSpeedLimits();
  });
}

// Store snapped polyline returned by the snap-to-road service.
function processSnapToRoadResponse(data) {
  snappedCoordinates = [];
  placeIdArray = [];
  for (var i = 0; i < data.snappedPoints.length; i++) {
    var latlng = new google.maps.LatLng(
        data.snappedPoints[i].location.latitude,
        data.snappedPoints[i].location.longitude);
    snappedCoordinates.push(latlng);
    placeIdArray.push(data.snappedPoints[i].placeId);
  }
}

// Draws the snapped polyline (after processing snap-to-road response).
function drawSnappedPolyline() {
  var snappedPolyline = new google.maps.Polyline({
    path: snappedCoordinates,
    strokeColor: 'red',
    strokeWeight: 3
  });

  snappedPolyline.setMap(map);
  polylines.push(snappedPolyline);
}

// Gets speed limits (for 100 segments at a time) and draws a polyline
// color-coded by speed limit. Must be called after processing snap-to-road
// response.
function getAndDrawSpeedLimits() {
  for (var i = 0; i <= placeIdArray.length / 100; i++) {
    // Ensure that no query exceeds the max 100 placeID limit.
    var start = i * 100;
    var end = Math.min((i + 1) * 100 - 1, placeIdArray.length);

    drawSpeedLimits(start, end);
  }
}

// Gets speed limits for a 100-segment path and draws a polyline color-coded by
// speed limit. Must be called after processing snap-to-road response.
function drawSpeedLimits(start, end) {
    var placeIdQuery = '';
    for (var i = start; i < end; i++) {
      placeIdQuery += '&placeId=' + placeIdArray[i];
    }

    $.get('https://roads.googleapis.com/v1/speedLimits',
        'key=' + apiKey + placeIdQuery,
        function(speedData) {
          processSpeedLimitResponse(speedData, start);
        }
    );
}

// Draw a polyline segment (up to 100 road segments) color-coded by speed limit.
function processSpeedLimitResponse(speedData, start) {
  var end = start + speedData.speedLimits.length;
  for (var i = 0; i < speedData.speedLimits.length - 1; i++) {
    var speedLimit = speedData.speedLimits[i].speedLimit;
    var color = getColorForSpeed(speedLimit);

    // Take two points for a single-segment polyline.
    var coords = snappedCoordinates.slice(start + i, start + i + 2);

    var snappedPolyline = new google.maps.Polyline({
      path: coords,
      strokeColor: color,
      strokeWeight: 6
    });
    snappedPolyline.setMap(map);
    polylines.push(snappedPolyline);
  }
}

// function getColorForSpeed(speed_kph) {
//   if (speed_kph <= 40) {
//     return 'purple';
//   }
//   if (speed_kph <= 50) {
//     return 'blue';
//   }
//   if (speed_kph <= 60) {
//     return 'green';
//   }
//   if (speed_kph <= 80) {
//     return 'yellow';
//   }
//   if (speed_kph <= 100) {
//     return 'orange';
//   }
//   return 'red';
// }

$(window).load(initialize);
//initialize();




        function getcoordinates() {

  var h_reg=document.getElementById("h_regid").value;
 var h_date=document.getElementById("h_date").value;

  //alert(h_reg);
  var sturl="/gps/getCoordinates.php?link="+h_reg+"&link2="+h_date;
    $.ajax({
  
  
  
        url: sturl,

        type: "get",

        dataType: "json",
  success: function (response) {

        var newstart={};
        var arr=[];
        var arr1={};
        var bounds = new google.maps.LatLngBounds();
        var arr2=[];
        var k=0;
          while(response.length) {

           arr1[k]= response.splice(0,100);

            k++;
          }
          //console.log(arr1);
          var pt={};
         for(var j in arr1)
         {
          for (var p=0; p < arr1[j].length; p++)
          {
              var latitOrig = arr1[j][p].latitude;
              var latTrimmed = latitOrig.substr(0,latitOrig.length - 1);   
              var longOrig = arr1[j][p].longitude;
              var longTrimmed = longOrig.substr(0,longOrig.length - 1); 
              if(Number(latTrimmed) > 0 && Number(longTrimmed) > 0){ 
                  var newPoint = new google.maps.LatLng(Number(latTrimmed),Number(longTrimmed));
                  arr.push(newPoint);
                  bounds.extend(newPoint);
                }
          }
        
         flightPath=new google.maps.Polyline({
                  path:arr,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2

                  });
        pt[j]=flightPath.getPath();
        arr=[];
        }       
        // if(zoomedOnce == 0){
        // map.fitBounds(bounds);

        //         zoomedOnce=1;
        //         map.setCenter(bounds.getCenter());
        // }

       //console.log(pt);

        for(var s in arr1)
        {
              runSnapToRoad(pt[s]);
        }
        //console.log(pt);
      //   for(var i=0; i<response.length; i++)
      //   {

          
      //     a.splice(0,100);
      //           var latitOrig = response[i].latitude;
      //           var latTrimmed = latitOrig.substr(0,latitOrig.length - 1);   
      //           var longOrig = response[i].longitude;
      //           var longTrimmed = longOrig.substr(0,longOrig.length - 1);  

      //              if(Number(latTrimmed) > 0 && Number(longTrimmed) > 0){ 
      //             var newPoint = new google.maps.LatLng(Number(latTrimmed),Number(longTrimmed));
      //               arr.push(newPoint);

      //               bounds.extend(newPoint);
      //               }
                
      //        }
      // if(zoomedOnce == 0){
      //  map.fitBounds(bounds);

      //           zoomedOnce=1;
      //           map.setCenter(bounds.getCenter());
      //   }

    
      // flightPath=new google.maps.Polyline({
      //             path:arr,
      //               geodesic: true,
      //               strokeColor: '#FF0000',
      //               strokeOpacity: 1.0,
      //               strokeWeight: 2

      //             });
      //   var pt=flightPath.getPath();
        

 

 // console.log(path1);

        },

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }
   });


        }

$(document).ready(function(){
    getcoordinates();
});

    </script>

<!-- ================== -->
  </body>
</html>

<!-- AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg  --> 
<!-- AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg  -->