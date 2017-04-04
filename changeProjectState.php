<?php
//changing project state form active to inactive or inactive to active

include 'connection.php';
include 'session.php' ;
if(isset($_POST['projId'])){
	
    $projId=$_POST['projId'];

    $q1="SELECT state FROM projects WHERE id='$projId'";
    $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
    $ro1 = $re1->fetch_array();
    $state=$ro1['state'];

    if ($state=='1') {
    	$state='0';
    }else if($state=='0'){
    	$state='1';
    }

    $sql="UPDATE  projects SET state='$state' WHERE id='$projId' ";
    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
    	echo 1;
    }else {
        echo 0;
    }                      

}
        
                                       
                                
?>