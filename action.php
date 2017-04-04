<?php 
  
//API for various actions

include 'connection.php';
                          
                                                       
  if($_POST['ACTION']=="register"){  // register new user
       
       // get details from form submitted
       $name=$_POST['NAME'];
       $email=$_POST['EMAIL'];
       $password=$_POST['PASSWORD']; 
       $authCode=$_POST['AUTH'];
         
        // check if auth code entered is valid or not
        $query="select * from authorised where email='$email' AND code='$authCode' AND status='1'";
        $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
        $row = $result->fetch_array();
        $row_cnt = mysqli_num_rows($result); 
        if ($row_cnt==1) {

          $password=md5($password);
          //add new user details to user table 
          $sql = "INSERT INTO user (name,email,password) VALUES ('$name','$email','$password')";
          if ($result=mysqli_query($conn,$sql)) {

              $q1 = "SELECT id FROM user where email='$email'";
              $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
              $id="";
              if ($re1->num_rows > 0) {
                  while($ro1 = $re1->fetch_array()){
                      $id = $ro1['id'];
                  }
              }

              //on new user register -> add a row for his/her leaves in leaves table 
              $q2 = "INSERT INTO leaves (user_id,pl_cl_ml,comp_off) VALUES ('$id','33','0')";
              mysqli_query($conn,$q2)or die(mysqli_error($conn));
              echo "1";

          }else {                                                                   
              echo 0;
          } 

        }else echo "2";

       exit();
  }        
   
   
   
   if($_POST['ACTION']=="loginUser"){ // login a normal user
                                 
       $email=$_POST['EMAIL'];
       $password=$_POST['PASSWORD']; 

       $password=md5($password);     
       //check if the user has right credentials    
       $query="SELECT id,name,email, password, status FROM user WHERE email='$email' AND password='$password' AND (status='1')";  //check for status if user is allowed to login or not
       $result = mysqli_query($conn, $query)or die(mysqli_error($conn));
       $row = $result->fetch_array();
       
       $row_cnt = mysqli_num_rows($result);        
       if ($row_cnt==1) {
            
                $token=uniqid();
                $query="UPDATE user SET token='$token' WHERE email='".$email."' "; // add token for login
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                $name=$row['name'];
                $user_id=$row['id'];
                $login_credentials=array("token"=>$token, "name"=>$name,"user_id"=>$user_id); // send token, name and user_id as response for storing in local storage
                if ($result === TRUE) {
                  session_start();
                    $_SESSION['emp_email']=$email;
                    $_SESSION['userid']=$user_id;
                    echo json_encode($login_credentials);;                  
                }else {
                    echo "2";
                } 
            
       }else{
           echo "0";      
       }
             
       exit();
   }
   
   if($_POST['ACTION']=='submitdata'){  // data from userEntry form

         $proj_id=$_POST['project'];
         $amount=$_POST['amount'];  
         $cat_id=$_POST['category'];
         $details=$_POST['details']; 
         $bill=$_POST['bill'];
         $pay_id=$_POST['payment'];
         $token=$_POST['token'];
         $date=$_POST['date'];

         $user_id="";
      //   $query="Select * from user where token='$token'";  //fetch user_id from db with token
      //   $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
      //   if(mysqli_num_rows($result)==1){
      //       $rows = mysqli_fetch_assoc($result);
      //       $user_id= $rows['id'];  
      //    }
         session_start();
         $user_id=$_SESSION['userid'];

         if(empty($user_id)){
          echo "2";
          exit();
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

                 //       echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

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
   


   if($_POST['ACTION']=="logout"){  //on press of logout button
       
       $token=$_POST['TOKEN'];
       $query="update user set token=NULL where token='$token'"; //remove token from db
       $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
       if ($result === TRUE) {
           echo "1";
       }else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }                                  
         exit();
   }
   
$conn->close();
?>