<title>Login</title>
<?php
session_start();
/*$IPADD=$_SERVER['REMOTE_ADDR'];
$IPHASH = md5($IPADD);*/

include("including_connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// username and password sent from Form 
	$myusername = addslashes($_POST['LOGINID']);
	//echo '<br>';
	$PWDHASH = addslashes($_POST['PWDHASH']);
	//exit;

	$sql = "SELECT * FROM `admin` WHERE FRMUSERID='$myusername' AND PWDHASH='$PWDHASH' AND STATUS='1'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$count = mysqli_num_rows($result);

	//============================================
	$sql_ad = "UPDATE `admin` SET LOGSTATUS='1' WHERE FRMUSERID='$myusername' and PWDHASH='$PWDHASH'";

	if (!mysqli_query($link, $sql_ad)) {
		echo "ERROR: Could not able to execute $sql_ad. " . mysqli_error($link);
	}

	$result1 = mysqli_query($link, "SELECT ID, FRMUSERID, PWDHASH, STATUS FROM `admin` WHERE FRMUSERID='$myusername' and PWDHASH='$PWDHASH'");

	while ($row1 = mysqli_fetch_array($result1)) {
		$active_ID = $row1['ID'];
	}

	$LOGIP = $_SERVER['REMOTE_ADDR'];
	/*$TIME = date('h:i:s A') . "\n";
   $DATE = date('d-m-Y') ."\n";*/
	$SYSTEMNAME = php_uname('n');
	$randGenPin = rand(00000, 99999) . time();

	$sql3 = "INSERT INTO `iplogin` (RANDID, USERID, IP, TIMEIN, SYNAME) VALUES 
		 ('$randGenPin', '$active_ID', '$LOGIP', NOW(), '$SYSTEMNAME')";

	if (!mysqli_query($link, $sql3)) {
		echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
	}

	$activity_logi = "INSERT INTO `activity_log` (USERID, IP, TIMEIN, SYSNAME) VALUES 
							('$active_ID', '$LOGIP', NOW(), '$SYSTEMNAME')";

	if (!mysqli_query($link, $activity_logi)) {
		echo "ERROR: Could not able to execute $activity_logi. " . mysqli_error($link);
	}

	//===========================================
	//exit;
	if ($count == 1) {
		$_SESSION['adminz'] = time();
		$_SESSION['USERID'] = $active_ID;
		$_SESSION['USERRANDIDLOGIN'] = $randGenPin;
		//header("location: dashboard.php");
		echo ("<script>location='dashboard.php'</script>");
	} else {
		//header("location: index.php?err=4");
		echo ("<script>location='index.php?err=4'</script>");
	}
}

//mysql_close($link);
?>