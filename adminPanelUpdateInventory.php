<?php
    include 'connection.php';
    include 'session.php';

    //add new asset to db
    if(isset($_GET['addNewAsset'])){
    if(!empty($_GET['NewAsset']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $asset=$_GET['NewAsset'];
            $sql = "INSERT INTO asset_type (asset_name) VALUES ('$asset')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New Asset added to database!');window.location.replace('adminPanelUpdateInventory.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanelUpdateInventory.php');</script>";
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
       
        <div id="update_inventoryType" class=" well " >
            
        
            <section>
                <div style="text-align: center"><h1>Inventory</h1></div>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Asset</th>
                      <th>Update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                          $query="Select * from asset_type order by asset_name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                                    echo "<tr><td align='left'>".$index."</td>
                                    <td align='left'>".$row1['asset_name']."</td>
                                    <td><button onclick=removeInventoryType(".$row1['id'].") class='btn btn-warning btn-xs' id='remove".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    <button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-assetname='".$row1['asset_name']."' data-id='".$row1['id']."' ><span class='glyphicon glyphicon-edit'></span> Edit</button></td>
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
                                <form method="GET" action="updateAssets.php">
                                    <div class="form-group ">
                                        <label for="assetName" class="control-label"> Asset Name:</label>
                                        <input type="text" class="form-control col-sm-4" id="assetName" name="assetName" >
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
                function removeInventoryType(invId){


                    var r = confirm("Are you sure you want delete this Inventory?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteInventoryType.php",
                                    type: "POST",
                                    data: "ACTION=remove&invId="+invId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Inventory deleted!");
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
                          var assetname = button.data('assetname');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update Inventory: ' + assetname);
                        
                         $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
                         $('#exampleModal1').find('input#assetName').val($(event.relatedTarget).data('assetname'));
                      
                         
                     });
                     
                }

           
                </script>
                
        
            </section><br>

            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                    <div class="form-group">
                        <label for="NewAsset">Add New Asset: </label><br>
                        <input class="form-control" id="NewAsset" type="text" name="NewAsset" placeholder="Enter Asset Type">
                        <button type="submit" class="btn btn-success" id="addNewAsset" name="addNewAsset" value="submit">Add Asset Type</button>            
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
 
    });
    </script>
     
   
   
  </body>
</html>