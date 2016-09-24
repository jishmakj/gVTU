<!DOCTYPE html>
<html>
<head>
        <title>VTU-GI</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHTDb8aE2WQOsO9dAqJMMWj8T5mmeCLk4&callback=initialize"
  type="text/javascript"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <style>
 body {
  padding-top: 51px;  
}
.text-center {
  padding-top: 20px;
}
.col-xs-12 {
  background-color: #fff;
}
.caheader
{
background-color:#e6e6e6;
}
#sidebar {
  height: 100%;
  padding-right: 0;
  padding-top: 20px;
}
#sidebar .nav {
  width: 95%;
}
#sidebar li {
  border:0 #f2f2f2 solid;
  border-bottom-width:1px;
}
a {
    color: #337ab7;
    text-decoration: none;
}

/* collapsed sidebar styles */
@media screen and (max-width: 767px) {
  .row-offcanvas {
    position: relative;
    -webkit-transition: all 0.25s ease-out;
    -moz-transition: all 0.25s ease-out;
    transition: all 0.25s ease-out;
  }
  .row-offcanvas-right
  .sidebar-offcanvas {
    right: -41.6%;
  }

  .row-offcanvas-left
  .sidebar-offcanvas {
    left: -41.6%;
  }
  .row-offcanvas-right.active {
    right: 41.6%;
  }
  .row-offcanvas-left.active {
    left: 41.6%;
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 41.6%;
  }
  #sidebar {
    padding-top:0;
  }
}
.changhead
{
background-color:black;
}
 

 
  </style>
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
        var myOptions=[];
       var map=null;
var flightPath=null;
var zoomedOnce = 0;

var arr2=[];
                function initialize() {

        map = new google.maps.Map(document.getElementById('googleMap'), {
      zoom: 10,
      center: new google.maps.LatLng(9.9312,76.2673),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

  /* 
    var marker;

  
      marker = new google.maps.Marker({
       position: new google.maps.LatLng(9.9985,76.3119),
        map: map
      });
*/

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
    var originalData = response[i].originalData;

    var array1 = originalData.split(',');
    $("#det1").text(array1[1]);
    $("#det2").text(array1[1]);
    
	var tm=response[i].datatime;
console.log(tm);

    
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
        //map.panTo(arr[arr.length - 1]);
        //map.setZoom(19);
       //console.log(arr);
        if(flightPath == null)
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
   strokeOpacity: 1.0,
                    strokeWeight: 2

                  });
                flightPath.setMap(map);
        }




        },

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }
   });


        }
$(document).ready(function(){

     setInterval(function(){ 

         getcoordinates();


        }, 3000);

 $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
    


});

</script>
<div class="page-container">
  
  <!-- top navbar -->
    <div class="navbar navbar-default navbar-fixed-top changhead" role="navigation">
       <div class="container">
      <div class="navbar-header">
           <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
           <a class="navbar-brand" href="<?php echo '/gps/template.php?link='.$no;?>">VTU</a>
      </div>
       </div>
    </div>
      
    <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li id="l1" class="active"><a href="<?php echo '/gps/template.php?link='.$no;?>">Home</a></li>
              <li id="l2"><a href="<?php echo '/gps/submit.php?link='.$no;?>">Display Map</a></li>
              <li id="l3"><a href="<?php echo '/gps/details.php?link='.$no;?>">Vehicle details</a></li>
           
       
              <!--<li id="l4"><a id="a4" href="#">Speed</a></li>-->  
    <li id="l6"><a href="#">Help</a></li>               
            </ul>
        </div>
    
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">
    <div class="container-fluid">
      <div class="row">
      

        
      <div class="w3-card-16">
        <header class="w3-container caheader">
            
            
            <div class="col-sm-4"><label>Vehicle Id: </label><span id="det1"></span></div>
            <div class="col-sm-4"><label>Reg.No:</label><span id="det2"></span></div>
            
            <div class="col-sm-4"><label></label><span id="det4"></span></div>
          
        </header>
          <div class="w3-container">
            
            <div id="googleMap" style="width:750px;height:650px;"></div>
            
      </div>
      
              </div>
            </div>
       </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->
</div><!--/.page-container-->
<footer style="background-color:#333;height:10%;">
    <p class="pull-right"><a href="#">Back to top</a></p>
    <p> Copyright (c) 2016 <a href="http://www.gardeninfosystems.com/">GARDEN INFOSYSTEMS </a></p>
  </footer>
</body>
</html>
<!-- http://codepen.io/keithpickering/pen/NqdzKO -->