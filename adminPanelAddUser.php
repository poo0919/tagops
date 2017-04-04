<?php
    include 'connection.php';
    include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--    <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--   <link href="css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="adminPanel.css">
<link rel="stylesheet" href="sidebar.css">
</head>

<body style="background-image: url(back12.jpg);">

<?php 
include 'adminBars.php';
?>

<div class="container" id="midNav" > 
    <div class="spacer"></div>
              
    <div id="new_user" class=" well " >
            <!-- form for adding new user with auth-code -->
            <h4>Add New User</h4>
            <form class="form-inline" id="authForm">
                <div class="form-group ">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" >
                    </div>
                    <div class="form-group">
                        <label for="auth-code" class="form-label">Auth Code</label>
                        <input type="text" class="form-control" id="auth-code" name="auth-code" readonly>
                    </div>
                    <div class="form-group" >
                        <button type="button-inline" id="generate-code" class="btn btn-info" >Generate Code</button>
                        <button type="button-inline" id="new-auth-user" class="btn btn-primary" disabled="true">Add user</button>
                    </div>
            </form>
            <br>
            <!-- form for adding new Admin -->
            <h4>Add New Admin</h4>
            <form class="form-inline" method="POST" action="newPermissions.php" id="admnForm">
                <div class="form-group ">
                    <label for="admnEmail" class="form-label">Email</label>
                    <select class="form-control" id="admnEmail">
                        <option value="0">--select--</option>
                            <?php
                                $query = "SELECT * FROM user where status='1' order by email";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                                }
                            ?>     
                    </select>
                </div>
                        <button type="button-inline" id="new-admn-user" class="btn btn-primary">Add as Admin</button>
            </form><br>

            <h4>Add New HR</h4>
            <form class="form-horizontal">
            <div class="form-group">
                          <label for="currentHR" class="control-label col-xs-2">Current HR</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                          
                            $sql="select name from user where type='3'";
                            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                              if ($result->num_rows > 0) {
                                $row = $result->fetch_array();
                                echo $row['name'];
                              }
                        ?></p>
                          </div>
                      </div>
                      </form>
            <form class="form-inline" method="POST" action="newPermissions.php" id="hrForm">
                <div class="form-group ">
                    <label for="hrEmail" class="form-label">Email</label>
                    <select class="form-control" id="hrEmail">
                        <option value="0">--select--</option>
                            <?php
                                $query = "SELECT * FROM user where status='1' order by email";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                                }
                            ?>     
                    </select>
                </div>
                        <button type="button-inline" id="new-hr-user" class="btn btn-primary">Add as HR</button>
            </form>
    </div>

</div>
    

 

 
    <script type="text/javascript">

    $(document).ready(function(){

          localStorage.removeItem('filter-projects');
          localStorage.removeItem('filter-employees');
          localStorage.removeItem('sort');
          localStorage.removeItem('filter1-employees');
          localStorage.removeItem('filter2-employees');
          localStorage.removeItem('filter1-projects');
          localStorage.removeItem('filter2-assets');
          localStorage.removeItem('filter1-assets');
      
       $("#generate-code").click(function(e){
        e.preventDefault();
                var x=Math.floor(Math.random() * 1000000);
        $('#authForm').find('input#auth-code').val(x);
                document.getElementById("new-auth-user").disabled = false;

        });

        $("#new-auth-user").click(function(e) {
                                 e.preventDefault();               
                            var email = $("#userEmail").val();              
                            var authCode = $("#auth-code").val();
                            var subject="TagOps Registration Credentials.";
                            var message="<p>Hi,<br>Your authorisation-code to register for TagOps is <b>"+authCode+"</b></p>";
                            var cc="";
                            if ( email == '' || authCode == '' ) {
                                alert("Please fill all fields...!!!!!!");
                            }else {
                                $.ajax({
                                        url: "newPermissions.php",
                                        type: "POST",
                                        data: "ACTION=addAuth&EMAIL="+email+"&AUTHCODE="+authCode,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='1'){

                                                $.ajax({
                                                        url: "http://dev.tagbin.in/phpHandler/mailer/mailgun/tagbinMailer.php",
                                                        type: "POST",
                                                        data: "_ACTION=send_email&_SUBJECT="+subject+"&_EMAIL="+email+"&_MESSAGE="+message+"&_CC="+cc,
                                                        success: function(data){
                                                         //   console.log(data);

                                                            if(data=='200'){

                                                                alert("Mail sent!");

                                                            }else{
                                                                alert("not allowed!");
                                                            }
                                                        }
                                                })






                                                $('#authForm')[0].reset();
                                                alert("user added with authcode "+authCode);



                                                window.location.reload();

                                            }else if (data=='0'){
                                                      alert("not added");
                                            }else if(data=="2")
                                            {       
                                                    $('#authForm')[0].reset();
                                                    alert("already authorised!");
                                            }
                                        }
                                })
                            }                 

                        }); 

        $("#new-admn-user").click(function(e) {
                            e.preventDefault();               
                            var email = $("#admnEmail").val();   
                            if ( email == '') {
                                alert("Please fill all fields...!!!!!!");
                            }else {
                                $.ajax({
                                        url: "newPermissions.php",
                                        type: "POST",
                                        data: "ACTION=addAdmn&id="+email,
                                        //+"&ADMNCODE="+admnCode,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='1'){
                                                $('#admnForm')[0].reset();
                                                alert("admin added");

                                            }else {
                                                $('#admnForm')[0].reset();
                                                      alert("Already an admin!");
                                            }
                                        }
                                })
                            }                 

                        });


        $("#new-hr-user").click(function(e) {
                            e.preventDefault();               
                            var email = $("#hrEmail").val();   
                            if ( email == '') {
                                alert("Please fill all fields...!!!!!!");
                            }else {
                                $.ajax({
                                        url: "newPermissions.php",
                                        type: "POST",
                                        data: "ACTION=addHR&id="+email,
                                        //+"&ADMNCODE="+admnCode,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='1'){
                                                $('#hrForm')[0].reset();
                                                alert("HR added");

                                            }else {
                                                $('#hrForm')[0].reset();
                                                      alert("Already an HR!");
                                            }
                                        }
                                })
                            }                 

                        }); 
     

    

    });
    </script>
     
   
   
  </body>
</html>