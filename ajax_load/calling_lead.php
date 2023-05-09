<?php include('../inc_php_funtions.php'); ?>
<?php
$sts = '';
if (isset($_GET['sts'])) {
    $sts = $_GET['sts'];
}
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
} else {
    $srch_DATEFROM_ftp = date('Y-m-d', strtotime('-61 days'));
    $srch_DATETO_ftp = date('Y-m-d');
}
?>
<div class="container" id="filters">
    <form name="frmSRCH" class="form-horizontal" action="calling_lead_v1.php?sts=<?php echo $sts; ?>" method="post">
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
                <a href="calling_lead_v1.php" class="btn btn-warning"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </form>
</div>
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
                    $sts_query = "AND `clt`.`STATUS`='1'";
                } else if ($sts == 2) {
                    $sts_query = "AND `clt`.`STATUS`='0'";
                } else {
                    $sts_query = '';
                }
                // $result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE DATED BETWEEN '$srch_DATEFROM' AND '$srch_DATETO' $sts_query ORDER BY DATED");
                $result_query = mysqli_query($link, "SELECT `clt`.*,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='1',1,0)) AS `used`,SUM(IF(`cl`.`LEADTID`=`clt`.`ID`,1,0)) AS `take` FROM `calling_lead_title` AS `clt` INNER JOIN `calling_lead` AS `cl` ON `clt`.`ID`=`cl`.`LEADTID` WHERE DATE(`clt`.`DATED`) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO' $sts_query GROUP BY `clt`.`ID` ORDER BY `clt`.`DATED`");
            }
            exit;
        } else {
            // if ($sts == 2) {
            //     // $result = mysqli_query($link, "SELECT `clt`.*,IF(`cl`.`ID`) FROM `calling_lead_title` AS `clt` INNER JOIN `calling_lead` AS `cl` ON `clt`.`ID`=`cl`.`LEADTID` WHERE `clt`.`STATUS`='1' ORDER BY `clt`.`DATED` DESC");
            //     // $query = ", SUM(IF(`cl`.`STATUS`='0',1,0))";
            //     $sts_query = "AND `clt`.`STATUS`='0'";
            // } else {
            //     // $result = mysqli_query($link, "SELECT `clt`.* FROM `calling_lead_title` AS `clt` WHERE STATUS='0' ORDER BY DATED DESC");
            //     // $query = ", SUM(IF(`cl`.`STATUS`='1',1,0))";
            //     $sts_query = "AND `clt`.`STATUS`='1'";
            // }
            if ($sts == 1) {
                $sts_query = "AND `clt`.`STATUS`='1'";
            } else if ($sts == 2) {
                $sts_query = "AND `clt`.`STATUS`='0'";
            } else {
                $sts_query = '';
            }
            // else {
            //     $query = "IF(`cl`.`STATUS`='1',)";
            //     // $result = mysqli_query($link, "SELECT `clt`.* FROM `calling_lead_title` AS `clt` WHERE STATUS='1' ORDER BY DATED DESC");
            // }
            $result_query = mysqli_query($link, "SELECT `clt`.*,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='1',1,0)) AS `used`,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='0',1,0)) AS `take` FROM `calling_lead_title` AS `clt` INNER JOIN `calling_lead` AS `cl` ON `clt`.`ID`=`cl`.`LEADTID` WHERE DATE(`clt`.`DATED`) BETWEEN '$srch_DATEFROM_ftp' AND '$srch_DATETO_ftp' $sts_query GROUP BY `clt`.`ID` ORDER BY `clt`.`DATED` DESC");
            // $result = mysqli_query($link, "SELECT `clt`.* FROM `calling_lead_title` AS `clt` INNER JOIN `calling_lead` AS `cl` ON `clt`.`ID`=`cl`.`LEADTID` WHERE $query ORDER BY `clt`.`DATED` DESC");
            // ,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='1',1,0)) AS `used`,SUM(IF(`cl`.`LEADTID`=`clt`.`ID`,1,0)) AS `take`
            // if (!mysqli_query($link, $result)) {
            //     echo "ERROR: Could not able to execute $result. " . mysqli_error($link);
            // }
        }
        $counters = '0';
        while ($rows1 = mysqli_fetch_array($result_query)) {
            $ID = $rows1['ID'];
            $DATED = $rows1['DATED'];
            $LEAD_CATEGORY = $rows1['LEAD_CATEGORY'];
            $LEAD_DATE = $rows1['LEAD_DATE'];
            $used = $rows1['used'];
            $take = $rows1['take'];
            $STATUS = $rows1['STATUS'];
            $counters = $counters + 1;
            // $result_calling_lead = mysqli_num_rows(mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS='1'"));
            // $results = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID'");
            // $result_count = mysqli_num_rows($results);
            // $results1 = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS ='1'");
            // $result_count1 = mysqli_num_rows($results1);
        ?>
            <tr>
                <td></td>
                <td><?php echo $DATED; ?></td>
                <td><?php echo $LEAD_CATEGORY; ?></td>
                <td><?php echo $LEAD_DATE; ?></td>
                <td><?php echo $used; ?>/<?php echo $take; ?></td>
                <td><?php if ($STATUS == '1') { ?><span class="bg-green text-white" style="padding: 5px; border-radius: 5px;">Active</span><?php } else { ?><span class="bg-red text-white" style="padding: 5px;border-radius: 5px;">InActive</span><?php } ?></td>
                <td data-title="Action" class="al-center"><a href="calling_lead_details.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a><a href="calling_lead_edit.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a><?php if ($used == 0) { ?><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a><?php } ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>