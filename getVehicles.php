<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
$con = mysqli_connect("localhost", "root", "!nnovations", "gpstrack");

 if ($con->connect_error) 
 {

    die("Connection failed: " . $con->connect_error);
} 

        //echo "connection success";
        $sql="SELECT * FROM VehicleDetails";

        $result = $con->query($sql);
     
   if ($result->num_rows > 0) {

                $i=0;
                $retArr=array();
                while($row = $result->fetch_assoc()) {

                        $retArr[$i]['id']=$row['id'];
                        $retArr[$i]['VehicleName']=$row['VehicleName'];
			$retArr[$i]['VehicleId']=$row['VehicleId'];
			$retArr[$i]['RegNo']=$row['RegNo'];
			$retArr[$i]['UserName']=$row['UserName'];
                        $i++;

                }
                echo json_encode($retArr);      
        }
else
{
echo "[]";
}
?>


