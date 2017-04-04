<?php
//api for retruning asset by emp 
include 'connection.php';
include 'empSession.php' ;

if(isset($_POST['invId'])){

    $invId=$_POST['invId'];
    $query="update inventory set status='4' where id='$invId'";
       $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
       if ($result === TRUE) {
           echo "1";
       }else {
           echo "0";
       }                                  
                             
}
        
                                       
                                
?>