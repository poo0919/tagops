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
<link rel="stylesheet" href="editable.css">
</head>

<body style="background-image: url(back12.jpg);">


<?php 
include 'adminBars.php';
?>

    
<div class="container" id="midNav" "> 
    <div class="spacer"></div>

       <div id="tab_employees" class="well "  >

            <section>
            <!--List of all employees with their avaiable leaves comp off as nested list -->
                <div style="text-align: center"><h1>Leave Management</h1></div>
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>Record</th>
                                    <th>Employee</th>
                                    <th>CL+PL+ML</th>
                                    <th>Comp Off</th>
                                    <th>RH</th>
                                    <th>Total Leaves</th>
                                    <th></th>                 
                                                  
                                  </tr>
                                </thead>

                                <tbody>
                                <?php

                                
                                    $q1="select * from user where status='1' order by name ";
                                    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                    if ($re1->num_rows > 0) {
                                        $index=1;
                                        while($ro1 = $re1->fetch_array()){          
                                            $user_id=$ro1['id'];

                                            $q2="select * from leaves where user_id='$user_id'";
                                            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2->num_rows > 0) {
                                                while($ro2 = $re2->fetch_array()){
                                                          //pl cl leaves table
                                                          $total=$ro2['pl_cl_ml']+$ro2['comp_off']+$ro2['rh'];
                                                  echo "
                                                      <tr  style='background: white;' class='edit_tr'>
                                                        <td><button id='leavesButton".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2(".$ro1['id'].")  data-id='".$ro1['id']."' data-name='".$ro1['name']."'><span class='glyphicon glyphicon-th-list'></span></button></td>
                                                        <td>".$ro1['name']."</td>
                                                        <td class='edit_td' id='".$ro2['id']."'>
                                                            <span id='first_".$ro2['id']."' class='text'>".$ro2['pl_cl_ml']."</span>
                                                            <input type='text' value='".$ro2['pl_cl_ml']."' class='editbox' id='first_input_".$ro2['id']."' style='display:none;'>
                                                        </td>
                                                        <td>".$ro2['comp_off']."</td>
                                                        <td>".$ro2['rh']."</td>
                                                        <td >".$total."</td>
                                                        <td class='accordion-toggle ' data-toggle='collapse' data-target='#a".$index."' ><span class='glyphicon glyphicon-chevron-down'></span></td>
                                                        
                                                      </tr>";
                                                }
                                            }
                                            //nested comp off list
                                     echo     "   <tr>
                                                      <td></td><td></td><td></td><td></td><td></td><td></td>
                                                        <td class='accordion-body collapse' id='a".$index."'>
                                                          <table class='table table-striped table-hover table-condensed'>
                                                            <thead>
                                                              <th>#</th>
                                                              <th>Against Date</th>
                                                              <th>Expiry</th>
                                                              <th>Reason</th>
                                                              <th>Status</th>
                                                              
                                                            </thead>
                                                            <tbody>
                                                            ";


                                            $q3="select * from leave_data where user_id='$user_id' AND type_id='2' ";
                                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            if ($re3->num_rows > 0) {
                                              $in=1;
                                                while($ro3 = $re3->fetch_array()){
                                                          //comp off table
                                                            if($ro3['status']=="3"){
                                                                $status="Available";
                                                            }else if($ro3['status']=="4"){
                                                                $status="Used";
                                                            }else if($ro3['status']=="5"){
                                                                $status="Expired";
                                                            }else if($ro3['status']=="1"){
                                                                $status="Applied";
                                                            }

                                                            $dateCreated1=date_create($ro3['against_date']);
                                                            $formattedAgainstDate=date_format($dateCreated1, 'd-m-Y');
                                                            $dateCreated2=date_create($ro3['expiry_date']);
                                                            $formattedExpiryDate=date_format($dateCreated2, 'd-m-Y');

                                                    echo "<tr>
                                                                <td>".$in."</td>
                                                                <td>".$formattedAgainstDate."</td>
                                                                <td>".$formattedExpiryDate."</td>
                                                                <td>".$ro3['reason']."</td>
                                                                <td>".$status."</td>

                                                              </tr> ";
                                                              $in++;
                                                }
                                            }
                                        echo   "  </tbody>
                                                          </table>
                                                        </td>
                                                      </tr>
                                                        ";

                                              $index++;
                                        }
                                    }

                                ?>

                                </tbody>
                              </table>

                              <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <h4 class="modal-title" id="exampleModalLabel1"> </h4>
                                          </div>
                                          <div class="modal-body">
                                              <table class="table table-condensed" id="tableItems">
                                                
                                                </table>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <script type="text/javascript">
                             

                                  function modalFunction2(userId){
                                      $("#tableItems").empty();
                                     
                                       $("#exampleModal2").on("show.bs.modal", function (event){
                                            var button = $(event.relatedTarget);
                                            var id = button.data('id');
                                            var name = button.data('name');

                                            var modal = $(this);
                                            modal.find('.modal-title').text('Leave Record of: '+name);
                                           // $('#exampleModal2').find('input#id').val($(event.relatedTarget).data('id'));

                                            

                                      
                                       });
                                       $.ajax({
                                                    url: "getLeaveRecord.php",
                                                    type: "POST",
                                                    data: "ACTION=getdata&ID="+userId,
                                                    success: function(json){
                                                        var response=JSON.parse(json);
                                                        
                                                        var tableHeader="";
                                                        for(i=0;i<response.header.length;i++){
                                                            tableHeader+="<th>"+response.header[i]+"</th>";
                                                        }
                                                        tableHeader="<thead><tr>"+tableHeader+"</tr></thead>";
                                                        var tableBody="";
                                                        
                                                        var rowsLen=response.rows.length;

                                                        for(i=0;i<rowsLen;i++){
                                                            var tableRow="";
                                                                for(j=0;j<response.rows[i].length;j++){
                                                                    tableRow=tableRow+"<td>"+response.rows[i][j]+"</td>";
                                                           
                                                                }
                                                              tableBody+="<tr>"+tableRow+"</tr>";
                                                        }  

                                                        tableBody="<tbody>"+tableBody+"</tbody>";
                                                        $("#tableItems").append(tableHeader+tableBody);
                                                                                   
                                                    }
                                                 })
                                        
                                       
                                  }
                              </script>
            </section>
   
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



$(".edit_td").click(function()
{
    var ID=$(this).attr('id');
    $("#first_"+ID).css("display","none")
    $("#first_input_"+ID).css("display","block")
}).change(function()
{
    var ID=$(this).attr('id');
    var first=$("#first_input_"+ID).val();
    var dataString = 'id='+ ID +'&first='+first;

    if(first.length>0)
    {

    $.ajax({
    type: "POST",
    url: "cl_pl_ml_edit_ajax.php",
    data: dataString,
    cache: false,
    success: function(data)
    {
      if(data==1)
    {
      alert("success");
      window.location.reload();
      }  
    
    }
    });
    }
    else
    {
    alert('Enter something.');
    }

});

// Edit input box click action
$(".editbox").mouseup(function() 
{
return false
});




// Outside click action
$(document).mouseup(function()
{
$(".editbox").css("display","none")
$(".text").css("display","block")
});

        localStorage.removeItem('filter-projects');
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