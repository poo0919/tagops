<?php

include 'connection.php';
include 'empSession.php';
$echoData="";
                              
            if(!isset($_POST['filter-assets']) || $_POST['filter-assets']=="0"){
                              $user_id=$_SESSION['userid']; 
                                $query = "Select * from inventory where assigned_to='$user_id' AND status NOT LIKE '1'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    $echoData.="<thead>
                                    <tr>
                                      <th>S.No.</th> 
                                      <th>Type</th>
                                      <th>Description</th>
                                      <th>Price</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id' ";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();
                                 
                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        
                                        $echoData.= "<tr><td>".$index.".</td>
                                              <td >".$r1['asset_name']."</td>
                                              <td >".$row['description']."</td>
                                              <td >".$row['price']."</td>
                                              <td >".$status."</td>";

                                              if($status=="Given"){

                                                  $echoData.=  "<td ><button id='changebtn".$index."' onclick='acceptUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #7cc576; color:'#ffffff'>Accept</button></td>";

                                              }else if($status=="Assigned"){

                                                $echoData.= "<td ><button id='changebtn".$index."' onclick='returnAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #ec585d;color='#ffffff'>Return</button></td>";

                                              }else if($status=="Returned"){

                                                 $echoData.= " <td >No Action</td>";

                                              }

                                     $echoData.=    "</tr>";

                                          $index++;
                                    }
                                    echo $echoData;
                            exit();
                                } else{
                                    echo " No entry in this table !";
                            }
                          //  $echoData.="</tbody>";
                            

                  }else if(isset($_POST['filter-assets'])){
               
                                $filter=$_POST['filter-assets'];
                              $user_id=$_SESSION['userid'];
                            $query = "Select * from inventory where assigned_to='$user_id' AND status='$filter'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    $echoData.="<thead>
                                      <tr>
                                        <th>S.No.</th> 
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                      </thead>
                                      <tbody>";
                                    while ($row = $result->fetch_array()){
                              
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();
        
                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }


        
                    
                                       $echoData.= "<tr><td>".$index.".</td>
                                              <td >".$r1['asset_name']."</td>
                                              <td >".$row['description']."</td>
                                              <td >".$row['price']."</td>
                                              <td >".$status."</td>";

                                              if($status=="Given"){

                                                 $echoData.=  "<td ><button id='changebtn".$index."' onclick='acceptUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #7cc576; color='#ffffff'>Accept</button></td>";

                                              }else if($status=="Assigned"){

                                                $echoData.=  "<td ><button id='changebtn".$index."' onclick='returnAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #ec585d;color='#ffffff'>Return</button></td>";

                                              }else if($status=="Returned"){

                                                  $echoData.= " <td >No Action</td>";

                                              }

                                   $echoData.=   "</tr>";
                                                $index++;
                                    }
                                    echo $echoData;
                            exit();
                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                            }
                          //  $echoData.="</tbody>";
                            


                        }

                    
                        ?>