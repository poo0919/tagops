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


     <style type="text/css">

.well{
  background: rgb(239, 250, 250   );
}
th{
        background: rgb(226, 237, 235   );
    }
.spacer
{
    width: 100%;
    height: 100px;
}

 </style>


    <link rel="stylesheet" href="sidebar.css">
  </head>
  <body style="background-image: url(back12.jpg);">

<?php 
include 'adminBars.php';
?>

  <div class="container" id="midNav">
      
  <div class="spacer"></div>
            <section class="well">

            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter-proj" >
                <div class="form-group" style="float: right;">
                    <select name="filter1-projects" class="form-control" id="filter1-projects" >
                        <option value="0" selected>Submitted</option>
                        <option value="all" >All</option>
                        <option value="1">Approved</option>
                        <option value="2">Rejected</option>
                    </select>
                    <input type="hidden" name="id" id="id" value="<?php
             
                $project_id= $_GET['id'];
               echo $project_id;  
                                   
              ?>">
                    <button type="submit" class="btn btn-info" style="float: right;"><b>Filter</b></button>              
                </div>
              </form>

              <div class="row text-center head">
              <h3><b>
              <?php
                $project_id= $_GET['id'];
                $query="select name from projects where id='$project_id'";
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_array()){
                    echo $row['name'];
                  }          
                }  
                                        
              ?>
              </b></h3>
              </div>
              
                <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.No.</th>  
                      <th>Name</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Details</th>
                      <th>Category</th>
                      <th>Payment Mode</th>
                      <th>Bill</th>
                      <th>View Bill</th>
                      <th>Status</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
               
                 
                    $project_id=$_GET['id'];
                    if(!isset($_GET['filter1-projects']) || $_GET['filter1-projects']=='0'){
                        
                        $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id' AND reimbursed='0' ";
       
                        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                   
                        if ($result->num_rows > 0) {
                            $index=1;
                            while ($row = $result->fetch_array()){
                                
                                $user_id=$row['user_id'];
                                $q1="select name,email from user where id=$user_id";
                                $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                $r1=$rs1->fetch_array();
                                
                                $category_id=$row['category_id'];
                                $q2="select category from categories where id=$category_id";
                                $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                $r2=$rs2->fetch_array();
                                
                                $payment_id=$row['payment_id'];
                                $q3="select mode from payment where id=$payment_id";
                                $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                $r3=$rs3->fetch_array();
                                
                                $reimbursed=$row['reimbursed'];
                                if($reimbursed=="0"){
                                  $reimbursed="Submitted";
                                }else if($reimbursed=="1"){
                                  $reimbursed="Approved";
                                }else if($reimbursed=="2"){
                                  $reimbursed="Rejected";
                                }

                                if($row['bill']=="0")
                                  $bill="No";
                                else
                                  $bill="Yes";

                                $dateCreated=date_create($row['date']);
                                $formattedDate=date_format($dateCreated, 'd-m-Y');
    
                                echo "<tr><td>".$index."</td>
                                <td align='left'>".$r1['name']."</td>
                                <td align='left'>".$row['amount']."</td>
                                <td align='left'>".$formattedDate."</td>
                                <td align='left'>".$row['details']."</td>
                                <td align='left'>".$r2['category']."</td>
                                <td align='left'>".$r3['mode']."</td>
                                <td align='left'>".$bill."</td>
                                <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }
                                              echo "</td>
                                <td>".$reimbursed."<button id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' class='btn btn-warning btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-down'></span></button><button id='changebtn".$index."' onclick='changeStatus(".$row['id'].")' class='btn btn-success btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-up'></span></button></td><tr>";
                                $index++;
                            }
                        } else{
                            echo "<h4> No entry in this table ! <h4>";
                        }
                        
                      }else{

                        $filter=$_GET['filter1-projects'];
                          if($filter=='all'){
                                   //   $project_id=$_SESSION['project_id'];
                                      $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id'";
                 
                                  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                             
                                  if ($result->num_rows > 0) {
                                      $index=1;
                                      while ($row = $result->fetch_array()){
                                          
                                          $user_id=$row['user_id'];
                                          $q1="select name,email from user where id=$user_id";
                                          $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                          $r1=$rs1->fetch_array();
                                          
                                          $category_id=$row['category_id'];
                                          $q2="select category from categories where id=$category_id";
                                          $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                          $r2=$rs2->fetch_array();
                                          
                                          $payment_id=$row['payment_id'];
                                          $q3="select mode from payment where id=$payment_id";
                                          $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                          $r3=$rs3->fetch_array();
                                          
                                          $reimbursed=$row['reimbursed'];
                                          if($reimbursed=="0"){
                                            $reimbursed="Submitted";
                                          }else if($reimbursed=="1"){
                                            $reimbursed="Approved";
                                          }else if($reimbursed=="2"){
                                            $reimbursed="Rejected";
                                          }

                                          if($row['bill']=="0")
                                            $bill="No";
                                          else
                                            $bill="Yes";

                                          $dateCreated=date_create($row['date']);
                                        $formattedDate=date_format($dateCreated, 'd-m-Y');
              
                                          echo "<tr><td>".$index."</td>
                                          <td align='left'>".$r1['name']."</td>
                                          <td align='left'>".$row['amount']."</td>
                                          <td align='left'>".$formattedDate."</td>
                                          <td align='left'>".$row['details']."</td>
                                          <td align='left'>".$r2['category']."</td>
                                          <td align='left'>".$r3['mode']."</td>
                                          <td align='left'>".$bill."</td>
                                          <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }
                                              echo "</td>
                                          <td>".$reimbursed."<button id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' class='btn btn-warning btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-down'></span></button><button id='changebtn".$index."' onclick='changeStatus(".$row['id'].")' class='btn btn-success btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-up'></span></button></td><tr>";

                                          if($reimbursed=="Approved"){
                                            echo "<script>document.getElementById('changebtn".$index."').disabled = true;</script>";
                                            echo "<script>document.getElementById('rejectbtn".$index."').disabled = true;</script>";
                                          }else if($reimbursed=="Rejected"){
                                            echo "<script>document.getElementById('changebtn".$index."').disabled = true;</script>";
                                            echo "<script>document.getElementById('rejectbtn".$index."').disabled = true;</script>";
                                          }
                                          $index++;
                                      }
                                  } else{
                                      echo "<h4> No entry in this table ! <h4>";
                                  }

                          }else {



                                      $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id' AND reimbursed='$filter'";
                 
                                  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                             
                                  if ($result->num_rows > 0) {
                                      $index=1;
                                      while ($row = $result->fetch_array()){
                                          
                                          $user_id=$row['user_id'];
                                          $q1="select name,email from user where id=$user_id";
                                          $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                          $r1=$rs1->fetch_array();
                                          
                                          $category_id=$row['category_id'];
                                          $q2="select category from categories where id=$category_id";
                                          $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                          $r2=$rs2->fetch_array();
                                          
                                          $payment_id=$row['payment_id'];
                                          $q3="select mode from payment where id=$payment_id";
                                          $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                          $r3=$rs3->fetch_array();
                                          
                                          $reimbursed=$row['reimbursed'];
                                          if($reimbursed=="0"){
                                            $reimbursed="Submitted";
                                          }else if($reimbursed=="1"){
                                            $reimbursed="Approved";
                                          }else if($reimbursed=="2"){
                                            $reimbursed="Rejected";
                                          }

                                          if($row['bill']=="0")
                                            $bill="No";
                                          else
                                            $bill="Yes";

                                          $dateCreated=date_create($row['date']);
                                        $formattedDate=date_format($dateCreated, 'd-m-Y');
              
                                          echo "<tr><td>".$index."</td>
                                          <td align='left'>".$r1['name']."</td>
                                          <td align='left'>".$row['amount']."</td>
                                          <td align='left'>".$formattedDate."</td>
                                          <td align='left'>".$row['details']."</td>
                                          <td align='left'>".$r2['category']."</td>
                                          <td align='left'>".$r3['mode']."</td>
                                          <td align='left'>".$bill."</td>
                                          <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }
                                              echo "</td>
                                          <td>".$reimbursed."<button id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' class='btn btn-warning btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-down'></span></button><button id='changebtn".$index."' onclick='changeStatus(".$row['id'].")' class='btn btn-success btn-xs' style='float:right;'><span class='glyphicon glyphicon-thumbs-up'></span></button></td><tr>";

                                          if($reimbursed=="Approved"){
                                            echo "<script>document.getElementById('changebtn".$index."').disabled = true;</script>";
                                            echo "<script>document.getElementById('rejectbtn".$index."').disabled = true;</script>";
                                          }else if($reimbursed=="Rejected"){
                                            echo "<script>document.getElementById('changebtn".$index."').disabled = true;</script>";
                                            echo "<script>document.getElementById('rejectbtn".$index."').disabled = true;</script>";
                                          }
                                          $index++;
                                      }
                                  } else{
                                      echo "<h4> No entry in this table ! <h4>";
                                  }

                          }


                      }
          
                    ?>

                    
                    </tbody>
                </table> 
              
            </section>
          </div>
        
     </div>   

    <script type="text/javascript">
    $(document).ready(function(){


    if(localStorage.getItem('filter1-projects')){
            $('#filter1-projects').val(localStorage.getItem('filter1-projects'));
        }

        $('#filter1-projects').change(function(){
            localStorage.setItem('filter1-projects',$('#filter1-projects').val() );
           
        })

        localStorage.removeItem('filter-projects');
        localStorage.removeItem('filter-employees');
        localStorage.removeItem('sort');
        localStorage.removeItem('filter2-employees');
    
  });

    function entryRejected(dataId){
          var r = confirm("Are you sure you want to reject this entry?");
                    if (r == true) {
                        $.ajax({
                                    url: "entryReject.php",
                                    type: "POST",
                                    data: "ACTION=change&id="+dataId,
                                    success: function(data){
                                        
                                        if(data=="1"){
                                           alert("Rejected!");
                                            window.location.reload();  
                                        }else if (data=='2'){
                                            alert("cannot reject");                            
                                        }else if (data=='3'){
                                            alert("It is approved");                            
                                        }else if (data=='4'){
                                            alert("Already rejected");                            
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
            
            
            
        }

    
  
            function changeStatus(dataId){

              var r = confirm("Are you sure you want to approve this entry?");
                    if (r == true) {
                        $.ajax({
                                    url: "changeReimbProj.php",
                                    type: "POST",
                                    data: "ACTION=change&id="+dataId,
                                    success: function(data){
                                        
                                        if(data=="1"){
                                            window.location.reload();  
                                        }else if (data=='2'){
                                            alert("cannot update wallet");                            
                                        }else if (data=='3'){
                                            alert("can not change reimbursed status");                            
                                        }else if (data=='4'){
                                            alert("advance balance is not set for this user");                            
                                        }else if (data=='5'){
                                            alert("already approved or rejected");                            
                                        }else if (data=='6'){
                                            alert("insufficient balance in wallet to reimburse");                            
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