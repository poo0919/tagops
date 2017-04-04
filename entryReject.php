<?php
//api for rejecting the entry filled for reimbursement
include 'connection.php';
include 'session.php' ;

if($_POST['ACTION']=="change"){

    $dataId=$_POST['id'];

    $query="select reimbursed from data where id='$dataId'";
    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){
            $reim=$row1['reimbursed'];
            if($reim=="0"){

                            $change="2";
                            $q3="UPDATE data SET reimbursed='$change' WHERE id='$dataId' ";
                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                
                            if ($re3 === TRUE) {
                                echo "1";                  
                            }else {
                            echo "2";
                            }
             
            }else if($reim=="1"){
                            echo "3";
            }else if($reim=="2"){
                echo "4";
            }  


        
        }
    }
                                       
                                    
}
?>