<?php
//api for deleting a category from db

include 'connection.php';
include 'session.php' ;
if(isset($_POST['catId'])){
    $catId=$_POST['catId'];
    $query="DELETE FROM categories WHERE id='$catId' ";
    
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                
  //  if (mysql_affected_rows()>0) {
        echo 1;
      //  echo "<script>alert('Employee Removed!');window.location.href='ex2.php';</script>";                  
  //  }else echo "0";                         

}
        
                                       
                                
?>