<?php
include 'connection.php';
include 'session.php' ;

//changing status of reimbursement from project wise details 

if($_POST['ACTION']=="change"){

    $dataId=$_POST['id'];

    $query="select amount,reimbursed,details,user_id,project_id from data where id='$dataId'";
    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){

            $details=$row1['details'];
            $projId=$row1['project_id'];
            $reim=$row1['reimbursed'];
            $amount=$row1['amount'];
            $user_id=$row1['user_id'];
            $today=date('Y-m-d');

            $sql="SELECT name FROM projects WHERE id='$projId'";
            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
            $projName="";
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()){
                        $projName=$row['name'];
                    }
                }

            if($reim=="0"){

                $remarks=$projName." -> ".$details;

                $q1="select SUM(transactions) as sumBalance from wallet where user_id='$user_id'";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                    while($ro1 = $re1->fetch_array()){
                            
                         //   echo $today." ";

                            $amount=(-1)*$amount;
                            $q2="INSERT into wallet (transactions,date,user_id,remarks) VALUES ('$amount','$today','$user_id','$remarks') ";
                            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                            if ($re2 === TRUE) {
                                             
                            }else {
                            echo "2";
                            }

                            $change="1";
                            $q3="UPDATE data SET reimbursed='$change' WHERE id='$dataId' ";
                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                
                            if ($re3 === TRUE) {
                             //   echo "1";                  
                            }else {
                            echo "3";
                            }
                          echo "1"; 

                    }
                }else {
                    echo "4";
                }
             
            }else{
                  echo "5"; 
            }

        }
    }
                                       
                                    
}
?>