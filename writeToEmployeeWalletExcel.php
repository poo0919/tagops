<?php 

include 'connection.php';

$employee_id=$_GET['EMPLOYEEID'];
$q3="select name from user where id='$employee_id'";
$re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
$employeeName="";
if ($re3->num_rows > 0) {
    while($ro3 = $re3->fetch_array()){
        $employeeName= $ro3['name'];
    }
}

$fileName=$employeeName." - Wallet.xls";

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";
//set headers
echo "Date". "\t";
echo "Transaction". "\t";
echo "Remarks". "\t";
print "\n";



$sql="SELECT id,user_id,date,transactions,remarks FROM wallet WHERE user_id='$employee_id' ";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            
            

            $schema_insert = "";

            $schema_insert .= "$row[date]".$sep."$row[transactions]".$sep."$row[remarks]".$sep;
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
            
        }
}

$sum="";

$sql="SELECT SUM(transactions) as sum FROM wallet WHERE user_id='$employee_id' ";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            $sum=$row['sum'];
        }
    }
print "\n\n";
echo $sep.$sep;
echo "Wallet Balance= ".$sep.$sum;

?>