<title>Logout</title>
<?php
session_start();
$EMPLOYEEID_LOGIN = $_SESSION['USERID'];
//echo '<br>';
$USERRANDIDLOGIN_LOGIN = $_SESSION['USERRANDIDLOGIN']; //Only for user log
//exit;

include("inc_functions.php");
CheckLogin();

include("including_connection.php");

//=================================================

	$sql="UPDATE `admin` SET LOGSTATUS='0' WHERE ID='$EMPLOYEEID_LOGIN'";
	
		if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
	
	$sql2="UPDATE `iplogin` SET TIMEOUT=NOW() WHERE RANDID='$USERRANDIDLOGIN_LOGIN' AND USERID='$EMPLOYEEID_LOGIN'";
	
		if(!mysqli_query($link, $sql2)){
		echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
	}
			
	$activity_logii="INSERT INTO `activity_log` (USERID, TIMEOUT) VALUES 
							('$EMPLOYEEID_LOGIN', NOW())";
				
				if(!mysqli_query($link, $activity_logii)){
		echo "ERROR: Could not able to execute $activity_logii. " . mysqli_error($link);
	}

session_unset();
session_destroy();
unset($_SESSION['adminz']);
//session_destroy();
//header("location: index.php?err=2");
echo ("<script>location='index.php?err=2'</script>");


?>
