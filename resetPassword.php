<?php
//api for updating password in db
include 'connection.php';

if(isset($_POST['newPassword'])){
    $token=$_POST['userid'];
    $newPassword=md5($_POST['newPassword']);

    $sql="UPDATE user SET password='$newPassword' WHERE token='$token' ";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));

    $query="SELECT * FROM user WHERE token='$token'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    $row = $result->fetch_array();
    $tokenCheck=$row['token'];

    if (!empty($tokenCheck)) {
        $query="update user set token=NULL where token='$token'";
        $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
        echo "1";  
        exit();
    }else {
        echo "2";
    }
              
}  
    


?>