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
                                            $AGID = '';
                                            $result_person_names = mysqli_query($link, "SELECT ID,PERSON_NAME FROM `calling_lead_agents` WHERE ID='$USERID'");
                                            while ($row_pn = mysqli_fetch_array($result_person_names)) {
                                                $AGID = $row_pn['ID'];
                                                $PERSON_NAME = $row_pn['PERSON_NAME'];
                                            }

                                            $counters = $counters + 1;
                                        ?>
                                            <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?id=" . $ID ?>&AGID=<?php echo $AGID; ?>" class="col-lg-2 c2i btn btn-default al-center">
                                                <span class="fa-2x"><?php echo $USERIDC; ?> / <?php echo $USERIDCI; ?></span><br>
                                                <?php echo $counters; ?>. <?php echo $PERSON_NAME; ?>
                                            </a>
                                        <?php } ?>

                                    </div>
                                    <div id="calling-lead">
                                        <?php if (isset($_GET['AGID'])) { ?>
                                            <div id="calling-loader">Loading.... Please Wait</div>
                                        <?php } ?>
                                    </div>
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
    <?php if (isset($_GET['AGID'])) { ?>
        <script>
            $(document).ready(function() {
                let AGID = '<?php echo $_GET['AGID'] ?>';
                $('#calling-lead').load(`ajax_load/calling_lead_details.php?id=<?php echo $ID; ?>&AGID=${AGID}`, function() {
                    $('#leads').DataTable();
                    $('#calling-loader').hide();
                });
            });
        </script>
    <?php } ?>
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