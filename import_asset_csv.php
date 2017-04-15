<?php

//api for importing asset data from csv
include 'connection.php';
if(isset($_POST['importSubmit'])){
   

    $rentalCompanyId=""; $userId=""; $assetId="";
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

                if($line[6]=='0'){
                    $userId=0;
                }else{
                     $q1="select id from user where email='$line[5]' ";
                    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                    if ($re1->num_rows <=0) {
                        $qstring='?status=mail';
                        header("Location: adminPanelAssets.php".$qstring);
                        exit();
                    }
                    $ro1=$re1->fetch_array();
                    $userId=$ro1['id'];
                   
                }
		          
                  if($line[4]=='NA'){
                    $rentalCompanyId=0;
                }else{
                    $q2="select id from rental_companies where rental_company_name='$line[3]' ";
                    $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                    $ro2=$re2->fetch_array(); 
                    $rentalCompanyId=$ro2['id'];
                }

				$q3="select id from asset_type where asset_name='$line[0]' ";
                $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
				$ro3=$re3->fetch_array();
                $assetId=$ro3['id'];

				$status=$line[5];
                if($status=="Free"){
                    $status="1";
                }else if($status=="Given"){
                    $status="2";
                } else if($status=="Assigned") {
                    $status="3";
                } else if($status=="Returned") {
                    $status="4";
                }               
                              
        //    $conn->query("INSERT INTO inventory (type,description,price,owner,rental_company,status,assigned_to) VALUES ('$assetId','".$line[1]."','".$line[2]."','".$line[3]."','$rentalCompanyId','$status','$userId') ");
         
         $query="INSERT INTO inventory (type,description,price,owner,rental_company,status,assigned_to) VALUES ('$assetId','".$line[1]."','".$line[2]."','".$line[3]."','$rentalCompanyId','$status','$userId') ";
         $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
        /*    if ($result === TRUE) {
                echo "1";
            }else {
                echo "0";
            }*/


            }
            
            //close opened csv file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

//redirect to the listing page
//header("Location: adminPanelAssets.php".$qstring);
?>