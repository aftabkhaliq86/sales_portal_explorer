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
    //UPDATE SQL Statements
    $sql = "DELETE FROM calling_lead_title WHERE ID = $del";
    $sql1 = "DELETE FROM calling_lead WHERE LEADTID = $del";

    if (!mysqli_query($link, $sql) || !mysqli_query($link, $sql1)) {
        echo "ERROR: Could not execute SQL. " . mysqli_error($link);
    }

    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?delete=y'</script>");
}
//============ Approve Unapprove in List ================
if (isset($_REQUEST['actc'])) {
    $RID = $_REQUEST['id'];
    $actc = $_REQUEST['actc'];
    $status = ($actc == 'app') ? '1' : (($actc == 'unapp') ? '0' : '');
    $sql = "UPDATE calling_lead_agents SET STATUS='$status' WHERE ID=$RID";
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
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
                                    $sts = !empty($_GET['sts']) ? $_GET['sts'] : '';
                                    $date_from = !empty($_GET['date_from']) ? date('Y-m-d', strtotime($_GET['date_from'])) : date('Y-m-d', strtotime('-61 days'));
                                    $date_to = !empty($_GET['date_to']) ? date('Y-m-d', strtotime($_GET['date_to'])) : date('Y-m-d');
                                    $leads_stats = "SELECT * FROM `calling_lead_title` WHERE DATE(`DATED`) BETWEEN '$date_from' AND '$date_to'";
                                    $active_leads = $link->query($leads_stats . " AND STATUS='1'")->num_rows;
                                    $inactive_leads = $link->query($leads_stats . " AND STATUS='0'")->num_rows;
                                    ?>
                                    <div class="col-lg-5">
                                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sts=1" class="col-lg-12 btn <?= $sts == 1 ? 'btn-success' : 'btn-default' ?>  al-center">
                                            <h5 class="col-lg-10 fa-2x"><i class="fa fa-check"></i> Active</h5>
                                            <h5 class="col-lg-2 fa-2x"> <?= $active_leads; ?></h5>
                                        </a>
                                    </div>
                                    <div class="col-lg-5">
                                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sts=2" class="col-lg-12 btn <?= $sts == 2 ? 'btn-success' : 'btn-default' ?>  al-center">
                                            <h5 class="col-lg-10 fa-2x"><i class="fa fa-times"></i> InActive</h5>
                                            <h5 class="col-lg-2 fa-2x"> <?= $inactive_leads; ?></h5>
                                        </a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="calling_lead.php" class="col-lg-12 btn btn-default al-center">
                                            <h5 class="fa-2x"><i class="fa fa-times"></i></h5>
                                        </a>
                                    </div>
                                </div>

                                <div class="x_content">
                                    <div class="container" id="filters">
                                        <form name="frmSRCH" class="form-horizontal" action="calling_lead.php?sts=<?php echo $sts; ?>" method="post">
                                            <div class="form-group al-right">
                                                <div class="col-lg-10">
                                                    <div class="input-daterange input-group">
                                                        <span class="input-group-addon">Dated :</span>
                                                        <input type="date" class="form-control" name="date_from" placeholder="Start Date" autocomplete="off" value="<?php echo $date_from; ?>" />
                                                        <span class="input-group-addon">to</span>
                                                        <input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?php echo $date_to; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="submit" name="srchfilter" class="btn btn-success btn-block">Search <i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="calling-lead">
                                        <div id="calling-loader">Loading.... Please Wait</div>
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
    <script>
        $(document).ready(function() {
            $('#calling-lead').load(`ajax_load/calling_lead.php?sts=<?php echo $sts; ?>&date_from=<?php echo $date_from; ?>&date_to=<?php echo $date_to; ?>`, function() {
                $('#leads').DataTable();
                $('#calling-loader').hide();
            });
        });
    </script>