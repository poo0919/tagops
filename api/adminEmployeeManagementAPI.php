<?php
include_once('database.php');
require_once('email.php');
include_once('commonUtilities.php');
include 'session.php';
include 'config.php';
$conn = getDB();

if($_POST["ACTION"]=="removeAdmin"){
    if(isset($_POST['id'])){
        $user_id=$_POST['id'];

        $q1="SELECT COUNT(*) as adminCount FROM user WHERE type='1'";
        $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
        $ro1 = $re1->fetch_array();
        $adminCount=$ro1['adminCount'];

        if ($adminCount>1) {
            $query="UPDATE user SET type='2' WHERE id='$user_id' ";
            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                        
            if ($result === TRUE) {
                echo 1;
            }
        }else if($adminCount<=1){
            echo 0;
        }
    } 
}

if($_POST["ACTION"]=="changeStatusOfUser"){
    if(isset($_POST['id'])){
        $user_id=$_POST['id'];

        $q1="SELECT status FROM user WHERE id='$user_id'";
        $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
        $ro1 = $re1->fetch_array();
        $status=$ro1['status'];

        if ($status=='1') {
            $status='0';
        }else if($status=='0'){
            $status='1';
        }

        $query="UPDATE user SET status='".$status."' WHERE id='$user_id' ";
        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                    
        if ($result === TRUE) {
            echo "1";
        }                         
    } 
}

if($_POST['ACTION']=="addAdmn"){  
    $id=$_POST['id'];                      
  $sql = "UPDATE user SET type='1' WHERE id='".$id."'";
  $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
  if ($result === TRUE) {
    echo "1";
  }else {                                                                   
    echo die(mysqli_error($conn));
  } 
  exit();
}

if($_POST['ACTION']=="addHR"){
    $id=$_POST['id'];
  $query="select id from user where hr='1'" ; 
  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
  $row = $result->fetch_array();
  $row_cnt = mysqli_num_rows($result); 
  $hrId="";
  if ($row_cnt==1) {
    $hrId=$row['id'];
  }

  $query="UPDATE user SET hr='0' WHERE id='$hrId'" ; 
  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
  if ($result === TRUE) { 
    $sql = "UPDATE user SET hr='1' WHERE id='".$id."'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result === TRUE) {
      echo "1";
    }else {                                                                   
      echo die(mysqli_error($conn));
    } 

  }   
  exit();
}

if($_POST['ACTION']=="addSystemAdmin"){
  $id=$_POST['id'];
  $query="select id from user where system_admin='1'" ; 
  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
  $row = $result->fetch_array();
  $row_cnt = mysqli_num_rows($result); 
  $systemAdminId="";
  if ($row_cnt==1) {
    $systemAdminId=$row['id'];
  }

  $query="UPDATE user SET system_admin='0' WHERE id='$systemAdminId'" ; 
  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));  
  if ($result === TRUE) { 
    $sql = "UPDATE user SET system_admin='1' WHERE id='".$id."'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result === TRUE) {
      echo "1";
    }else {                                                                   
      echo die(mysqli_error($conn));
    } 
  }   
  exit();
}

if($_POST["ACTION"]=="addNewEmployee"){
    function calculateClPlMl($joining_date){
  
      $startMonth = 4; $endMonth = 3; $count="";
      $currentDate = date('Y-m-d');

      $currentDateArray = date_parse_from_format("Y-m-d", $currentDate);
      $currentDay = $currentDateArray["day"];
      $currentMonth = $currentDateArray["month"];

      $joiningDateArray = date_parse_from_format("Y-m-d", $joining_date);
      $joiningDay = $joiningDateArray["day"];
      $joiningMonth = $joiningDateArray["month"];

      if($joiningDay==1){

        if($joiningMonth >= 1 && $joiningMonth <= 3){
          $count=(3 - $joiningMonth + 1)*2;
        }else if($joiningMonth >= 4 && $joiningMonth <= 12){
          $count=(12 - $joiningMonth + 1)*2 + 3*2;
        }

      }else if( $joiningDay >= 2 && $joiningDay <=16 ){

        if($joiningMonth >= 1 && $joiningMonth <= 3){
          $count=(3 - $joiningMonth)*2 + 1;
        }else if($joiningMonth >= 4 && $joiningMonth <= 12){
          $count=(12 - $joiningMonth)*2 + 3*2 +1;
        }

      }else if( $joiningDay >= 17 && $joiningDay <=31 ){

        if($joiningMonth >= 1 && $joiningMonth <= 3){
          $count=(3 - $joiningMonth)*2;
        }else if($joiningMonth >= 4 && $joiningMonth <= 12){
          $count=(12 - $joiningMonth)*2 + 3*2;
        }

      }

    return $count;
    }

    if(!empty($_POST['newName']) && !empty($_POST['companyMail']))
    {
            
      $newName=$_POST['newName'];
      $joining_date=$_POST['joiningDate'];
      $companyMail=$_POST['companyMail'];
      $designation1=$_POST['designation1'];
      $rm_id=$_POST['rmMail'];

      $sql = "INSERT INTO user (name,email,designation,joining_date,rm_id) VALUES ('$newName','$companyMail','$designation1','$joining_date','$rm_id')";
      if ($result=mysqli_query($conn,$sql)) {

        $q1 = "SELECT id FROM user where email='$companyMail'";
        $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
        $id="";
        if ($re1->num_rows > 0) {
          while($ro1 = $re1->fetch_array()){
            $id = $ro1['id'];
          }
        }

        $clplml_count=calculateClPlMl($joining_date);
        //on new user register -> add a row for his/her leaves in leaves table 
        $q2 = "INSERT INTO leaves (user_id,pl_cl_ml,comp_off) VALUES ('$id','$clplml_count','$maxRH')";
        mysqli_query($conn,$q2)or die(mysqli_error($conn));
        $to = "$companyMail";
        $cc = "";
        $subject = "TagOps Registration Link";
        $body = "Hi $newName,<br><br>Create your account on following link with ur <b>EmailId</b> as : $companyMail<br><a href='http://dev.tagbin.in/dev/reimbursement/index.php'>http://dev.tagbin.in/dev/reimbursement/index.php</a><br><br>Thanks,<br>TagOps.";
        $send_mail_value = send_email( $to,$cc,$subject,$body );
        header( 'Content-Type: application/json' );
        echo json_encode( $send_mail_value );
      }else {                                                                   
        echo  "<script type='text/javascript'>alert('Can't Add!');window.location.href='adminEmployeeManagement.php';</script>";
      }
    }else {
      echo "0";
    }
}

if($_POST["ACTION"]=="updateEmployeeDetails"){
    if(isset($_POST['submit'])){
        if(!empty($_POST['oldName']) && !empty($_POST['repMgrMail']))
        {
            $newName=$_POST['oldName'];
            $joining_date=$_POST['joiningDate1'];
            $rm_mail=$_POST['repMgrMail'];
            $designation=$_POST['designation'];
            $companyMail=$_POST['companymail'];
            $id=$_POST['id'];

            $q1="SELECT * FROM user WHERE email='$rm_mail'";
            $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
            $ro1 = $re1->fetch_array();
                
            $row_cnt = mysqli_num_rows($re1); 
            if ($row_cnt==1) {
                $rm_id=$ro1['id'];
                $sql="UPDATE user SET name='$newName',joining_date='$joining_date', email='$companyMail', rm_id='$rm_id', designation='$designation' WHERE id='$id' ";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('Data Updated!');window.location.href='../adminEmployeeManagement.php';</script>";  
                }else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else{
                echo "<script type='text/javascript'>alert('No such email id is registered!');window.location.href='../adminEmployeeManagement.php';</script>";
            }
        }else {
            echo "<script type='text/javascript'>alert('Field is empty!');window.location.href='../adminEmployeeManagement.php';</script>";
        }
    }
}

if($_POST["ACTION"]=="changeEmpPhoneNumber"){
    if($_POST['userId'])
    {
        $userId=mysql_escape_String($_POST['userId']);
        $phoneNumber=$_POST['phoneNumber'];
        $sql = "update user set phone_number='$phoneNumber' where id='$userId'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if($result === TRUE) {
            echo 1;
        }
        else {
            echo 0;
        }
    }
}

if($_POST["ACTION"]=="changeEmpBirthday"){
    if($_POST['userId'])
    {
        if(!empty($_POST['birthday']))
        {   
            $userId=mysql_escape_String($_POST['userId']);
            $userBirthday=mysql_escape_String($_POST['birthday']);
            $sql = "update user set birthday='$userBirthday' where id='$userId'";
            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
            if($result === TRUE) {
                echo 1;
            }
            else {
                echo 0;
            }
        }else echo 2;
    }
}

if($_POST["ACTION"]=="changeEmpPersonalEmail"){
    if($_POST['userId'])
    {
        $userId=mysql_escape_String($_POST['userId']);
        $personalEmail=mysql_escape_String($_POST['personalEmail']);
        $sql = "update user set personal_email='$personalEmail' where id='$userId'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if($result === TRUE) {
            echo 1;
        }
        else {
            echo 0;
        }
    }
}
?>