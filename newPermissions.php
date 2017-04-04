<?php 
  //api for adding new user with code and adding new admin
include 'connection.php';

   if($_POST['ACTION']=="addAuth"){
                                 
       $email=$_POST['EMAIL'];
       $authCode=$_POST['AUTHCODE'];  
             
       $sql = "INSERT INTO authorised (email,code) VALUES ('$email','$authCode')";
       $result=mysqli_query($conn,$sql);//or die(mysqli_error($conn));
       if ($result === TRUE) {
            echo "1";
       }else if(mysqli_error($conn)){
            echo "2";
       }else {                                                                   
           echo 0;
       } 

             
       exit();
   }

   if($_POST['ACTION']=="addAdmn"){
                                 
       $id=$_POST['id'];
    //   $admnCode=$_POST['ADMNCODE'];  
       $query="select email from authorised where id='$id'" ; 
       $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
       $row = $result->fetch_array();
        $row_cnt = mysqli_num_rows($result); 
        if ($row_cnt==1) { 
            $email=$row['email'];   

             $sql = "INSERT INTO admin (email) VALUES ('$email')";
             $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
             if ($result === TRUE) {
                  echo "1";
             }else {                                                                   
                 echo die(mysqli_error($conn));
             } 

        }   
       exit();
   }

   if($_POST['ACTION']=="addHR"){
                                 
       $id=$_POST['id'];
    //   $admnCode=$_POST['ADMNCODE'];  
       $query="UPDATE user SET type='2'" ; 
       $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
       
        if ($result === TRUE) { 

             $sql = "UPDATE user SET type='3' WHERE id='".$id."'";
             $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
             if ($result === TRUE) {
                  echo "1";
             }else {                                                                   
                 echo die(mysqli_error($conn));
             } 

        }   
       exit();
   }

$conn->close();
?>