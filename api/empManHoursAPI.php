<?php
include_once('database.php');
include 'empSession.php';
$conn = getDB();

if(isset($_POST['man_hours_log'])){
	$man_hours_log = json_decode($_POST["man_hours_log"],true);
	$length = sizeof($man_hours_log);
	$projectid=""; $hours=""; $description="";
	for($i=0;$i<$length-3;$i++){
		$projectid = $man_hours_log[$i]['projectid'];
		$hours = $man_hours_log[$i]['hours'];
		$description = $man_hours_log[$i]['description'];
		$user_id = $man_hours_log[$length-1];
		$half_full = $man_hours_log[$length-2];
		$date = $man_hours_log[$length-3];

		$query = "INSERT INTO man_hours_log (user_id, project_id, date, half_full, hours, description) VALUES ('$user_id', '$projectid', '$date','$half_full','$hours','$description')";
		$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
        if ($result!=TRUE) {
        	echo "0";
        }else if($result==TRUE){
        	echo "1";
        }
	}
}
?>