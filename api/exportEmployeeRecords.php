<?php 
include_once('database.php');
$conn = getDB();

$fileName="Employees Record - Tagbin.xls";
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";
//set headers
echo "Emp Name". "\t";
echo "Designation". "\t";
echo "Phone Number". "\t";
echo "Company Email". "\t";
echo "Personal Email". "\t";
echo "Reporting Manager". "\t";
print "\n";

    $query="Select * from user where status='1' order by name";
    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){
            $schema_insert = "";

            $rm_id=$row1['rm_id'];
                                  $personal_email=$row1['personal_email'];
                                  if(empty($personal_email))
                                    $personal_email="empty";
                                  $phone_number=$row1['phone_number'];
                                  if(empty($phone_number))
                                    $phone_number="empty";
                                  $designation=$row1['designation'];
                                  if(empty($designation))
                                    $designation="not assigned";

                                  $rm_name="";
                                  $rm_mail="";
                                  if(empty($rm_id))
                                    $rm_name="not assigned";
                                  else{

                                        $q1="SELECT name,email FROM user WHERE id='$rm_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $ro1 = $re1->fetch_array();
                                        $rm_name=$ro1['name'];
                                        $rm_mail=$ro1['email'];

                                    }

                                    if(empty($status)){
                                        $status="Inactive";
                                        $bckColor="#ec585d";
                                    }else{
                                        $status="Active";
                                        $bckColor="#7cc576";
                                    }


                                $schema_insert .= "$row1[name]".$sep."$designation".$sep."$phone_number".$sep."$row1[email]".$sep.$personal_email.$sep.$rm_name.$sep;
                                $schema_insert = str_replace($sep."$", "", $schema_insert);
                                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                                $schema_insert .= "\t";
                                print(trim($schema_insert));
                                print "\n";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                           


        }
    }
?>