<?php
include 'connection.php';
// add new comp off entry in db for vaarious users
    if(isset($_POST['action'])){
        if(!empty($_POST['againstDate']) && !empty($_POST['reason']))
        {
            
                $againstDate=$_POST['againstDate'];
                $reason=$_POST['reason'];
                $userId=$_POST['userId'];
                $rpId=$_POST['rpId'];

                $comp_off="";
                $q1="select comp_off from leaves where user_id='$rpId'";  //getting number of comp_off available from leaves table in db
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                    while($ro1 = $re1->fetch_array()){
                        $comp_off=$ro1['comp_off'];
                    }
                }

                //getting reportee mail id 
                $rpMail="";
                $q3="SELECT email FROM user WHERE id='$rpId'";
                $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                if ($re3->num_rows > 0) {
                    while($ro3 = $re3->fetch_array()){
                        $rpMail=$ro3['email'];
                    }
                }
              

                $expiryDate=date('Y-m-d', strtotime("+3 months", strtotime($againstDate))); // calculating expiry date for comp off entry
                   
                     $sql = "INSERT INTO leave_data (user_id,type_id,against_date,expiry_date,reason,status) VALUES ('$rpId','2','$againstDate','$expiryDate','$reason','3')";
                       if ($result=mysqli_query($conn,$sql)) {

                            $comp_off+=1; //incrementing comp off on new comp off entry
                            $q2="update leaves set comp_off='$comp_off' where user_id='$rpId'"; // updating comp off value in leaves table 
                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                            if ($re2 === TRUE) {
                                echo $rpMail;
                                
                            }

                       }else {                                                                   
                           echo "0";
                       }      

        }else {
            echo "2";
        }
    }
    
    
?>