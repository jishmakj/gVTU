<!DOCTYPE html>
<html>
<head>
        <title>VTU-GI</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg&libraries=drawing,places"></script>
<script type="text/javascript" src="http://www.w3schools.com/lib/w3color.js"></script>
<script src="/gps/moment.js"></script>
<script src="/gps/color.js"></script>
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
<script type="text/javascript">


var apiKey = 'AIzaSyALvpNjPdZom-Ht14FLYe6ggK7s0TL_ndg';

var map=null;
var drawingManager;
var placeIdArray = [];
var polylines = [];
var snappedCoordinates = [];
var arr=[];
var zoomedOnce = 0;


  //var myOptions=[];
 
  var flightPath=null;
  var zoomedOnce = 0;
  var arr2=[];
               function initialize() {
  var mapOptions = {
    zoom: 17,
    center: {lat: 10.0111079, lng: 76.3376786}
    ,mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

    //     map = new google.maps.Map(document.getElementById('map'), {
    //   zoom: 10,
    //   center: new google.maps.LatLng(9.9312,76.2673),
    //   mapTypeId: google.maps.MapTypeId.ROADMAP
    // });
}
function runSnapToRoad(path,col) {
  // alert("haii");
   //console.log(path);
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
    drawSnappedPolyline(col);
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
function drawSnappedPolyline(col) {
  var snappedPolyline = new google.maps.Polyline({
    path: snappedCoordinates,
    strokeColor: col,
    strokeOpacity: 1.0,
    strokeWeight: 3
  });

  snappedPolyline.setMap(map);
  polylines.push(snappedPolyline);
}




$(window).load(initialize);

        function getcoordinates() {




  var h_reg=document.getElementById("h_regid").value;
 var h_date=document.getElementById("h_date").value;
 var h_time=document.getElementById("h_time").value;

  //alert(h_reg);
  var sturl="/gps/getCoordinates.php?link="+h_reg+"&link2="+h_date;
    $.ajax({
  
  
  
        url: sturl,

        type: "get",

        dataType: "json",
  success: function (response) {

       //console.log(response);
        var arr=[];
 	var arr1={};
 	var arr2=[];
        var bounds = new google.maps.LatLngBounds();



  var p=0;
  var newstart={};
        for(var i=0; i<response.length; i++)
        {
    	var originalData = response[i].originalData;

   	 var array1 = originalData.split(',');
    	$("#det1").text(array1[1]);
    	$("#det2").text(array1[1]);
    

    newstart[0]="IntialPoint";
	if(i!=0)
	{
			var then  = "04/09/2013 "+ response[i-1].datatime ;
			var now = "04/09/2013 " +response[i].datatime;
		
			var hms=moment.utc(moment(now,"DD/MM/YYYY HH:mm:ss").diff(moment(then,"DD/MM/YYYY HH:mm:ss"))).format("HH:mm:ss");
			
			var a =hms.split(':');
			
			var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
      var tmsec=30*60;
      if(h_time != "")
      {
        tmsec=h_time*60;
      }
      
			if(seconds > tmsec)
			{
           newstart[i]=0;
      }
      else
      {
        newstart[i]=1;

      }
		
	   }
  }

    var newArr=[];
    var retArr={};
    // var testArr={};
    var p=0;
		for(var j=0; j<response.length; j++)
    {



      var latitOrig = response[j].latitude;
      var latTrimmed = latitOrig.substr(0,latitOrig.length - 1);   
      var longOrig = response[j].longitude;
      var longTrimmed = longOrig.substr(0,longOrig.length - 1);  

      //console.log(latTrimmed + " -- " + longTrimmed);
      if(Number(latTrimmed) > 0 && Number(longTrimmed) > 0){ 
          var newPoint = new google.maps.LatLng(Number(latTrimmed),Number(longTrimmed));
          newArr.push(newPoint);
          bounds.extend(newPoint);
        }
         //rewArr=newArr;
        retArr[p]=newArr;

        if(newstart[j]  == 0)
        {
         newArr=[];
         p++;
        }

    }

//console.log(retArr);
    //console.log(response.length);

        if(zoomedOnce == 0){
            map.fitBounds(bounds);
           zoomedOnce=1;
            map.setCenter(bounds.getCenter());
        }
    var fnlArr={};
    var z=0;
    var a=0;
  
  //fnlArr[a]={};
  // var  fnlArr[a][z]={};
   var arr1={};
   var arry = [];
for(var x in retArr)
{



    if(retArr[x].length != 0 )
    {
    
            fnlArr[a]= getArr(retArr[x]);
        a++; 
    }
}
// console.log(fnlArr[0]);
// console.log(fnlArr[71]);

   //}
    //a++;
  //   for(var y=0; y < retArr[x].length; y++)
  //   {

  //     // if(retArr[x].length !=0)
  //     // {
  //       arry.push(retArr[x].splice(0,100));

        

  //       // z++;
  //     //}
   
       
  //     //fnlArr[a][z]=retArr[x].splice(0,100);
     
  //   }
  //   fnlArr[a]=arry;
  //   a++;
  
  //  }
  

   
  // console.log(a); 
  //console.log(z);  
  //console.log(arr1); 

  //fnlArr[k]={};
     var pt={};
    for(var k in fnlArr)
    {
      // if(k==71)
      // {
          for(var h=0; h < fnlArr[k].length; h++)
          {

            if(fnlArr[k].length != 0)
            {
              //console.log("1");



                 var npath=fnlArr[k][h];
             // console.log(fnlArr[k][h]);

             flightPath=new google.maps.Polyline({
                    path:npath,
                      geodesic: true,
                      strokeColor: '#FF0000',
                      strokeOpacity: 1.0,
                      strokeWeight: 2

                    });
             pt[h]=flightPath.getPath();
           //flightPath.setMap(map);
           var ncolor=col[k];
          // console.log(col[k]);
          //   var ncolor='#FF0000';
           runSnapToRoad(pt[h],ncolor);


}


            // }
            // else
            // {
              // var u=0;
              // while(fnlArr[k][h].length)
              // {

              //   u++;
              // }
              //console.log(fnlArr[k][h][0]);
            // }

           
          }
      //}
      
    }
    // console.log(pt);

 // for(var s in fnlArr)
 //  {
 //    var ncolor=col[s];
 //     runSnapToRoad(pt[s],ncolor);
 //    }
        




      //}
      
      
      // if(k <147)
      // {
      //   var ncolor=col[k];
      // }
      // else
      // {
      //   var ncolor='#FF0000';
      // }

      
     
     
      //pt[k]=flightPath.getPath();
       
    //}		
   
   //console.log(fnlArr.length);
        //for(var s in fnlArr)
        // {
        //     var ncolor=col[s];
        //     // if(s>147){

        //       //   var ncolor='#FF0000';
        //       // }
            
        //       //console.log(s);
        //      // runSnapToRoad(pt[s],ncolor);
        
        // }

        },

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }
   });


  }
function getArr(arr)
{

  var z=0;
  var a=0;
  
  //fnlArr[a]={};
  // var  fnlArr[a][z]={};
   var arr1={};
   var arry = [];
          for(var y=0; y < arr.length; y++)
            {
             // arry=arr;
             arry.push(arr.splice(0,100));
              //z++;
              //console.log(arry.length);
              
            }
            return  arry;
}


// function getRandomColor() {

//     // var letters = '0123456789ABCDEF';
//     // var color = '#';
//     // for (var i = 0; i < 6; i++ ) {
//     //     color += letters[Math.floor(Math.random() * 16)];
//     //     colorArr.push(color);
//     // }
// // assumes hue [0, 360), saturation [0, 100), lightness [0, 100)



//     console.log(dropColors);
// }



$(document).ready(function(){


     // setInterval(function(){ 

       getcoordinates();
// getRandomColor();

       // }, 3000);

 
    //console.log(col.length);


});

</script>

        
       
             <div id="map"></div>
            <!-- <div id="googleMap" style="width:750px;height:650px;"></div> -->
            
      
</body>
</html>
