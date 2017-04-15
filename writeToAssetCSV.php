<?php
//api for writing sample csv for assets

include 'connection.php';

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$q1="select asset_name from asset_type order by asset_name";
$re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
$asset_type="";
if ($re1->num_rows > 0) {

        while($ro1 = $re1->fetch_array()){
                $asset_type=$asset_type.$ro1['asset_name']."/";
        }
}

$q2="select rental_company_name from rental_companies order by rental_company_name";
$re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
$rentCompanies="";
if ($re2->num_rows > 0) {

        while($ro2 = $re2->fetch_array()){
                $rentCompanies=$rentCompanies.$ro2['rental_company_name']."/";
        }
}

$status="Free/Given/Assigned/Returned";
$email="0/registered email-id";
$line2=$asset_type.",text,numbers,Tagbin/Rent,NA/".$rentCompanies.",".$status.",".$email;

$data = array(
        "asset_type,description,price,owner,owned by,status,email",
        $line2
);

$fp = fopen('php://output', 'w');
foreach ( $data as $line ) {
    $val = explode(",", $line);
    fputcsv($fp, $val);
}
fclose($fp);

?>