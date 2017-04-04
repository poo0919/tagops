<?php

//set all the remubursements to yes of that particular user -> right now not in use
include 'connection.php';
include 'session.php' ;
if(isset($_GET['ACTION'])){
    $user_id=$_GET['id'];
    $query="UPDATE data SET reimbursed='1' WHERE user_id='$user_id' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
    if ($result === TRUE) {
        echo "1";
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
    }                         

}
        
                                       
                                
?>