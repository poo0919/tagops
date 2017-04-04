<?php
include 'connection.php';
include 'empSession.php';
//apply for leaves and add leave data to db
    $user_id=$_POST['id'];
    $leaveType1=$_POST['leaveType1']; $againstDate1=$_POST['againstDate1']; $forDate1=$_POST['forDate1']; $rhDate1=$_POST['rhDate1']; $reason1=$_POST['reason1'];
    $leaveType2=$_POST['leaveType2']; $againstDate2=$_POST['againstDate2']; $forDate2=$_POST['forDate2']; $rhDate2=$_POST['rhDate2']; $reason2=$_POST['reason2'];
    $leaveType3=$_POST['leaveType3']; $againstDate3=$_POST['againstDate3']; $forDate3=$_POST['forDate3']; $rhDate3=$_POST['rhDate3']; $reason3=$_POST['reason3'];
    $leaveType4=$_POST['leaveType4']; $againstDate4=$_POST['againstDate4']; $forDate4=$_POST['forDate4']; $rhDate4=$_POST['rhDate4']; $reason4=$_POST['reason4'];
    $leaveType5=$_POST['leaveType5']; $againstDate5=$_POST['againstDate5']; $forDate5=$_POST['forDate5']; $rhDate5=$_POST['rhDate5']; $reason5=$_POST['reason5'];

                $comp_off=""; $pl_cl_ml="";
                $q1="select pl_cl_ml,comp_off from leaves where user_id='$user_id'";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                    while($ro1 = $re1->fetch_array()){
                        $comp_off=$ro1['comp_off'];
                        $pl_cl_ml=$ro1['pl_cl_ml'];
                    }
                }


                $sql1 = "SELECT name,email,rm_id FROM user where id='$user_id'"; //fetching user details
                $userResult=mysqli_query($conn,$sql1)or die(mysqli_error($conn));
                $userName="";
                $userEmail="";
                $rm_id="";
                if ($userResult->num_rows > 0) {
                    while($rowResult1 = $userResult->fetch_array()){
                        $userName=$rowResult1['name'];
                        $userEmail=$rowResult1['email'];
                        $rm_id=$rowResult1['rm_id'];
                    }
                }

                $sql2 = "SELECT name,email FROM user where id='$rm_id'";  //fetching RM details
                $mgrResult=mysqli_query($conn,$sql2)or die(mysqli_error($conn));
                $mgrName="";
                $mgrEmail="";
                if ($mgrResult->num_rows > 0) {
                    while($rowResult2 = $mgrResult->fetch_array()){
                        $mgrName=$rowResult2['name'];
                        $mgrEmail=$rowResult2['email'];
                    }
                }

                $hrName="";
                $hrEmail="";
                $sql="select name,email from user where type='3'";
                            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                              if ($result->num_rows > 0) {
                                $row = $result->fetch_array();
                                $hrName= $row['name'];
                                $hrEmail= $row['email'];
                              }
                                

                $message="";

        $flag=0;
    	if($leaveType1!=0){
    	
    		if($leaveType1=="1"){

                if(empty($forDate1) && empty($reason1)){
                    echo "4";
                    exit();
                }
    		
    				$q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','1','$forDate1','$reason1','1')";
    				$re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
    			    			if ($re1===TRUE) {
    			    				
    			    				$pl_cl_ml-=1;
    			    			    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$user_id'";
    			    			    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
    			    			    if ($re2 === TRUE) {
             							$flag=1;
    			    			    }
    			    			}

                    $message.="1. <b>Leave Type:</b> PL+CL+ML    <b>For Date:</b> ".$forDate1.",    <b>Reason:</b> ".$reason1.",<br>";

    		}else if($leaveType1=="2"){

        			if($comp_off>0)
        			{
                            if(empty($forDate1) || empty($againstDate1)){
                                echo "4";
                                exit();
                            }
    			                $sql="update leave_data set status='1',for_date='$forDate1' where id='$againstDate1'";
    			                $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
    			                if ($re === TRUE) {
    			                    $comp_off-=1;
    			                            $q2="update leaves set comp_off='$comp_off' where user_id='$user_id'";
    			                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
    			                            if ($re2 === TRUE) {
    			                                $flag=1;
    			                            }
    			                }
    			     }

                        $sql3 = "SELECT against_date FROM leave_data where id='$againstDate1'";
                        $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
                        $DateAgainst="";
                        if ($againstDateResult->num_rows > 0) {
                            while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                                $DateAgainst=$rowAgainstDateResult['against_date'];
                            }
                        }

                    $message.="1. <b>Leave Type:</b> Comp Off     <b>For Date:</b> ".$forDate1."    <b>Against Date:</b> ".$DateAgainst.",<br>";

    		}else if($leaveType1=="3"){

                if(empty($rhDate1)){
                    echo "4";
                    exit();
                }

                if($rhDate1=="Birthday"){

                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$forDate1','$rhDate1','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message.="1. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$forDate1.",           <b>Reason:</b> ".$rhDate1.",<br>";

                }else
                {
                    $q2="SELECT date,occasion FROM restricted_holidays where id='$rhDate1'";
                                $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
                                $DateRH=""; $occasion="";
                                if ($re2->num_rows > 0) {
                                            while($ro2 = $re2->fetch_array()){
                                                $DateRH=$ro2['date'];
                                                $occasion=$ro2['occasion'];
                                            }
                                        }
                
                                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$DateRH','$occasion','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message.="1. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$DateRH.",           <b>Reason:</b> ".$occasion.",<br>";
                                }
            }

    	}else{
    		if($flag==0)
    		{
                echo "2";
    		    exit();
            }
    	}



    	if($leaveType2!="0"){

    		if($leaveType2=="1"){

                if(empty($forDate2) && empty($reason2)){
                    echo "4";
                    exit();
                }
            
                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','1','$forDate2','$reason2','1')";
                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                if ($re1===TRUE) {
                                    
                                    $pl_cl_ml-=1;
                                    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$user_id'";
                                    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                    if ($re2 === TRUE) {
                                        $flag=1;
                                    }
                                }

            $message.="2. <b>Leave Type:</b> PL+CL+ML    <b>For Date:</b> ".$forDate2.",    <b>Reason:</b> ".$reason2.",<br>";

            }else if($leaveType2=="2"){

                if($comp_off>0)
                {
                            if(empty($forDate1) || empty($againstDate2)){
                                echo "4";
                                exit();
                            }

                                $sql="update leave_data set status='1',for_date='$forDate2' where id='$againstDate2'";
                                $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($re === TRUE) {
                                    $comp_off-=1;
                                            $q2="update leaves set comp_off='$comp_off' where user_id='$user_id'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2 === TRUE) {
                                                $flag=1;
                                            }
                                }
                }

                        $sql3 = "SELECT against_date FROM leave_data where id='$againstDate2'";
                        $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
                        $DateAgainst="";
                        if ($againstDateResult->num_rows > 0) {
                            while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                                $DateAgainst=$rowAgainstDateResult['against_date'];
                            }
                        }



                $message.="2. <b>Leave Type:</b> Comp Off    <b>For Date:</b> ".$forDate2."    <b>Against Date:</b> ".$DateAgainst.",<br>";
            }else if($leaveType2=="3"){

                if(empty($rhDate2)){
                    echo "4";
                    exit();
                }

                if($rhDate2=="Birthday"){

                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$forDate2','$rhDate2','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message="2. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$forDate2.",           <b>Reason:</b> ".$rhDate2.",<br>";

                }else
                {

                    $q2="SELECT date,occasion FROM restricted_holidays where id='$rhDate2'";
                    $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
                    $DateRH=""; $occasion="";
                    if ($re2->num_rows > 0) {
                                while($ro2 = $re2->fetch_array()){
                                    $DateRH=$ro2['date'];
                                    $occasion=$ro2['occasion'];
                                }
                            }


                        $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$DateRH','$occasion','1')";
                        $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                    if ($re1===TRUE) {
                                        $flag=1;
                                    }

                    $message.="2. <b>Leave Type:</b> RH        <b>RH Date:</b> ".$DateRH.",        <b>Reason:</b> ".$occasion.",<br>";
            }
            }

    	}else{
    		$dataArray =array( 
                        "userName" => $userName,
                        "userEmail" => $userEmail,
                        "mgrName" => $mgrName,
                        "mgrEmail" => $mgrEmail,
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "message" => $message
                    );
                
                echo json_encode($dataArray);      


                        exit();
    	}


    	if($leaveType3!="0"){

    		if($leaveType3=="1"){

                if(empty($forDate3) && empty($reason3)){
                    echo "4";
                    exit();
                }
            
                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','1','$forDate3','$reason3','1')";
                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                if ($re1===TRUE) {
                                    
                                    $pl_cl_ml-=1;
                                    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$user_id'";
                                    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                    if ($re2 === TRUE) {
                                        $flag=1;
                                    }
                                }

            $message.="3. <b>Leave Type:</b> PL+CL+ML    <b>For Date:</b> ".$forDate3.",    <b>Reason:</b> ".$reason3.",<br>";

            }else if($leaveType3=="2"){

                if($comp_off>0)
                {
                            if(empty($forDate3) || empty($againstDate3)){
                                echo "4";
                                exit();
                            }
                                $sql="update leave_data set status='1',for_date='$forDate3' where id='$againstDate3'";
                                $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($re === TRUE) {
                                    $comp_off-=1;
                                            $q2="update leaves set comp_off='$comp_off' where user_id='$user_id'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2 === TRUE) {
                                                $flag=1;
                                            }
                                }
                }

                        $sql3 = "SELECT against_date FROM leave_data where id='$againstDate3'";
                        $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
                        $DateAgainst="";
                        if ($againstDateResult->num_rows > 0) {
                            while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                                $DateAgainst=$rowAgainstDateResult['against_date'];
                            }
                        }



    $message.="3. <b>Leave Type:</b> Comp Off    <b>For Date:</b> ".$forDate3."    <b>Against Date:</b> ".$DateAgainst.",<br>";
            }else if($leaveType3=="3"){

                if(empty($rhDate3)){
                    echo "4";
                    exit();
                }

                if($rhDate3=="Birthday"){

                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$forDate3','$rhDate3','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message="3. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$forDate3.",           <b>Reason:</b> ".$rhDate3.",<br>";

                }else
                {
                    $q2="SELECT date,occasion FROM restricted_holidays where id='$rhDate3'";
                                $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
                                $DateRH="";$occasion="";
                                if ($re2->num_rows > 0) {
                                            while($ro2 = $re2->fetch_array()){
                                                $DateRH=$ro2['date'];
                                                $occasion=$ro2['occasion'];
                                            }
                                        }
                
                
                                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$DateRH','$occasion','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                                }
                
                                $message.="3. <b>Leave Type:</b> RH        <b>RH Date:</b> ".$DateRH.",           <b>Reason:</b> ".$occasion.",<br>";
                            }
            }

    	}else{
    		$dataArray =array( 
                        "userName" => $userName,
                        "userEmail" => $userEmail,
                        "mgrName" => $mgrName,
                        "mgrEmail" => $mgrEmail,
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "message" => $message
                    );
                
                echo json_encode($dataArray);      


                        exit();
    	}



    	if($leaveType4!="0"){

    		if($leaveType4=="1"){

                if(empty($forDate4) && empty($reason4)){
                    echo "4";
                    exit();
                }
            
                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','1','$forDate4','$reason4','1')";
                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                if ($re1===TRUE) {
                                    
                                    $pl_cl_ml-=1;
                                    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$user_id'";
                                    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                    if ($re2 === TRUE) {
                                        $flag=1;
                                    }
                                }

            $message.="4. <b>Leave Type:</b> PL+CL+ML    <b>For Date:</b> ".$forDate4.",    <b>Reason:</b> ".$reason4.",<br>";

            }else if($leaveType4=="2"){

                if($comp_off>0)
                {
                            if(empty($forDate4) || empty($againstDate4)){
                                echo "4";
                                exit();
                            }

                                $sql="update leave_data set status='1',for_date='$forDate4' where id='$againstDate4'";
                                $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($re === TRUE) {
                                    $comp_off-=1;
                                            $q2="update leaves set comp_off='$comp_off' where user_id='$user_id'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2 === TRUE) {
                                                $flag=1;
                                            }
                                }
                }

                        $sql3 = "SELECT against_date FROM leave_data where id='$againstDate4'";
                        $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
                        $DateAgainst="";
                        if ($againstDateResult->num_rows > 0) {
                            while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                                $DateAgainst=$rowAgainstDateResult['against_date'];
                            }
                        }



                $message.="4. <b>Leave Type:</b> Comp Off    <b>For Date:</b> ".$forDate4."    <b>Against Date:</b> ".$DateAgainst.",<br>";
            }else if($leaveType4=="3"){

                if(empty($rhDate4)){
                    echo "4";
                    exit();
                }


                if($rhDate4=="Birthday"){

                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$forDate4','$rhDate4','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message="4. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$forDate4.",           <b>Reason:</b> ".$rhDate4.",<br>";

                }else
                {
                    $q2="SELECT date,occasion FROM restricted_holidays where id='$rhDate4'";
                                $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
                                $DateRH="";$occasion="";
                                if ($re2->num_rows > 0) {
                                            while($ro2 = $re2->fetch_array()){
                                                $DateRH=$ro2['date'];
                                                $occasion=$ro2['occasion'];
                                            }
                                        }
                
                
                                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$DateRH','$occasion','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                                }
                
                                $message.="4. <b>Leave Type:</b> RH        <b>RH Date:</b> ".$DateRH.",           <b>Reason:</b> ".$occasion.",<br>";
                            }
            }

    	}else{
    		$dataArray =array( 
                        "userName" => $userName,
                        "userEmail" => $userEmail,
                        "mgrName" => $mgrName,
                        "mgrEmail" => $mgrEmail,
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "message" => $message
                    );
                
                echo json_encode($dataArray);      


                        exit();
    	}


    	if($leaveType5!="0"){

    		if($leaveType5=="1"){

                if(empty($forDate5) && empty($reason5)){
                    echo "4";
                    exit();
                }
            
                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','1','$forDate5','$reason5','1')";
                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                if ($re1===TRUE) {
                                    
                                    $pl_cl_ml-=1;
                                    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$user_id'";
                                    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                    if ($re2 === TRUE) {
                                        $flag=1;
                                    }
                                }

            $message.="5. <b>Leave Type:</b> PL+CL+ML    <b>For Date:</b> ".$forDate5.",    <b>Reason:</b> ".$reason5.",<br>";

            }else if($leaveType5=="2"){

                if($comp_off>0)
                {

                            if(empty($forDate5) || empty($againstDate5)){
                                echo "4";
                                exit();
                            }

                                $sql="update leave_data set status='1',for_date='$forDate5' where id='$againstDate5'";
                                $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($re === TRUE) {
                                    $comp_off-=1;
                                            $q2="update leaves set comp_off='$comp_off' where user_id='$user_id'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2 === TRUE) {
                                                $flag=1;
                                            }
                                }
                }

                        $sql3 = "SELECT against_date FROM leave_data where id='$againstDate5'";
                        $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
                        $DateAgainst="";
                        if ($againstDateResult->num_rows > 0) {
                            while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                                $DateAgainst=$rowAgainstDateResult['against_date'];
                            }
                        }



                $message.="5. <b>Leave Type:</b> Comp Off           <b>For Date:</b> ".$forDate5."           <b>Against Date:</b> ".$DateAgainst.",<br>";
            }else if($leaveType5=="3"){

                if(empty($rhDate5)){
                    echo "4";
                    exit();
                }

                if($rhDate5=="Birthday"){

                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$forDate5','$rhDate5','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                        }
                
                                    $message="5. <b>Leave Type:</b> RH           <b>RH Date:</b> ".$forDate5.",           <b>Reason:</b> ".$rhDate5.",<br>";

                }else
                {
                    $q2="SELECT date,occasion FROM restricted_holidays where id='$rhDate5'";
                                $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
                                $DateRH="";$occasion="";
                                if ($re2->num_rows > 0) {
                                            while($ro2 = $re2->fetch_array()){
                                                $DateRH=$ro2['date'];
                                                $occasion=$ro2['occasion'];
                                            }
                                        }
                
                
                                    $q1="INSERT INTO leave_data (user_id,type_id,for_date,reason,status) VALUES ('$user_id','3','$DateRH','$occasion','1')";
                                    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
                                                if ($re1===TRUE) {
                                                    $flag=1;
                                                }
                
                                $message.="5. <b>Leave Type:</b> RH        <b>RH Date:</b> ".$DateRH.",           <b>Reason:</b> ".$occasion.",<br>";
                            }
            }
    	}else{
    		$dataArray =array( 
                        "userName" => $userName,
                        "userEmail" => $userEmail,
                        "mgrName" => $mgrName,
                        "mgrEmail" => $mgrEmail,
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "message" => $message
                    );
                
                echo json_encode($dataArray);      


                        exit();
    	}

    	$dataArray =array( 
                        "userName" => $userName,
                        "userEmail" => $userEmail,
                        "mgrName" => $mgrName,
                        "mgrEmail" => $mgrEmail,
                        "hrName" => $hrName,
                        "hrEmail" => $hrEmail,
                        "message" => $message
                    );
                
                echo json_encode($dataArray);      


                   
         
?>