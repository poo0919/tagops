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
<!--    <link rel="stylesheet" href="/resources/demos/style.css">  -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--    <link href="css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  <link rel="stylesheet" type="text/css" href="adminPanel.css">
<link rel="stylesheet" href="sidebar.css">
</head>

<body style="background-image: url(back12.jpg);">

<?php 
include 'adminBars.php';
?>
<div class="container" id="midNav" "> 
    <div class="spacer"></div>
       
        <div id="update_employee" class=" well " >
          
            <section>
                <!--List of all employees with various actions -->
                <div style="text-align: center"><h1>Employees</h1></div>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Designation</th>
                      <th>Phone Number</th>
                      <th>Personal Email</th>
                      <th>RM</th>
                      <th>Actions</th>
                      <th>Wallet</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include 'connection.php';
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                          $query="Select * from user where status='1' order by name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                  $status=$row1['status'];
                                  $rm_id=$row1['rm_id'];
                                  $personal_email=$row1['personal_email'];
                                  if(empty($personal_email))
                                    $personal_email="empty";
                                  $phone_number=$row1['phone_number'];
                                  if(empty($phone_number))
                                    $phone_number="empty";
                                  $designation=$row1['designation'];
                                  if(empty($designation))
                                    $designation="not assigned";

                                  $rm_name="";
                                  $rm_mail="";
                                  if(empty($rm_id))
                                    $rm_name="not assigned";
                                  else{

                                        $q1="SELECT name,email FROM user WHERE id='$rm_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $ro1 = $re1->fetch_array();
                                        $rm_name=$ro1['name'];
                                        $rm_mail=$ro1['email'];

                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                    echo "<tr><td align='left'>".$index."</td>
                                    <td align='left'>".$row1['name']."</td>
                                    <td align='left'>".$designation."</td>
                                    <td align='left'>".$phone_number."</td>
                                    <td align='left'>".$personal_email."</td>
                                    <td align='left'>".$rm_name."</td>
                                    <td><button onclick=removeUser(".$row1['id'].") class='btn btn-warning btn-xs' id='remove".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Remove</button> 
                                    <button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-name='".$row1['name']."' data-id='".$row1['id']."' data-designation='".$designation."' data-rm='".$rm_name."' data-rm_mail='".$rm_mail."'><span class='glyphicon glyphicon-edit'></span> Edit</button></td>
                                    <td>
                                      <button id='addbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id='".$row1['id']."'><span class='glyphicon glyphicon-plus'></span> Add</button>  
                                    </td></tr>";

                                    if($status=="0"){
                                       echo "<script>document.getElementById('remove".$index."').disabled = true;</script>";
                                       echo "<script>document.getElementById('editbtn".$index."').disabled = true;</script>";
                                       echo "<script>document.getElementById('addbtn".$index."').disabled = true;</script>";
                                    }
                                    $index++;
                              }
                          }
                      
                  }
  
                    ?>
                    </tbody>
                </table>
                
                  <!--Updating data of employee -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel1">New </h4>
                            </div>
                            <div class="modal-body">
                                <form method="GET" action="renameUser.php">
                                    <div class="form-group">
                                        <label for="oldName" class="control-label">Name:</label>
                                        <input type="text" class="form-control" id="oldName" name="oldName" >
                                    </div>
                                    <div class="form-group">
                                        <label for="designation" class="control-label">Designation:</label>
                                        <input type="text" class="form-control" id="designation" name="designation" >
                                    </div><br>
                                    <label class="control-label">Details of RM:</label>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                        <label for="repMgr" class="control-labelcol-sm-2">Name:</label>
                                        <input type="text" class="form-control col-sm-4" id="repMgr" name="repMgr" readonly>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="repMgrMail" class="control-label">Email:</label>
                                        <input type="email" class="form-control" id="repMgrMail" name="repMgrMail" >
                                    </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                    <button type="button-inline" id="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--adding balance to wallet of a user -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel2">Wallet </h4>
                            </div>
                            <div class="modal-body">
                                <form method='POST' action='wallet.php' id="walletForm">
                                    <div class='form-group'>
                                        <label for='date' class='control-label'>Date:</label>
                                        <input type='text' class='form-control datepicker' id='date' name='date'>
                                    <div>
                                    <div class='form-group'>
                                        <label for='remarks' class='control-label'>Remarks:</label>
                                        <input type='text' class='form-control' id='remarks' name='remarks'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='advance' class='control-label'>Advance:</label>
                                        <input type='number' class='form-control' id='advance' name='advance'>
                                    </div>
                                    <div class='form-group'>
                                        <input type='hidden' name='id' id='id' >
                                    </div>
                                        <button type='button-inline' id='submit' class='btn btn-primary' name='submit' value='submit'>Add in Wallet</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelModal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                function removeUser(id){

                    var r = confirm("Are you sure you want remove this user?");
                    if (r == true) {
                        $.ajax({
                                    url: "removeUser.php",
                                    type: "GET",
                                    data: "ACTION=remove&id="+id,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("user removed!");
                                            window.location.href = window.location.href;
                                          //  window.loaction.href='adminPanelUpdateEmp.php';
                                          //  window.loaction.reload();
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
                }


                function modalFunction1(){
                     $("#exampleModal1").on("show.bs.modal", function (event){
                          var button = $(event.relatedTarget);
                          var name = button.data('name');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update details of ' + name);
                
                         $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
                         $('#exampleModal1').find('input#repMgr').val($(event.relatedTarget).data('rm'));
                         $('#exampleModal1').find('input#designation').val($(event.relatedTarget).data('designation'));
                         $('#exampleModal1').find('input#repMgrMail').val($(event.relatedTarget).data('rm_mail'));
                         $('#exampleModal1').find('input#oldName').val($(event.relatedTarget).data('name'));
                      
                         
                     });
                     
                }

                function modalFunction2(){
                     $("#exampleModal2").on("show.bs.modal", function (event){
                          var button = $(event.relatedTarget);
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Add in wallet');
                        $('#exampleModal2').find('input#id').val($(event.relatedTarget).data('id'));
                     });
                     
                }
           
                </script>
            </section>
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
 
        $("#cancelModal").click(function(e){
            e.preventDefault();
                $('#walletForm')[0].reset(); 
        });

    });
    </script>
     
   
   
  </body>
</html>