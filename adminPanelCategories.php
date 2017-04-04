<?php
    include 'connection.php';
    include 'session.php';

    if(isset($_GET['addNewCat'])){ //code for adding new category to db
    if(!empty($_GET['NewCat']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $category=$_GET['NewCat'];
            $sql = "INSERT INTO categories (category) VALUES ('$category')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New Category added to database!');window.location.replace('adminPanelCategories.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanelCategories.php');</script>";
    }
    }
    
    if(isset($_GET['renameCat'])){   //code for renaming a category
    if((!empty($_GET['oldCatName'])) && (!empty($_GET['newCatName'])))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $oldname=$_GET['oldCatName'];
            $newname=$_GET['newCatName'];
            $sql="UPDATE categories SET category='$newname' WHERE category='$oldname' ";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('Category renamed!');window.location.replace('adminPanelCategories.php');</script>";  
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else{
        echo "<script type='text/javascript'>alert('Field is empty!');window.location.replace('adminPanelCategories.php');</script>";
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
 <!--   <link rel="stylesheet" href="/resources/demos/style.css">  -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--   <link href="css/bootstrap.min.css" rel="stylesheet">  -->
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
      
            
        <div id="tab_categories" class=" well" >
            <section><!-- List of all categories -->
                    <div style="text-align: center">  <h1>All Categories</h1></div>
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Category</th>
                          <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                      
                        if(!isset($_SESSION['login_email'])){
                             header("location:index.php");
                        }else{
                            $query="Select id,category from categories order by category ASC";
           
                            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                            if ($result->num_rows > 0) {
                                $index=1;
                                while ($row = $result->fetch_array()){
                                    echo "<tr><td align='left'>".$index."</td><td align='left'>".$row['category']."</a></td><td><button onclick='removeCategory(".$row['id'].")' class='btn btn-warning btn-xs' style='float:right;'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                    $index++;
                                }
                            }
                        }
                      
                        ?>
                        </tbody>
                    </table>
            </section>
            <!-- form for adding new category-->
           <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                    <div class="form-group">
                        <label for="NewCat">Add New Category: </label><br>
                        <input class="form-control" id="NewCat" type="text" name="NewCat" placeholder="Enter Category">
                        <button type="submit" class="btn btn-success" id="addNewCat" name="addNewCat" value="submit">Add Category</button>            
                    </div>
        
                </form><br>
                <!-- form for renaimng a category-->
           <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form2">
                    <div class="form-group">
                        <label >Rename Category: </label><br>
                        <label for="oldCatName"> from </label>
                        <select class="form-control" id="oldCatName" name="oldCatName">
                        <option value="">--select--</option>
                             <?php
                           
                                $query = "SELECT * FROM categories order by category";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option >" .$rows['category']. "</option>";
                                }
                             ?> 
                        </select>                    
                        <label for="newCatName"> to </label>
                        <input class="form-control" id="newCatName" type="text" name="newCatName" placeholder="Rename">
                        <button type="submit" class="btn btn-info" id="renameCat" name="renameCat" value="submit">Rename</button>            
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

    function removeCategory(catId){
        var r = confirm("Are you sure you want delete this category?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteCategory.php",
                                    type: "POST",
                                    data: "ACTION=delete&catId="+catId,
                                    success: function(data){
                                            window.location.reload();
                                    }
                            })
                        
                    } else {
                        alert("You pressed Cancel!");
                    }
    }
    </script>
     
   
   
  </body>
</html>