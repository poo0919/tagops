<?php
//api for updating emp details in db from admin panel
include 'connection.php';
include 'session.php' ;
    
    if(isset($_GET['submit'])){
    if(!empty($_GET['oldName']) && !empty($_GET['repMgrMail']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{

            $newName=$_GET['oldName'];
            $rm_mail=$_GET['repMgrMail'];
            $designation=$_GET['designation'];
            $id=$_GET['id'];

            $q1="SELECT * FROM user WHERE email='$rm_mail'";
            $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
            $ro1 = $re1->fetch_array();
            
            $row_cnt = mysqli_num_rows($re1); 
            if ($row_cnt==1) {
                $rm_id=$ro1['id'];
                $sql="UPDATE user SET name='$newName', rm_id='$rm_id', designation='$designation' WHERE id='$id' ";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('Data Updated!');window.location.href='adminPanelUpdateEmp.php';</script>";  
                }else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }else{
                echo "<script type='text/javascript'>alert('No such email id is registered!');window.location.href='adminPanelUpdateEmp.php';</script>";
            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Field is empty!');window.location.href='adminPanelUpdateEmp.php';</script>";
    }
    }
    
    
?>