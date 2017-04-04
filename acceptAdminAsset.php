<?php

//API for accepting accepting asset returned by employee

include 'connection.php';
include 'session.php' ;
if(isset($_POST['invId'])){

    $invId=$_POST['invId'];
    $query="update inventory set status='1',assigned_to='0' where id='$invId'";
       $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
       if ($result === TRUE) {
           echo "1";
       }else {
           echo "0";
       }     

}
                                       
?>