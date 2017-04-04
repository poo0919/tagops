<?php
//api for deleting a rental company from db
include 'connection.php';
include 'session.php' ;
if(isset($_POST['rentId'])){
    $rentId=$_POST['rentId'];
    $query="DELETE FROM rental_companies WHERE id='$rentId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>