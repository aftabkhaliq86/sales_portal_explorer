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
                <?php
                $result_calling_comments_call_count = 0;
                $result_calling_comments_call = mysqli_query($link, "SELECT * FROM `calling_comments_call` WHERE USERID='$EMPLOYEEID_LOGIN' AND calls_status='1'");

                $result_calling_comments_call_count = mysqli_num_rows($result_calling_comments_call);

                while ($row_rcc = mysqli_fetch_array($result_calling_comments_call)) {
                    $Cl_ID_rcc = $row_rcc['Cl_ID'];
                }

                if ($result_calling_comments_call_count > 0) {
                ?>
                    <!-- <blink>Call in progress</blink> -->

                    <a href="calling_lead_comment.php?id=<?php echo $Cl_ID_rcc; ?>" id="blink"><i class="fa fa-phone"></i> Call in progress </a>
                    <!-- <div class="btn text-danger" style="font-size: 20px;font-weight: bold;"> Call in progress </div> -->
                <?php
                }
                ?>
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

                                <div class="row">

                                    <?php
                                    $leads = '';
                                    if (isset($_POST['filter'])) {
                                        $email = trim($_POST['email']);
                                        $leads = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE EMAIL='$email'");
                                    }

                                    ?>
                                    <form action="" method="post">
                                        <div class="col-lg-4 col-lg-4 col-sm-4 col-xs-4">
                                        </div>
                                        <div class="col-lg-4 col-lg-4 col-sm-4 col-xs-4">
                                            <input type="text" class="form-control" name="email" value="<?php if (isset($_POST['email'])) {
                                                                                                            echo $_POST['email'];
                                                                                                        } ?>">
                                        </div>
                                        <div class="col-lg-4 col-lg-4 col-sm-4 col-xs-4">
                                            <button class="btn btn-success al-center col-lg-2 col-lg-2 col-sm-2 col-xs-2" type="submit" name="filter"><i class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="x_content">

                                    <table class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>RMS ID</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Sending Country</th>
                                                <th>Preffered Country</th>
                                                <th>Last Transaction Details</th>
                                                <th>Status</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($leads != '' && mysqli_num_rows($leads) > 0) {
                                                foreach ($leads as $lead) {
                                                    $lead_id = $lead['ID'];
                                                    $lead_rms_id = $lead['RMS_ID'];
                                                    $userid = $lead['USERID'];
                                                    $lead_status = $lead['LEAD_STATUS'];
                                                    $lead_status_dated = $lead['LEAD_STATUS_DATED'];
                                                    $lead_sending_country = $lead['SENDING_COUNTRY'];
                                                    $lead_preffered_country = $lead['PREFFERED_COUNTRY'];
                                                    $lead_last_transaction_date = $lead['LAST_TRANSACTION_DATE'];
                                                    $lead_transaction_count = $lead['TRANSACTION_COUNT'];
                                                    $lead_phone = $lead['PHONE'];
                                                    $lead_email = $lead['EMAIL'];
                                                    $lead_register_date = $lead['REGISTER_DATE'];
                                                    $status = $lead['STATUS'];
                                                    $active_calls = $lead['calls'];
                                                    $result_note_s = mysqli_query($link, "SELECT * FROM `calling_lead_notes` WHERE LEADID='$lead_rms_id' AND USERID='$userid' AND LEAD_R_ID='$lead_id'");
                                                    $STATUS_note_s = '0';
                                                    while ($row_note_s = mysqli_fetch_array($result_note_s)) {
                                                        $ID_note_s = $row_note_s['ID'];
                                                        $STATUS_note_s = $row_note_s['STATUS'];
                                                    }
                                                    // echo $lead_email;
                                                    // exit;
                                                    if ($lead_status != NULL) {
                                                        $result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$lead_status'");
                                                        $rows_ls = mysqli_fetch_array($result_lead_status);
                                                        $status_title_status = $rows_ls['STATUS_HEADING'];
                                                    }

                                            ?>
                                                    <tr id="<?php echo $lead_id; ?>">
                                                        <td><?php //echo $counters1; 
                                                            ?></td>
                                                        <td>
                                                            <?php echo $lead_rms_id; ?><br>
                                                            <small><?php echo $lead_register_date; ?></small>

                                                        </td>
                                                        <td>
                                                            <?php echo $lead_phone; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $lead_email; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $lead_sending_country; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $lead_preffered_country; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $lead_last_transaction_date; ?><br>
                                                            <?php echo $lead_transaction_count; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($lead_status != NULL) { ?>
                                                                <?php echo $status_title_status; ?><br>
                                                                <small><?php echo $lead_status_dated; ?></small>
                                                            <?php } ?>
                                                        </td>
                                                        <td data-title="Action" class="al-center">

                                                            <a href="calling_lead_comment_preview.php?id=<?php echo $lead_id; ?>" data-toggle="tooltip" data-placement="top" title="Preview" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $lead_id ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            <?php } else {
                                            ?>
                                                <tr>
                                                    <td colspan="9" style="text-align: center;"> No Record Found </td>
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