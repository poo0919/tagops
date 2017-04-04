<?php
//api for update RH

include 'connection.php';
include 'session.php' ;
if( !isset($_GET['occasion']) && !isset($_GET['date1'])){
	echo "<script type='text/javascript'>window.location.href='adminPanelRestrictedHolidays.php';alert('Field is empty!');</script>";
	

}else{
	if(!isset($_GET['id']))
	{
		echo "<script type='text/javascript'>window.location.href='adminPanelRestrictedHolidays.php';alert('Field is empty!');</script>";
	}else
    {
    	$rhId=$_GET['id'];
        $occasion=$_GET['occasion'];
        $date1=$_GET['date1'];
        $sql="UPDATE restricted_holidays SET occasion='$occasion',date='$date1' WHERE id='$rhId' ";
                    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                        echo "<script type='text/javascript'>alert('RH Updated!');window.location.href='adminPanelRestrictedHolidays.php';</script>";  
                    }else {
                       echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
}
        
                                       
                                
?>