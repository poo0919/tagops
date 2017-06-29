<?php 
include_once('database.php');
$conn = getDB();

$project_id=$_GET['project_idEx'];
$q3="select name from projects where id='$project_id'";
$re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
$projectName="";
if ($re3->num_rows > 0) {
    while($ro3 = $re3->fetch_array()){
        $projectName= $ro3['name'];
    }
}

$fileName=$projectName." - Expenses.xls";

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";
//set headers
echo "Emp Name". "\t";
echo "Date". "\t";
echo "Details". "\t";
echo "Amount". "\t";
echo "Category". "\t";
print "\n";

$totalExpense=0;

$sql="select d.user_id as user_id, d.amount as amount,d.bill as bill,d.reimbursed as reimbursed, d.date as date,d.category_id as category_id,d.payment_id as payment_id,d.details as details from data d join (select id,name from user) as u on d.user_id=u.id where (d.reimbursed='1') && d.project_id='$project_id' order by u.name,d.date DESC";
$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            
            $schema_insert = "";

            $q2="select name from user where id='$row[user_id]'";
            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
            $userName="";
            if ($re2->num_rows > 0) {
                    while($ro2 = $re2->fetch_array()){
                            $userName= $ro2['name'];
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

            $totalExpense=$totalExpense+$row['amount'];
            
            $schema_insert .= "$userName".$sep."$row[date]".$sep."$row[details]".$sep."$row[amount]".$sep.$category.$sep;
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
            
        }
}
print "\n";
echo $sep.$sep;
echo "Total= ".$sep.$totalExpense;
print "\n\n\n";

echo "Categories". "\tExpense";
print "\n";

$totalCatExpense=0;
$setSql ="select cat.category as Categories, SUM(d.amount) as Expense from data d join (select id,category from categories) as cat on d.category_id=cat.id where (d.reimbursed='1') && d.project_id='$project_id' group by cat.category order by cat.category";
$result1=mysqli_query($conn,$setSql)or die(mysqli_error($conn));
if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){

            $schema_insert = "";
            $totalCatExpense=$totalCatExpense+$row1['Expense'];
            
            $schema_insert .= "$row1[Categories]".$sep."$row1[Expense]".$sep;
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
           
        }
}

print "\n";
echo "Total= ".$sep.$totalCatExpense;

?>