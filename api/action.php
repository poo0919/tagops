<?php 
//API for various actions
include_once('database.php');
include 'config.php';
require_once('email.php');
$conn = getDB();
                        
if($_POST['ACTION']=="register"){  // register new user
  $email=$_POST['EMAIL'];
  $password=$_POST['PASSWORD']; 

  $query="SELECT * from user where email='$email' ";
  $result1 = mysqli_query($conn, $query)or die(mysqli_error($conn));
  if ($result1->num_rows > 0) {
    while($row1 = $result1->fetch_array()){
      if(!empty($row1['password'])){
        echo 2;
        exit();
      }
    }
  }

  $password=md5($password);
  //add new user details to user table 
  $sql = "UPDATE user SET password='$password'  WHERE email='$email'";
  if ($result=mysqli_query($conn,$sql)) {
    $q1 = "SELECT id FROM user where email='$email'";
    $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
    $id="";
    if ($re1->num_rows > 0) {
      while($ro1 = $re1->fetch_array()){
        echo 1;
      }
    }
  }else {                                                                   
    echo 0;
  } 
  exit();
}        
      
if($_POST['ACTION']=="loginUser"){ // login a normal user
  $email=$_POST['EMAIL'];
  $password=$_POST['PASSWORD']; 
  $password=md5($password);     
  //check if the user has right credentials    
  $query="SELECT id,name,email, password, status FROM user WHERE email='$email' ";  //check for status if user is allowed to login or not
  $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
  $row = $result->fetch_array();
  $row_cnt = mysqli_num_rows($result);        
  if ($row_cnt==1) {

    if($password!=$row['password']){
      echo "1"; exit();
    }
    if($row['status']!='1'){
      echo "3"; exit();
    }

    $token=uniqid();
    $query="UPDATE user SET token='$token' WHERE email='".$email."' "; // add token for login
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
    $name=$row['name']; $user_id=$row['id'];
    $login_credentials=array("token"=>$token, "name"=>$name,"user_id"=>$user_id); // send token, name and user_id as response for storing in local storage
    if ($result === TRUE) {
      session_start();
      $_SESSION['emp_email']=$email;
      $_SESSION['userid']=$user_id;
      echo json_encode($login_credentials);                  
    }else {
      echo "2";
    } 
  }else{
    echo "0";      
  }      
  exit();
}

if($_POST['ACTION']=='loginAdmin'){                        
    $email=$_POST['EMAIL'];
    $password=$_POST['PASSWORD']; 

    $password=md5($password);
    $query="SELECT id,name,email, password,status,type FROM user WHERE email='".$email."'"; //verify the credentials
    $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
    $row = $result->fetch_array();
    $row_cnt = mysqli_num_rows($result);        
    if ($row_cnt==1) {
        if($password!=$row['password']){
          echo "0"; exit();
        }
       
        if($row['type']==1){
            $adminName=$row['name'];
            $adminId=$row['id'];
            $login_credentials=array("adminName"=>$adminName,"user_id"=>$adminId);
            if($row['status']=="1"){
              session_start();
                $_SESSION['login_email']=$email;
                $_SESSION['adminid']=$adminId;
                echo json_encode($login_credentials);
            }else echo "4";
        }else{
            echo '2';
        }
    }else{
        echo "3";   
    }   
    exit();
}

if($_POST["ACTION"]=="passwordResetLink"){
  if(isset($_POST['EMAIL'])){
    $email=$_POST['EMAIL'];

    $token=uniqid(); $currentTimestamp=date('Y-m-d H:i:s');
    $q1="UPDATE user SET created_timestamp='$currentTimestamp',token='$token' WHERE email='".$email."' ";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));

    $query="SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    $row = $result->fetch_array();
    $status=$row['status'];
    if ($result->num_rows > 0) {
      if($status!=1){
        echo "0"; exit();
      }else{
        $token=uniqid();
        $q1="UPDATE user SET token='".$token."' WHERE email='".$email."' ";
        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
        $to = $email; $cc = "";
        $subject = "TagOps - Reset Password Link.";
        $body = "Hi,<br><br>Click here to reset your password <a href='$url/resetPasswordForm.php?encrypt%3D".$token."' target='_blank'>Forget Password</a>.<br><br>Thanks,<br>TagOps.";
        $send_mail_value = send_email( $to,$cc,$subject,$body );
        header( 'Content-Type: application/json' );
        echo json_encode( $send_mail_value );
      }
    }else{
      echo "2";
    }
  }
}
   
if($_POST["ACTION"]=="resetPassword"){
  if(isset($_POST['newPassword'])){
    $token=$_POST['userid'];
    $newPassword=md5($_POST['newPassword']);

    $query="SELECT * FROM user WHERE token='$token'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt==1){
        $row = $result->fetch_array();
        $tokenCheck=$row['token'];
        $created_timestamp=$row['created_timestamp'];

        $currentTimestamp=date('Y-m-d H:i:s');

        $datetime1 = new DateTime($created_timestamp);
        $datetime2 = new DateTime($currentTimestamp);
        $interval = $datetime1->diff($datetime2);

        if($interval->format('%d')>=1){
          echo "2";
        }else{
          $sql="UPDATE user SET password='$newPassword' WHERE token='$token' ";
          $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
          if (!empty($tokenCheck)) {
            $query="update user set token=NULL where token='$token'";
            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
            echo "1"; exit();
          }else {
            echo "2";
          }
      }
    }else{
      echo "2";
    } 
  }  
}

if($_POST['ACTION']=="logout"){  //on press of logout button     
  $token=$_POST['TOKEN'];
  $query="update user set token=NULL where token='$token'"; //remove token from db
  $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
  if ($result === TRUE) {
    echo "1";
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }                                  
  exit();
}  
$conn->close();
?>