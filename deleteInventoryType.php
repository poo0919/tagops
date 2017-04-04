<?php
//api for deleting an asset from db

include 'connection.php';
include 'session.php' ;
if(isset($_POST['invId'])){
    $invId=$_POST['invId'];
    $query="DELETE FROM asset_type WHERE id='$invId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>