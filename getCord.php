<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
$con = mysqli_connect("localhost", "root", "!nnovations", "gps");

 if ($con->connect_error) 
 {

    die("Connection failed: " . $con->connect_error);
} 

        //echo "connection success";
        $sql="SELECT * FROM coordinates";

        $result = $con->query($sql);
       
 if ($result->num_rows > 0) {

                $i=0;
                $retArr=array();
                while($row = $result->fetch_assoc()) {

                        $retArr[$i]['latitude']=$row['latitude'];
                        $retArr[$i]['longitude']=$row['longitude'];
                        $i++;

                }
                echo json_encode($retArr);      
        }
else
{
echo "[]";
}
?>

