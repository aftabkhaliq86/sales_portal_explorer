<?php
function call_record($link, $DATEDG_other)
{
    $calling_comments_calls = mysqli_query($link, "SELECT count(ID) AS count, USERID FROM `calling_comments_call` WHERE calls_start_time!='' $DATEDG_other GROUP BY USERID");
    $name = [];
    foreach ($calling_comments_calls as $calling_comments_call) {
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$calling_comments_call[USERID]' AND STATUS=1");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $name[] = [
                'label' => $PERSON_NAME . ' - ' . $calling_comments_call['count'],
                'y' => (int) $calling_comments_call['count']
            ];
        }
    }
    $name = json_encode($name);
    return $name;
}
function  profile_completed($link, $DATEDG)
{
    $Profile_Completed = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as `profile_completed` FROM `calling_lead` WHERE LEAD_STATUS='11' AND STATUS='1' $DATEDG AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");
    $Profile_Completed_arr = [];
    foreach ($Profile_Completed as  $Profile_Complete) {
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$Profile_Complete[USERID]' AND STATUS='1'");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $Profile_Completed_arr[] = [
                'label' => $PERSON_NAME,
                'y' => (int) $Profile_Complete['profile_completed']
            ];
        }
    }
    $Profile_Completed_arr = json_encode($Profile_Completed_arr);
    return $Profile_Completed_arr;
}
function lead_converted($link, $DATEDG)
{
    $Lead_Converted = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as `Lead_Converted` FROM `calling_lead` WHERE LEAD_STATUS='12' AND STATUS='1' $DATEDG AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");
    $Lead_Converted_arr = [];
    foreach ($Lead_Converted as  $Lead_Convert) {
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$Lead_Convert[USERID]' AND STATUS='1'");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $Lead_Converted_arr[] = [
                'label' => $PERSON_NAME,
                'y' => (int) $Lead_Convert['Lead_Converted']
            ];
        }
    }
    $Lead_Converted_arr = json_encode($Lead_Converted_arr);
    return $Lead_Converted_arr;
}
