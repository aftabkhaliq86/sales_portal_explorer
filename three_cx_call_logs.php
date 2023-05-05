<?php

 include('including_connection.php'); 
//Set our script to JSON


//Web Login Page
$ServerURL = "remitchoice.3cx.co.uk";  //e.g.  "company.3cx.co.uk"

//Web URL Credentials
$LoginCreds = new stdClass();
$LoginCreds->username = "admin";  //admin
$LoginCreds->password = "64iF.cAW#gcUau8";  //Password


function Get3CXCookie()
{
    global $link;

    $cx_cookie = mysqli_query($link, "SELECT * FROM `three_cx_cookie` ");
    $cx_cookie = mysqli_fetch_assoc($cx_cookie);

    if (!is_null($cx_cookie) && gmdate('Y-m-d H:i:s') < $cx_cookie['expire_at']) {
        return $cx_cookie['cookie'];
    }
    //Define our variables are globals
    global $ServerURL, $LoginCreds;

    //Encode Logon into JSON Data for body
    $UserDetails = json_encode($LoginCreds);

    //Create our POST login with headers, ensure close!
    $PostData = file_get_contents("https://" . $ServerURL . "/api/login", null, stream_context_create(array('http' => array('protocol_version' => '1.1', 'user_agent' => 'PHP', 'method' => 'POST', 'header' => 'Content-type: application/json\r\n' . 'User-Agent: PHP\r\n' . 'Connection: close\r\n' . 'Content-length: ' . strlen($UserDetails) . '', 'content' => $UserDetails,),)));

    //Take response header 9 and break it into an array using explode from "; " which separates each variable
    $TempCookie = explode("; ", $http_response_header[9]);
    //Build our required cookie
    $FinalCookie = substr($TempCookie[0], 12);


    //Return the cookie Data if auth succeeded
    if ($PostData == "AuthSuccess") {
        $expire_at = strtotime(explode('=', $TempCookie[1])[1]);
        $expire_at = gmdate('Y-m-d H:i:s', $expire_at);
        if (!is_null($cx_cookie)) {
            $cookie_id = $cx_cookie['id'];
             mysqli_query($link, "UPDATE `three_cx_cookie` SET `cookie`='$FinalCookie',`expire_at`='$expire_at' WHERE  id = '$cookie_id'");
        } else {
             mysqli_query($link, "INSERT INTO `three_cx_cookie`( `cookie`, `expire_at`) VALUES ('$FinalCookie','$expire_at')");
        }

        return $FinalCookie;
    }

    //Return null/blank if auth failed
    return null;
}

//$Auth3CX = Get3CXCookie();
function getCallLogs($import_date)
{
    global $link;
    // $number = substr($number, 3);
    $Auth3CX = Get3CXCookie();
    if (strlen($Auth3CX) != 0) {
        global $ServerURL;
        //Create our GET with headers
        $GetData = @file_get_contents("https://" . $ServerURL . "/api/CallLog?TimeZoneName=Asia%2FKarachi&callState=All&dateRangeType=".$import_date."&fromFilter=&fromFilterType=Any&numberOfRows=5000&searchFilter=&startRow=0&toFilter=&toFilterType=Any", null, stream_context_create(array('http' => array('protocol_version' => '1.1', 'user-agent' => 'PHP', 'method' => 'GET', 'header' => 'Cookie: ' . $Auth3CX . ''),)));
        $GetData = json_decode($GetData, true);
        
        if (@count($GetData['CallLogRows']) > 0) {
            foreach ($GetData['CallLogRows'] as $key => $log) {
                $number = substr($log['Destination'], 3);
                $getCallingLeadQuery = mysqli_query($link,"SELECT * FROM `calling_lead` WHERE `PHONE` like '%".$number."%' ORDER by ID DESC LIMIT 1");
                $calling_lead = mysqli_fetch_assoc($getCallingLeadQuery);
                if(!empty($calling_lead) && !preg_match('/^[A-Za-z]+$/', $number)){
                $call_time = date('Y-m-d H:i:s', strtotime($log['CallTime']));
                $query = "
                INSERT INTO `three_cx_call_logs`(`three_cx_log_id`,`CI_ID`, `agent_name`, `phone_numnber`, `duration`,`call_time`, `is_answered`) 
                VALUES ('" . $log['Id'] . "','".$calling_lead['ID']."','" . $log['CallerId'] . "','" . $log['Destination'] . "','" . $log['Duration'] . "','$call_time','" . $log['Answered'] . "')
               ON DUPLICATE KEY UPDATE call_time = '$call_time'
                ";
                if (mysqli_query($link, $query)) {

                } else {
                    echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
                }
                }
               
            }
        }
    }
}
getCallLogs($_POST['import_date']);

?>


											