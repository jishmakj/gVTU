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
a {
    color: #337ab7;
    text-decoration: none;
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

.changhead
{
background-color:black;
}
 
  </style>
</head>
<body>
<?php error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "!nnovations", "gpstrack");

 if ($con->connect_error) 
 {

    die("Connection failed: " . $con->connect_error);
} 
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
           <a class="navbar-brand" href="<?php echo '/gps/template.php?link='.$no;?>">VTU</a>
    	</div>
       </div>
    </div>
      
    <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav">
              <li id="l1" class="active"><a id="a1" href="<?php echo '/gps/template.php?link='.$no;?>">Home</a></li>
              <li id="l2"><a id="a2" href="<?php echo '/gps/submit.php?link='.$no;?>">Display Map</a></li>
              <li id="l3"><a id="a3" href="<?php echo '/gps/details.php?link='.$no;?>">Vehicle details</a></li>
              <!--<li id="l4"><a id="a4" href="#">Speed</a></li>-->
	     
              <li id="l5"><a href="#">Settings</a></li>  
		<li id="l6"><a href="#">Help</a></li>               
            </ul>
        </div>
  	
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">

		<div class="container-fluid">
			<div class="row">
<?php

        $sql="SELECT * FROM coordinates WHERE RegNo='$no'";;

        $result = $con->query($sql);
       
 	if ($result->num_rows > 0) {

                $i=0;
                $retArr=array();
                while($row = $result->fetch_assoc()) {
                        
                        
			$retArr[$i]['originalData']=$row['originalData'];
			$retArr[$i]['time']=$row['datatime'];
			$detArr[$i]=$row['originalData'];
                        $i++;

                }
		?>

		<div class="w3-card-8" style="width:100%">
			<header class="w3-container w3-dark-grey">Vehicle Details</header>
				<div class="w3-container">
		 <table class="table table-striped">
    			<thead>
      			<tr>
        		<th>Vehicle ID</th>
        		<th>Speed(kmph)</th>
        		<th>Date</th>
			<th>Time</th>
      			</tr>
    			</thead>
    			<tbody>
			
		<?php
		$j=0;
		foreach($detArr as $det)
		{
			$retArr2[$j]=explode(",",$det);
			$arr5[$j]['speed']=$retArr2[$j][11];
			$arr5[$j]['date']=$retArr2[$j][3];



			?>
			<tr>
			<td><?php echo $no;?></td>
			<td><?php echo $retArr2[$j][11];?></td>
			<td><?php echo $retArr2[$j][3].'/'.$retArr2[$j][4].'/'.$retArr2[$j][5];?></td>
			<td><?php echo $retArr2[$j][6].':'.$retArr2[$j][7].':'.$retArr2[$j][8];?></td>
			</tr>
			<?php
			$j++;
		}
//print_r($arr5);
		
	
			
		
		
		?>

		
 </tbody>
  </table>
</div>
</div>






<?php
                 
        }
else
{
echo "No results Found";
}
?>


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
<script>
$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
});
</script>
</body>
</html>

