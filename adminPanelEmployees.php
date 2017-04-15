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

       <div id="tab_employees" class="well "  >
            <!--filter for waleet balacnce clear/due -->
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter-emp" >
                <div class="form-group" style="float: right;">
                    <select name="filter-employees" class="form-control" id="filter-employees" >
                        <option value="due">Due</option>
                        <option value="all" >All</option>
                        <option value="clear">Clear</option>
                    </select>
                    <button type="submit" class="btn btn-info" style="float: right;"><b>Filter</b></button>              
                </div>
            </form>
        
            <section>
                <!--List of all employees with their wallet balance -->
                <div style="text-align: center"><h1>Employees</h1></div>
                <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Wallet Balance</th>
                      <th>Expense Download</th>
                      <th>Wallet Download</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    include 'connection.php';
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                      if(!isset($_GET['filter-employees']) || ($_GET['filter-employees']=='due')){ //filter if wallet balance is due 

                            $q1="select id, name from user order by name";
                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                            if ($re1->num_rows > 0) {
                                $index=1;
                                while($ro1 = $re1->fetch_array()){
                                    $user_id=$ro1['id'];
                                    $name=$ro1['name'];
                                    $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_array()){
                                            $walletBalance=$row['sumTransactions'];
                                            if($walletBalance<0){
                                                echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='writeToEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><td><a href='writeToEmployeeWalletExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download'></span></a></td><tr>";
                                                $index++;
                                            }
                                        }
                                    }else{

                                        echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>0</td><td><a href='writeToEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><tr>";
                                    }

                                }
                            }

                      }else{
                          $filter=$_GET['filter-employees'];
                          if($filter=='all'){  //show all user's wallet balance

                            $q1="select id, name from user order by name";
                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                            if ($re1->num_rows > 0) {
                                $index=1;
                                while($ro1 = $re1->fetch_array()){
                                    $user_id=$ro1['id'];
                                    $name=$ro1['name'];

                                    $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_array()){
                                            $walletBalance=$row['sumTransactions'];
                                            if(empty($walletBalance))
                                                $walletBalance="0";
                                             
                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='writeToEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><tr>";
                                            $index++;
                                        }
                                    }

                                }
                            }

                          }else{ //show whose wallet balance is clear

                            $q1="select id, name from user order by name";
                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                            if ($re1->num_rows > 0) {
                                $index=1;
                                while($ro1 = $re1->fetch_array()){
                                    $user_id=$ro1['id'];
                                    $name=$ro1['name'];

                                    $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_array()){

                                            $walletBalance=$row['sumTransactions'];

                                            if($walletBalance<0){
                                                continue;
                                            }else{
                                                if(empty($walletBalance))
                                                    $walletBalance="0";
                                                 
                                                echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='writeToEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><tr>";
                                                $index++;
                                            }
                                        }
                                    }

                                }
                            }
                   
                          }
                          
                      }
                    }
  
                    ?>
                    </tbody>
                </table>
                
                
                
        
            </section>
           <div class="container">
             
          
               <?php
                include 'connection.php';
                if(!isset($_SESSION['login_email'])){
                     header("location:index.php");
                }else{
                  $total=0;
                    if(!isset($_GET['filter-employees']) || $_GET['filter-employees']=='due'){

                        $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                              $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()){
                                     
                                        $walletBalance=$row['sumBalance'];

                                        if($walletBalance<0){
                                              $total+=$walletBalance;
                                            }
                                        }
                                }

                                echo "<h3 style='float:right;padding-right:100px;'>Total Wallet Balance: <span class='label label-default'>".$total."</span></h3>";
                         
                    }else{
                          $filter=$_GET['filter-employees'];
                          if($filter=='all'){
                                $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                                $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()){
                                     
                                        $walletBalance=$row['sumBalance'];
                                        $total+=$walletBalance;
                                          
                                    }
                                }

                                echo "<h3 style='float:right;padding-right:100px;'>Total Wallet Balance: <span class='label label-default'>".$total."</span></h3>";
                         
                      
                          }else{
                              
                              $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                              $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()){
                                     
                                        $walletBalance=$row['sumBalance'];

                                        if($walletBalance>=0){
                                              $total+=$walletBalance;
                                            }
                                        }
                                }

                                echo "<h3 style='float:right;padding-right:100px;'>Total Wallet Balance: <span class='label label-default'>".$total."</span></h3>";
                         
                          }
                    }
                }
                ?>
             
          </div>   <br>
        </div>
            
</div>
    

 

    <script type="text/javascript">

    $(document).ready(function(){

            if(localStorage.getItem('filter-employees')){
            $('#filter-employees').val(localStorage.getItem('filter-employees'));
        }

        $('#filter-employees').change(function(){
            localStorage.setItem('filter-employees',$('#filter-employees').val() );
          
        });

         

        localStorage.removeItem('filter-projects');
        localStorage.removeItem('sort');
        localStorage.removeItem('filter1-employees');
        localStorage.removeItem('filter2-employees');
        localStorage.removeItem('filter1-projects');
        localStorage.removeItem('filter2-assets');
        localStorage.removeItem('filter1-assets');


      

    });
    function downloadEmployeeExpenses(userId){
        alert(userId);
        $.ajax({
            url: "writeToEmployeeExpenseExcel.php",
            type: "POST",
            data: "EMPLOYEEID="+userId,
            success: function(json){
            //    $("#assetsData").append(json);
                                                                    
            }
        })
    }
    </script>
     
   
   
  </body>
</html>