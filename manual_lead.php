<?php include('inc_meta_header.php'); ?>
<title>
    <?php
    $page_link_url = basename($_SERVER['PHP_SELF']);
    $plu_del_ext = rtrim($page_link_url, ' .php');
    echo $plu_del_rep = ucwords(str_replace("_", " ", $plu_del_ext));
    ?>

    <?php include('inc_page_title.php'); ?>
</title>
<?php include('inc_head.php'); ?>
<?php include('export_js.php'); ?>

<?php
if (isset($_GET['del'])) {
    $del = $_GET['del'];

    //UPDATE SQL Statement
    $sql = "DELETE FROM `calling_lead` WHERE ID = $del";
    $sql = "DELETE FROM `calling_lead_comments` WHERE LEAD_R_ID = $del";
    mysqli_query($link, "DELETE FROM `calling_lead` WHERE ID = $del");
    mysqli_query($link, "DELETE FROM `calling_lead_comments` WHERE LEAD_R_ID = $del");
    mysqli_query($link, "DELETE FROM `calling_comments_call` WHERE Cl_ID = $del");
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?delete=y'</script>");
}

//============ Approve Unapprove in List ================

if (isset($_REQUEST['actc'])) {
    $RID = $_REQUEST['id'];

    if ($_REQUEST['actc'] == 'app') {
        $sql = "UPDATE admin SET STATUS='1' WHERE ID=$RID ";
    } else if ($_REQUEST['actc'] == 'unapp') {
        $sql = "UPDATE admin SET STATUS='0' WHERE ID=$RID ";
    }

    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "'</script>");
}

?>
<style>
    .pm_0 {
        padding: 0;
        margin: 0;
    }
</style>


<body class="nav-md" style="height: 100vh;">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
            <!-- breadcrumb -->
            <div class="breadcrumb_content">
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboard</a> / <?= $plu_del_rep; ?>
                </div>
            </div>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <?php
                    $date_from = isset($_GET['search']) && isset($_GET['date_from']) && !empty($_GET['date_from']) ? $_GET['date_from'] : '';
                    $date_to = isset($_GET['search']) && isset($_GET['date_to']) && !empty($_GET['date_to']) ? $_GET['date_to'] : '';
                    $agent = isset($_GET['search']) &&  isset($_GET['agent']) && !empty($_GET['agent']) ? $_GET['agent'] : '';
                    $err_html = isset($_GET['search']) && empty($date_from) &&  empty($date_to) ?
                        '<div class="alert alert-danger"><div class="container"><strong>Both Dates are Required</strong></div></div>' : '';
                    if (!empty($date_from) || !empty($date_to)) {
                        $agent_filter = !empty($agent) ? "AND USERID='$agent'" : '';
                        $date_from_to = !empty($date_from) && !empty($date_to) ? "AND DATE(DATED) BETWEEN '$date_from' AND '$date_to' $agent_filter" : '';
                        $err_html = (empty($date_from) && !empty($date_to)) ?
                            '<div class="alert alert-danger"><div class="container"><strong>From Date is Required</strong></div></div>' : ((!empty($date_from) && empty($date_to)) ?
                                '<div class="alert alert-danger"><div class="container"><strong>To Date is Required</strong></div></div>' : '');
                        // Determine current page number
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        // Number of records to display per page
                        $records_per_page = 20;
                        // Query string parameters
                        $params = $_GET;
                        unset($params['page']); // Remove the 'page' parameter
                        // Calculate the starting point of the records
                        $offset = ($page - 1) * $records_per_page;
                        $invalid_lead_sts = 0;
                        $total_records = 0;
                        // Calculate the starting point of the records
                        $calling_leads_query = "SELECT * FROM `calling_lead` WHERE MANUAL_LEAD='1' $date_from_to";
                        $calling_leads = mysqli_query($link, "$calling_leads_query LIMIT " . $offset . "," . $records_per_page);
                        $total_records = $link->query($calling_leads_query)->num_rows;
                        $total_pages = ceil($total_records / $records_per_page);
                    } else {
                        $calling_leads = '';
                    }
                    ?>
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                        <div class="col-lg-12 pm_0" style="display: flex;flex-direction: row; justify-content: center;">
                            <div class="col-lg-3 pm_0">
                                <input type="date" class="form-control input-date-picker datepicker-dropdown " id="date_from" name="date_from" placeholder="Start Date" autocomplete="off" value="<?= $date_from; ?>" />
                            </div>
                            <div class="col-lg-1 pm_0">
                                <span class="input-group-addon" style="padding: 9px 0;"><i class="fa fa-angle-left"></i> <span class="text-danger">*</span> From DATE To <span class="text-danger">*</span> <i class="fa fa-angle-right"></i></span>
                            </div>
                            <div class="col-lg-3 pm_0">
                                <input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?= $date_to; ?>" />
                            </div>
                            <div class="col-lg-1 pm_0">
                                <span class="input-group-addon" style="padding: 9px 0;"> Agent </span>
                            </div>
                            <div class="col-lg-3 pm_0">
                                <select name="agent" class="form-control">
                                    <option selected hidden disabled>SELECT</option>
                                    <option value="" style="font-weight: bold;text-align: center;">Reset</option>
                                    <?php
                                    $calling_lead_agents = mysqli_query($link, "SELECT * FROM `calling_lead_agents`");
                                    foreach ($calling_lead_agents as $calling_lead_agent) {
                                    ?>
                                        <option value="<?= $calling_lead_agent['ID']; ?>" <?= ($_GET['agent'] ?? '') == $calling_lead_agent['ID'] ? 'selected' : '' ?>><?= $calling_lead_agent['PERSON_NAME']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" name="search" class="btn btn-success col-lg-12"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                    <?= $err_html; ?>
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?= $plu_del_rep; ?></h3>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="progress" style="margin: 10px;display: none;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            <span class="sr-only">0% Complete</span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" style="display: flex;flex-direction: row; justify-content: space-between;">
                                    <h4><?= $plu_del_rep; ?></h4>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="<?= basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li>
                                            <button type="button" id="btnExport" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="x_content">
                                    <table id="example" class="col-lg-12 table-striped table-condensed cf tbl">
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
                                </div>
                                <?php if (!empty($calling_leads)) {
                                    include('pagination.php');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <?php include('inc_footer.php'); ?>
        </div>
    </div>
    <?php include('inc_foot.php'); ?>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').slideUp('slow');
            }, 3000);
        });
    </script>
    <script>
        $('#btnExport').click(function(e) {
            e.preventDefault();
            $('#btnExport').button('loading');
            $('.progress').show();
            let calling_leads = "<?php echo $calling_leads_query; ?>";
            $.get('export/manual_lead.php?calling_leads=' + calling_leads, function(data) {
                var progressBar = $('.progress-bar');
                var progressWidth = 0;
                var interval = setInterval(function() {
                    progressWidth += 1;
                    progressBar.css('width', progressWidth + '%').attr('aria-valuenow', progressWidth).text(progressWidth + '%');
                    $('.progress-text').text(progressWidth + '%'); // Update text element with progress percentage
                    if (progressWidth >= 100) {
                        var tableId = "leads_export"; // assign an id to the new table element
                        var newTable = $("<table>").attr("id", tableId).html(data);
                        $("body").append(newTable); // append the new table to the body
                        xport.toCSV(tableId);
                        newTable.remove(); // remove the new table after the export is done
                        $('#btnExport').button('reset');
                        clearInterval(interval);
                        setInterval(function() {
                            $('.progress').hide();
                        }, 5000);
                    }
                }, 200); // Set interval to 100ms for faster updates
            });
        });
    </script>