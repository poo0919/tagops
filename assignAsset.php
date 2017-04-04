<?php

//assigning assets to emp and details in db
include 'connection.php';
include 'session.php' ;
if(isset($_GET['submit'])){
	    
	    if(!empty($_GET['assignTo']) && !empty($_GET['id']) )
	    {
	    		$invId=$_GET['id'];
	     	    $email=$_GET['assignTo'];
	     
	     	    $sql="select id from user where email='$email' And status='1'";
	     	    $result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	     	    $row = $result->fetch_array();
	     	    $row_cnt = mysqli_num_rows($result);        
	     	    if ($row_cnt==1) 
	     	    {		
	     	    		$user_id=$row['id'];
	     	    		$query="update inventory set status='2',assigned_to='$user_id' where id='$invId'";
	     	            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	     	            if ($result === TRUE) {
	     	                echo "<script>alert('Asset Given!.');window.location.href='adminPanelAssets.php'</script>";
	     	            }else {
	     	                echo "<script>alert('Unable to Give..');window.location.href='adminPanelAssets.php'</script>";
	     	            }
	     	    }else{
	     	    	echo "<script>alert('Not a valid user Or wrong email-id.');window.location.href='adminPanelAssets.php'</script>";
	     	    }
	     	} else {
					echo "<script>alert('Field is empty.');window.location.href='adminPanelAssets.php'</script>";
			}

}
                                       
?>