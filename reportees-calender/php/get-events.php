<?php

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
require dirname(__FILE__) . '/utils.php';

// Short-circuit if the client did not give us a date range.
if (!isset($_GET['start']) || !isset($_GET['end'])) {
	die("Please provide a date range.");
}

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
$range_start = parseDateTime($_GET['start']);
$range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
$timezone = null;
if (isset($_GET['timezone'])) {
	$timezone = new DateTimeZone($_GET['timezone']);
}



include_once('../../api/database.php');
$conn = getDB();
session_start();
if(isset($_SESSION['userid'])){
$user_id = $_SESSION['userid']; $json = array();
$q1="SELECT * FROM user where rm_id='$user_id' AND status='1' ORDER BY name";
$re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
if ($re1->num_rows > 0) {
  $index=0;
    while($ro1 = $re1->fetch_array()){
        $rp_id=$ro1['id'];
        $query="Select * from leave_data where user_id='$rp_id' AND (status='2' || status='4')";
        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            $tableRows = array(); 
            while ($row = $result->fetch_array()){
	            $type=""; $againstDate=""; $reason="";                            
	            $startDate=$row['for_date'];
	            if($row['to_date']=="0000-00-00" || empty($row['to_date'])){
	            	$endDate="";
	        	}else{
              $endDate=date('Y-m-d', strtotime("+1 day", strtotime($row['to_date'])));
	        		//$endDate=$row['to_date'];
	        	}

	        	$user_name="";
	        	$q2="SELECT * FROM user WHERE id='$rp_id'";
	        	$re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
				if ($re2->num_rows > 0) {
				    while($ro2 = $re2->fetch_array()){
				    	$user_name.=$ro1['name'];
				    }
				}

				if(empty($endDate)){
					$json[$index] = array("title" => $user_name, "start" => $startDate);
				}else{
					$json[$index] = array("title" => $user_name, "start" => $startDate, "end" => $endDate);
				}
				
				$index++;
        	}
        }
    }
}
}   else if($_SESSION['adminid']) {
  $user_id = $_SESSION['adminid']; $json = array();

  $index=0;

        $query="Select * from leave_data where (status='2' || status='4')";
        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            $tableRows = array(); 
            while ($row = $result->fetch_array()){
              $type=""; $againstDate=""; $reason="";                            
              $startDate=$row['for_date'];
              if($row['to_date']=="0000-00-00" || empty($row['to_date'])){
                $endDate="";
            }else{
              $endDate=date('Y-m-d', strtotime("+1 day", strtotime($row['to_date'])));
              //$endDate=$row['to_date'];
            }
            $rp_id=$row['user_id'];

            $user_name="";
            $q2="SELECT * FROM user WHERE id='$rp_id'";
            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
        if ($re2->num_rows > 0) {
            while($ro2 = $re2->fetch_array()){
              $user_name.=$ro2['name'];
            }
        }

        if(empty($endDate)){
          $json[$index] = array("title" => $user_name, "start" => $startDate);
        }else{
          $json[$index] = array("title" => $user_name, "start" => $startDate, "end" => $endDate);
        }
        
        $index++;
          }
        }

}                                            
            /*if($row['type_id']=="1"){
                $type="CL+PL+ML";
                if($row['half_full']=="Half"){
                                $formattedForDate1=$formattedForDate1;
                              }else{
                                if($row['to_date']!="0000-00-00"){
                                }
                              }
            }else if($row['type_id']=="2"){
                              $type="Comp Off";
                              $againstDate=$row['against_date'];
                              $dateCreated2=date_create($againstDate);
                              $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
            }else if($row['type_id']=="3"){
                              $type="RH"; $formattedAgainstDate2="NA";
            }else if($row['type_id']=="4"){
                              $type="Work from Home";
                              $formattedAgainstDate2="NA";
                              if($row['half_full']=="Half"){
                                $formattedForDate1=$formattedForDate1;
                              }else{
                                if($row['to_date']!="0000-00-00"){
                                  $formattedForDate1="from( ".$formattedForDate1." ) -> to( ".$formattedtoDate3." ) ";
                                }
                              }
            }*/
                            
                     
                        

                            
                          //}
                        






















// Read and parse our events JSON file into an array of event data arrays.
//$json = file_get_contents(dirname(__FILE__) . '/../json/events.json');
/*$input_arrays = json_decode($json, true);

// Accumulate an output array of event data arrays.
$output_arrays = array();
foreach ($input_arrays as $array) {

	// Convert the input array into a useful Event object
	$event = new Event($array, $timezone);

	// If the event is in-bounds, add it to the output
	if ($event->isWithinDayRange($range_start, $range_end)) {
		$output_arrays[] = $event->toArray();
	}
}

// Send JSON to the client.
echo json_encode($output_arrays);*/
echo json_encode($json);;