<!DOCTYPE html>
<html>
<head>
	<title>redirecting</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #e1e1e1;">
<div style="padding-left: 50%;padding-top: 20%; position: relative;">Loading...<i class="fa fa-spinner fa-pulse fa-3x fa-fw" ></i></div>
</body>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		localStorage.setItem('activeEmpReporteesTabs','#leaveRequestsTab');
		 window.location.href='empReportees.php';
	});
</script>
</html>