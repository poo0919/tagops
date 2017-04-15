<?php
include 'empSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Employee Records - TagOps</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <!--   <link rel="stylesheet" href="/resources/demos/style.css">  -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--   <link href="css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="empBars.css">
<link rel="stylesheet" href="empExpenses.css">
<style type="text/css">
  h5,a{
  margin-top: 0px;
  margin-bottom: 0px;
    font-family:Montserrat;
    font-size: 16px;
} 
.submenu-heading {
        padding: 0px;
    padding-left: 0px;
    cursor: pointer;
}
</style>
<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
</head>
<body >

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a id="menu-toggle" href="#" class="navbar-toggle pull-left">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="navbar-brand" href="empExpenses.php">
            <img src="logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
        
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" id="login_user_name" data-toggle="dropdown" href="#" style="background-color: white; ">
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="empProfile.php">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu">
                    <div class="submenu-heading" id="expenses"> <h5 class="submenu-title" ><img src="Expenses.png" alt="expenses" >Expenses</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="leaves" > <h5 class="submenu-title" id="leaves"><img src="Leaves.png" alt="leaves" >Leaves</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="assets"> <h5 class="submenu-title" id="assest"><img src="Assets.png" alt="assets" >Assets</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="reportees"> <h5 class="submenu-title" id="reportees"><img src="Reportees.png" alt="reportees" >Reportees</h5> </div>                   
                </div>
                

            </div>
            
        </div>
        
    </div>
</nav>


  


<div id="page-wrapper" class="container" >
    <div class="bs-example">
    <center>   <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
            <li class="active " ><a data-toggle="tab" href="#myExpenseTab" >MY EXPENSES</a></li>
            <li><a data-toggle="tab" href="#myTransactionTab" >MY TRANSACTIONS</a></li>
            <li><a data-toggle="tab" href="#newExpenseTab" >NEW EXPENSES</a></li>
        </ul></center> 
     

        <div class="tab-content" id="myContent">
            <div id="myExpenseTab" class="tab-pane fade in active">
            
                <form class="form-inline"  id="form-filter-emp" style="float:right;" >
                    <div class="form-group" >
                    <label style="color: #2a409f">Filters </label>
                        <select name="filter2-employees" class="form-control" id="filter2-employees" style="background: #fcf9f9" >
                            <option value="0" selected="" >Submitted</option>
                            <option value="all" >All</option>
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        </select>                                  
                    </div>
                </form> <br>
                <hr  >​
                <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;" id="filterMyEmpExpenseData">
                   <script type="text/javascript">
                      window.onload = function() {
                            var val=localStorage.getItem('filter2-employees');
                            $.ajax({
                                                    url: "filterMyEmpExpenses.php",
                                                    type: "POST",
                                                    data: "ACTION=getFilteredData&filter2-employees="+val,
                                                    success: function(json){
                                                      $("#filterMyEmpExpenseData").append(json);
                                                                    
                                                    }
                                                 })
                                        
                        };
                    </script>
                    
                    <script type="text/javascript">
                       $(function() { 
                        
                       $('#filter2-employees').change(function(){
                        $("#filterMyEmpExpenseData").empty();
                        var value;
                                        if($(this).val()=="0"){
                                            value="0";
                                        }else if($(this).val()=="2" ){
                                             value="2";
                                        }else if($(this).val()=="1"){
                                              value="1";
                                        }else if($(this).val()=="all"){
                                              value="all";
                                        }
                                         $.ajax({
                                                    url: "filterMyEmpExpenses.php",
                                                    type: "POST",
                                                    data: "ACTION=getFilteredData&filter2-employees="+value,
                                                    success: function(json){
                                                      $("#filterMyEmpExpenseData").append(json);
                                                                    
                                                    }
                                                 })
                                        
                                      });
                      });
                    </script>
                </table>
            </div>
            
     
            <div id="myTransactionTab" class="tab-pane fade"><center>
           
            <?php 
                    include 'connection.php';
                              $userId=$_SESSION['userid'];
                        $sql="select SUM(transactions) as sumBalance from wallet where user_id='$userId'";
                              $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()){
                                        if(empty($row['sumBalance']))
                                            $row['sumBalance']="0";

                                       echo "<p style='float:right;font:   18px Montserrat ;color:  #2a409f;'> Wallet Balance:  ".$row['sumBalance']."</p>";
                                            
                                        }
                                }             
                    ?><br>
            <hr />​
              <table class="table table-bordered table-hover table-condensed" style="table-layout: fixed; width: 1150px;  font-family: Montserrat ;">
                    

                    
                    <?php
                     
                              $user_id=$_SESSION['userid'];
                                $query = "Select * from wallet where user_id='$user_id'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    ?>
                                    <thead>
                                        <tr>
                                          <th>S.No.</th> 
                                          <th>Date</th>
                                          <th>Transaction</th>
                                          <th>Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                    <?php
                                    while ($row = $result->fetch_array()){
                                        
                                        $dateCreated=date_create($row['date']);
                                        $formattedDate=date_format($dateCreated, 'd-m-Y');
                    
                                        echo "<tr><td>".$index.".</td>
                                              <td align='left'>".$formattedDate."</td>
                                              <td align='left'>".$row['transactions']."</td>
                                              <td align='left'>".$row['remarks']."</td>";
                                        
                                                $index++;
                                    }
                                } else{
                                    echo " No entry in this table !";
                                }

                    ?>
                    </tbody>
                </table>
               </center>
            </div>
            <div id="newExpenseTab" class="tab-pane fade">
           
            <?php 
                    include 'connection.php';
                              $userId=$_SESSION['userid'];
                        $sql="select SUM(transactions) as sumBalance from wallet where user_id='$userId'";
                              $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_array()){
                                        if(empty($row['sumBalance']))
                                            $row['sumBalance']="0";

                                       echo "<p style='float:right;font:   18px Montserrat ;color:  #2a409f;'> Wallet Balance:    ".$row['sumBalance']."</p>";
                                            
                                        }
                                }             
                    ?><br>
                    <hr  />​
                    <center>
                 <form  action="action.php" method="POST" id="entry_form" name="entry_form" class="form-horizontal" enctype="multipart/form-data" style="no-margin center-block">
                      <div class="form-group">
                        <label class=" col-sm-3 control-label">Project</label>
                        <div class="col-sm-6">
                        <select class="form-control" id="project" name="project">
                        <option value="0" >--select--</option>
                            <?php
                                include 'connection.php';
                                $query = "SELECT * FROM projects where state='1' order by name";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option value=" .$rows['id']. ">" .$rows['name']. "</option>";
                                }
                            ?>     
                        </select>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label class=" col-sm-3 control-label">Category</label>
                        <div class="col-sm-6">
                        <select class="form-control" id="category" name="category">
                        <option value="0">--select--</option> 
                             <?php
                                include 'connection.php';
                                $query = "SELECT * FROM categories order by category";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option value=" .$rows['id']. ">" .$rows['category']. "</option>";
                                }
                             ?> 
                        </select>
                        </div>
                      </div>

            <div class="form-group">
                <label class=" col-sm-3 control-label" for="date">Date</label>
                <div class="col-sm-6 controls">
                    <div class="input-group">
                        <input id="date" type="text" class="form-control" name="date"  autocomplete="off" />
                        <label for="date" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class=" col-sm-3 control-label" for="amount">Amount</label>
                <div class="col-sm-6">
                <input class="form-control" id="amount" type="number" name="amount" autocomplete="off">
                </div>
            </div>
          
            <div class="form-group">
                <label class=" col-sm-3 control-label" for="details">Details</label>
                <div class="col-sm-6">
                <textarea class="form-control" id="details" type="text" name="details" rows="3" autocomplete="off"></textarea>
                </div>
            </div>
                    
            <div class="form-group">
                <label class=" col-sm-3 control-label" for="payment">Mode Of Payment</label>
                <div class="col-sm-6">
                <select class="form-control" id="payment" name="payment" >
                    <option value="0">--select--</option>
                        <?php
                            include 'connection.php';
                            $query = "SELECT * FROM payment order by mode";
                            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                            while ($rows = mysqli_fetch_array($result)) {
                                echo "<option value=" .$rows['id']. ">" .$rows['mode']. "</option>";
                            }
                        ?> 
                </select>
                </div>
            </div>
            

        <div class="row">
            <div class="btn-group col-sm-6" id="bill">
                <label class="control-label  col-sm-6" for="bill">Bill</label>
                <div class="col-sm-4">
                <div class="radio-inline">
                    <label>
                    <input type="radio" name="bill" id="No" value="0" checked>
                    No
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                    <input type="radio" name="bill" id="Yes" value="1">
                    Yes
                    </label> 
                </div>
                </div>
            </div>
            
            <div class="form-group-inline col-sm-3" id="fileUpload" style="display: none">
                <input type="file" name="fileToUpload" id="fileToUpload"  />
            </div>
        </div> 
           <br>
           <center>
            <div class="form-group ">
                <button type="button-inline" id="submit-data-button" class="btn " >SUBMIT</button>
                <button type="button-inline" id="cancel-user-button" class="btn " >CANCEL</button>    
                
            </div>
            </center>
          </form></center>
            </div>
           
        </div>
    </div>
</div>



    
</body>

    <script type="text/javascript">

    $(document).ready(function(){
        // $("#empBars").load("empBars.html");

        document.getElementById("login_user_name").prepend(localStorage.getItem('name'));
            $("#expenses").click(function(e) {
          window.location.href="empExpenses.php";
        });
              $("#leaves").click(function(e) {
          window.location.href="empLeaves.php";
        });
                $("#assets").click(function(e) {
          window.location.href="empAssets.php";
        });
                  $("#reportees").click(function(e) {
          window.location.href="empReportees.php";
        });

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeEmpExpenseTabs', $(e.target).attr('href'));
        });
        var activeEmpExpenseTabs = localStorage.getItem('activeEmpExpenseTabs');
        if(activeEmpExpenseTabs){
            $('#myTab a[href="' + activeEmpExpenseTabs + '"]').tab('show');
        }
            
        if(localStorage.getItem('filter2-employees')){
              $('#filter2-employees').val(localStorage.getItem('filter2-employees'));
          }

          $('#filter2-employees').change(function(){
              localStorage.setItem('filter2-employees',$('#filter2-employees').val() );   
          });


          var userid=localStorage.getItem('user_id');
       

        $(":radio:eq(1)").click(function(){
             $("#fileUpload").show(500);
          });

          $(":radio:eq(0)").click(function(){
             $("#fileUpload").hide(500);
          });

        
        $("#submit-data-button").click(function(e) {
                e.preventDefault();
                var project = $("#project").val();
                var category = $("#category").val();
                var amount = $("#amount").val();
                var details = $("#details").val();
                var payment = $("#payment").val();
                var bill = $('#bill input:radio:checked').val();
                var date = $("#date").val();

                 //getting form into Jquery Wrapper Instance to enable JQuery Functions on form                    
                var form = $("#entry_form");

                //Serializing all For Input Values (not files!) in an Array Collection so that we can iterate this collection later.
                var params = form.serializeArray();

                //Getting Files Collection
                var files = $("#fileToUpload")[0].files;
               // alert(files);

                //Declaring new Form Data Instance  
                var formData = new FormData();

                //Looping through uploaded files collection in case there is a Multi File Upload. This also works for single i.e simply remove MULTIPLE attribute from file control in HTML.  
                for (var i = 0; i < files.length; i++) {
                    formData.append('fileToUpload', files[i]);
                }

                //Now Looping the parameters for all form input fields and assigning them as Name Value pairs. 
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });



                if ( amount == '' || details == '' ) {
                    alert("Please fill the empty fields!");
                }else if( date == ""){
                    alert("Please select date!");
                }else if(project=="0"){
                    alert("Please select appropriate project.");
                } else if ( category=="0"){
                    alert("Please select appropriate category.");
                }else if(payment=="0"){
                    alert("Please select appropriate payment mode.");
                }else {
                    var token=localStorage.getItem('token');
                    formData.append('token', token);
                    formData.append('ACTION','submitdata');
                    
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                    //    data: "ACTION=submitdata&PROJECT="+project+"&CATEGORY="+category+"&AMOUNT="+amount+"&DETAILS="+details+"&BILL="+bill+"&PAYMENT="+payment+"&TOKEN="+token+"&DATE="+date,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            if(data=="1") {
                                alert ("Your data is submitted!");
                                $('#entry_form')[0].reset();
                                window.location.reload();
                            } else if(data=="0") {
                               
                                window.location.href="index.php";
                                alert("you are logged out! Please log in!");
                            }else if(data=="2"){
                                alert("try again! your id is not defined.");
                            }
                             
                        }
                    })
                }
            });
            
     
            
        $("#cancel-user-button").click(function(e){
                e.preventDefault();
                $('#entry_form')[0].reset();                                   
            });
            
        $('#logout-button').click(function() {
              localStorage.removeItem('filter-assets');
              localStorage.removeItem('name');
              localStorage.removeItem('token');   
              localStorage.removeItem('email');
              localStorage.removeItem('user_id');
              localStorage.removeItem('activeEmpExpenseTabs');
              localStorage.removeItem('activeEmpLeavesTabs');
              localStorage.removeItem('activeCollapsibleTab');
              localStorage.removeItem('activeEmpReporteesTabs');
              localStorage.removeItem('filter2-employees');
          });
            
     
                            
    });

    function removeRecord(dataId){
            var r = confirm("Are you sure you want delete this entry?");
                        if (r == true) {
                            $.ajax({
                                        url: "removeEntry.php",
                                        type: "POST",
                                        data: "ACTION=delete&dataId="+dataId,
                                        success: function(data){
                                            window.location.reload();
                                        }
                                    })
                        }
                       
        }
   
    </script>
<!--<script type="text/javascript" src="empBars.js"></script>-->

</html>                                        