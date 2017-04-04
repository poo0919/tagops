<?php
//api for deleting reimbursement entry from db
include 'connection.php';
include 'empSession.php' ;
if(isset($_POST['dataId'])){
    $dataId=$_POST['dataId'];
    $query="DELETE FROM data WHERE id='$dataId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>