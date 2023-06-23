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

<script>
    var xport = {
        _fallbacktoCSV: true,
        toXLS: function(tableId, filename) {
            this._filename = (typeof filename == 'undefined') ? tableId : filename;

            //var ieVersion = this._getMsieVersion();
            //Fallback to CSV for IE & Edge
            if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
                return this.toCSV(tableId);
            } else if (this._getMsieVersion() || this._isFirefox()) {
                alert("Not supported browser");
            }

            //Other Browser can download xls
            var htmltable = document.getElementById(tableId);
            var html = htmltable.outerHTML;

            this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
        },
        toCSV: function(tableId, filename) {

            this._filename = (typeof filename === 'undefined') ? tableId : filename;
            // Generate our CSV string from out HTML Table
            var csv = this._tableToCSV(document.getElementById(tableId));
            // Create a CSV Blob
            var blob = new Blob([csv], {
                type: "text/csv"
            });

            // Determine which approach to take for the download
            if (navigator.msSaveOrOpenBlob) {
                // Works for Internet Explorer and Microsoft Edge
                navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
            } else {
                this._downloadAnchor(URL.createObjectURL(blob), 'csv');
            }
        },
        _getMsieVersion: function() {
            var ua = window.navigator.userAgent;

            var msie = ua.indexOf("MSIE ");
            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
            }

            var trident = ua.indexOf("Trident/");
            if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf("rv:");
                return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
            }

            var edge = ua.indexOf("Edge/");
            if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
            }

            // other browser
            return false;
        },
        _isFirefox: function() {
            if (navigator.userAgent.indexOf("Firefox") > 0) {
                return 1;
            }

            return 0;
        },
        _downloadAnchor: function(content, ext) {
            var anchor = document.createElement("a");
            anchor.style = "display:none !important";
            anchor.id = "downloadanchor";
            document.body.appendChild(anchor);

            // If the [download] attribute is supported, try to use it

            if ("download" in anchor) {
                anchor.download = this._filename + "." + ext;
            }
            anchor.href = content;
            anchor.click();
            anchor.remove();
        },
        _tableToCSV: function(table) {
            // We'll be co-opting `slice` to create arrays
            var slice = Array.prototype.slice;

            return slice
                .call(table.rows)
                .map(function(row) {
                    return slice
                        .call(row.cells)
                        .map(function(cell) {
                            return '"t"'.replace("t", cell.textContent);
                        })
                        .join(",");
                })
                .join("\r\n");
        }
    };
</script>

<?php
$LEADTID = !empty($_GET['id']) ? $_GET['id'] : '';
$date_from = !empty($_POST['date_from']) ? date('Y-m-d', strtotime($_POST['date_from'])) : '';
$date_to = !empty($_POST['date_to']) ? date('Y-m-d', strtotime($_POST['date_to'])) : '';
if (!empty($date_from) && !empty($date_to)) {
    $live_lead_query =  "UPDATE `calling_lead` SET `STATUS`='2' WHERE  DATE(`DATED`) BETWEEN '$date_from' AND '$date_to' AND MANUAL_LEAD = 1 AND `STATUS`='1'";
    if (!mysqli_query($link, $live_lead_query)) {
        echo "ERROR: Could not able to execute $live_lead_query. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$LEADTID&updated=y'</script>");
}

$lead_name_get = mysqli_query($link, "SELECT LEAD_CATEGORY, LEAD_DATE FROM `calling_lead_title` WHERE ID='$LEADTID'");
while ($row_lng = mysqli_fetch_array($lead_name_get)) {
    $LEAD_CATEGORY_lng = $row_lng['LEAD_CATEGORY'];
    $LEAD_DATE_lng = $row_lng['LEAD_DATE'];
}

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    $AGID = $_GET['AGID'];
    $LEADTID = $_GET['LEADTID'];
    //UPDATE SQL Statement
    $sql = "DELETE FROM calling_lead WHERE ID = $del";
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$LEADTID&AGID=$AGID&delete=y'</script>");
}
if (isset($_POST['detach'])) {
    $calling_lead_id = $_POST['calling_lead_id'];
    $total_selected = count($calling_lead_id);
    $lead_ids = '';
    $counter = 0;
    foreach ($calling_lead_id as $lead_id) {
        $lead_ids .= ($counter === 0) ? $lead_id : ',' . $lead_id;
        $counter++;
    }
    $sql = "UPDATE calling_lead SET USERID=NULL,U_DATED=NULL WHERE ID IN ($lead_ids) ";
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
//============ Approve Unapprove in List ================
if (isset($_REQUEST['actc'])) {
    $RID = $_REQUEST['id'];
    if ($_REQUEST['actc'] == 'app') {
        $sql = "UPDATE calling_lead_agents SET STATUS='1' WHERE ID=$RID ";
    } else if ($_REQUEST['actc'] == 'unapp') {
        $sql = "UPDATE calling_lead_agents SET STATUS='0' WHERE ID=$RID ";
    }
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "'</script>");
}
?>

<body class="nav-md">

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
            <!-- /breadcrumb -->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?= $LEAD_CATEGORY_lng; ?> <small>- <?= $LEAD_DATE_lng; ?></small></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if ($LEAD_CATEGORY_lng == 'Live Lead') {
                    ?>
                        <div class="container" id="filters">
                            <form name="" class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] . '?id=' . $LEADTID ?>" method="POST">
                                <div class="form-group al-right">
                                    <div class="col-lg-10">
                                        <div class="input-daterange input-group">
                                            <span class="input-group-addon">Dated :</span>
                                            <input type="date" class="form-control" name="date_from" placeholder="Start Date" autocomplete="off" value="<?= $date_from; ?>" required />
                                            <span class="input-group-addon">to</span>
                                            <input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?= $date_to; ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" class="btn btn-success btn-block">In Active</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h4><?= $plu_del_rep; ?></h4>
                                    <a href="<?= basename($_SERVER['PHP_SELF']) ?>?id=<?= $LEADTID ?>" class="btn btn-default btn-xs pull-right" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a>

                                    <button type="button" id="btnExport" class="btn btn-default btn-xs pull-right"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>

                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_GET['updated'])) { ?>
                                        <div class="alert alert-success">
                                            <div class="container"><strong>Row Updated Succesfully!</strong></div>
                                        </div>
                                    <?php } ?>

                                    <div class="container">
                                        <?php
                                        $calling_lead_query = "SELECT COUNT(cl.USERID) AS USERID_COUNT, `cl`.`USERID`, `clg`.`ID` AS `AGID`, `clg`.`PERSON_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_agents` AS `clg` ON `cl`.`USERID`=`clg`.`ID` WHERE LEADTID='$LEADTID' ";
                                        $calling_lead_query_extend = "$calling_lead_query GROUP BY USERID";
                                        $calling_lead = mysqli_query($link, $calling_lead_query_extend);
                                        $counters = '0';
                                        foreach ($calling_lead as $lead) {
                                            $USERID = $lead['USERID'];
                                            $AGID = $lead['AGID'];
                                            $PERSON_NAME = $lead['PERSON_NAME'] ? $lead['PERSON_NAME'] : '';
                                            $USERID_COUNTS = mysqli_query($link, "$calling_lead_query AND `cl`.`USERID`='$USERID' AND `cl`.`STATUS`!='2' GROUP BY `cl`.`USERID`");
                                            $USERID_COUNT = mysqli_fetch_array($USERID_COUNTS);
                                            $Total_USERID_COUNT = $USERID_COUNT ? $USERID_COUNT['USERID_COUNT'] : 0;
                                            $used_leads = mysqli_query($link, "$calling_lead_query AND `cl`.`USERID`='$USERID' AND `cl`.`STATUS`='1' GROUP BY `cl`.`USERID`");
                                            $used_lead = mysqli_fetch_array($used_leads);
                                            $USED_USERID_COUNT = $used_lead ? $used_lead['USERID_COUNT'] : 0;
                                            $AGID_LEAD = !empty($_GET['AGID']) ? trim($_GET['AGID']) : '';
                                            $counters++;
                                        ?>
                                            <a href="<?= basename($_SERVER['PHP_SELF']) . "?id=" . $LEADTID ?>&AGID=<?= $AGID; ?>" class="col-lg-2 c2i btn <?= ($USERID ?? '') == $AGID_LEAD ? 'btn-success' : 'btn-default' ?> al-center">
                                                <span class="fa-2x"><?= $USED_USERID_COUNT; ?> / <?= $Total_USERID_COUNT; ?></span><br>
                                                <?= $counters; ?>. <?= $PERSON_NAME; ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="progress" style="margin: 10px;display: none;">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            <span class="sr-only">0% Complete</span>
                                        </div>
                                    </div>
                                    <?php if (isset($_GET['AGID']) && !empty($_GET['AGID'])) { ?>
                                        <form action="" method="post">
                                            <table id="leads" class="col-lg-12 table-striped table-condensed cf tbl table-responsive">
                                                <thead class="cf">
                                                    <tr>
                                                        <th>#</th>
                                                        <th></th>
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
                                                        <th style="display: none;">Status Summary</th>
                                                        <td style="display: none;">Comments</td>
                                                        <th style="display: none;">Call Summary</th>
                                                        <th class="al-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET['AGID'])) {
                                                        // Determine current page number
                                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                                                        // Number of records to display per page
                                                        $records_per_page = 10;

                                                        // Query string parameters
                                                        $params = $_GET;
                                                        unset($params['page']); // Remove the 'page' parameter

                                                        // Calculate the starting point of the records
                                                        $offset = ($page - 1) * $records_per_page;
                                                        $total_records = 0;


                                                        $invalid_lead_sts = 0;
                                                        $AGID = $_GET['AGID'];
                                                        $LEAD_STATUS_sclc = '';
                                                        $STATUS_TITLE_STATUS = '';
                                                        $DATED_sclc = '';
                                                        $query = "SELECT `cl`.*,`clg`.`PERSON_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_agents` AS `clg` ON `cl`.`USERID`=`clg`.`ID` WHERE `cl`.`LEADTID`='$LEADTID' AND `cl`.`USERID`='$AGID' AND `cl`.`STATUS`!='2' ORDER BY `cl`.`DATED`";
                                                        $result =  $link->query($query . "LIMIT " . $offset . "," . $records_per_page);
                                                        $total_records = $link->query($query)->num_rows;
                                                        $total_pages = ceil($total_records / $records_per_page);
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
                                                                <td><?php if (mysqli_num_rows($sel_calling_lead_comments) == 0) {  ?><input type="checkbox" name="calling_lead_id[]" id="Detach" value="<?= $ID; ?>"><?php } ?></td>
                                                                <td><?= $DATED; ?></td>
                                                                <td><?= $RMS_ID; ?></td>
                                                                <td><a href="tel:8<?= $PHONE; ?>"><?= $PHONE; ?></a></td>
                                                                <td><?= $EMAIL; ?></td>
                                                                <td><?= $SENDING_COUNTRY; ?></td>
                                                                <td><?= $PREFFERED_COUNTRY; ?></td>
                                                                <td><?= $REGISTER_DATE; ?></td>
                                                                <td><?= $LAST_TRANSACTION_DATE; ?><br><?= $TRANSACTION_COUNT; ?></td>
                                                                <td><?php if (!empty($row['PERSON_NAME'])) {
                                                                        echo $row['PERSON_NAME']; ?><br><small><?= $U_DATED;
                                                                                                            } ?></small></td>
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
                                                                <td style="display: none;"><?php $counter1 = 1;
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
                                                                <td style="display: none;"><?php $counter2 = 1;
                                                                                            $three_cx_call_logs = mysqli_query($link, "SELECT * FROM `three_cx_call_logs` WHERE CI_ID='$ID'");
                                                                                            $three_cx_call_logs_count = mysqli_num_rows($three_cx_call_logs);
                                                                                            foreach ($three_cx_call_logs as $three_cx_call) {
                                                                                                $call_time = $three_cx_call['call_time'];
                                                                                                $duration = $three_cx_call['duration'];
                                                                                                if ($counter2 < $three_cx_call_logs_count) {
                                                                                                    echo $call_time . ' [ ' . $duration . ' ] | ';
                                                                                                } else {
                                                                                                    echo $call_time . ' [ ' . $duration . ' ] ';
                                                                                                }
                                                                                                $counter2++;
                                                                                            } ?></td>
                                                                <td><?php if ($DATED_sclc != NULL) { ?> <?= $STATUS_TITLE_STATUS; ?><br><small><?= $DATED_sclc; ?></small><?php } ?></td>
                                                                <td data-title="Action" class="al-center"><a href="calling_lead_comment_preview.php?id=<?= $ID; ?>" data-toggle="tooltip" data-placement="top" title="Preview" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a><a href="<?= basename($_SERVER['PHP_SELF']) . "?del=" . $ID . '&AGID=' . $USERID . '&LEADTID=' . $LEADTID; ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                            <?php include('pagination.php'); ?>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                                <ul class="pagination pagination-lg">
                                                    <li class="active"><button type="submit" name="detach" class="btn btn-warning btn-md">Detach</button></li>
                                                </ul>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
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
        $('#btnExport').click(function(e) {
            e.preventDefault();
            $('#btnExport').button('loading');
            $('.progress').show();
            let ID = '<?= $_GET['id']; ?>';
            let AGID = '<?= !empty($_GET['AGID']) ? $_GET['AGID'] : ''; ?>';
            $.get('export/calling_lead_details.php?id=' + ID + '&AGID=' + AGID, function(data) {
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
    <script type="text/javascript">
        $(document).ready(function() {
            // submit form using $.ajax() method
            $('#product_add').submit(function(e) {
                e.preventDefault(); // Prevent Default Submission
                $.ajax({
                        url: 'calling_lead_agents_add.php',
                        type: 'POST',
                        data: $(this).serialize() // it will serialize the form data
                    })
                    .done(function(data) {
                        $('#form-content').fadeOut('slow', function() {
                            $('#form-content').fadeIn('slow').html(data);
                        });
                    })
                    .fail(function() {
                        alert('Ajax Submit Failed ...');
                    });
            });
        });
    </script>