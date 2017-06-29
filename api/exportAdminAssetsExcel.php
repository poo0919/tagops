<?php 
include_once('database.php');
$conn = getDB();

$owner=$_POST['asset_idEx'];
if(empty($owner)){
  echo "<script type='text/javascript'>alert('Select Owner Type!');window.location.replace('adminAssetsManagement.php');</script>";
  exit();
}
$fileName=$owner." - Assets.xls";
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";
//set headers
echo "Type". "\t";
echo "Description". "\t";
echo "Price". "\t";
echo "Owner". "\t";
echo "Rental Company". "\t";
echo "Status". "\t";
echo "Assigned To". "\t";
print "\n";

if($owner=="Rent"){

}

$sql="Select * from inventory where owner='$owner'";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            
            $schema_insert = "";

                  $type_id=$row['type'];
                  $q1="select asset_name from asset_type where id='$type_id'";
                  $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                  $r1=$rs1->fetch_array();

                  if($owner=="Rent"){
                      $rent_id=$row['rental_company'];
                      $q2="select rental_company_name from rental_companies where id='$rent_id'";
                      $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                      $r2=$rs2->fetch_array();
                      $rentCompany=$r2['rental_company_name'];                                    
                  }else{
                      $rentCompany="NA";
                  }
     
                  $user_id=$row['assigned_to'];
                  $q3="select name from user where id=$user_id";
                  $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                  $r3=$rs3->fetch_array();
                  $name=$r3['name'];

                  $status=$row['status'];
                  if($status=="1"){
                      $status="Free";
                      $name="No one.";
                  }else if($status=="2"){
                      $status="Given";
                  }else if($status=="3"){
                      $status="Assigned";
                  }else if($status=="4"){
                      $status="Returned";
                  }
            
            $schema_insert .= "$r1[asset_name]".$sep."$row[description]".$sep."$row[price]".$sep."$owner".$sep.$rentCompany.$sep.$status.$sep.$name.$sep;
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
            
        }
}
print "\n";
$totalPrice="";
$sql="Select SUM(price) as totalPrice from inventory where owner='$owner'";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
          $totalPrice.=$row['totalPrice'];
        }
}
$insert= $sep.$sep.$sep.$sep.$sep."Total Price".$sep."$totalPrice".$sep;
echo $insert;

?>