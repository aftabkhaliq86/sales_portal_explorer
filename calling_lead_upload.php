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
$errstmt = '';
if (isset($_GET['err'])) {
    $err = $_GET['err'];
    if ($err == "1") {
        $errstmt = '<div class="alert alert-success"><i class="fa fa-check"></i> Selected entries are approved!</div>';
    } elseif ($err == "3") {
        $errstmt = '<div class="alert alert-warning"><i class="fa fa-check"></i> Nothing selected!</div>';
    }
}
?>
<?php

$FileName = '';
$strNotice = '<em>Only CVS file can be upload!</em>';
if (isset($_POST["Import"])) {
    $LEAD_CATEGORY = $_POST["LEAD_CATEGORY"];
    $LEAD_TYPE = $_POST["LEAD_TYPE"];
    $LEAD_DATE = $_POST["LEAD_DATE"];
    if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        && ($_FILES["file"]["type"] == "image/jpg"))) {
        echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?err=1'</script>");
    } else {

        $FileName = $_FILES["file"]["name"];
        $filename = $_FILES["file"]["tmp_name"];
        // Short Name File
        $FileNameSubStr = substr($FileName, 0, -4);
        $i = 0; //so we can skip first row
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");

            $sql2 = mysqli_query($link, "INSERT INTO `calling_lead_title` (`SESSID`, `DATED`,`LEAD_CATEGORY`,`LEAD_TYPE`,`LEAD_DATE`,`STATUS`)
            values('$SESSID', NOW(),'$LEAD_CATEGORY','$LEAD_TYPE','$LEAD_DATE','1')");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $emapData = str_replace(",", " ", $emapData);
                // $CTID_CART = implode(', ', $emapData).'<br>';
                // print_r($CTID_CART);
                // exit;
                if ($i > 0) {
                    $selectsessid =  mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE `SESSID`='$SESSID'");
                    $SelectSID = mysqli_fetch_array($selectsessid);
                    if ($SelectSID['ID'] != '') {
                        $LEADTID = $SelectSID['ID'];
                        $selectquerys = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `calling_lead` WHERE `RMS_ID` ='" . $emapData[0] . "' AND `INACTIVE_LEAD_TITLE` ='1'"));
                        if ($selectquerys == '0') {
                            $sql = mysqli_query($link, "INSERT INTO `calling_lead` (`LEADTID`, `DATED`, `RMS_ID`, `PHONE`, `EMAIL`, `PREFFERED_COUNTRY`, `REGISTER_DATE`,`SENDING_COUNTRY`,`TRANSACTION_COUNT`,`LAST_TRANSACTION_DATE`,`INACTIVE_LEAD_TITLE`)
                            values('$LEADTID',NOW(),'$emapData[0]', '$emapData[1]', '$emapData[2]', '$emapData[3]', '$emapData[4]', '$emapData[5]', '$emapData[6]', '$emapData[7]','1')");
                        }
                    }
                }
                $i++;
            }
            fclose($file);
            $strNotice = "<strong>Your File:</strong> <strong><u>" . $FileName . "</u></strong> <em>CSV File has been successfully Imported.</em>";
        } else {
            $strNotice = "<strong>Invalid File:</strong> <strong><u>" . $FileName . "</u></strong> <em>Please Upload CSV File.</em>";
        }
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?&upload=y'</script>");
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
                                <div class="x_title">
                                    <h4><?php echo $plu_del_rep; ?></h4>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                        <!--<a href="daily_trans_add.php" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Creat New Transaction"><i class="fa fa-plus"></i> Upload New File</a>-->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php echo $errstmt; ?>
                                    <?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['failes'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong><?php echo $_SESSION['failes']; ?></strong></div>
                                        </div>
                                    <?php } ?>
                                    <div id="no-more-tables">

                                        <form class="form-horizontal" method="POST" id="product_add" enctype="multipart/form-data" name="uploadfiles" autocomplete="off">
                                            <div class="container">
                                                <div class="sml-padding" style="margin-top: 4%;">
                                                    <div class="col-lg-2"><label class="control-label">Lead Category<span class="text-danger">*</span></label></div>
                                                    <div class="col-lg-9">
                                                        <input name="LEAD_CATEGORY" class="form-control" type="text" required>
                                                    </div>
                                                </div>
                                                <div class="sml-padding" style="margin-top: 4%;">
                                                    <div class="col-lg-2"><label class="control-label">Lead Type<span class="text-danger">*</span></label></div>
                                                    <div class="col-lg-9">
                                                        <select name="LEAD_TYPE" class="form-control" id="" required>
                                                            <option selected hidden disabled>SELECT</option>
                                                            <option value="1">New Reg</option>
                                                            <option value="2">Dormant</option>
                                                            <option value="3">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="sml-padding" style="margin-top: 4%;">
                                                    <div class="col-lg-2"><label class="control-label">Lead Date<span class="text-danger">*</span></label></div>
                                                    <div class="col-lg-9">
                                                        <input name="LEAD_DATE" class="form-control" type="date" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <?php if (isset($_GET['updated'])) { ?>
                                                    <div class="alert alert-warning">
                                                        <div class="container"><strong>Data is successfully updated!</strong></div>
                                                    </div>
                                                <?php } ?>
                                                <div class="widget-block" style="margin-top: 4%;">
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-md-3 control-label text-left">Upload File <span class="text-danger">*</span></label>
                                                        <div class=" col-md-7">
                                                            <input type="file" name="file" id="file" required>
                                                        </div>
                                                    </div>
                                                    <font><?php echo $strNotice; ?> <?php //echo '<br>'.$picdel; 
                                                                                    ?></font>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-md-5 widget-block text-right al-right">
                                                    <!-- <a href="country_list.php" class="btn btn-default"><i class="fa fa-angle-left"></i> Back</a> -->
                                                    <input type="reset" class="btn btn-default hidden-xs" value="Clear">
                                                </div>
                                                <div class="col-md-7 widget-block text-left al-left">
                                                    <input type="submit" class="btn btn-primary" name="Import" value="Submit">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <!-- End SmartWizard Content -->
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