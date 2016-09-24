<html>
<head>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<style>

/* BOOTSTRAP 3.x GLOBAL STYLES
-------------------------------------------------- */
body {
  padding-bottom: 40px;
  color: #5a5a5a;
}



/* CUSTOMIZE THE NAVBAR
-------------------------------------------------- */

/* Special class on .container surrounding .navbar, used for positioning it into place. */
.navbar-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
}



/* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */

/* Carousel base class */
.carousel {
  margin-bottom: 60px;
}
/* Since positioning the image, we need to help out the caption */
.carousel-caption {
  z-index: 1;
}

/* Declare heights because of positioning of img element */
.carousel .item {
  height: 400px;
  background-color:#555;
}
.carousel img {
  position: absolute;
  top: 0;
  left: 0;
  min-height: 400px;
}



/* MARKETING CONTENT
-------------------------------------------------- */

/* Pad the edges of the mobile views a bit */
.marketing {
  padding-left: 15px;
  padding-right: 15px;
}

/* Center align the text within the three columns below the carousel */
.marketing .col-lg-4 {
  text-align: center;
  margin-bottom: 20px;
}
.marketing h2 {
  font-weight: normal;
}
.marketing .col-lg-4 p {
  margin-left: 10px;
  margin-right: 10px;
}


/* Featurettes
------------------------- */

.featurette-divider {
  margin: 80px 0; /* Space out the Bootstrap <hr> more */
}
.featurette {
  padding-top: 120px; /* Vertically center images part 1: add padding above and below text. */
  overflow: hidden; /* Vertically center images part 2: clear their floats. */
}
.featurette-image {
  margin-top: -120px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
}

/* Give some space on the sides of the floated elements so text doesn't run right into it. */
.featurette-image.pull-left {
  margin-right: 40px;
}
.featurette-image.pull-right {
  margin-left: 40px;
}

/* Thin out the marketing headings */
.featurette-heading {
  font-size: 50px;
  font-weight: 300;
  line-height: 1;
  letter-spacing: -1px;
}



/* RESPONSIVE CSS
-------------------------------------------------- */

@media (min-width: 768px) {

  /* Remve the edge padding needed for mobile */
  .marketing {
    padding-left: 0;
    padding-right: 0;
  }

  /* Navbar positioning foo */
  .navbar-wrapper {
    margin-top: 20px;
    margin-bottom: -90px; /* Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
  }
  /* The navbar becomes detached from the top, so we round the corners */
  .navbar-wrapper .navbar {
    border-radius: 4px;
  }

  /* Bump up size of carousel content */
  .carousel-caption p {
    margin-bottom: 20px;
    font-size: 21px;
    line-height: 1.4;
  }

}

</style>
</head>
<body>
<?php 
$no="";
$no=$_GET['link'];?>

<div class="navbar-wrapper">
  <div class="container">
    <div class="navbar navbar-inverse navbar-static-top">
      
        <div class="navbar-header">
	    <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </a>
        <a class="navbar-brand" href="#">VTU</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#" target="ext">About</a></li>
            <li><a href="#contact">Contact</a></li>
           <li><a href="#contact">Settings</a></li>
	   <li><a href="#contact">Help</a></li>
          </ul>
        </div>

    </div>
  </div><!-- /container -->
</div><!-- /navbar wrapper -->


<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
  <!--<li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>-->
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="/gps/pic/main3.jpg" style="width:100%" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>Vehicle Tracking Unit</h1>
          	<p>
			<!--select-->
						<div class="col-sm-4">
						<div class="form-group">
						<select id="vehicle" class="form-control inp-sm" onchange="getVehicleDet()">
						<option>Choose Vehicle</option>
						<?php if($no != ""){ ?>
						<option value="<?php echo $no;?>" selected><?php echo $no;?></option>
						<?php }?>
						</select>
						</div>
						</div>
			<!--select-->
			<!--seldate-->
						<div class="col-sm-4">
						<div class="form-group">
						<select id="selDate" class="form-control inp-sm" onchange="changHref()">
						<option>Select Date</option>
						</select></div>
						</div>
			<!--seldate-->

			<!--buttons-->

						<div class="col-sm-2"><button class="btn btn-lg btn-primary" ><a id="a2" href="#">Display Map</a></button></div>

						<div class="col-sm-2"><button class="btn btn-lg btn-primary"><a 									id="a3" href="#p">Vehicle Details</a></button></div>

		</p>
          
        </p>
        </div>
      </div>
    </div>
    <div class="item">
      <img src="/gps/pic/m2.jpg" style="width:100% class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          
          
        </div>
      </div>
    </div>
    <div class="item">
      <img src="/gps/pic/m1.jpg" style="width:100% class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
         
        </div>
      </div>
    </div>
  </div>
  <!-- Controls -->
  <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="icon-prev"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="icon-next"></span>
  </a> --> 
</div>
<!-- /.carousel -->



<!--select vehicle-->



<div class="row">
    
	<div class="col-md-12">
			
		

			<div class="w3-card-12" style="width:100%">
						<header class="w3-container w3-light-grey"></header>
						<div class="w3-container">

						<!--select-->
						
						
						
						<!--select-->
						
							<div class="col-sm-4"><label>Vehicle Name:</label><span id="det1"></span></div>
							<div class="col-sm-4"><label>Vehicle Id</label><span id="det2"></span></div>
							<div class="col-sm-4"><label>Reg.No</label><span id="det3"></span></div>
							<div class="col-sm-4"><label>Person:</label><span id="det4"></span></div>
							


						




						</div>	
			</div>	
		






	</div>
</div>



<!--select vehicle-->


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing" >

  <!-- Three columns of text below the carousel -->
  <div class="row" style="margin-left:25%;margin-top:20%;">
	
 	<div class="col-md-2 col-lg-2 text-center"> 
	
	<img class="img-circle img-responsive" src="/gps/pic/main2.jpg">
      
	</div  >
		<div class="col-md-2 col-lg-2 text-center">
      		<img class="img-circle img-responsive" src="/gps/pic/m4.jpg">
      		<h2>VTU</h2>
      		<p>Track Your Vehicle Anytime ,Any where</p>
      		<p><a class="btn btn-default" href="#">More</a></p>
   		</div>

    
    <div class="col-md-2 col-lg-2 text-center">
      <img class="img-circle img-responsive" src="/gps/pic/main3.jpg">
      
    </div>
  </div><!-- /.row -->


  

 


  <!-- FOOTER -->
  <footer style="background-color:#333;height:10%;">
    <p class="pull-right"><a href="#">Back to top</a></p>
    <p> Copyright (c) 2016 <a href="http://www.gardeninfosystems.com/">GARDEN INFOSYSTEMS </a></p>
  </footer>

</div><!-- /.container -->

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

	var myKeyVals = { 'vehicleId': vehicle_id};	
	
	 $.ajax({

        url: "/gps/getVehicleDet.php",

        type: "post",

        dataType: "json",
	
	data: myKeyVals,

        success: function (response) {

	//sethref(vehicle_id);

	$("#det1").text(response[0].VehicleName);
	$("#det2").text(response[0].VehicleId);
	$("#det3").text(response[0].RegNo);
	$("#det4").text(response[0].UserName);


		
	//console.log(response[0].VehicleName);

	},

        error: function(jqXHR, textStatus, errorThrown) {


           console.log(textStatus, errorThrown);

        }

         });
	
	
}

function sethref(vehicle_id)
{
	var link2 = document.getElementById("a2");
	var link3 = document.getElementById("a3");
	
	
	var setLink2="/gps/submit.php?link="+vehicle_id;
	link2.setAttribute('href',setLink2);

	var setLink3="/gps/details.php?link="+vehicle_id;
	link3.setAttribute('href',setLink3);


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
function changHref()
{

	var vehicle_id=$("#vehicle").val();

	var vehicle_date=$("#selDate").val();

	sethref(vehicle_id,vehicle_date);
}
function sethref(vehicle_id,vehicle_date)
{
	var link2 = document.getElementById("a2");
	var link3 = document.getElementById("a3");
	var link4 = document.getElementById("a4");
	var link5 = document.getElementById("a5");
	
	var setLink2="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date;
	link2.setAttribute('href',setLink2);

	var setLink3="/gps/details.php?link="+vehicle_id;
	link3.setAttribute('href',setLink3);

	//var setLink4="/gps/speed.php?link="+vehicle_id;
	//link4.setAttribute('href',setLink4);

	var setLink5="/gps/submit.php?link="+vehicle_id+"&link2="+vehicle_date;
	link5.setAttribute('href',setLink5);
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
