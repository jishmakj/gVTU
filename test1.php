
<!DOCTYPE html>
<html>
<head>
        <title></title>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHTDb8aE2WQOsO9dAqJMMWj8T5mmeCLk4&callback=initialize"
  type="text/javascript"></script>
		
</head>
<body>
        <script type="text/javascript">
        var myOptions=[];
       var map=null;
var flightPath=null;
var zoomedOnce = 0;
var directionsDisplay=null;
 var directionsService=null;
	
var arr2=[];
                function initialize() {
		
		



	//var x=new google.maps.LatLng(9.9312,76.2673);
 
    //var myOptions = {
      //  zoom: 4,
       // center: x,
      //  mapTypeId: google.maps.MapTypeId.ROADMAP
   // };

   	//var map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
    
	 directionsDisplay = new google.maps.DirectionsRenderer;
         directionsService = new google.maps.DirectionsService;



	map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: 10,
      center: new google.maps.LatLng(9.9312,76.2673),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	directionsDisplay.setMap(map);
	 getcoordinates(directionsService, directionsDisplay);

  /* 
    var marker;

  
      marker = new google.maps.Marker({
       position: new google.maps.LatLng(9.9985,76.3119),
        map: map
      });
*/


	
	

               

}

        function getcoordinates(directionsService, directionsDisplay) {
    $.ajax({

        url: "/gps/getCord.php",

        type: "get",

        dataType: "json",

        success: function (response) {
	
//		console.log(response);
	var arr=[];
	var bounds = new google.maps.LatLngBounds();

	for(var i=0; i<response.length; i++)
	{
		
		/*new google.maps.Marker({
       		position: new google.maps.LatLng(response[i].latitude,response[i].longitude),
       	 	map: map
		});*/
		//str.substring(0, str.length - 1);
		var latitOrig = response[i].latitude;
		var latTrimmed = latitOrig.substr(0,latitOrig.length - 1);   
		var longOrig = response[i].longitude;
		var longTrimmed = longOrig.substr(0,longOrig.length - 1);  
		//console.log(latTrimmed + " -- " + longTrimmed);
	if(Number(latTrimmed) > 0 && Number(longTrimmed) > 0){ 
	  var newPoint = new google.maps.LatLng(Number(latTrimmed),Number(longTrimmed));
	arr.push(newPoint);
		bounds.extend(newPoint);
	}
	}
	if(zoomedOnce == 0){
	map.fitBounds(bounds);

		zoomedOnce=1;
		map.setCenter(bounds.getCenter());
	}
	 

	 directionsService.route({
        // origin: {lat: arr[0]['latitude'], lng: arr[0]['longitude']},  
    	//destination: {lat: 37.768, lng: -122.511},
          waypoints: arr,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
		
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
















	//map.panTo(arr[arr.length - 1]);
	//map.setZoom(19);
	//console.log(arr);
	/*if(flightPath == null)
	{
		flightPath=new google.maps.Polyline({
		  path:arr,
		    geodesic: true,
		    strokeColor: '#FF0000',
		    strokeOpacity: 1.0,
		    strokeWeight: 2
		
		  });
	flightPath.setMap(map);
	}
	else
	{
		flightPath.setMap(null);
		flightPath=new google.maps.Polyline({
		  path:arr,
		    geodesic: true,
		    strokeColor: '#FF0000',
		    strokeOpacity: 1.0,
		    strokeWeight: 2
		
		  });
		flightPath.setMap(map);
	}
	 */

                

        },

        error: function(jqXHR, textStatus, errorThrown) {
  	 

           console.log(textStatus, errorThrown);

        }

         });

                
        }
$(document).ready(function(){

 //directionsDisplay = new google.maps.DirectionsRenderer;
        // directionsService = new google.maps.DirectionsService;
     setInterval(function(){ 


         getcoordinates(directionsService, directionsDisplay);
        

        }, 3000);
    


});

</script>
<div id="googleMap" style="width:1000px;height:768px;"></div>
</body>
</html>







