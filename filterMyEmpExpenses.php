<?php
                    include 'connection.php';
                    include 'empSession.php';

                    $echoData="";
                              


                      if(!isset($_POST['filter2-employees']) || $_POST['filter2-employees']=='all'){
                              $user_id=$_SESSION['userid'];
                                $query = "Select id,project_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where user_id='$user_id'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    $echoData.="<thead style='background: #e1e1e1;''>
                                        <tr >
                                          <th >S.No.</th> 
                                          <th>Project</th>
                                          <th>Amount</th>
                                          <th>Date</th>
                                          <th>Details</th>
                                          <th>Category</th>
                                          <th>Payment Mode</th>
                                          <th>Bill</th>
                                          <th>View Bill</th>
                                          <th>Status</th>
                                          <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>";
                                    while ($row = $result->fetch_array()){
                                                
                                        $project_id=$row['project_id'];
                                        $q1="select name from projects where id=$project_id";
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
                    
                                        $echoData.= "<tr><td>".$index.".</td>
                                              <td >".$r1['name']."</td>
                                              <td >".$row['amount']."</td>
                                              <td >".$formattedDate."</td>
                                              <td >".$row['details']."</td>
                                              <td >".$r2['category']."</td>
                                              <td >".$r3['mode']."</td>
                                              <td >".$bill."</td>
                                              <td >";
                                               if(empty($row['file'])){
                                                $echoData.= "Not Uploaded";
                                              }else{
                                                $echoData.= "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }
                                              $echoData.= "</td>
                                              <td >".$reimbursed."</td>
                                      <td>";

                                    if($reimbursed=="Approved" || $reimbursed=="Rejected")
                                      $echoData.= "<span style='color:#a8a8a8;'><i class='fa fa-trash' ></i></span>";
                                    else
                                    $echoData.=  "<span onclick='removeRecord(".$row['id'].")' style='color: black;'><i class='fa fa-trash'></i></span>";

                                    $echoData.= "</td>
                                      <tr>";
                                                $index++;
                                    }
                                     echo $echoData;
                            exit();
                                } else{
                                   $echoData.= "<h4> No entry in this table ! <h4>";
                                }

                    }else if(isset($_POST['filter2-employees'])){
                          $filter=$_POST['filter2-employees'];
                              $user_id=$_SESSION['userid'];
                              $query = "Select id,project_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where user_id='$user_id' AND reimbursed='$filter' ";
             
                              $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                         
                              if ($result->num_rows > 0) {
                                  $index=1;
                                  $echoData.="<thead style='background: #e1e1e1;''>
                                      <tr >
                                        <th >S.No.</th> 
                                        <th>Project</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>Category</th>
                                        <th>Payment Mode</th>
                                        <th>Bill</th>
                                        <th>View Bill</th>
                                        <th>Status</th>
                                        <th>Delete</th>
                                      </tr>
                                      </thead>
                                      <tbody>";
                                  while ($row = $result->fetch_array()){
                                      
                                      $project_id=$row['project_id'];
                                      $q1="select name from projects where id=$project_id";
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

                                      $echoData.= "<tr><td>".$index."</td>
                                      <td align='left'>".$r1['name']."</td>
                                      <td align='left'>".$row['amount']."</td>
                                      <td align='left'>".$formattedDate."</td>
                                      <td align='left'>".$row['details']."</td>
                                      <td align='left'>".$r2['category']."</td>
                                      <td align='left'>".$r3['mode']."</td>
                                      <td align='left'>".$bill."</td>
                                              <td align='left'>";
                                               if(empty($row['file'])){
                                                $echoData.= "Not Uploaded";
                                              }else{
                                                $echoData.= "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }
                                              $echoData.= "</td>
                                              <td align='left'>".$reimbursed."</td>
                                      <td>";

                                    if($reimbursed=="Approved" || $reimbursed=="Rejected")
                                      $echoData.= "<span style='color:#a8a8a8;' ><i class='fa fa-trash' ></i></span>";
                                    else
                                    $echoData.= "<span onclick='removeRecord(".$row['id'].")' style='color: black;'><i class='fa fa-trash'></i></span>";

                                    $echoData.= "</td>
                                      <tr>";
                                      $index++;
                                  }
                                   echo $echoData;
                            exit();
                              }else{
                                  $echoData= "<h4> No entry in this table ! <h4>";
                              }

                        
                    }

                    ?>