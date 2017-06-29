<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="js/config.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#forgot-password-btn").click(function() {
            var email = $("#email").val();
            if ( email == '') {
                alert("Empty field...!!!!!!");
            }else{
                $.ajax({
                    url: "api/action.php",
                    type: "POST",
                    data: "ACTION=passwordResetLink&EMAIL="+email,
                    success: function(response){
                        var data=$.trim(response);
                        console.log("forgot password: "+JSON.stringify(response));
                        if(data=='0'){
                            alert('Your access is denied. Contact Admin!');  
                        }else if (data=='2'){
                            alert('This email id is not registered!');                            
                        }else if(response.success==true){
                            console.log("send email: "+JSON.stringify(response));
                            alert("Mail has been sent.");
                            $('#forgotPasswordForm')[0].reset();
                        }else if(response.success==false){
                            alert(response.message);
                        }
                    }
                })
            }                        
        });   
                            
             
        $("#email").keyup(function(event){
            if(event.keyCode == 13){
                $("#forgot-password-btn").click();
            }
        });
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
<body style="background-image: url(images/backImage.png);">
<div>
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
    <h5 style="color: rgb(0,0,0);text-align: center;">Enter your registered email below and we will send you a link to reset your password.</h5><br>
    <div class="container" style="width: 30%;">
        <div class="tab-content well " id="myContent" style="background: rgb(300,300,300 );">
            <div id="sectionA" class="tab-pane fade in active"  style="min-height: 100px;">
                <section>
                    <form method="POST" action="passwordResetLink.php" id="forgotPasswordForm">
                        <div class="form-group ">
                            <label for="email" class="form-label">Email: </label>
                            <input type="email" class="form-control" id="email" name="email" >
                        </div>
                            <button type="button" id="forgot-password-btn" class="btn btn-primary" style="float: right;">Submit</button>
                    </form><br>
                </section>   
            </div>
        </div>
    </div>
</div>
</body>
</html>