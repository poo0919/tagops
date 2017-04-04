<?php
//api for deleting a project from db
include 'connection.php';
include 'session.php' ;
if(isset($_POST['projId'])){
    $projId=$_POST['projId'];
    $query="DELETE FROM projects WHERE id='$projId' ";

    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));

                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>