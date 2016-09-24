<!DOCTYPE html>
<html>
<head>
  <title>VTU-GI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
/*ADDITIONS*/
.changhead
{
background-color:black;
}
.changea {
    color: #337ab7;
    text-decoration: none;
}
/**/
.wrapper {
    min-height: 100%;
    height: auto !important;
    height: 100%;
    margin: 0 auto -155px; /* the bottom margin is the negative value of the footer's height */
}
.footer {
    position: fixed;
    height: 100px;
    bottom: 0;
    width: 100%;
background-color:#b9c1c7;
margin-right:300px;

}
.footerpara
{
color: #337ab7;

}
  </style>
</head>
<body>
<?php 
$no="";
$no=$_GET['link'];?>

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
           <a class="navbar-brand" href="/gps/template.php">GPS Vehicle Tracking System</a>
    	</div>
       </div>
    </div>
      
    <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li id="l1" class="active"><a class="changea" id="a1" href="/gps/template.php">Home</a></li>
              <li id="l2"><a class="changea" id="a2" href="#">Display Map</a></li>
              <li id="l3"><a class="changea" id="a3" href="#">Vehicle details</a></li>
            <!--  <li id="l4"><a class="changea" id="a4" href="#">Speed</a></li>-->
	     
              <li id="l5"><a class="changea" href="#">Settings</a></li>  
		<li id="l6"><a class="changea" href="#">Help</a></li>               
            </ul>
        </div>
  	
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">

		<div class="container-fluid">
	

			<div class="row">
			<div class="contentbox" id="div1">
					
				<div class="col-sm-4">
				<div class="form-group">
					<select id="vehicle" class="form-control inp-sm" onchange="getVehicleDet()">
					
					<?php if($no != ""){ ?>
					<option value="<?php echo $no;?>" selected><?php echo $no;?></option>
					<?php }?>
					</select>
					

					</div>



					
					
				</div>


						<div class="col-sm-4">
						<div class="form-group"><select id="selDate" class="form-control inp-sm" onchange="changHref()">
						<option>Select Date</option>
						</select></div>
						</div>



            <!-- ====  -->
            <div class="col-sm-4">
            <label>Time filtering</label>
              <div class="form-group"><input type="text" name="tm" id="tm" class="form-control inp-sm" placeholder="Enter Time in Minutes" onchange="changHref()"></div>
            </div>
            <!-- ==== -->

						<div class="w3-card-8" style="width:100%">
						<header class="w3-container w3-light-grey"></header>
						<div class="w3-container">
							<div class="col-sm-4"><label>Vehicle Name:</label><span id="det1"></span></div>
							<div class="col-sm-4"><label>Vehicle Id</label><span id="det2"></span></div>
							<div class="col-sm-4"><label>Reg.No</label><span id="det3"></span></div>
							<div class="col-sm-4"><label>Person:</label><span id="det4"></span></div>
							<div class="col-sm-6"><button class="btn-primary" style="padding-bottom:10px;"><a id="a5" href="/gps/submit.php">Display Map</a></button></div>
						</div>
			</div>
			
			
		</div>

          
        </div><!-- /.col-xs-12 main -->
    </div><!--/.row-->
  </div><!--/.container-->




</div><!--/.page-container-->
<!--/.footer-->

<div class="footer">
 <div class="container">
  <p  class="footerpara" style="text-align: center;">Copyright (c) 2016 <a href="http://www.gardeninfosystems.com/">GARDEN INFOSYSTEMS </a></p>
</div>
</div>

<!--/.footer-->
<script type="text/javascript">
$(document).ready(function() {
getvehicles();
getdate();
var vehicle_id=$("#vehicle").val();
if(vehicle_id != null)
{

	getVehicleDet();
}

  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });

});
function getVehicleDet()
{

	var vehicle_id=$("#vehicle").val();

	//var vehicle_date=$("#selDate").val();

	var myKeyVals = { 'vehicleId': vehicle_id};	
	
	 $.ajax({

        url: "/gps/getVehicleDet.php",

        type: "post",

        dataType: "json",
	
	data: myKeyVals,

        success: function (response) {

	//sethref(vehicle_id,vehicle_date);

	$("#det1").text(response[0].VehicleName);
	$("#det2").text(response[0].VehicleId);
	$("#det3").text(response[0].RegNo);
	$("#det4").text(response[0].UserName);


		
	console.log(response[0].VehicleName);

	},

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }

         });
	
	
}
function changHref()
{

	var vehicle_id=$("#vehicle").val();

	var vehicle_date=$("#selDate").val();

  var  vehicle_time=$("#tm").val();

	sethref(vehicle_id,vehicle_date,vehicle_time);
}

function sethref(vehicle_id,vehicle_date,vehicle_time)
{
	var link2 = document.getElementById("a2");
	var link3 = document.getElementById("a3");
	var link4 = document.getElementById("a4");
	var link5 = document.getElementById("a5");
	


  var setLink3="/gps/details.php?link="+vehicle_id;
  link3.setAttribute('href',setLink3);

  if(vehicle_time == "")
  {
      var setLink2="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date+"&link3=";
      var setLink5="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date+"&link3=";  
  }
  else
  {
      var setLink2="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date+"&link3="+vehicle_time;
      var setLink5="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date+"&link3="+vehicle_time;  
  }

  link5.setAttribute('href',setLink5);
  link2.setAttribute('href',setLink2);
}

function getvehicles()
{
    
    $.ajax({

        url: "/gps/getVehicles.php",

        type: "get",

        dataType: "json",

        success: function (response) {
		
	

	 $.each(response, function(key, value) {
		 $('#vehicle').append('<option value=' + value.RegNo + '>' + value.RegNo + '</option>');
          
        });

	},

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }

         });




}


function getdate()
{
    
    $.ajax({

        url: "/gps/getDates.php",

        type: "get",

        dataType: "json",

        success: function (response) {
		
	console.log(response);

	 $.each(response, function(key, value) {
		 $('#selDate').append('<option value=' + value.date + '>' + value.date + '</option>');
          
       });

	},

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }

         });




}
</script>
</body>
</html>


