<?php
function call_record($link, $date_from_to_call)
{
    $calling_comments_calls = mysqli_query($link, "SELECT count(three_cx_log_id) AS count, agent_name FROM `three_cx_call_logs` WHERE call_time!='' $date_from_to_call GROUP BY agent_name");
    $name = [];
    foreach ($calling_comments_calls as $calling_comments_call) {
        $array = explode("(", "{$calling_comments_call['agent_name']}");
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE EXT_NUMBER='$array[1]' AND STATUS=1");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $name[] = [
                'label' => $PERSON_NAME . ' - ' . $calling_comments_call['count'],
                'y' => (int) $calling_comments_call['count']
            ];
        }
    }
    $name = json_encode($name, JSON_NUMERIC_CHECK);
    return ['count' => mysqli_num_rows($calling_comments_calls), 'name' => $name];
}
function  profile_completed($link, $date_from_to)
{
    $Profile_Completed = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as `profile_completed` FROM `calling_lead_comments` WHERE LEAD_STATUS='11' $date_from_to AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");
    $Profile_Completed_arr = [];
    foreach ($Profile_Completed as  $Profile_Complete) {
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$Profile_Complete[USERID]'");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $Profile_Completed_arr[] = [
                'label' => $PERSON_NAME,
                'y' => (int) $Profile_Complete['profile_completed']
            ];
        }
    }
    $Profile_Completed_arr = json_encode($Profile_Completed_arr, JSON_NUMERIC_CHECK);
    return $Profile_Completed_arr;
}
function lead_converted($link, $date_from_to)
{
    $Lead_Converted = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as `Lead_Converted` FROM `calling_lead_comments` WHERE LEAD_STATUS='12' $date_from_to AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");
    $Lead_Converted_arr = [];
    foreach ($Lead_Converted as  $Lead_Convert) {
        $calling_lead_agents = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$Lead_Convert[USERID]'");
        foreach ($calling_lead_agents as $calling_lead_agent) {
            $PERSON_NAME = $calling_lead_agent['PERSON_NAME'];
            $Lead_Converted_arr[] = [
                'label' => $PERSON_NAME,
                'y' => (int) $Lead_Convert['Lead_Converted']
            ];
        }
    }
    $Lead_Converted_arr = json_encode($Lead_Converted_arr, JSON_NUMERIC_CHECK);
    return $Lead_Converted_arr;
}
