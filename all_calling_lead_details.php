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
if (isset($_POST['deletealls'])) {
    mysqli_query($link, "DELETE  FROM `calling_lead` WHERE USERID='0'");
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "'</script>");
}
?>

<?php
if (isset($_POST['update'])) {
    if (isset($_POST['ID']) && $_POST['ID'] != '') {
        $USERID = $_POST['USERID'];
        $array = array();
        $IDs = $_POST['ID'];
        $countID = count($IDs);
        for ($j = 0; $j < $countID; $j++) {
            mysqli_query($link, "UPDATE `calling_lead` SET `USERID`=$USERID,`U_DATED`=NOW() WHERE `ID`=$IDs[$j]");
            mysqli_query($link, "INSERT INTO `calling_lead_assign_history`(`CALLING_LEAD_ID`, `UPDATED`, `USERID`, `UPDATED_BY`, `ACTION`) VALUES ('$IDs[$j]',Now(),'$USERID','$EMPLOYEEID_LOGIN','manual assign')");
        }
    } else {
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
                                
                                        <a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?id=<?php echo $LEADTID ?>" class="btn btn-default btn-xs pull-right" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <button type="submit" name="deletealls" class="btn btn-danger btn-xs pull-right"><i class="fa fa-trash"></i></button>
                                        </form>
                                  

                                    <!--<button type="button" id="btnExport" onclick="javascript:xport.toCSV('Leads');" class="btn btn-default btn-xs pull-right"><i class="fa fa-download"></i>&nbsp;Export to CSV</button> -->

                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="container">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4" align="right">
                                                    <label style="padding-top:7px;">Select Agent</label>
                                                </div>
                                                <div class="col-lg-4">
                                                    <select name="USERID" class="form-control">
                                                        <option value="" selected hidden disabled>SELECT</option>
                                                        <?php
                                                        $Agent_query = mysqli_query($link, "SELECT * FROM `calling_lead_agents` WHERE STATUS='1'");
                                                        foreach ($Agent_query as $value) {
                                                        ?>
                                                            <option value="<?php echo $value['ID'] ?>"><?php echo $value['PERSON_NAME'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>&nbsp;</label>
                                                    <input type="submit" class="btn btn-success" name="update" value="update">
                                                </div>
                                            </div>
                                        </div>
                                        <table id="example" class="table table-striped table-condensed cf tbl table-responsive" id="Leads">
                                            <thead class="cf">
                                                <tr>
                                                    <th>#</th>
                                                    <th><input type="checkbox" id="select_all"> </th>
                                                    <th>DATED</th>
                                                    <th>LEAD TITLE</th>
                                                    <th>RMS ID</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Sending Country</th>
                                                    <th>Preffered Country</th>
                                                    <th>Register Date</th>

                                                    <th class="al-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result_calling_lead = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE USERID='0'");
                                                $counters = '0';
                                                while ($row_cl = mysqli_fetch_array($result_calling_lead)) {
                                                    $ID = $row_cl['ID'];
                                                    $LEADTID = $row_cl['LEADTID'];
                                                    $DATED = $row_cl['DATED'];
                                                    $RMS_ID = $row_cl['RMS_ID'];
                                                    $PHONE = $row_cl['PHONE'];
                                                    $EMAIL = $row_cl['EMAIL'];
                                                    $PREFFERED_COUNTRY = $row_cl['PREFFERED_COUNTRY'];
                                                    $REGISTER_DATE = $row_cl['REGISTER_DATE'];
                                                    $SENDING_COUNTRY = $row_cl['SENDING_COUNTRY'];
                                                    $TRANSACTION_COUNT = $row_cl['TRANSACTION_COUNT'];
                                                    $LAST_TRANSACTION_DATE = $row_cl['LAST_TRANSACTION_DATE'];
                                                    $USERID = $row_cl['USERID'];
                                                    $U_DATED = $row_cl['U_DATED'];
                                                    $LEAD_STATUS = $row_cl['LEAD_STATUS'];
                                                    $STATUS = $row_cl['STATUS'];

                                                    $result2 = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE ID='$LEADTID'");
                                                    while ($row2 = mysqli_fetch_array($result2)) {
                                                        $LEAD_CATEGORY = $row2['LEAD_CATEGORY'];
                                                        $LEAD_DATE = $row2['LEAD_DATE'];
                                                    }
                                                    $counters = $counters + 1;
                                                    $result_calling_lead_agents = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `calling_lead_agents` WHERE ID='$USERID'"));
                                                    $result_lead_status = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'"));
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><input class="checkbox" name="ID[]" type="checkbox" value="<?php echo $ID; ?>"></td>
                                                        <td>
                                                            <?php echo $DATED; ?>
                                                        </td>
                                                        <td>
                                                            <strong><?php echo $LEAD_CATEGORY; ?></strong><br>
                                                            <small><?php echo $LEAD_DATE; ?></small>
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
                                                            <?php echo $SENDING_COUNTRY; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $PREFFERED_COUNTRY; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $REGISTER_DATE; ?>
                                                        </td>

                                                        <td data-title="Action" class="al-center">
                                                            <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </form>
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
        $(function() {
            $('.checkbox').click(function() {
                if ($(this).is(':checked')) {
                    $(this).attr("checked", true)
                } else {
                    $(this).attr('checked', false);
                }
            });
        });
        $(document).on('change', '#select_all', function() {
            if ($(this).prop('checked')) {
                $('.checkbox').prop('checked', true)
                $('input:checkbox').attr('checked', true);
            } else {
                $('.checkbox').prop('checked', false);
                $('input:checkbox').attr('checked', false);
            }
        });
    </script>