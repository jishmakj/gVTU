<?php
header('Content-Type: application/json');
include 'connection.php';

$sql = "SELECT * FROM coordinates";
$result = $conn->query($sql);
$row=array();
if ($result->num_rows > 0) {
	 $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
}
echo json_encode($row);
$conn->close();
?>
