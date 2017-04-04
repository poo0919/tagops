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
 <!--   <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--    <link href="css/bootstrap.min.css" rel="stylesheet"> -->
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

<body style="background-image: url(back12.jpg);" >

<?php 
include 'adminBars.php';
?>
    
<div class="container" id="midNav" "> 
  <div class="spacer"></div>
        <div id="tab_projects" class="well" >

           <!--form for filter -->
              <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter-proj" >
                <div class="form-group" style="float: right;">
                    <select name="filter-projects" class="form-control" id="filter-projects" >
                        <option value="due">Due</option>
                        <option value="all" >All</option>
                        <option value="clear">Clear</option>
                    </select>
                    <button type="submit" class="btn btn-info" style="float: right;"><b>Filter</b></button>              
                </div>
              </form><br>
             
              
                <section>
                    <div style="text-align: center">  <h1>Projects</h1></div>
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Project</th>
                          <th>Approved Expense(Total)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include 'connection.php';
           
                        if(!isset($_SESSION['login_email'])){
                            header("location:index.php");
                        }else{
                          
                          if(!isset($_GET['filter-projects']) || $_GET['filter-projects']=='due'){  

                                $sql="select d.project_id,SUM(d.amount) as total,pr.id as id,pr.name as name from data d join (select id,name from projects) as pr on d.project_id=pr.id where d.reimbursed='0' group by pr.name order by pr.name";
                                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                     if ($result->num_rows > 0) {
                                        $index=1;
                                        while($row = $result->fetch_array()){
                                            $project_id=$row['id'];
                                            $q1="SELECT SUM(amount) as total from data where project_id='$project_id' AND reimbursed='1' group by project_id";
                                            $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                            $total="";
                                             if ($re1->num_rows > 0) {
                                                while($ro1 = $re1->fetch_array()){
                                                  $total=$ro1['total'];
                                                }
                                              }

                                              if(empty($total))
                                                $total="0";

                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$row['id'].">".$row['name']."</a></td><td>".$total."</td><tr>";
                                                $index++;
                                        }
                                     }
                              
                          }else{

                            $filter=$_GET['filter-projects'];
                              if($filter=='all'){
                                    $query="Select id,name from projects order by name";
                                     $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                              
                                  if ($result1->num_rows > 0) {
                                            $index=1;
                                      while($row1 = $result1->fetch_array()){
                                            
                                            $project_id=$row1['id'];
                                            $query="select id,project_id,SUM(amount) as total from data where project_id='$project_id' group by project_id";
                                            $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            $row2 = $result2->fetch_array();
                                            
                                            if(empty($row2['total']))
                                                $row2['total']="0";

                                              $project_id=$row1['id'];
                                            $q1="SELECT SUM(amount) as total from data where project_id='$project_id' AND reimbursed='1' group by project_id";
                                            $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                            $total="";
                                             if ($re1->num_rows > 0) {
                                                while($ro1 = $re1->fetch_array()){
                                                  $total=$ro1['total'];
                                                }
                                              }

                                              if(empty($total))
                                                $total="0";

                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$row1['id'].">".$row1['name']."</a></td><td>".$total."</td><tr>";
                                            $index++;
                                      }
                                  }
                                  
                              }else{
                                    $q1="select id,name from projects order by name";
                                    $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                    if ($re1->num_rows > 0) {
                                        $index=1;
                                          while($ro1= $re1->fetch_array()){
                                            $flag="0";
                                            $q2="select * from data where project_id='$ro1[id]'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));

                                              if ($re2->num_rows > 0) {                                        
                                                  while($ro2= $re2->fetch_array()){
                                                    if($ro2['reimbursed']=="0"){
                                                      $flag="1";
                                                      break;
                                                    }
                                                  } 
                                              }

                                              $q3="SELECT SUM(amount) as total from data where project_id='$ro1[id]' AND reimbursed='1' group by project_id";
                                            $re3 = mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            $total="";
                                             if ($re3->num_rows > 0) {
                                                while($ro3 = $re3->fetch_array()){
                                                  $total=$ro3['total'];
                                                }
                                              }

                                              if(empty($total))
                                                $total="0";

                                              if($flag=="0"){
                                                            
                                                  $due="0";
                                                  echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$ro1['id'].">".$ro1['name']."</a></td><td>".$total."</td><tr>";
                                                  $index++;
                                                            
                                              }
                                          } 
                                    }
                                  
                              }
                              
                          }
                        }
      
                        $conn->close();
                        ?>
                        </tbody>
                    </table>
                </section>
                
            <section>
                
            <?php  //messgage shown on csv file upload
            include 'connection.php';

            if(!empty($_GET['status'])){
                switch($_GET['status']){
                    case 'succ':
                        $statusMsgClass = 'alert-success';
                        $statusMsg = 'CSV file imported successfully.';
                        break;
                    case 'err':
                        $statusMsgClass = 'alert-danger';
                        $statusMsg = 'Some problem occurred, please try again.';
                        break;
                    case 'invalid_file':
                        $statusMsgClass = 'alert-danger';
                        $statusMsg = 'Please upload a valid CSV file.';
                        break;
                    case 'mail':
                        $statusMsgClass = 'alert-message';
                        $statusMsg = 'Email id is wrong.';
                        break;
                    default:
                        $statusMsgClass = '';
                        $statusMsg = '';
                }
            }
            ?>

                <?php if(!empty($statusMsg)){
                    echo '<div id="alert_message" class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
                } ?>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Add data from CSV file: 
                        <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import File</a>
                       <p style="float: right">Download Sample CSV format: <a href="writeToCSV.php" download >Sample</a></p> 
                    </div>
                    <div class="panel-body">
                        <form action="import_csv.php" method="post" enctype="multipart/form-data" id="importFrm" class="form-inline">
                            <div class="form-group" >
                                <label>Select Project: </label>
                                <select class="form-control" id="project" name="project_id">
                                    <option value="0">--select--</option>
                                        <?php
                                            include 'connection.php';
                                            $query = "SELECT * FROM projects order by name";
                                            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            while ($rows = mysqli_fetch_array($result)) {
                                                echo "<option value=" .$rows['id']. ">" .$rows['name']. "</option>";
                                            }
                                        ?>     
                                </select>
                            </div>
                            <div class="form-group" >
                                <input type="file" name="file" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Download Project wise CSV: 
                        <a href="javascript:void(0);" onclick="$('#exportTo').slideToggle();">Export File</a>
                 <!--      <p style="float: right">Download: <a href="writeToProjectExpenseCSV.php" download >Sample</a></p>   -->
                    </div>
                    <div class="panel-body">
                        <form action="writeToProjectExpenseExcel.php" method="post" id="exportTo" class="form-inline">
                            <div class="form-group" >
                                <label>Select Project: </label>
                                <select class="form-control" id="project_idEx" name="project_idEx">
                                    <option value="0">--select--</option>
                                        <?php
                                            include 'connection.php';
                                            $query = "SELECT * FROM projects order by name";
                                            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            while ($rows = mysqli_fetch_array($result)) {
                                                echo "<option value=" .$rows['id']. ">" .$rows['name']. "</option>";
                                            }
                                        ?>     
                                </select>
                            </div>
                          
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="exportSubmit" value="EXPORT">
                            </div>
                        </form>
                    </div>
                </div>

                <script type="text/javascript">
                    window.setTimeout(function() {
              $("#alert_message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
              });
            }, 3000);
                </script>

            </section>
        </div>
</div>
    
    <script type="text/javascript">

    $(document).ready(function(){
        
        if(localStorage.getItem('filter-projects')){
            $('#filter-projects').val(localStorage.getItem('filter-projects'));
        }

        $('#filter-projects').change(function(){
            localStorage.setItem('filter-projects',$('#filter-projects').val() );
           
        });

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