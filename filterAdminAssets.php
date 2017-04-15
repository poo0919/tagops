<?php

include 'connection.php';
$echoData="";
               

        if(isset($_POST['filter3-assets']) && $_POST['filter3-assets']!="all"){
    
          $filter=$_POST['filter3-assets'];
          $query = "Select * from inventory where type='$filter'";
          $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
          if ($result->num_rows > 0) {
              $index=1;
              $echoData.= "<thead><tr>
                                            <th>S.no</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Owner</th>
                                            <th>Rental Company</th>
                                            <th>Status</th>
                                            <th>Given To</th>
                                            <th>Action</th>
                                            <th>Update</th>
                                          </tr></thead><tbody>";
              while ($row = $result->fetch_array()){
                                                
                  $type_id=$row['type'];
                  $q1="select asset_name from asset_type where id='$type_id'";
                  $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                  $r1=$rs1->fetch_array();

                  if($row['owner']=="Rent"){
                      $rent_id=$row['rental_company'];
                      $q2="select rental_company_name from rental_companies where id='$rent_id'";
                      $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                      $r2=$rs2->fetch_array();
                      $rentCompany=$r2['rental_company_name'];                                    
                  }else{
                      $rentCompany="NA";
                  }
     
                  $user_id=$row['assigned_to'];
                  $q3="select name from user where id=$user_id";
                  $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                  $r3=$rs3->fetch_array();
                  $name=$r3['name'];

                  $status=$row['status'];
                  if($status=="1"){
                      $status="Free";
                      $name="No one.";
                  }else if($status=="2"){
                      $status="Given";
                  }else if($status=="3"){
                      $status="Assigned";
                  }else if($status=="4"){
                      $status="Returned";
                  }
                                        
                      
                      $echoData.= "<tr><td>".$index."</td>
                                  <td align='left'>".$r1['asset_name']."</td>
                                  <td align='left'>".$row['description']."</td>
                                  <td align='left'>".$row['price']."</td>
                                  <td align='left'>".$row['owner']."</td>
                                  <td align='left'>".$rentCompany."</td>
                                  <td align='left'>".$status."</td>
                                  <td align='left'>".$name."</td><td>";

                                  if($status=="Given" || $status=="Assigned"){
                                      $echoData.=  "No Action";
                                  }else if($status=="Free"){
                                      $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                  }else if($status=="Returned"){
                                      $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                  }

                                  $echoData.=    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td></td><tr>";
                                    $index++;
                    }
                    echo $echoData;
                  }else{
                    echo "<h4> No entry in this table ! <h4>";
                  }
          }               

        if(($_POST['filter1-assets']=="all") && ($_POST['filter2-assets']=="all") && ($_POST['filter3-assets']=="all")){

            $echoData.= "<thead><tr>
                            <th>S.no</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Owner</th>
                            <th>Rental Company</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                            <th>Update</th>
            </tr>/thead><tbody>";

            $query = "Select * from inventory";
            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result->num_rows > 0) {
                      $index=1;
                      while ($row = $result->fetch_array()){
                                                      
                          $type_id=$row['type'];
                          $q1="select asset_name from asset_type where id='$type_id'";
                          $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                          $r1=$rs1->fetch_array();

                              if($row['owner']=="Rent"){
                  
                                  $rent_id=$row['rental_company'];
                                  $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                  $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                  $r2=$rs2->fetch_array();
                                  $rentCompany=$r2['rental_company_name'];                                    
                              }else{
                                  $rentCompany="NA";
                              }

                              $user_id=$row['assigned_to'];
                              $q3="select name from user where id=$user_id";
                              $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                              $r3=$rs3->fetch_array();
                              $name=$r3['name'];
                              $status=$row['status'];
                              if($status=="1"){
                                  $status="Free";
                                  $name="No one.";
                              }else if($status=="2"){
                                  $status="Given";
                              }else if($status=="3"){
                                  $status="Assigned";
                              }else if($status=="4"){
                                  $status="Returned";
                              }
                              
                  $echoData.= "<tr><td>".$index."</td>
                                          <td align='left'>".$r1['asset_name']."</td>
                                          <td align='left'>".$row['description']."</td>
                                          <td align='left'>".$row['price']."</td>
                                          <td align='left'>".$row['owner']."</td>
                                          <td align='left'>".$rentCompany."</td>
                                          <td align='left'>".$status."</td>
                                          <td align='left'>".$name."</td><td>";

                              if($status=="Given" || $status=="Assigned"){
                                  $echoData.=  "No Action";
                              }else if($status=="Free"){
                                  $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                              }else if($status=="Returned"){
                                  $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                              }

                              $echoData.=  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."'data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";

                              $index++;
                      }
                      echo $echoData;
                  } else{
                      echo "<h4> No entry in this table ! <h4>";
                  }

        } else if(($_POST['filter1-assets']=="company")){

            $echoData.= "<thead><tr>
                            <th>S.no</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Owner</th>
                            <th>Rental Company</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                            <th>Update</th>
                        </tr></thead><tbody>";
            
            $filter=$_POST['filter1-assets'];
                if($filter=="rent")
                    $query = "Select * from inventory where owner='$filter'";
                else
                    $query = "Select * from inventory where owner NOT LIKE 'Rent'";
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                    $index=1;
                    while ($row = $result->fetch_array()){
                                                
                        $type_id=$row['type'];
                        $q1="select asset_name from asset_type where id='$type_id'";
                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                        $r1=$rs1->fetch_array();
                        if($row['owner']=="Rent"){
                            $rent_id=$row['rental_company'];
                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                            $r2=$rs2->fetch_array();
                            $rentCompany=$r2['rental_company_name'];                                    
                        }else{
                            $rentCompany="NA";
                        }

                        $user_id=$row['assigned_to'];
                        $q3="select name from user where id=$user_id";
                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                        $r3=$rs3->fetch_array();
                        $name=$r3['name'];

                        $status=$row['status'];
                        if($status=="1"){
                            $status="Free";
                            $name="No one.";
                        }else if($status=="2"){
                            $status="Given";
                        }else if($status=="3"){
                            $status="Assigned";
                        }else if($status=="4"){
                            $status="Returned";
                        }
                        
            $echoData.= "<tr><td>".$index."</td>
                                    <td align='left'>".$r1['asset_name']."</td>
                                    <td align='left'>".$row['description']."</td>
                                    <td align='left'>".$row['price']."</td>
                                    <td align='left'>".$row['owner']."</td>
                                    <td align='left'>".$rentCompany."</td>
                                    <td align='left'>".$status."</td>
                                    <td align='left'>".$name."</td><td>";

                        if($status=="Given" || $status=="Assigned"){
              $echoData.=  "No Action";
                        }else if($status=="Free"){
                            $echoData.=  "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                        }else if($status=="Returned"){
                            $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                        }

                        $echoData.=  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."'data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                        
            $index++;
                    }
                    
          echo $echoData;
                } else{
                    echo "<h4> No entry in this table ! <h4>";
                }

        }else if(($_POST['filter1-assets']=="rent")){

            $echoData.= "<thead><tr>
                            <th>S.no</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Owner</th>
                            <th>Rental Company</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                            <th>Update</th>
                        </tr></thead><tbody>";

            $filter=$_POST['filter1-assets'];
            if($filter=="rent")
                $query = "Select * from inventory where owner='$filter'";
            else
                $query = "Select * from inventory where owner NOT LIKE 'Rent'";

            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result->num_rows > 0) {
                $index=1;
                while ($row = $result->fetch_array()){
                                                
                    $type_id=$row['type'];
                    $q1="select asset_name from asset_type where id='$type_id'";
                    $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                    $r1=$rs1->fetch_array();

                    if($row['owner']=="Rent"){
                        $rent_id=$row['rental_company'];
                        $q2="select rental_company_name from rental_companies where id='$rent_id'";
                        $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                        $r2=$rs2->fetch_array();
                        $rentCompany=$r2['rental_company_name'];                                    
                    }else{
                        $rentCompany="NA";
                    }

                    $user_id=$row['assigned_to'];
                    $q3="select name from user where id=$user_id";
                    $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                    $r3=$rs3->fetch_array();
                    $name=$r3['name'];

                    $status=$row['status'];
                    if($status=="1"){
                        $status="Free";
                        $name="No one.";
                    }else if($status=="2"){
                        $status="Given";
                    }else if($status=="3"){
                        $status="Assigned";
                    }else if($status=="4"){
                        $status="Returned";
                    }

                    $echoData.= "<tr><td>".$index."</td>
                <td align='left'>".$r1['asset_name']."</td>
                                <td align='left'>".$row['description']."</td>
                                <td align='left'>".$row['price']."</td>
                                <td align='left'>".$row['owner']."</td>
                                <td align='left'>".$rentCompany."</td>
                                <td align='left'>".$status."</td>
                                <td align='left'>".$name."</td><td>";

                    if($status=="Given" || $status=="Assigned"){
                        $echoData.=  "No Action";
                    }else if($status=="Free"){
                        $echoData.=  "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                    }else if($status=="Returned"){
                        $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                    }
          
                    $echoData.=  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                    
          $index++;
                }
                echo $echoData;
            } else{
                echo "<h4> No entry in this table ! <h4>";
            }
        }
                      
            
        if(isset($_POST['filter2-assets']) && $_POST['filter2-assets']!="all"){
    
                $filter=$_POST['filter2-assets'];
                     
                            $query = "Select * from inventory where status='$filter'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }
     
                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];

                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }
                                        
                                        if($status=="Given"){
                                            if($index==1) //checking for index 1 to laod the table-headers
                                            {
                                              $echoData.= "
                                                    <thead>
                                                      <tr>
                                                          <th>S.no</th>
                                                          <th>Type</th>
                                                          <th>Description</th>
                                                          <th>Price</th>
                                                          <th>Owner</th>
                                                          <th>Rental Company</th>
                                                          <th>Status</th>
                                                          <th>Given To</th>
                                                          <th>Action</th>
                                                          <th>Update</th>
                                                      </tr>
                                                    </thead>
                                                <tbody>";
                                            }

                                              $echoData.= "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['price']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  $echoData.=  "No Action";
                                              }else if($status=="Free"){
                                                  $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                              $echoData.=    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td></td><tr>";

                                        }else if($status=="Assigned" ){
                                              if($index==1)   //checking for index 1 to laod the table-headers
                                                {
                                                  $echoData.= "
                                                        <thead>
                                                          <tr>
                                                              <th>S.no</th>
                                                              <th>Type</th>
                                                              <th>Description</th>
                                                              <th>Price</th>
                                                              <th>Owner</th>
                                                              <th>Rental Company</th>
                                                              <th>Status</th>
                                                              <th>Assigned To</th>
                                                              <th>Action</th>
                                                              <th>Update</th>
                                                          </tr>
                                                        </thead>
                                                  <tbody>";
                                                }

                                          $echoData.= "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['price']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  $echoData.=  "No Action";
                                              }else if($status=="Free"){
                                                  $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                      $echoData.=   "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td></td><tr>";

                                        }else if($status=="Returned"){
                                              if($index==1){  //checking for index 1 to laod the table-headers
                                                $echoData.= "
                                                      <thead>
                                                      <tr>
                                                          <th>S.no</th>
                                                          <th>Type</th>
                                                          <th>Description</th>
                                                          <th>Price</th>
                                                          <th>Owner</th>
                                                          <th>Rental Company</th>
                                                          <th>Status</th>
                                                          <th>Returned By</th>
                                                          <th>Action</th>
                                                          <th>Update</th>
                                                      </tr>
                                                      </thead>
                                                    <tbody>";                                          
                                              }


                                          $echoData.= "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['price']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  $echoData.=  "No Action";
                                              }else if($status=="Free"){
                                                  $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                          $echoData.=    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";

                                  }else if ($status=="Free") {
                                              if($index==1)   //checking for index 1 to laod the table-headers
                                                {
                                                  $echoData.= "<thead>
                                                          <tr>
                                                            <th>S.no</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Price</th>
                                                            <th>Owner</th>
                                                            <th>Rental Company</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <th>Update</th>
                                                          </tr>
                                                        </thead>
                                                  <tbody>";
                                                }

                                          $echoData.= "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['price']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  $echoData.=  "No Action";
                                              }else if($status=="Free"){
                                                  $echoData.=   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                      $echoData.=    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                  }
                                    $index++;
                              }
                              echo $echoData;
                          } else{
                                    echo "<h4> No entry in this table ! <h4>";
                            }
    }


?>