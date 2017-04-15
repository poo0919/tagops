<?php

	include 'connection.php';


function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '') {
    global $conn;
    $parent = $conn->real_escape_string($parent);
    if (!is_array($category_tree_array))
        $category_tree_array = array();
 
    $q1 = "SELECT id,name,designation,rm_id FROM user WHERE rm_id = '$parent' ORDER BY rm_id,name ";
    $result=mysqli_query($conn, $q1)or die(mysqli_error($conn));	
    if ($result->num_rows > 0) {
        while($rowCategories = $result->fetch_assoc()) {
            $category_tree_array[] = array("id" => $rowCategories['id'], "name" => $spacing . $rowCategories['name'],"designation" => $rowCategories['designation']);
            $category_tree_array = categoryParentChildTree($rowCategories['id'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
        }
    }
    return $category_tree_array;
}


 $categoryList = categoryParentChildTree(); 
 /*   foreach($categoryList as $key => $value){
        echo $value['name'].'  -->  '.$value['designation'].'<br>';
    }*/

header('Content-Type: application/json');
echo json_encode($categoryList);

















//	include 'session.php';

/*	$q1="SELECT id,name,designation FROM user WHERE rm_id='0'";
	$re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
	$row1 = $re1->fetch_array();
	$row_cnt = mysqli_num_rows($re1); 
	if ($row_cnt>0) {



	}*/
	//call the recursive function to print category listing
/*org_chart(0);
header('Content-Type: application/json');

//Recursive php function
function org_chart($rm_id){
	global $conn;

	$sql = "SELECT id,name,designation FROM user WHERE rm_id='".$rm_id."'";
	$result =  mysqli_query($conn, $sql)or die(mysqli_error($conn));
	$json_response = array();
	if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()){
        	
	        $rm_id = $row['id'];
	        org_chart($rm_id);
	        $row_array = array();
	        $row_array['name'] = $row['name'];        
	        $row_array['title'] = $row['designation'];
	        $row_array['children'] = array();
	     /*   $sql = "SELECT id,name,designation FROM user WHERE rm_id='".$rm_id."'";
			$result =  mysqli_query($conn, $sql)or die(mysqli_error($conn));
			if ($result->num_rows > 0) {
        		while ($row = $result->fetch_array()){
        			$row_array['children'][] = array(
		                'name' => $row['name'],
		                'title' => $row['designation']
	            	);
        		}
        	}
	  
	        
	
		}
	}else {
		return;
	}
	echo  $json_response;
}
*/

?>