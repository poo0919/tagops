<?php
    include 'api/autoRun.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TagOps</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    
    $("#cancel-user-button").click(function(e){
        e.preventDefault();
        $('#reg_form')[0].reset();                                   
    });
    
    $("#login-user-button").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        if ( email == '' || password == '' ) {
            alert("Please fill all fields...!!!!!!");
        } 

        if($("#adminLogin").is(':checked')){
            $.ajax({
                url: "api/action.php",
                type: "POST",
                data: "ACTION=loginAdmin&EMAIL="+email+"&PASSWORD="+password,
                success: function(response){
                    console.log(response);
                    data=$.trim(response);
                    if(data=='2'){
                        alert("You are not admin!");
                    }else if(data=='3'){
                        alert("This Email Id does not exist.");
                    }else if(data=='0'){
                        alert('Wrong password.');
                    }else if(data=='4'){
                        alert('Your access is denied! Contact Admin.');
                    }else {
                        var response=JSON.parse(data);
                        var adminName=response.adminName;
                        var user_id=response.user_id;
                        localStorage.setItem('adminName', adminName);
                        localStorage.setItem('user_id',user_id);
                        localStorage.setItem('filterAssetType','2');
                        localStorage.setItem('filterAssetsAdmin','all');
                        window.location.href="adminExpenseManagement.php";
                    }                              
                }
            })    
        }else {
            localStorage.setItem('email',email);
            $.ajax({
                url: "api/action.php",
                type: "POST",
                data: "ACTION=loginUser&EMAIL="+email+"&PASSWORD="+password,
                success: function(response){
                    data=$.trim(response);
                    console.log(data);
                    if(data=='0'){
                        alert("This Email Id does not exist.");
                    }else if (data=='1'){
                        alert("Wrong password.");                            
                    }else if (data=='3'){
                        alert("Your access is denied! Contact Admin.");                            
                    }else if (data=='2'){
                        alert("token not generated!");                            
                    }else{
                        var response=JSON.parse(data);
                        var token=response.token;
                        var name=response.name;
                        var user_id=response.user_id;
                        localStorage.setItem('token', token);
                        localStorage.setItem('name',name);
                        localStorage.setItem('user_id',user_id);
                        localStorage.setItem('filter2-employees','0');
                        localStorage.setItem('filter-assets','0');
                        if(localStorage.getItem('activeEmpReporteesTabs'))
                            window.location.href="empReportees.php";
                        else
                            window.location.href="empExpenses.php";
                    }
                }
            })
        }
    });   
                        
          
    $("#register-user-button").click(function(e) {
        e.preventDefault();
        var name = $("#name").val();
        var regemail = $("#reg_email").val();
        var regpassword = $("#reg_password").val();
        var rentpassword = $("#rentpassword").val();
        var authcode = $("#auth-code").val();
                        
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                         
        if (name == ""  ) {
            alert("Enter your name.");
        } else if ((regpassword.length) < 3) {
            alert("Password should atleast 3 character in length...!!!!!!");
        } else if (!(regpassword).match(rentpassword)) {
            alert("Your passwords don't match. Try again!");
        } else{ 
            $.ajax({
                url: "api/action.php",
                type: "POST",
                data: "ACTION=register&EMAIL="+regemail+"&PASSWORD="+regpassword+"&NAME="+name+"&AUTH="+authcode,
                success: function(response){
                    data=$.trim(response);
                    console.log(data);
                                    
                    if(data==2){
                        alert("This email id is already registered!");
                    }else if(data==0){
                        alert("This email id is already registered!");
                    }else if(data=="1"){
                        alert("you are registered!");
                        window.location.reload();
                        $('#reg_form')[0].reset();
                    }                            
                }
            })
        }
    });
                    
    $("#auth-code").keyup(function(event){
        if(event.keyCode == 13){
            $("#register-user-button").click();
        }
    });
    $("#password").keyup(function(event){
        if(event.keyCode == 13){
            $("#login-user-button").click();
        }
    });  
    $("#admn_password").keyup(function(event){
        if(event.keyCode == 13){
            $("#login_admn_button").click();
        }
    });     
            
});
</script>

<link rel="stylesheet" href="css/empBars.css">
<style type="text/css">
    #myTab{
        background:#ffffff;
    }
    #title1{
        color: rgb(300,300,300);
    }
    h1{
        color: rgb(0,0,0);
        font-family: palatino, sans-serif;
        font-size: 40px;
        font-weight: bold;
        margin-top: 0px;
        margin-bottom: 1px;
    }
</style>
</head>

<body style="background-image: url(images/backImage.png);"><div>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a id="menu-toggle" href="#" class="navbar-toggle pull-left">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
    </div>
</nav>

<h2 style="color: rgb(0,0,0);margin-left: 200px; padding-top: 50px;padding-bottom: 1%;">TagOps</h2>

<div class="container" style="width: 25%;margin-left: 100px;">
    <ul class="nav nav-pills nav-justified" id="myTab" style="border:1px #5f5f5f;" >
        <li class="active"><a data-toggle="tab" href="#sectionA">LOGIN</a></li>
        <li><a data-toggle="tab" href="#sectionB">REGISTER</a></li>
    </ul>
  
    <div class="tab-content well " id="myContent" style="background: #ffffff;border:2px #fefefe;">
        <div id="sectionA" class="tab-pane fade in active"  style="min-height: 300px;">
            <section>
                <form method="POST" action="action.php" id="user_form">
                    <div class="form-group ">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" >
                    </div>
                        <div class="form-group checkbox">
                        <label><input type="checkbox" name="adminLogin" id="adminLogin" value="" /> Login as Admin</label>
                        </div>
                        <button type="button" id="login-user-button" class="btn btn-primary btn-block">Login</button>
                </form><br>
                <p><a style="float: right;" href="forgotPassword.php">Forgot your password?</a></p>
            </section>   
         
        </div>
        
        <div id="sectionB" class="tab-pane fade" style="min-height: 300px;" >
            <section>
                <form method="POST" action="action.php" id="reg_form">
                <!--    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" id="name" type="text" name="name" >
                    </div>-->
                    <div class="form-group">
                        <label for="reg_email">Email </label>
                        <input type="email" class="form-control" id="reg_email" >
                    </div>
                    <div class="form-group">
                        <label for="reg_password">Password</label>
                        <input type="password" class="form-control" id="reg_password"  >
                    </div>
                    <div class="form-group">
                        <label for="rentpassword">Re-enter Password</label>
                        <input type="password" class="form-control" id="rentpassword" name="rentpassword"  >
                    </div>
                    <div class="form-group">
                        <button type="button-inline" id="cancel-user-button"  class="btn btn-default">Cancel</button>  
                        <button type="button-inline" id="register-user-button"  class="btn  btn-primary">Register</button>  
                    </div>
                </form>
            </section>
        </div>
    </div>

</div>
</div>
</body>
</html>
