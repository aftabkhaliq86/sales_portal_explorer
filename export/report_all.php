<?php include('../inc_php_funtions.php'); ?>
<table id="leads_export" class="col-lg-12 table-striped table-condensed cf tbl">
    <thead class="cf">
        <tr>
            <th>#</th>
            <th>Calling Agent</th>
            <th>Lead Name</th>
            <th>Lead Type</th>
            <th>RMS ID</th>
            <th>Lead Upload Date</th>
            <th>Registration Date</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Sending Country</th>
            <th>Preffered Country</th>
            <th>Last Transaction Details</th>
            <th>Status</th>
            <th style="display: none;">Call Summary</th>
            <!-- <td style="display: none;">Comments</td> -->
            <th>Tags Status</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['calling_leads'])) {

            $calling_leads = mysqli_query($link, "$_GET[calling_leads]");
        }
        if (!empty($calling_leads)) {
            foreach ($calling_leads as $calling_lead) {
                $ID = $calling_lead['ID'];
                $calling_lead_comments = mysqli_query($link, "SELECT `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
                if (!empty($calling_lead_comments)) {
                    $RMS_ID = $calling_lead['RMS_ID'];
                    $PHONE = $calling_lead['PHONE'];
                    $EMAIL = $calling_lead['EMAIL'];
                    $PREFFERED_COUNTRY = $calling_lead['PREFFERED_COUNTRY'];
                    $REGISTER_DATE = $calling_lead['REGISTER_DATE'];
                    $TRANSACTION_COUNT = $calling_lead['TRANSACTION_COUNT'];
                    $LAST_TRANSACTION_DATE = $calling_lead['LAST_TRANSACTION_DATE'];
                    $STATUS = $calling_lead['STATUS'];
                    $active_calls = $calling_lead['calls'];
                    // --------------------------------- Lead Status Start --------------------------------------
                    $LEAD_STATUS = $calling_lead['LEAD_STATUS'];
                    $LEAD_STATUS_DATED = $calling_lead['LEAD_STATUS_DATED'];
                    $STATUS_TITLE_STATUS = $calling_lead['STATUS_TITLE_STATUS'];
                    // --------------------------------- Lead Status End ----------------------------------------
                    // --------------------------------- Lead Agent Start ---------------------------------------
                    $USERID = $calling_lead['USERID'];
                    $U_DATED = $calling_lead['U_DATED'];
                    $PERSON_NAME = $calling_lead['PERSON_NAME'];
                    // --------------------------------- Lead Agent End -----------------------------------------
                    // --------------------------------- Lead Category Start ------------------------------------
                    $LEAD_ID = $calling_lead['LEADTID'];
                    $LEAD_CATEGORY_clt = $calling_lead['LEAD_CATEGORY_clt'];
                    $LEAD_TYPE_clt = $calling_lead['LEAD_TYPE_clt'];
                    $LEAD_DATED_clt = $calling_lead['LEAD_DATED_clt'];
                    // --------------------------------- Lead Category End --------------------------------------
                    // --------------------------------- Lead Country Start -------------------------------------
                    $SENDING_COUNTRY = $calling_lead['SENDING_COUNTRY_NAME'];
                    // --------------------------------- Lead Country End ---------------------------------------

        ?>
                    <tr id="<?php echo $ID; ?>">
                        <td></td>
                        <td><?php echo $PERSON_NAME; ?></td>
                        <td><small><?php echo $LEAD_CATEGORY_clt; ?></small></td>
                        <td><small><?php if ($LEAD_TYPE_clt == 1) {
                                        echo "New Reg";
                                    } elseif ($LEAD_TYPE_clt == 2) {
                                        echo "Dormant";
                                    } elseif ($LEAD_TYPE_clt == 3) {
                                        echo "Inactive";
                                    } ?></small></td>
                        <td><?php echo $RMS_ID; ?></td>
                        <td><?php echo $LEAD_DATED_clt; ?></td>
                        <td><?php echo $REGISTER_DATE; ?></td>
                        <td><?php echo $PHONE; ?></td>
                        <td><?php echo $EMAIL; ?></td>
                        <td><?php echo $SENDING_COUNTRY; ?></td>
                        <td><?php echo $PREFFERED_COUNTRY; ?></td>
                        <td><?php echo $LAST_TRANSACTION_DATE; ?><br> <?php echo $TRANSACTION_COUNT; ?></td>
                        <td><?php echo $STATUS_TITLE_STATUS; ?><br> <small><?php echo $LEAD_STATUS_DATED; ?></small></td>
                        <?php
                        $calling_lead_comments = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
                        $query_counts = mysqli_num_rows($calling_lead_comments);
                        ?>
                        <td style="display: none;"><?php $counter = 1;
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
                                $LEAD_CMT_ID = $all_comments['LEAD_TAGS'];
                                if (!empty($LEAD_CMT_ID)) {
                                    $lead_comments = mysqli_query($link, "SELECT * FROM lead_tags WHERE id IN ($LEAD_CMT_ID)");
                                    $query_count = mysqli_num_rows($lead_comments);
                                    // Rest of your code remains the same

                                    foreach ($lead_comments as $all_comment) {
                                        if ($counter1 < $query_counts) {
                                            echo $all_comment['HEADING'] . ' | ';
                                        } else {
                                            echo $all_comment['HEADING'] . ' ';
                                        }


                                        $counter1++;
                                    }
                                }
                            } ?>
                        </td>

                        <td style="display: none;"><?php $counter2 = 1;
                                                    foreach ($calling_lead_comments as $all_comments) {
                                                        if (mysqli_num_rows($lead_comments) > 0) {
                                                            $COMMENT_HEADING = $all_comments['comments'];
                                                            if (!empty($COMMENT_HEADING)) {
                                                                if ($counter2 < $query_counts) {
                                                                    echo $COMMENT_HEADING . ' | ';
                                                                } else {
                                                                    echo $COMMENT_HEADING;
                                                                }
                                                            }

                                                            $counter2++;
                                                        }
                                                    } ?></td>

                    </tr>
        <?php
                }
            }
        }
        ?>
    </tbody>
</table>