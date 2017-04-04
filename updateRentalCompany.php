<?php
//api for renaming rental company name

include 'connection.php';
include 'session.php' ;
if(isset($_GET['id']) && isset($_GET['companyname'])){
    $rentId=$_GET['id'];
    $rentCompany=$_GET['companyname'];
    $sql="UPDATE rental_companies SET rental_company_name='$rentCompany' WHERE id='$rentId' ";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('Company Name Updated!');window.location.href='adminPanelRentalCompanies.php';</script>";  
                }else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
                }

}else{
	echo "<script type='text/javascript'>alert('Field is empty!');window.location.replace('adminPanelRentalCompanies.php');</script>";
}
        
                                       
                                
?>