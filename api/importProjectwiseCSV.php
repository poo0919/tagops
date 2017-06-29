<?php
//api for feching reimbursement data from  csv and adding to db
include_once('database.php');
$conn = getDB();

if(isset($_POST['importSubmit'])){
    $project_id=$_POST['project_id'];
    
    //validate whether uploaded file is a csv file
    $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            //skip two lines
            fgetcsv($csvFile);
            fgetcsv($csvFile);

            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
               $q1="select id from user where email='$line[7]' ";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows <=0) {
                    $qstring='?status=mail';
                    header("Location: ../adminExpenseManagement.php".$qstring);
                    exit();
                }
				$ro1=$re1->fetch_array();
		

				$q3="select id from categories where category='$line[3]' ";
                $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                
				$ro3=$re3->fetch_array();

				$q4="select id from payment where mode='$line[4]' ";
                $re4=mysqli_query($conn,$q4)or die(mysqli_error($conn));
				$ro4=$re4->fetch_array();

				$reimbursed=$line[6];
                if($reimbursed=="submitted"){
                    $reimbursed="0";
                }else if($reimbursed=="approved"){
                    $reimbursed="1";
                } else if($reimbursed=="rejected") {
                    $reimbursed="2";
                }               

                if($line[5]=="Yes")
                    $bill="1";
                else
                    $bill="0";
                                
                    $conn->query("INSERT INTO data (user_id,project_id,amount,date,details,category_id,payment_id,bill,reimbursed) VALUES ('$ro1[id]','$project_id','".$line[0]."','".$line[1]."','".$line[2]."','$ro3[id]','$ro4[id]','$bill','$reimbursed ') ");
         
            }
            
            //close opened csv file
            fclose($csvFile);

            $qstring = 'success';
        }else{
            $qstring = 'error';
        }
    }else{
        $qstring = 'invalid_file';
    }
    // $qstring;
}

//redirect to the listing page
echo $qstring;
?>