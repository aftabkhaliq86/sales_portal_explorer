<?php
// These 3 lines are compulsory copy at whole pages
session_start();
$SESSID = session_id() . time();
$EMPLOYEEID_LOGIN = $_SESSION['USERID'];
$USERRANDIDLOGIN_LOGIN = $_SESSION['USERRANDIDLOGIN']; //Only for user log

include("inc_functions.php");
CheckLogin();

$str = '';
include("inc_apostrophe.php");
normalize_str($str);

//=================================================

//Time Zone
//date_default_timezone_set('Asia/Karachi');

include("including_connection.php");
include('timeago.php');
include('digitstowords.php');


$NEWPURCHASE_login		= 	'';
$NEWORDER_login			= 	'';
$REVERSEORDER_login		= 	'';
$REVERSEPURCHASE_login	= 	'';

$NEWPURCHASE_EDIT_login		= 	'';
$NEWORDER_EDIT_login			= 	'';
$REVERSEORDER_EDIT_login		= 	'';
$REVERSEPURCHASE_EDIT_login	= 	'';

$DEPOSITADD_login			= 	'';
$DEPOSITDELETE_login		= 	'';
$DEPOSITAPPROVE_login		= 	'';

$result_login = mysqli_query($link, "SELECT * FROM `admin` WHERE ID='$EMPLOYEEID_LOGIN'");

while ($row_login = mysqli_fetch_array($result_login)) {
	$ID_login			= 	$row_login['ID'];
	$AgentID			= 	$row_login['ID'];
	$FRMUSERID_login	= 	$row_login['FRMUSERID'];
	$USERCAT_login		= 	$row_login['USERCAT'];
	$EMAIL_login		= 	$row_login['EMAIL'];
	$PNAME_login		= 	$row_login['PNAME'];
	$PCAT_login			= 	$row_login['PCAT'];
	$STATUS_login		= 	$row_login['STATUS'];
	$ROLL_login			= 	$row_login['ROLL'];
	$PICPATH_login			= 	$row_login['PICPATH'];


	$POSTINGDATE_cp			= 	$row_login['POSTINGDATE'];
	$LASTUPDATE_cp			= 	$row_login['LASTUPDATE'];

	$NEWPURCHASE_login				= 	$row_login['NEWPURCHASE'];
	$NEWORDER_login					= 	$row_login['NEWORDER'];
	$REVERSEORDER_login				= 	$row_login['REVERSEORDER'];
	$REVERSEPURCHASE_login			= 	$row_login['REVERSEPURCHASE'];

	$NEWPURCHASE_EDIT_login			= 	$row_login['NEWPURCHASE_EDIT'];
	$NEWORDER_EDIT_login			= 	$row_login['NEWORDER_EDIT'];
	$REVERSEORDER_EDIT_login		= 	$row_login['REVERSEORDER_EDIT'];
	$REVERSEPURCHASE_EDIT_login		= 	$row_login['REVERSEPURCHASE_EDIT'];

	$DEPOSITADD_login			= 	$row_login['DEPOSITADD'];
	$DEPOSITDELETE_login		= 	$row_login['DEPOSITDELETE'];
	$DEPOSITAPPROVE_login		= 	$row_login['DEPOSITAPPROVE'];

	$PP_CANSEE_login		= 	$row_login['PP_CANSEE'];

	$WORKTIMEIN_login		= 	$row_login['WORKTIMEIN'];
	//echo '<br>';
	$WORKTIMEOUT_login		= 	$row_login['WORKTIMEOUT'];
	//echo '<br>';
}

$result_company_profile = mysqli_query($link, "SELECT * FROM `company_profile`");

while ($row_company_profile = mysqli_fetch_array($result_company_profile)) {
	$setelment_cur			= 	$row_company_profile['CURRENCY'];
}

$currenttimei = date('h:i:s A');
//echo '<br>';
$currenttimeii = substr($currenttimei, 9, 11);
//echo '<br>';
$currenttime = substr($currenttimei, 0, -6) . ' ' . $currenttimeii;

$currenttime_sale = date('Y-m-d h:i:s A');

?>
<?php
//----Activity Log------------------------------
$match_actlog = '';
$page_nameful_actlog = basename($_SERVER['REQUEST_URI']);
$page_name_actlog = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

// Read website
$url_actlog = $page_name_actlog;
$data_actlog = implode('', file($url_actlog));
// Get <title> line
preg_match("/<title>([^`]*?)<\/title>/", $data_actlog, $match_actlog);

$titleofpage_actlog = '';

if (preg_match("/<title>([^`]*?)<\/title>/", $data_actlog)) {
	$titleofpage_actlog = $match_actlog[1];

	$titleofpage_actlog_v = normalize_str($titleofpage_actlog);
	$titleofpage_actlog_vi = substr($titleofpage_actlog_v, 0, -39);
	$titleofpage_actlog_vii = preg_replace('/[^A-Za-z0-9\-]/', ' ', $titleofpage_actlog_vi);

	if ($titleofpage_actlog_vii != NULL) {
		$activity_log = "INSERT INTO `activity_log` (USERID, ROLL, TIMEIN, PAGETITLE, PAGEURL) VALUES 
								('$EMPLOYEEID_LOGIN', '$ROLL_login', NOW(), '$titleofpage_actlog_vii', '$page_nameful_actlog')";

		if (!mysqli_query($link, $activity_log)) {
			echo "ERROR: Could not able to execute $activity_log. " . mysqli_error($link);
		}
	}
}

//==============================================
?>

