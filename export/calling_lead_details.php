<?php include('../inc_php_funtions.php'); ?>
<?php
if (isset($_GET['id'])) {
    $ID = $_GET['id'];  
}
?>
<table id="leads_export" class=" leads_export col-lg-12 table-striped table-condensed cf tbl table-responsive">
    <thead class="cf">
        <tr>
            <th>#</th>
            <th>DATED</th>
            <th>RMS ID</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Sending Country</th>
            <th>Preffered Country</th>
            <th>Register Date</th>
            <th>Last Transaction Details</th>
            <th>USER</th>
            <th>Lead Status</th>
            <th>Status Summary</th>
            <td>Comments</td>
            <th>Call Summary</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $AGID = !empty($_GET['AGID']) ? $_GET['AGID'] : '';
        $AGID_QUERY = !empty($AGID) ? "AND `cl`.`USERID`='$AGID'" : '';
        $LEAD_STATUS_sclc = '';
        $STATUS_TITLE_STATUS = '';
        $DATED_sclc = '';
        $result = mysqli_query($link, "SELECT `cl`.*,`clg`.`PERSON_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_agents` AS `clg` ON `cl`.`USERID`=`clg`.`ID` WHERE `cl`.`LEADTID`='$ID' $AGID_QUERY ORDER BY `cl`.`DATED`");
        $counters = '0';
        while ($row = mysqli_fetch_array($result)) {
            $ID = $row['ID'];
            $DATED = $row['DATED'];
            $RMS_ID = $row['RMS_ID'];
            $PHONE = $row['PHONE'];
            $EMAIL = $row['EMAIL'];
            $PREFFERED_COUNTRY = $row['PREFFERED_COUNTRY'];
            $REGISTER_DATE = $row['REGISTER_DATE'];
            $SENDING_COUNTRY = $row['SENDING_COUNTRY'];
            $TRANSACTION_COUNT = $row['TRANSACTION_COUNT'];
            $LAST_TRANSACTION_DATE = $row['LAST_TRANSACTION_DATE'];
            $USERID = $row['USERID'];
            $U_DATED = $row['U_DATED'];
            $LEAD_STATUS = $row['LEAD_STATUS'];
            $LEAD_STATUS_DATED = $row['LEAD_STATUS_DATED'];
            $STATUS = $row['STATUS'];
            $counters = $counters + 1;
            // Last Status--------------------------------------
            $sel_calling_lead_comments = mysqli_query($link, "SELECT `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
            while ($row_sclc = mysqli_fetch_array($sel_calling_lead_comments)) {
                $LEAD_STATUS_sclc = $row_sclc['LEAD_STATUS'];
                $DATED_sclc = $row_sclc['DATED'];
            }
            $result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS_sclc'");
            $rows_ls = mysqli_fetch_array($result_lead_status);
            if (!empty($rows_ls['STATUS_HEADING'])) {
                $STATUS_TITLE_STATUS = $rows_ls['STATUS_HEADING'];
            }
            // Last Status End ---------------------------------	
        ?>
            <tr>
                <td></td>
                <td><?php echo $DATED; ?></td>
                <td><?php echo $RMS_ID; ?></td>
                <td><a href="tel:8<?php echo $PHONE; ?>"><?php echo $PHONE; ?></a></td>
                <td><?php echo $EMAIL; ?></td>
                <td><?php echo $SENDING_COUNTRY; ?></td>
                <td><?php echo $PREFFERED_COUNTRY; ?></td>
                <td><?php echo $REGISTER_DATE; ?></td>
                <td><?php echo $LAST_TRANSACTION_DATE; ?><br><?php echo $TRANSACTION_COUNT; ?></td>
                <td><?php if (!empty($row['PERSON_NAME'])) {
                        echo $row['PERSON_NAME']; ?><br><small><?php echo $U_DATED;
                                                            } ?></small></td>
                <td><?php if ($DATED_sclc != NULL) { ?> <?php echo $STATUS_TITLE_STATUS; ?><br><small><?php echo $DATED_sclc; ?></small><?php } ?></td>
                <?php
                $calling_lead_comments = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
                $query_counts = mysqli_num_rows($calling_lead_comments);
                ?>
                <td><?php $counter = 1;
                    foreach ($calling_lead_comments as $call_summary) {
                        $LEAD_STATUS = $call_summary['LEAD_STATUS'];
                        $results1 = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
                        $rows1 = mysqli_fetch_array($results1);
                        $STATUS_HEADING = $rows1['STATUS_HEADING'];
                        if ($counter < $query_counts) {
                            echo $STATUS_HEADING . ' | ';
                        } else {
                            echo $STATUS_HEADING;
                        }
                        $counter++;
                    } ?></td>
                <td><?php $counter1 = 1;
                    foreach ($calling_lead_comments as $all_comments) {
                        $LEAD_CMT_ID = $all_comments['LEAD_CMT_ID'];
                        $lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
                        if (mysqli_num_rows($lead_comments) > 0) {
                            $lead_comments_row = mysqli_fetch_array($lead_comments);
                            $COMMENT_HEADING = $lead_comments_row['HEADING'];
                            if ($COMMENT_HEADING == "Other") {
                                $COMMENT_AREA = $all_comments['COMMENT_AREA'];
                            } else {
                                $COMMENT_AREA = '';
                            }
                        } else {
                            $COMMENT_HEADING = '';
                            $COMMENT_AREA = '';
                        }
                        if ($counter1 < $query_counts) {
                            echo $COMMENT_HEADING . ': ' . $COMMENT_AREA . ' | ';
                        } else {
                            echo $COMMENT_HEADING . ': ' . $COMMENT_AREA;
                        }
                        $counter1++;
                    } ?></td>
                <td>
                    
                    <?php
                    //  $counter2 = 1;
                    // $three_cx_call_logs = mysqli_query($link, "SELECT * FROM `three_cx_call_logs` WHERE CI_ID='$ID'");
                    // $three_cx_call_logs_count = mysqli_num_rows($three_cx_call_logs);
                    // foreach ($three_cx_call_logs as $three_cx_call) {
                    //     $call_time = $three_cx_call['call_time'];
                    //     $duration = $three_cx_call['duration'];
                    //     if ($counter2 < $three_cx_call_logs_count) {
                    //         echo $call_time . ' [ ' . $duration . ' ] | ';
                    //     } else {
                    //         echo $call_time . ' [ ' . $duration . ' ] ';
                    //     }
                    //     $counter2++;
                    // } 
                    ?>
                    
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>