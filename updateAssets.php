<?php
//api for updating asset name

include 'connection.php';
include 'session.php' ;
if(isset($_GET['id']) && isset($_GET['assetName'])){
    $invId=$_GET['id'];
    $assetName=$_GET['assetName'];
    $sql="UPDATE asset_type SET asset_name='$assetName' WHERE id='$invId' ";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('Asset Name Updated!');window.location.href='adminPanelUpdateInventory.php';</script>";  
                }else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
                }

}else{
	echo "<script type='text/javascript'>alert('Field is empty!');window.loction.replace('adminPanelUpdateInventory.php');</script>";
}
        
                                       
                                
?>