<?php 
include_once('database.php');
$conn = getDB();

$employee_id=$_GET['EMPLOYEEID'];
$q3="select name from user where id='$employee_id'";
$re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
$employeeName="";
if ($re3->num_rows > 0) {
    while($ro3 = $re3->fetch_array()){
        $employeeName= $ro3['name'];
    }
}

$fileName=$employeeName." - Expenses.xls";

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";
//set headers
echo "Project Name". "\t";
echo "Date". "\t";
echo "Details". "\t";
echo "Amount". "\t";
echo "Category". "\t";
echo "Reimbursed Status". "\t";
print "\n";

$totalExpense=0;

$sql="select d.project_id as project_id, d.amount as amount,d.bill as bill,d.reimbursed as reimbursed, d.date as date,d.category_id as category_id,d.payment_id as payment_id,d.details as details, d.reimbursed as reimbursed from data d join (select id,name from projects) as p on d.project_id=p.id where d.user_id='$employee_id' order by p.name,d.date DESC";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            
            $schema_insert = "";

            $q2="select name from projects where id='$row[project_id]'";
            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
            $userName="";
            if ($re2->num_rows > 0) {
                    while($ro2 = $re2->fetch_array()){
                            $projectName= $ro2['name'];
                    }
            }

            $q1="select category from categories where id='$row[category_id]'";
            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
            $category="";
            if ($re1->num_rows > 0) {
                    while($ro1 = $re1->fetch_array()){
                            $category=$ro1['category'];
                    }
            }

            $Status="";
            if($row['reimbursed']==0){
                $Status="Submitted";
            }else if($row['reimbursed']==1){
                $Status="Approved";
            }else if($row['reimbursed']==2){
                $Status="Rejected";
            }

            $totalExpense=$totalExpense+$row['amount'];
            
            $schema_insert .= "$projectName".$sep."$row[date]".$sep."$row[details]".$sep."$row[amount]".$sep.$category.$sep.$Status.$sep;
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