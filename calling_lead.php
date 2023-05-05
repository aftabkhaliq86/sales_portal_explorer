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
    $sql = "DELETE FROM calling_lead_title WHERE ID = $del";
    $sql1 = "DELETE FROM calling_lead WHERE LEADTID = $del";
    mysqli_query($link, $sql);
    mysqli_query($link, $sql1);
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
                            <h3><?php echo $plu_del_rep; ?></h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" style="display: flex;flex-direction: row; justify-content: space-between;">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <div class="clearfix">
                                        <button type="button" id="btnExport" onclick="javascript:xport.toCSV('leads');" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
                                    </div>
                                </div>

                                <div class="row">

                                    <?php
                                    $sts = '';
                                    if (isset($_GET['sts'])) {
                                        $sts = $_GET['sts'];
                                    }

                                    ?>
                                    <div class="col-lg-5">
                                        <a href="calling_lead.php?sts=1" class="col-lg-12 btn <?php if ($sts == 1) {
                                                                                                    echo 'btn-success';
                                                                                                } else {
                                                                                                    echo 'btn-default';
                                                                                                } ?>  al-center">
                                            <h5><i class="fa fa-check"></i> Active</h5>
                                        </a>
                                    </div>
                                    <div class="col-lg-5">
                                        <a href="calling_lead.php?sts=2" class="col-lg-12 btn <?php if ($sts == 2) {
                                                                                                    echo 'btn-success';
                                                                                                } else {
                                                                                                    echo 'btn-default';
                                                                                                } ?>  al-center">
                                            <h5><i class="fa fa-times"></i> InActive</h5>
                                        </a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="calling_lead.php" class="col-lg-12 btn btn-default al-center">
                                            <h5><i class="fa fa-times"></i></h5>
                                        </a>
                                    </div>
                                </div>

                                <div class="x_content">
                                    <?php
                                    if (isset($_POST['srchfilter'])) //submit button name
                                    {
                                        $srch_DATEFROM_ftp = $_POST['DATEFROM'];
                                        //echo '<br>';
                                        $srch_DATETO_ftp = $_POST['DATETO'];
                                        //echo '<hr>';
                                        //Get previous Date From-----------------------
                                        $srch_DATEFROM_ftp = strtotime($srch_DATEFROM_ftp);
                                        $srch_DATEFROM_ftp = date('Y-m-d', $srch_DATEFROM_ftp);
                                        //----------------------------------------------
                                        //echo '<br>';
                                        //Get previous Date To-----------------------
                                        $srch_DATETO_ftp = strtotime($srch_DATETO_ftp);
                                        $srch_DATETO_ftp = date('Y-m-d', $srch_DATETO_ftp);
                                        //----------------------------------------------
                                    }
                                    //exit;
                                    ?>
                                    <div class="container" id="filters">
                                        <form name="frmSRCH" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?sts=<?php echo $sts; ?>" method="post">
                                            <div class="form-group al-right">
                                                <label class="col-lg-1 control-label" style="padding:10px;">Dated :</label>
                                                <div class="col-lg-8">
                                                    <div class="input-daterange input-group">
                                                        <input type="date" class="form-control" name="DATEFROM" placeholder="Start Date" autocomplete="off" value="<?php echo $srch_DATEFROM_ftp; ?>" />
                                                        <span class="input-group-addon">to</span>
                                                        <input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" value="<?php echo $srch_DATETO_ftp; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="submit" name="srchfilter" class="btn btn-success btn-block">Search <i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="col-lg-1">
                                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-warning"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>

                                    <table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>DATED</th>
                                                <th>Lead Category</th>
                                                <th>Lead Date</th>
                                                <th>Lead Report</th>
                                                <th>Status</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['srchfilter'])) //submit button name
                                            {
                                                $srch_DATEFROM = $_POST['DATEFROM'];
                                                //echo '<br>';
                                                $srch_DATETO = $_POST['DATETO'];
                                                //echo '<hr>';
                                                //Get previous Date From-----------------------
                                                $srch_DATEFROM = strtotime($srch_DATEFROM);
                                                //$srch_DATEFROM = strtotime('-1 day', $srch_DATEFROM);
                                                $srch_DATEFROM = date('Y-m-d', $srch_DATEFROM);
                                                //----------------------------------------------
                                                //echo '<br>';
                                                //Get previous Date To-----------------------
                                                $srch_DATETO = strtotime($srch_DATETO);
                                                $srch_DATETO = strtotime('+1 day', $srch_DATETO);
                                                $srch_DATETO = date('Y-m-d', $srch_DATETO);
                                                //----------------------------------------------

                                                if ($srch_DATEFROM != NULL && $srch_DATETO != NULL) {
                                                    if ($sts == 1) {
                                                        $sts_query = "AND `STATUS`='1'";
                                                    } else if ($sts == 2) {
                                                        $sts_query = "AND `STATUS`='0'";
                                                    } else {
                                                        $sts_query = '';
                                                    }
                                                    $result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE DATED BETWEEN '$srch_DATEFROM' AND '$srch_DATETO' $sts_query ORDER BY DATED");
                                                }
                                            } else {
                                                if ($sts == 1) {
                                                    $result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='1' ORDER BY DATED DESC");
                                                } elseif ($sts == 2) {
                                                    $result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='0' ORDER BY DATED DESC");
                                                } else {
                                                    $result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='1' ORDER BY DATED DESC");
                                                }
                                            }
                                            $counters = '0';
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ID = $row['ID'];
                                                $DATED = $row['DATED'];
                                                $LEAD_CATEGORY = $row['LEAD_CATEGORY'];
                                                $LEAD_DATE = $row['LEAD_DATE'];
                                                $STATUS = $row['STATUS'];
                                                $counters = $counters + 1;
                                                $result_calling_lead = mysqli_num_rows(mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS='1'"));
                                                $results = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID'");
                                                $result_count = mysqli_num_rows($results);
                                                $results1 = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS ='1'");
                                                $result_count1 = mysqli_num_rows($results1);
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $DATED; ?></td>
                                                    <td><?php echo $LEAD_CATEGORY; ?></td>
                                                    <td><?php echo $LEAD_DATE; ?></td>
                                                    <td><?php echo $result_count1; ?>/<?php echo $result_count; ?></td>
                                                    <td><?php if ($STATUS == '1') { ?><span class="bg-green text-white" style="padding: 5px; border-radius: 5px;">Active</span><?php } else { ?><span class="bg-red text-white" style="padding: 5px;border-radius: 5px;">InActive</span><?php } ?></td>
                                                    <td data-title="Action" class="al-center"><a href="calling_lead_details.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a><a href="calling_lead_edit.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a><?php if ($result_calling_lead == 0) { ?><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a><?php } ?></td>
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