<?php
//api for deleting a asset row from db
include 'connection.php';
include 'session.php' ;
if(isset($_POST['rowId'])){
    $rowId=$_POST['rowId'];
    $query="DELETE FROM inventory WHERE id='$rowId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>