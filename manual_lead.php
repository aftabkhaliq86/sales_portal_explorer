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
                <div class="breadcrumb_text"><a href="dashboard.php">Dashboard</a> / <?php echo $plu_del_rep; ?>
                </div>
            </div>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <?php
                    $date_from = '';
                    $date_to = '';
                    $agent = '';
                    $agent_filter = '';
                    $date_filter = '';
                    $err_html = '';
                    if (isset($_POST['search'])) {
                        if (isset($_POST['date_from']) && !empty($_POST['date_from']) && isset($_POST['date_to']) && !empty($_POST['date_to'])) {
                            $date_from = $_POST['date_from'];
                            $date_to = $_POST['date_to'];
                            if (isset($_POST['agent']) && !empty($_POST['agent'])) {
                                $agent = $_POST['agent'];
                                $agent_filter = "AND USERID='$agent'";
                            }
                            $date_filter = "AND DATE(DATED) BETWEEN '$date_from' AND '$date_to' $agent_filter";
                        } else {
                            if (empty($date_from) && empty($date_to)) {
                                $err_html = '<div class="alert alert-danger">
                                    <div class="container"><strong>Both Dates are Required</strong></div>
                                </div>';
                            } else {
                                if (empty($date_from)) {
                                    $err_html = '<div class="alert alert-danger">
                                        <div class="container"><strong>From Date is Required</strong></div>
                                    </div>';
                                }
                                if (empty($date_to)) {
                                    $err_html = '<div class="alert alert-danger">
                                        <div class="container"><strong>To Date is Required</strong></div>
                                    </div>';
                                }
                            }
                        }
                    }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="col-lg-12 pm_0" style="display: flex;flex-direction: row; justify-content: center;">
                            <div class="col-lg-3 pm_0">
                                <input type="date" class="form-control input-date-picker datepicker-dropdown " id="date_from" name="date_from" placeholder="Start Date" autocomplete="off" value="<?php if (!empty($date_from)) {
                                                                                                                                                                                                        echo $_POST['date_from'];
                                                                                                                                                                                                    } ?>" />
                            </div>
                            <div class="col-lg-1 pm_0">
                                <span class="input-group-addon" style="padding: 9px 0;"><i class="fa fa-angle-left"></i> <span class="text-danger">*</span> From DATE To <span class="text-danger">*</span> <i class="fa fa-angle-right"></i></span>
                            </div>
                            <div class="col-lg-3 pm_0">
                                <input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?php if (!empty($date_to)) {
                                                                                                                                                                            echo $_POST['date_to'];
                                                                                                                                                                        } ?>" />
                            </div>
                            <div class="col-lg-1 pm_0">
                                <span class="input-group-addon" style="padding: 9px 0;"> Agent </span>
                            </div>
                            <div class="col-lg-3 pm_0">
                                <select name="agent" class="form-control">
                                    <option selected hidden disabled>SELECT</option>
                                    <?php
                                    $calling_lead_agents = mysqli_query($link, "SELECT * FROM `calling_lead_agents`");
                                    foreach ($calling_lead_agents as $calling_lead_agent) {
                                    ?>
                                        <option value="<?php echo $calling_lead_agent['ID']; ?>" <?php if (!empty($agent) && $calling_lead_agent['ID'] == $agent) {
                                                                                                        echo "selected";
                                                                                                    } ?>><?php echo $calling_lead_agent['PERSON_NAME']; ?></option>
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
                    <?php echo $err_html; ?>
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $plu_del_rep; ?></h3>
                        </div>

                    </div>
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" style="display: flex;flex-direction: row; justify-content: space-between;">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        <li>
                                            <button type="button" id="btnExport" onclick="javascript:xport.toCSV('example');" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
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
                                            if (isset($_POST['search']) && !empty($date_filter)) {
                                                $calling_leads = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE MANUAL_LEAD='1' $date_filter");
                                                if (mysqli_num_rows($calling_leads) > 0) {
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
                                                            <td data-title="Date"><?php echo $DATED; ?></td>
                                                            <td data-title="Rmsid"><small><?php echo $RMS_ID; ?></small></td>
                                                            <td data-title="Phone"><?php echo $PHONE; ?></td>
                                                            <td data-title="Email"><?php echo $EMAIL; ?></td>
                                                            <td data-title="Sending_country"><?php if (!empty($SENDING_COUNTRY)) {
                                                                                                    echo $SENDING_COUNTRY['name'];
                                                                                                } ?></td>
                                                            <td data-title="Preffered_country"><?php if (!empty($PREFFERED_COUNTRY)) {
                                                                                                    echo $PREFFERED_COUNTRY['name'];
                                                                                                } ?></td>
                                                            <td><?php echo $PERSON_NAME; ?><br><small><?php echo $U_DATED; ?></small></td>
                                                            <td>
                                                                <?php if ($LEAD_STATUS != NULL) { ?>
                                                                    <?php echo $STATUS_TITLE_STATUS; ?><br>
                                                                    <small><?php echo $LEAD_STATUS_DATED; ?></small>
                                                                <?php

                                                                } ?>
                                                            </td>
                                                            <td data-title="Action" class="al-center"><a href="calling_lead_comment_preview.php?id=<?php echo $ID; ?>&mnl=1" data-toggle="tooltip" data-placement="top" title="Preview" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
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
                                            }
                                            ?>
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
            setTimeout(function() {
                $('.alert').slideUp('slow');
            }, 3000);
        });
    </script>