<?php include('../inc_php_funtions.php'); ?>
<table id="leads_export" class="col-lg-12 table-striped table-condensed cf tbl">
    <thead class="cf">
        <tr>
            <th>#</th>
            <th>DATED</th>
            <th>RMS ID</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Sending Country</th>
            <th>Preffered Country</th>
            <th>USER</th>
            <th>Lead Status</th>
            <th class="al-center">Action</th>
            <td style="display: none;">Comments</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['calling_leads'])) {
            $calling_leads = mysqli_query($link, "$_GET[calling_leads]");
        }
        if (!empty($calling_leads)) {
            foreach ($calling_leads as $index => $calling_lead) {
                $ID = $calling_lead['ID'];
                $DATED = $calling_lead['DATED'];
                $RMS_ID = $calling_lead['RMS_ID'];
                $PHONE = $calling_lead['PHONE'];
                $EMAIL = $calling_lead['EMAIL'];
                $PREFFERED_COUNTRY_ISO3 = $calling_lead['PREFFERED_COUNTRY'];
                $SENDING_COUNTRY_ISO3 = $calling_lead['SENDING_COUNTRY'];
                $USERID = $calling_lead['USERID'];
                $U_DATED = $calling_lead['U_DATED'];
                $LEAD_STATUS = $calling_lead['LEAD_STATUS'];
                $LEAD_STATUS_DATED = $calling_lead['LEAD_STATUS_DATED'];
                $STATUS = $calling_lead['STATUS'];
                $PREFFERED_COUNTRY = mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `currencies` WHERE iso3='$PREFFERED_COUNTRY_ISO3'"));
                $SENDING_COUNTRY = mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `currencies` WHERE iso3='$SENDING_COUNTRY_ISO3'"));

                $calling_lead_comments = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
                $calling_comments_call = mysqli_query($link, "SELECT * FROM `calling_comments_call` WHERE Cl_ID='$ID'");
                $calling_lead_comments_count = 0;
                $calling_comments_call_count = 0;
                if (mysqli_num_rows($calling_lead_comments) > 0) {
                    $calling_lead_comments_count = mysqli_num_rows($calling_lead_comments);
                }
                if (mysqli_num_rows($calling_comments_call) > 0) {
                    $calling_comments_call_count = mysqli_num_rows($calling_comments_call);
                }
                if ($LEAD_STATUS != NULL) {
                    $result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
                    $rows_ls = mysqli_fetch_array($result_lead_status);
                    $STATUS_TITLE_STATUS = $rows_ls['STATUS_HEADING'];
                }
                $result_calling_lead_agents = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `calling_lead_agents` WHERE ID='$USERID'"));
                if (!empty($result_calling_lead_agents)) {
                    $PERSON_NAME = $result_calling_lead_agents['PERSON_NAME'];
                } else {
                    $PERSON_NAME = '';
                }
        ?>
                <tr>
                    <td></td>
                    <td data-title="Date"><?= $DATED; ?></td>
                    <td data-title="Rmsid"><small><?= $RMS_ID; ?></small></td>
                    <td data-title="Phone"><?= $PHONE; ?></td>
                    <td data-title="Email"><?= $EMAIL; ?></td>
                    <td data-title="Sending_country"><?= !empty($SENDING_COUNTRY) ? $SENDING_COUNTRY['name'] : ''; ?></td>
                    <td data-title="Preffered_country"><?= !empty($PREFFERED_COUNTRY) ? $PREFFERED_COUNTRY['name'] : ''; ?></td>
                    <td><?= $PERSON_NAME; ?><br><small><?= $U_DATED; ?></small></td>
                    <td> <?= ($LEAD_STATUS !== NULL) ? $STATUS_TITLE_STATUS . '<br><small>' . $LEAD_STATUS_DATED . '</small>' : ''; ?></td>
                    <td data-title="Action" class="al-center"><a href="calling_lead_comment_preview.php?id=<?= $ID; ?>&mnl=1" data-toggle="tooltip" data-placement="top" title="Preview" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a><a href="<?= basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                    <td style="display: none;"> <?php $counter = 1;
                                                foreach ($calling_lead_comments as $calling_lead_comment) {
                                                    $LEAD_CMT_ID = $calling_lead_comment['LEAD_CMT_ID'];
                                                    $lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
                                                    if (mysqli_num_rows($lead_comments) > 0) {
                                                        $lead_comments_row = mysqli_fetch_array($lead_comments);
                                                        $COMMENT_HEADING = $lead_comments_row['HEADING'];
                                                        if ($COMMENT_HEADING == "Other") {
                                                            $COMMENT_AREA = $calling_lead_comment['COMMENT_AREA'];
                                                        } else {
                                                            $COMMENT_AREA = '';
                                                        }
                                                    } else {
                                                        $COMMENT_HEADING = '';
                                                    }
                                                    $result_statuses_i = mysqli_query($link, "SELECT `STATUS_HEADING` FROM `lead_status` WHERE ID='$calling_lead_comment[LEAD_STATUS]'");
                                                    while ($row_sts_i = mysqli_fetch_array($result_statuses_i)) {
                                                        $STATUS_HEADING_sts_i = $row_sts_i['STATUS_HEADING'];
                                                    }
                                                    if ($counter < $calling_lead_comments_count) {
                                                        echo $COMMENT_AREA_clcs =  "<strong>" . $STATUS_HEADING_sts_i . ':- </strong>' .  $COMMENT_HEADING  . ': ' . $COMMENT_AREA . '  [ Date: ' . $calling_lead_comment['DATED'] . ' ]';
                                                        echo "\r\n";
                                                    } else {
                                                        echo $COMMENT_AREA_clcs = "<strong>" . $STATUS_HEADING_sts_i . ':- </strong>' . $COMMENT_HEADING  . ': ' . $COMMENT_AREA . '  [ Date: ' . $calling_lead_comment['DATED'] . ' ] ';
                                                    }
                                                    $counter++;
                                                } ?></td>
                </tr>
        <?php }
        }
        ?>
    </tbody>
</table>