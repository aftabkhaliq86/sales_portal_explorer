<?php

/*$USERRANDIDLOGIN_LOGIN = $_SESSION['USERRANDIDLOGIN']; //Only for user log

function CheckLogin()
{
	$IPADD=$_SERVER['REMOTE_ADDR'];
	$IPHASH = md5($IPADD);
	$CheckAdmin = $_SESSION['adminz'];
	$EMPLOYEEID_LOGIN = $_SESSION['USERID'];
	
	if ($CheckAdmin != $IPHASH)
	{
	header("location: index.php?err=3");	
	}
}*/


$USERRANDIDLOGIN_LOGIN = $_SESSION['USERRANDIDLOGIN']; //Only for user log

function CheckLogin()
{

	if (isset($_SESSION['adminz']) && (time() - $_SESSION['adminz'] > 1800)) {
		// 30 Minutes
	    session_unset(); 
	    session_destroy();
	    echo ("<script>location='index.php?err=3'</script>"); 
	}
	else if ($_SESSION['adminz']=="") {
		session_unset(); 
	    session_destroy();
	    echo ("<script>location='index.php?err=3'</script>"); 
	}
	else {
		//echo "de";
	}

}

?>
