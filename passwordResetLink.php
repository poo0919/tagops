<?php
//api for generating link to reset password

include 'connection.php';
if(isset($_POST['EMAIL'])){
    $email=$_POST['EMAIL'];

    $token=uniqid();
    $q1="UPDATE user SET token='$token' WHERE email='".$email."' ";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));

    $query="SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    $row = $result->fetch_array();
    $status=$row['status'];
    if ($result->num_rows > 0) {
        if($status!=1){
            echo "0";
            exit();
        }else{

            $token=uniqid();
            $q1="UPDATE user SET token='$token' WHERE email='".$email."' ";
            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
            echo $token ;
        }
                
    }else{
        echo "2";
    }
    
}

?>