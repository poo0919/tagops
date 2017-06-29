<?php
//api for starting a session
   session_start();
   if(!isset($_SESSION['emp_email'])){
      header("location:../index.php");
   }
?>