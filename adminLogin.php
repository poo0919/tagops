<?php

// separate file for adminLogin

include 'connection.php';
session_start();
    if(isset($_POST['ACTION'])){
                                 
       $email=$_POST['EMAIL'];
       $password=$_POST['PASSWORD']; 

       $query="select * from admin where email='$email' AND (status='1' || status='3')"; //check if admin is allowed to login or not
        $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
        $row = $result->fetch_array();
        $row_cnt = mysqli_num_rows($result); 
        if ($row_cnt==1) {  

            $password=md5($password);
            $query="SELECT email, password,status FROM user WHERE email='".$email."' AND password='$password'"; //verify the credentials
            $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
            $row = $result->fetch_array();
            $row_cnt = mysqli_num_rows($result);        
            if ($row_cnt==1) {

                if($row['status']=="1"){
                    $_SESSION['login_email']=$email;
                    echo "1";
                }else echo "4";

            }else{
                echo "3";   
            }   
           
        }else echo "2";

       exit();
    }
   $conn->close();
                   
?>
