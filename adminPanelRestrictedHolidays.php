<?php
    include 'connection.php';
    include 'session.php';

    //add new rental company
    if(isset($_GET['occasion1'])){
    if(!empty($_GET['occasion1']) && !empty($_GET['date']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $occasion1=$_GET['occasion1'];
            $date=$_GET['date'];
            $sql = "INSERT INTO restricted_holidays (occasion,date) VALUES ('$occasion1','$date')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New RH added to database!');window.location.replace('adminPanelRestrictedHolidays.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanelRestrictedHolidays.php');</script>";
    }
    }
    
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
       
        <div id="update_rentalCompany" class=" well " >
            
        
            <section>
                <div style="text-align: center"><h1>Restricted Holidays</h1></div>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Occasion</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                  
                          $query="Select * from restricted_holidays order by date";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                                                     
                                    $dateCreated=date_create($row1['date']);
                                    $formattedDate=date_format($dateCreated, 'd-m-Y');

                                    echo "<tr><td align='left'>".$index."</td>
                                    <td align='left'>".$row1['occasion']."</td>
                                    <td align='left'>".$formattedDate."</td>
                                    <td><button onclick=deleteRH(".$row1['id'].") class='btn btn-warning btn-xs' id='remove".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    <button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-occasion='".$row1['occasion']."' data-date='".$row1['date']."' data-id='".$row1['id']."' ><span class='glyphicon glyphicon-edit'></span> Edit</button></td>
                                    </tr>";

                                    $index++;
                              }
                          }
                      
                  }
  
                    ?>
                    </tbody>
                </table>
                

                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel1">New </h4>
                            </div>
                            <div class="modal-body">
                                <form method="GET" action="updateRH.php">
                                    <div class="form-group ">
                                        <label for="occasion" class="control-label"> Occasion:</label>
                                        <input type="text" class="form-control col-sm-4" id="occasion" name="occasion" >
                                    </div>
                                    <div class="form-group ">
                                        <label for="date1" class="control-label">  Date:</label>
                                        <input type="date" class="form-control col-sm-4" id="date1" name="date1" >
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                    <button type="button-inline" id="submit" class="btn btn-default" name="submit" value="submit">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

              
                
                <script>
                function deleteRH(rhId){
                    var r = confirm("Are you sure you want delete this RH?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteRH.php",
                                    type: "POST",
                                    data: "ACTION=delete&rhId="+rhId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("RH deleted!");
                                            window.location.href = window.location.href;
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
                          var occasion = button.data('occasion');
                          var date = button.data('date');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update RH: ' + occasion);
        
                         $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
                         $('#exampleModal1').find('input#occasion').val($(event.relatedTarget).data('occasion'));
                         $('#exampleModal1').find('input#date1').val($(event.relatedTarget).data('date'));
                      
                     });
                     
                }

           
                </script>
                
        
            </section><br>
            <!--form for adding new Rental company  -->
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                    <div class="form-group">
                        <label for="occasion1">Add New RH: </label>
                        <input class="form-control" id="occasion1" type="text" name="occasion1" placeholder="Enter Occasion">
                                    
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                      
                            <div class="input-group">
                                <input id="date" type="text" class="form-control" name="date"  autocomplete="off" placeholder="Select Date" />
                                <label for="date" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>

                                </label>
                            </div>
                        
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success" id="addNewCompany" name="addNewCompany" value="submit">Add</button>
                    </div>
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
 
    $("#cancelModal").click(function(e){
            e.preventDefault();
                $('#walletForm')[0].reset(); 
        });

    });
    </script>
     
   
   
  </body>
</html>