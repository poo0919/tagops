<?php
include_once('database.php');
include 'empSession.php';
$conn = getDB();

if($_POST['ACTION']=="delete"){
  if(isset($_POST['dataId'])){
    $dataId=$_POST['dataId'];
    $query="DELETE FROM data WHERE id='$dataId' ";
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
      echo 1;
  }
}
  
if($_POST['ACTION']=='submitdata'){  // data from userEntry form
  $proj_id=$_POST['project'];
  $amount=$_POST['amount'];  
  $cat_id=$_POST['category'];
  $details=mysqli_real_escape_string($conn,$_POST['details']); 
  $bill=$_POST['bill'];
  $pay_id=$_POST['payment'];
  $token=$_POST['token'];
  $date=$_POST['date'];

  $user_id="";
  $user_id=$_SESSION['userid'];

  if(empty($user_id)){
    echo "2"; exit();
  }
  
  // if file is sent for uploading 
  if(isset($_FILES["fileToUpload"])){
    $target_dir = "./uploads/";
    if(!is_dir($target_dir)){
      mkdir($target_dir);
    }
    $target_file = $target_dir .uniqid()."_".basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10485760) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    // Allow certain file formats
    if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "pdf" ) {
      echo "Sorry, only JPG, JPEG, PNG, GIF & pdf files are allowed.";
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $query = "INSERT INTO data (user_id,project_id,amount,details,category_id,payment_id,bill,date,file) VALUES ('$user_id','$proj_id','$amount','$details','$cat_id','$pay_id','$bill','$date','".$target_file."')";
        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
        if ($result === TRUE) {
          echo "1";
        }else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }else {
    //if there is no file to upload
    $query = "INSERT INTO data (user_id,project_id,amount,details,category_id,payment_id,bill,date) VALUES ('$user_id','$proj_id','$amount','$details','$cat_id','$pay_id','$bill','$date')";
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result === TRUE) {
      echo "1";
    }else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }  
  exit();
}

if($_POST['ACTION']=="getFilteredData"){
  $echoData="";
  if(!isset($_POST['filter2-employees']) || $_POST['filter2-employees']=='all'){
      $user_id=$_SESSION['userid'];
      $query = "Select id,project_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where user_id='$user_id'";
      $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
      if ($result->num_rows > 0) {
          $index=1;
          $echoData.="<thead style='background: #e1e1e1;'>
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
                                    $echoData.=  "<span onclick='removeRecord(".$row['id'].")' style='color: black;cursor:pointer;'><i class='fa fa-trash'></i></span>";

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
}
?>