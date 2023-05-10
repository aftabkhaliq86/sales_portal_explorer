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
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
}

$lead_name_get = mysqli_query($link, "SELECT LEAD_CATEGORY, LEAD_DATE FROM `calling_lead_title` WHERE ID='$ID'");
while ($row_lng = mysqli_fetch_array($lead_name_get)) {
    $LEAD_CATEGORY_lng = $row_lng['LEAD_CATEGORY'];
    $LEAD_DATE_lng = $row_lng['LEAD_DATE'];
}

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    //UPDATE SQL Statement
    $sql = "DELETE FROM calling_lead WHERE ID = $del";
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?delete=y'</script>");
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
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboard</a> / <?php echo $plu_del_rep; ?>
                </div>
            </div>
            <!-- /breadcrumb -->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $LEAD_CATEGORY_lng; ?> <small>- <?php echo $LEAD_DATE_lng; ?></small></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?id=<?php echo $LEADTID ?>" class="btn btn-default btn-xs pull-right" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a>

                                    <button type="button" id="btnExport" onclick="javascript:xport.toCSV('example');" class="btn btn-default btn-xs pull-right"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>

                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>

                                    <div class="container">
                                        <?php
                                        $USERIDCI = '';
                                        $USERIDC = '';
                                        $USERID = '';
                                        $result_person_counter = mysqli_query($link, "SELECT COUNT(USERID) AS USERIDC, USERID FROM `calling_lead` WHERE LEADTID='$ID' GROUP BY USERID");
                                        $counters = '0';
                                        while ($row_pc = mysqli_fetch_array($result_person_counter)) {
                                            $USERIDC = $row_pc['USERIDC'];
                                            $USERID = $row_pc['USERID'];

                                            $result_person_counteri = mysqli_query($link, "SELECT COUNT(USERID) AS USERIDC, USERID FROM `calling_lead` WHERE LEADTID='$ID' AND USERID='$USERID' AND STATUS='1' GROUP BY USERID");
                                            $USERIDCI = 0;
                                            while ($row_pci = mysqli_fetch_array($result_person_counteri)) {
                                                $USERIDCI = $row_pci['USERIDC'];
                                            }
                                            $PERSON_NAME = '';
                                            $result_person_names = mysqli_query($link, "SELECT PERSON_NAME FROM `calling_lead_agents` WHERE ID='$USERID'");
                                            while ($row_pn = mysqli_fetch_array($result_person_names)) {
                                                $PERSON_NAME = $row_pn['PERSON_NAME'];
                                            }

                                            $counters = $counters + 1;
                                        ?>
                                            <div class="col-lg-2 c2i btn btn-default al-center">
                                                <span class="fa-2x"><?php echo $USERIDC; ?> / <?php echo $USERIDCI; ?></span><br>
                                                <?php echo $counters; ?>. <?php echo $PERSON_NAME; ?>
                                            </div>
                                        <?php } ?>

                                    </div>

                                    <table id="example" class="col-lg-12 table-striped table-condensed cf tbl table-responsive">
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
                                                <th style="display: none;">Status Summary</th>
                                                <td style="display: none;">Comments</td>
                                                <th style="display: none;">Call Summary</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $LEAD_STATUS_sclc = '';
                                            $STATUS_TITLE_STATUS = '';
                                            $DATED_sclc = '';

                                            $result = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE LEADTID='$ID' ORDER BY DATED");
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
                                                $result_calling_lead_agents = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `calling_lead_agents` WHERE ID='$USERID'"));
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
                                                    <td><?php echo $result_calling_lead_agents['PERSON_NAME']; ?><br><small><?php echo $U_DATED; ?></small></td>
                                                    <td><?php if ($DATED_sclc != NULL) { ?> <?php echo $STATUS_TITLE_STATUS; ?><br><small><?php echo $DATED_sclc; ?></small><?php } ?></td>
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
                                                                                    $call_date = date('Y-m-d', strtotime($three_cx_call['call_time']));
                                                                                    $call_start_time = date('h:i:s', strtotime($three_cx_call['call_time']));
                                                                                    $duration = $three_cx_call['duration'];
                                                                                    // Create a DateTime object for the call start time
                                                                                    $start_time = new DateTime($call_start_time);
                                                                                    // Split the duration into hours, minutes, and seconds
                                                                                    $duration_parts = explode(':', $duration);
                                                                                    $duration_hours = $duration_parts[0];
                                                                                    $duration_minutes = $duration_parts[1];
                                                                                    $duration_seconds = $duration_parts[2];
                                                                                    // Create a DateInterval object for the duration
                                                                                    $duration_interval = new DateInterval('PT' . $duration_hours . 'H' . $duration_minutes . 'M' . $duration_seconds . 'S');
                                                                                    // Add the duration to the call start time
                                                                                    $end_time = $start_time->add($duration_interval);
                                                                                    // Format the end time as a string in the desired format
                                                                                    $call_end_time = $end_time->format('h:i:s');

                                                                                    if ($counter2 < $three_cx_call_logs_count) {
                                                                                        echo $call_date . ' [ ' . $call_start_time . ' - ' . $call_end_time . ' ] | ';
                                                                                    } else {
                                                                                        echo $call_date . ' [ ' . $call_start_time . ' - ' . $call_end_time . ' ] ';
                                                                                    }
                                                                                    $counter2++;
                                                                                } ?></td>
                                                    <td data-title="Action" class="al-center"><a href="calling_lead_comment_preview.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Preview" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
        $(document).ready(function() {
            $('#example').DataTable();
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