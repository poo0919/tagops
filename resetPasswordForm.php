<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#reset-password-btn").click(function(e) {
        var newPassword = $("#newPassword").val();
        var confirmPassword = $("#confirmPassword").val();
        var userid = $("#userid").val();
                            
        if ( newPassword == '' || confirmPassword == '') {
            alert("Empty field...!!!!!!");
        }else if(!(newPassword).match(confirmPassword)){
            alert("Your passwords don't match. Try again!");
        }else if((newPassword).match(confirmPassword)){
            $.ajax({
                url: "api/action.php",
                type: "POST",
                data: "ACTION=resetPassword&newPassword="+newPassword+"&userid="+userid,
                success: function(data){
                    console.log(data);
                    if(data=='1'){
                        alert("Your password is succesfully reset");
                        window.location.href="index.php";
                    }else if(data=='2'){
                        alert("Link has expired!");
                    }
                }
            })
        }
    }); 

    var encrypt = getParameterValue();
    $("#userid").val(encrypt);       
    $("#confirmPassword").keyup(function(event){
        if(event.keyCode == 13){
            $("#reset-password-btn").click();
        }
    });

function getParameterValue(){
    var URL=window.location.href;
    var encrypt = URL.split("%3D").pop();
    return encrypt;
}                   
});
</script>
<link rel="stylesheet" href="css/empBars.css">
<style type="text/css">
    #myTab {
        background:#ffffff;
    }
    #title1{
        color: rgb(300,300,300);
    }
    h1  {
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

            <a class="navbar-brand" href="index.php">
             <img src="images/logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
        </div>
        </nav>
        <h2 style="color: rgb(0,0,0);text-align: center; padding-top: 50px;padding-bottom: 1%;">TagOps</h2>


<h5 style="color: rgb(0,0,0);text-align: center;">Forgot Password?</h5>


<div class="container" style="width: 30%;">

    <div class="tab-content well " id="myContent" style="background: rgb(300, 300, 300 );">
        <div id="sectionA" class="tab-pane fade in active"  style="min-height: 150px;">
            <section>
                <form method="GET" action="resetPassword.php" id="resetPasswordForm">
                    <div class="form-group ">
                        <label for="newPassword" class="form-label">New Password: </label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" >
                    </div>
                    <div class="form-group ">
                        <label for="confirmPassword" class="form-label">Confirm Password: </label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" >
                    </div>
                    <div>
                        <input type="hidden" name="userid" id="userid" value="<?php echo $_GET['encrypt'];?>">
                    </div>
                        <button type="button" id="reset-password-btn" class="btn btn-primary" style="float: right;">Submit</button>
                </form><br>
            
            </section>   
         
        </div>
        
        
    </div>

</div>
</div>

</body>
</html>
