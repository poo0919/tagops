<?php
    include 'connection.php';
    include 'session.php';

    //add new rental company
    if(isset($_GET['addNewCompany'])){
    if(!empty($_GET['NewCompany']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $rental_company_name=$_GET['NewCompany'];
            $sql = "INSERT INTO rental_companies (rental_company_name) VALUES ('$rental_company_name')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New Company added to database!');window.location.replace('adminPanelRentalCompanies.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanelRentalCompanies.php');</script>";
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
                <div style="text-align: center"><h1>Rental Companies</h1></div>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Rental Company</th>
                      <th>Update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                  
                          $query="Select * from rental_companies order by rental_company_name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                                    echo "<tr><td align='left'>".$index."</td>
                                    <td align='left'>".$row1['rental_company_name']."</td>
                                    <td><button onclick=removeRentalCompany(".$row1['id'].") class='btn btn-warning btn-xs' id='remove".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    <button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-companyname='".$row1['rental_company_name']."' data-id='".$row1['id']."' ><span class='glyphicon glyphicon-edit'></span> Edit</button></td>
                                    </tr>";

                                    $index++;
                              }
                          }
                      
                  }
  
                    $conn->close();
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
                                <form method="GET" action="updateRentalCompany.php">
                                    <div class="form-group ">
                                        <label for="companyname" class="control-label"> Asset Name:</label>
                                        <input type="text" class="form-control col-sm-4" id="companyname" name="companyname" >
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
                function removeRentalCompany(rentId){
                    var r = confirm("Are you sure you want delete this Company?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteRentalCompanyName.php",
                                    type: "POST",
                                    data: "ACTION=remove&rentId="+rentId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Company deleted!");
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
                          var companyname = button.data('companyname');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update Inventory: ' + companyname);
        
                         $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
                         $('#exampleModal1').find('input#companyname').val($(event.relatedTarget).data('companyname'));
                      
                     });
                     
                }

           
                </script>
                
        
            </section><br>
            <!--form for adding new Rental company  -->
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                    <div class="form-group">
                        <label for="NewCompany">Add New Rental Company: </label><br>
                        <input class="form-control" id="NewCompany" type="text" name="NewCompany" placeholder="Enter Rental Company">
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