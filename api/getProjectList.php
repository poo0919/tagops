<?php
include_once('database.php'); 
$conn = getDB();
$query = "SELECT * FROM projects where state='1' order by name"; 
$result = mysqli_query($conn,$query)or die(mysqli_error($conn)); 
$arrayName = array();
$index=0;
while ($rows = mysqli_fetch_array($result)) { 
	$arrayName[$index]=array(
		"id" => $rows['id'],
		"name" => $rows['name']
	);
	$index++;
}
echo json_encode($arrayName);
?>