<?php 
  
//API for various actions

include 'connection.php';
                          
if($_POST['ACTION']=="getdata"){
       
       $user_id=$_POST['ID'];
            
           $query="Select * from leave_data where user_id='$user_id' AND (status='2' OR status='4')";
           $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
           if ($result->num_rows > 0) {
               
                $index = 0;
                $tableRows = array();
                
                while ($row = $result->fetch_array()){

                  $type="";
                  $againstDate="";
                  $reason="";

                  $dateCreated1=date_create($row['for_date']);
                  $formattedForDate1=date_format($dateCreated1, 'd-m-Y');
                    

                  if($row['type_id']=="1"){
                    $type="CL+PL+ML";
                    $againstDate="NA";
                    $reason="NA";
                  }else if($row['type_id']=="2"){
                    $type="Comp Off";
                    $againstDate=$row['against_date'];
                    $dateCreated2=date_create($againstDate);
                    $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                    $reason=$row['reason'];
                  }else if($row['type_id']=="3"){
                    $type="RH";
                    $againstDate="NA";
                    $reason="NA";
                  }

                    

                    $tableRows [$index] = array($index+1, $type, $formattedForDate1, $formattedAgainstDate2, $reason);
                    $index++;    
                }
                
                $dataArray =array( 
                        
                            "header" => array("S.No.","Leave Type","Leave Date","Against Date","Reason"),
                            "rows" => $tableRows
                    );
                
                echo json_encode($dataArray);      
           }
        
    exit();
  }
    $conn->close();
?>