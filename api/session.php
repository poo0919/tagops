<?php
//api for starting a session
session_start();
if(!isset($_SESSION['login_email'])){
    header("location:../index.php");
}
?>