<?php
//api for writing sample csv for reimbursement

include 'connection.php';

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$q1="select category from categories order by category";
$re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
$categories="";
if ($re1->num_rows > 0) {

        while($ro1 = $re1->fetch_array()){
                $categories=$categories.$ro1['category']."/";
        }
}



$paymentMode="Cash/Online (Net banking/CC/DC)/Funds transfer";
$bill="Yes/No";
$reimbursed="submitted/approved/rejected";
$email="registered email-id";
$line2=">0,YYYY-MM-DD,text,".$categories.",".$paymentMode.",".$bill.",".$reimbursed.",".$email;


$data = array(
        "amount,date,details,category,payment mode,bill, reimbursed status,email",
        $line2
);

$fp = fopen('php://output', 'w');
foreach ( $data as $line ) {
    $val = explode(",", $line);
    fputcsv($fp, $val);
}
fclose($fp);

?>