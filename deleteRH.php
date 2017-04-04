<?php
//api for deleting RH entry from db
include 'connection.php';
include 'session.php' ;
if(isset($_POST['rhId'])){
    $rhId=$_POST['rhId'];
    $query="DELETE FROM restricted_holidays WHERE id='$rhId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>