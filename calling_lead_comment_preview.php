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
$Cl_ID = $_GET['id'];
if (isset($_GET['id'])) {
    $Cl_ID = $_GET['id'];
}

$innd = '';
$inndl = '';
if (isset($_GET['innd'])) {
    $innd = $_GET['innd'];

    if ($innd == 1) {
        $inndl = '&innd=1';
    } else {
        $inndl = '';
    }
}

$nid = '';
$nidi = '';
if (isset($_GET['nid'])) {
    $nid = $_GET['nid'];
    $nidi = $_GET['nid'];
    if ($nid > 0) {
        $nid = '&nid=' . $_GET['nid'];
    } else {
        $nid = '';
    }
}
$mnl = '';
$mnll = '';
if (isset($_GET['mnl'])) {
    $mnl = $_GET['mnl'];
    if ($mnl == 1) {
        $mnll = '&mnl=1';
    } else {
        $mnll = '';
    }
}

$result_calling_lead_c = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE ID='$Cl_ID'");
while ($row_clc = mysqli_fetch_array($result_calling_lead_c)) {
    $ID = $row_clc['ID'];
    $M_LEADTID = $row_clc['LEADTID'];
    $RMS_ID = $row_clc['RMS_ID'];
    $PHONE = $row_clc['PHONE'];
    $EMAIL = $row_clc['EMAIL'];
    $PREFFERED_COUNTRY = $row_clc['PREFFERED_COUNTRY'];
    $REGISTER_DATE = $row_clc['REGISTER_DATE'];
    $SENDING_COUNTRY = $row_clc['SENDING_COUNTRY'];
    $TRANSACTION_COUNT = $row_clc['TRANSACTION_COUNT'];
    $LAST_TRANSACTION_DATE = $row_clc['LAST_TRANSACTION_DATE'];
    $Calls = $row_clc['calls'];
    $USERID = $row_clc['USERID'];
    $calls_start_time = $row_clc['calls_start_time'];
    $calls_end_time = $row_clc['calls_end_time'];
    $LEAD_STATUS_clc = $row_clc['LEAD_STATUS'];
}

$result_clt = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE ID='$M_LEADTID'");

while ($row_clt = mysqli_fetch_array($result_clt)) {
    $mLEAD_LEAD_CATEGORY = $row_clt['LEAD_CATEGORY'];
    $mLEAD_STATUSi = $row_clt['STATUS'];
}

$result_clcmts = mysqli_query($link, "SELECT LEAD_STS_INVALID FROM `calling_lead_comments` WHERE LEAD_R_ID='$Cl_ID'");
$LEAD_STS_INVALID_clcmts = '';
while ($row_clcmts = mysqli_fetch_array($result_clcmts)) {
    $LEAD_STS_INVALID_clcmts = $row_clcmts['LEAD_STS_INVALID'];
}

?>
<script>
    window.history.forward(1);
</script>

<style>
    .innercontainer span {
        font-weight: bold;
    }

    .Commments {
        font-size: 20px;
        margin-top: 3%;
    }

    .allcomments {
        padding: 20px 30px;
        display: flow-root;
    }

    .allcomments:nth-child(odd):hover {
        background: #cecece;
    }

    .allcomments:nth-child(even):hover {
        background: #cecece;
    }

    .allcomments:nth-child(odd) {
        background: #ffffff;
        padding: 10px;
        text-align: left;
    }

    .allcomments:nth-child(even) {
        background: #eef1f5;
        padding: 10px;
        text-align: left;
    }
</style>

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
                                <div class="x_title">
                                    <h4><?php if (!empty($mLEAD_LEAD_CATEGORY)) {
                                            echo $mLEAD_LEAD_CATEGORY;
                                        } ?> <?php if (!empty($mLEAD_STATUSi) && $mLEAD_STATUSi == 0) {
                                                    echo '<span class="btn btn-danger btn-xs" style="color:#fff;">Inactive</span>';
                                                } ?> </h4>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="col-lg-10">
                                        <div class="container float-left">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php

                                                $result_calling_comments_call = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `calling_comments_call` WHERE USERID='$EMPLOYEEID_LOGIN' AND calls_status='1' "));

                                                //while ($row_ccc = mysqli_fetch_array($result_calling_comments_call)) {

                                                ?>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">RMS ID: </label></div>
                                                    <div class="col-lg-7">

                                                        <?php echo $RMS_ID; ?>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">Phone: </label></div>
                                                    <div class="col-lg-7">
                                                        <span>
                                                            <?php echo $PHONE; ?>
                                                        </span>

                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">Email: </label></div>
                                                    <div class="col-lg-7">
                                                        <?php echo $EMAIL; ?>

                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">Preffered Country: </label></div>
                                                    <div class="col-lg-7">
                                                        <?php echo $PREFFERED_COUNTRY; ?>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">Registered Date: </label></div>
                                                    <div class="col-lg-7">
                                                        <?php echo $REGISTER_DATE; ?>
                                                    </div>
                                                </div>
                                                <div class="row sml-padding">
                                                    <div class="col-lg-5"><label class="control-label">Last Call Duration: </label></div>
                                                    <div class="col-lg-7">

                                                        Total Calling Time: <?php
                                                                            $t1 = strtotime($calls_start_time);
                                                                            $t2 = strtotime($calls_end_time);
                                                                            $totals = $t2 - $t1;
                                                                            // echo gmdate("H:i:s", $totals);
                                                                            $hours = floor($totals / 3600);
                                                                            $minutes = floor(($totals - ($hours * 3600)) / 60);
                                                                            $seconds = $totals - ($hours * 3600) - ($minutes * 60);

                                                                            echo $hours . " h " . $minutes  . " m " . $seconds . " s ";
                                                                            ?>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="container float-left">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                                <label class="Commments" for="Commments"><i class="fa fa-commenting"></i> Comments</label>
                                                <?php
                                                $DID = $_GET['id'];
                                                $results = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$DID' ORDER BY ID DESC");
                                                while ($rows = mysqli_fetch_array($results)) {
                                                    $LEAD_ID_rows = $rows['ID'];
                                                    $LEAD_STATUS = $rows['LEAD_STATUS'];
                                                    $LEAD_PICPATH = $rows['PICPATH'];
                                                    $DATED = $rows['DATED'];
                                                    $LEAD_CMT_ID = $rows['LEAD_CMT_ID'];
                                                    $lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
                                                    if (mysqli_num_rows($lead_comments) > 0) {
                                                        $lead_comments_row = mysqli_fetch_array($lead_comments);
                                                        $COMMENT_HEADING = $lead_comments_row['HEADING'];
                                                        if ($COMMENT_HEADING == "Other") {
                                                            $COMMENT_AREA = $rows['COMMENT_AREA'];
                                                        } else {
                                                            $COMMENT_AREA = '';
                                                        }
                                                    } else {
                                                        $COMMENT_HEADING = '';
                                                    }
                                                    $results1 = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
                                                    $rows1 = mysqli_fetch_array($results1);
                                                    $STATUS_HEADING = $rows1['STATUS_HEADING'];
                                                ?>
                                                    <div class="allcomments">
                                                        <div class="col-lg-11">
                                                            <div class="col-lg-4">
                                                                <i class="fa fa-comment-o"></i> <strong><?php echo $rows1['STATUS_HEADING'] ?>:</strong>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <?php if ($COMMENT_AREA == '') {
                                                                ?>
                                                                    <strong>
                                                                        <?php
                                                                        echo $COMMENT_HEADING;
                                                                        ?>
                                                                    </strong>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <strong>
                                                                        <?php
                                                                        echo $COMMENT_HEADING . ':';
                                                                        ?>
                                                                    </strong>
                                                                    <span style="word-wrap: break-word;">
                                                                        <?php
                                                                        echo $COMMENT_AREA;
                                                                        ?>
                                                                    </span>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                [ <?php echo $DATED ?> ]
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <?php if ($LEAD_PICPATH != NULL) { ?>
                                                                <i class="fa fa-picture-o" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal<?php echo $LEAD_ID_rows; ?>"></i>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal<?php echo $LEAD_ID_rows; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-body">
                                                                                <img src="webpics/<?php echo $LEAD_PICPATH; ?>" style="width: 100%;">
                                                                            </div>
                                                                            <div class="modal-footer" align="center" style="text-align: center;">
                                                                                <button type="button" class="btn btn-primary" data-dismiss="modal" style="float: none;">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                                <label class="Commments" for="phone"><i class="fa fa-phone"></i>3cx Calls</label>
                                                <?php
                                                $DID = $_GET['id'];
                                                $call_logs = mysqli_query($link, "SELECT * FROM three_cx_call_logs WHERE CI_ID ='$DID' ORDER BY call_time DESC");
                                                ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Agent Name</th>
                                                            <th>Call Date</th>
                                                            <th>Duration</th>
                                                            <th>Answered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($logs = mysqli_fetch_array($call_logs)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo  $logs['agent_name'] ?></td>
                                                                <td><?php echo  date('d-m-Y h:i:s', strtotime($logs['call_time'])) ?></td>
                                                                <td><?php echo  $logs['duration'] ?></td>
                                                                <td><?php echo  $logs['is_answered'] ? 'YES' : 'NO' ?></td>
                                                            </tr>
                                                        <?php
                                                        } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="3cx-logs"></div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                                                <label class="Commments" for="phone"><i class="fa fa-phone"></i>Old Calls</label>
                                                <?php
                                                /*old calling comments*/
                                                $result1s = mysqli_query($link, "SELECT * FROM calling_comments_call WHERE Cl_ID ='$DID' ORDER BY ID DESC");
                                                while ($rows1 = mysqli_fetch_array($result1s)) {
                                                    $calls_start_time = $rows1['calls_start_time'];
                                                    $calls_end_time = $rows1['calls_end_time'];
                                                ?>
                                                    <div class="allcomments">
                                                        <i class="fa fa-phone mx-5"></i> <?php echo $calls_start_time ?> - <?php echo $calls_end_time ?>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 border-left">
                                        <div class="container">
                                            <div class="col-lg-10">
                                                <h4><i class="fa fa-list-alt"></i> Notes</h4>
                                            </div>
                                            <div class="col-lg-2">


                                            </div>
                                        </div>

                                        <div class="container">
                                            <ul class="list-group">
                                                <?php
                                                $note_counter = '0';
                                                $SELECT_NOTES = mysqli_query($link, "SELECT * FROM `calling_lead_notes` WHERE LEAD_R_ID=$Cl_ID AND USERID=$EMPLOYEEID_LOGIN");

                                                while ($row = mysqli_fetch_array($SELECT_NOTES)) {
                                                    $ID = $row['ID'];
                                                    $NOTE = $row['NOTE'];
                                                    $STATUS = $row['STATUS'];

                                                    $note_counter = $note_counter + 1;

                                                ?>
                                                    <li class="list-group-item <?php if ($STATUS == 1) {
                                                                                    echo '';
                                                                                } else {
                                                                                    echo 'disabled aria-disabled="true"';
                                                                                } ?>"><?php echo $note_counter; ?>. <?php echo $NOTE; ?></li>
                                                <?php } ?>
                                            </ul>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class=" modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-lg-10">
                            <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-list-alt"></i> Add a note</h4>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $Cl_ID; ?>" method="post" name="frm">

                            <div class="container">

                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Note</label></div>
                                    <div class="col-lg-9">
                                        <textarea name="NOTE" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Date & Time</label></div>
                                    <div class="col-lg-9">
                                        <input type="datetime-local" name="DATENTIME" class="form-control">
                                    </div>
                                </div>

                                <input type="hidden" name="LEADID" value="<?php echo $M_LEADTID; ?>">
                                <input type="hidden" name="LEAD_R_ID" value="<?php echo $Cl_ID; ?>">
                                <input type="hidden" name="USERID" value="<?php echo $EMPLOYEEID_LOGIN; ?>">

                                <input type="hidden" name="inndl" value="<?php echo $inndl; ?>">

                                <hr>

                                <div class="row sml-padding">
                                    <div class="col-lg-3">&nbsp;</div>
                                    <div class="col-lg-9">
                                        <input type="submit" class="btn btn-primary" name="SupplierAddSbmt" value="Add Note">
                                    </div>
                                </div>


                            </div>

                        </form>

                    </div>
                    <!--<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
		  </div>-->
                </div>
            </div>
        </div>

        <!-- /page content -->
        <?php include('inc_footer.php'); ?>
    </div>
    </div>
    <?php include('inc_foot.php'); ?>
    <!--<script type="text/javascript">
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
            $('#call_compulsory').click(function() {
                if ($(this).is(':checked')) {
                    $(this).attr("checked", true)
                    $(this).val(this.checked ? 1 : 0);
                } else {
                    $(this).attr('checked', false);
                    $(this).val(this.checked ? 1 : 0);
                }
            });
        });
    </script>-->