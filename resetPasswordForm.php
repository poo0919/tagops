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
                                        url: "resetPassword.php",
                                        type: "POST",
                                        data: "ACTION=reset&newPassword="+newPassword+"&userid="+userid,
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
                        
         
                    
    $("#confirmPassword").keyup(function(event){
    if(event.keyCode == 13){
        $("#reset-password-btn").click();
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


<h5 style="color: rgb(0,0,0);text-align: center;padding-top: 1%;">Forgot Password?</h5>


<div class="container" style="width: 30%;">

    <div class="tab-content well " id="myContent" style="background: rgb(239, 250, 250 );">
        <div id="sectionA" class="tab-pane fade in active"  style="min-height: 100px;">
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
