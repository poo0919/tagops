<?php

//API for accepting asset assigned to an employee by admin

include 'connection.php';
include 'empSession.php' ;

if(isset($_POST['invId'])){

    $invId=$_POST['invId'];
    $userId=$_POST['userId'];

    $query="update inventory set status='3' where id='$invId'";
       $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
       if ($result === TRUE) {
           echo "1";
       }else {
           echo "0";
       }                                  
                             

}
        
                                       
                                
?>