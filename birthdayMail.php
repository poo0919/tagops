<?php
//api for checking if comp off's are expired or not
include 'connection.php';
	
	$today=date("Y-m-d"); $flag=0; $birthdayPersons="";$hrEmail="";$hrName="";
    $query="select * from user where status='1'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()){ 
        	

        	if($today==$row['birthday']){
                $flag=1;
        		$birthdayPersons.=$row['name'].",";
        	}
        }
    }      

$sql="select name,email from user where type='3'";
                            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                              if ($result->num_rows > 0) {
                                $row = $result->fetch_array();
                                $hrName= $row['name'];
                                $hrEmail= $row['email'];
                              }
        $dataArray =array( 
                        
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "birthdayPersons" => $birthdayPersons
                    );
                
                


    if($flag==1){
        echo json_encode($dataArray);
    } else echo "";                       
                                                          
?>