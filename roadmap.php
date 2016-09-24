<!DOCTYPE html>
<html>
<head>
        <title>VTU-GI</title>

   <!--  <script
      src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script> -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places"></script>
   
<!--  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHTDb8aE2WQOsO9dAqJMMWj8T5mmeCLk4&callback=initialize"
  type="text/javascript"></script>  -->
  
  
<script type="text/javascript">
   // var apiKey = "AIzaSyBUOsBnjxAtNmUXCdfusUQ2SrcetpJdPvI";
</script>

</head>
<body>
<?php
$no="";
$no=$_GET['link'];
$dt=$_GET['link2'];
?>
<form action="#">
<input type="hidden" id="h_regid" value="<?php echo $no;?>">
<input type="hidden" id="h_date" value="<?php echo $dt;?>">
</form>

        <script type="text/javascript">
        var apiKey = "AIzaSyBUOsBnjxAtNmUXCdfusUQ2SrcetpJdPvI";


//var map;
var drawingManager;
var placeIdArray = [];
var polylines = [];
var snappedCoordinates = [];


        var myOptions=[];
       var map=null;
var flightPath=null;
var zoomedOnce = 0;
var  path1=[];
var arr2=[];




                function initialize() {

    //     map = new google.maps.Map(document.getElementById('googleMap'), {
    //   zoom: 10,
    //   center: new google.maps.LatLng(9.9312,76.2673),
    //   mapTypeId: google.maps.MapTypeId.ROADMAP
    // });

  var mapOptions = {
    zoom: 17,
    center: {lat: -33.8667, lng: 151.1955}
  };
  map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);




  /* sfcd*/
 var  drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYLINE,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [
        google.maps.drawing.OverlayType.POLYLINE
      ]
    },
    polylineOptions: {
      strokeColor: '#696969',
      strokeWeight: 2
    }
  });
  drawingManager.setMap(map);

}










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

       //console.log(response);
        var arr=[];
        var bounds = new google.maps.LatLngBounds();

        for(var i=0; i<response.length; i++)
        {
    // var originalData = response[i].originalData;

    // var array1 = originalData.split(',');
    // $("#det1").text(array1[1]);
    // $("#det2").text(array1[1]);
    
  // var tm=response[i].datatime;
//console.log(tm);

    
                /*new google.maps.Marker({
                position: new google.maps.LatLng(response[i].latitude,response[i].longitude),
                map: map
                });*/
                //str.substring(0, str.length - 1);
                var latitOrig = response[i].latitude;
                var latTrimmed = latitOrig.substr(0,latitOrig.length - 1);   
                var longOrig = response[i].longitude;
                var longTrimmed = longOrig.substr(0,longOrig.length - 1);  


                var rdobject=latTrimmed +","+longTrimmed;
                //var nrdobject= rdobject.toUrlValue();
                //console.log(rdobject);
                //var nrdobject=rdobject.toUrlValue();
                path1.push(rdobject);
              }


    


 
    //runSnapToRoad(path1);
 // console.log(path1);

        },

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }
   });


        }


        ////



        function runSnapToRoad(path) {

          var apiKey = "AIzaSyBUOsBnjxAtNmUXCdfusUQ2SrcetpJdPvI";
        var pathValues = [];




  for (var i = 0; i < path1.length; i++) {
    pathValues.push(path1[i]);
  }
var jn=path1.join('|');

    //console.log(jn);


  // $.get('https://roads.googleapis.com/v1/snapToRoads', {
  //   interpolate: true,
  //   key: apiKey,
  //   dataType: "json",
  //   path: JSON.parse(jn)
  // }, function(data) {
  //   console.log(data);
  //   //processSnapToRoadResponse(data);
  //   //drawSnappedPolyline();
  //   //getAndDrawSpeedLimits();
  // });
}


///
$(document).ready(function(){

     setInterval(function(){ 

         getcoordinates();


        }, 3000);

 $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
    


});
// $(window).load(initialize);
</script>
<
         
            
            <div id="googleMap" style="width:750px;height:650px;"></div>
   
</body>
</html>