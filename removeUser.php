<?php
//api for removing user from logging in
include 'connection.php';
include 'session.php' ;
if(isset($_GET['id'])){
    $user_id=$_GET['id'];
    $query="UPDATE user SET status='0' WHERE id='$user_id' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
    if ($result === TRUE) {
        echo "1";
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
    }                         

}
        
                                       
                                
?>