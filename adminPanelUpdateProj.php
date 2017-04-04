<?php
    include 'connection.php';
    include 'session.php';

    // add new project to db
    if(isset($_GET['addNewProj'])){
    if(!empty($_GET['addNewProjName']))
    {   
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        } else{
            $name=$_GET['addNewProjName'];
            
            $sql = "INSERT INTO projects (name) VALUES ('$name')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New project added to database!');window.location.replace('adminPanelUpdateProj.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanelUpdateProj.php');</script>";
    }
    }
    
    // rename a project
    if(isset($_GET['renameProj'])){
    if((!empty($_GET['oldProjName'])) && (!empty($_GET['newProjName'])))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:adminLogin.php");
        }else{
            $oldname=$_GET['oldProjName'];
            $newname=$_GET['newProjName'];
            $sql="UPDATE projects SET name='$newname' WHERE name='$oldname' ";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('Project renamed!');window.location.replace('adminPanelUpdateProj.php');</script>";  
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Field is empty!');window.location.replace('adminPanelUpdateProj.php');</script>";
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

        <div id="update_project" class="well " >
            
            <section>
                <div style="text-align: center">  <h1>Projects</h1></div>
                <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Project</th>
                      <th>State</th>
                      <th>Delete</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    <?php
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                      
                          $query="Select id,name,state from projects order by name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                    $state= $row1['state'];

                                    if(empty($state)){
                                        $state="Inactive";
                                    }else{
                                        $state="Active";
                                    }
                                   
                                    echo "<tr><td align='left'>".$index."</td><td align='left'>".$row1['name']."</td><td>".$state."<button onclick='changeProjectState(".$row1['id'].")' class='btn btn-success btn-xs' style='float:right;'><span class='glyphicon glyphicon-random'></span> Change</button></td><td><button onclick='removeProject(".$row1['id'].")' class='btn btn-warning btn-xs' style='float:right;'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                    $index++;
                              }
                          }
                      }
                   
  
                    ?>
                    </tbody>
                </table>
                </section>

            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                <div class="form-group">
                    <label for="addNewProjName">Add New Project: </label><br>
                    <input class="form-control" id="addNewProjName" type="text" name="addNewProjName" placeholder="Enter Project Name">
                    <button type="submit" class="btn btn-success" id="addNewProj" name="addNewProj" value="submit">Add Project</button>            
                </div>
    
                </form><br>
                <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form2">
                    <div class="form-group">
                        <label >Rename Project: </label><br>
                        <label for="oldProjName"> from </label>
                        <select class="form-control" id="oldProjName" name="oldProjName">
                        <option value="">--select--</option>
                             <?php
                              
                                $query = "SELECT * FROM projects order by name";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option >" .$rows['name']. "</option>";
                                }
                             ?> 
                        </select>                        <label for="newProjName"> to </label>
                        <input class="form-control" id="newProjName" type="text" name="newProjName" placeholder="Enter New Name">
                        <button type="submit" class="btn btn-info" id="renameProj" name="renameProj" value="submit">Rename</button>            
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

    function removeProject(projId){
        var r = confirm("Are you sure you want delete this project?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteProject.php",
                                    type: "POST",
                                    data: "ACTION=delete&projId="+projId,
                                    success: function(data){
                                            window.location.reload();
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
    }

    
    function changeProjectState(projId){
        var r = confirm("Are you sure you want to Activate/Deactivate this Project?");
                    if (r == true) {
                        $.ajax({
                                    url: "changeProjectState.php",
                                    type: "POST",
                                    data: "ACTION=change&projId="+projId,
                                    success: function(data){
                                        
                                        if(data=="1"){
                                            alert("State Changed");
                                            window.location.reload();
                                        }else if(data=="0"){
                                            alert("Can't change state!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
    }
    </script>
     
   
   
  </body>
</html>