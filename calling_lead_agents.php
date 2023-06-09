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
if (isset($_GET['del'])) {
    $del = $_GET['del'];
    //UPDATE SQL Statement
    $sql = "DELETE FROM calling_lead_agents WHERE ID = $del";
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
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Status</label></div>
                                    <div class="col-lg-9"><label><input type="checkbox" name="STATUS" value="1" checked /> Active</label></div>
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
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                        <li><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ProductAdd">
                                                <i class="fa fa-plus"></i> New
                                            </button></li>
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <table class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>DATED</th>
                                                <th>Person Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th class="al-center">Status</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($link, "SELECT * FROM calling_lead_agents ORDER BY PERSON_NAME");
                                            $counter = '0';
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ID = $row['ID'];
                                                $DATED = $row['DATED'];
                                                $PERSON_NAME = $row['PERSON_NAME'];
                                                $EMAIL_ADDRESS = $row['EMAIL_ADDRESS'];
                                                $DEPARTMENT = $row['DEPARTMENT'];
                                                $STATUS = $row['STATUS'];
                                                $counter = $counter + 1;
                                            ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td>
                                                        <?php echo $DATED; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $PERSON_NAME; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $EMAIL_ADDRESS; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $DEPARTMENT; ?>
                                                    </td>
                                                    <td data-title="Status" class="al-center">
                                                        <?php
                                                        if ($STATUS == 0) {
                                                        ?>
                                                            <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?id=" . $ID . "&actc=app" ?>" class="btn btn-danger btn-xs">Inactive</a>
                                                        <?php
                                                        } elseif ($STATUS == 1) {
                                                        ?>
                                                            <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?id=" . $ID . "&actc=unapp" ?>" class="btn btn-success btn-xs">Active</a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td data-title="Action" class="al-center">
                                                        <a href="calling_agent_lead.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                        <a href="calling_lead_agents_edit.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    </td>
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