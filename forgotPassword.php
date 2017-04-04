<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="config.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    
    $("#forgot-password-btn").click(function() {
                           
             var email = $("#email").val();
                            
                            if ( email == '') {
                                alert("Empty field...!!!!!!");
                            }else{
                                $.ajax({
                                        url: "passwordResetLink.php",
                                        type: "POST",
                                        data: "ACTION=reset&EMAIL="+email,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='0'){
                                                alert('Your access is denied. Contact Admin!');  
                                            }else if (data=='2'){
                                                alert('This email id is not registered!');                            
                                            }else{
                                                var subject="TagOps - Reset Password Link.";
                                                var message="<p>Hi,<br>Click here to reset your password"+resetPasswordLink+"/resetPasswordForm.php?encrypt="+data+"</p>";
                                            
                                                    $.ajax({
                                                                                   
                                                        url: "http://dev.tagbin.in/phpHandler/mailer/mailgun/tagbinMailer.php",
                                                        type: "POST",
                                                        data: "_ACTION=send_email&_SUBJECT="+subject+"&_EMAIL="+email+"&_MESSAGE="+message,
                                                        success: function(data){
                                                            alert("Mail has been sent!");
                                                            $('#forgotPasswordForm')[0].reset();
                                                        }
                                                    })
                                                        alert("Mail has been sent!");
                                                        $('#forgotPasswordForm')[0].reset();
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


</head>
<body style="background-image: url(back12.jpg);"><div>


<nav class="navbar navbar-default" style="background: rgb(239, 250, 250 );">
<div class="container-fluid">
    <div class="navbar-header">
        <img src="logo.png" style="width:155px;height:33px;">
    </div>
</div>
</nav>


<h5 style="color: rgb(0,0,0);text-align: center;padding-top: 1%;">Enter your registered email below and we will send you a link to reset your password.</h5>


<div class="container" style="width: 30%;">

    <div class="tab-content well " id="myContent" style="background: rgb(239, 250, 250 );">
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
