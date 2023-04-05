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
<?php
$Sales_Agnet_ID = $_SESSION['USERID'];
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
    <!-- Modal -->
    <div class="modal fade" id="ProductAdd" tabindex="-1" role="dialog" aria-labelledby="ProductAdd">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo basename($_SERVER['PHP_SELF']) ?>'"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Roll Page Details</h4>
                </div>
                <div id="form-content">
                    <form method="post" id="product_add" name="productAdd" autocomplete="off">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Person Name<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="PERSON_NAME" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Email Name<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="EMAIL_ADDRESS" class="form-control" type="email" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Password<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="PASSWORD" class="form-control" type="password" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Department<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="DEPARTMENT" class="form-control" type="text" required>
                                        <!-- <select name="DEPARTMENT" id="" class="form-control" required>
                                            <option value="Compalaince"> 
                                                Compalaince
                                            </option>
                                            <option value="">
                                                Sales
                                            </option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Status</label></div>
                                    <div class="col-lg-9"><label><input type="checkbox" name="STATUS" value="1" /> Active</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="reset" class="btn btn-default pull-left" value="Clear">
                            <input type="submit" class="btn btn-primary" name="ProductAddSbmt" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                <div class="x_title">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <table class="col-lg-12 table-striped table-condensed cf tbl ">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>DATED</th>
                                                <th>RMS ID</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Preffered Country</th>
                                                <th>Register Date</th>
                                                <th>USERID</th>
                                                <th>Lead Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $LEADTID = $_GET['id'];
                                            $USERID = $_GET['USERID'];

                                            $result = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$LEADTID' AND  USERID='$USERID' AND STATUS='1'");
                                            $counters = '0';
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ID = $row['ID'];
                                                $DATED = $row['DATED'];
                                                $RMS_ID = $row['RMS_ID'];
                                                $PHONE = $row['PHONE'];
                                                $EMAIL = $row['EMAIL'];
                                                $PREFFERED_COUNTRY = $row['PREFFERED_COUNTRY'];
                                                $REGISTER_DATE = $row['REGISTER_DATE'];
                                                $USERID = $row['USERID'];
                                                $U_DATED = $row['U_DATED'];
                                                $LEAD_STATUS = $row['LEAD_STATUS'];
                                                $LEAD_STATUS_DATED = $row['LEAD_STATUS_DATED'];
                                                $STATUS = $row['STATUS'];
                                                $counters = $counters + 1;
                                                $resultss = mysqli_query($link, "SELECT * FROM lead_status WHERE ID='$LEAD_STATUS'");
                                                $rowss = mysqli_fetch_array($resultss);
                                                $STATUS_HEADING = $rowss['STATUS_HEADING'];
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <?php echo $DATED; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $RMS_ID; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $PHONE; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $EMAIL; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $PREFFERED_COUNTRY; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $REGISTER_DATE; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $USERID; ?><br>
														<small><?php echo $U_DATED; ?></small>
														
                                                    </td>
                                                    <td>
                                                        <?php echo $STATUS_HEADING; ?><br>
														<small><?php echo $LEAD_STATUS_DATED; ?></small>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
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