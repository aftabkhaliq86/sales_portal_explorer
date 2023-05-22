<?php include('../inc_php_funtions.php'); ?>
<?php
$sts = '';
if (isset($_GET['sts'])) {
    $sts = $_GET['sts'];
}
if (isset($_GET['DATEFROM']) && isset($_GET['DATETO'])) //submit button name
{
    $DATEFROM = $_GET['DATEFROM'];
    $DATETO = $_GET['DATETO'];
    if ($sts == 1) {
        $sts_query = "AND `clt`.`STATUS`='1'";
    } else if ($sts == 2) {
        $sts_query = "AND `clt`.`STATUS`='0'";
    } else {
        $sts_query = '';
    }
    $result_query = mysqli_query($link, "SELECT `clt`.*,`clty`.`HEADING` AS `clty_HEADING`,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='1',1,0)) AS `used`,SUM(IF(`cl`.`LEADTID`=`clt`.`ID` && `cl`.`STATUS`='0',1,0)) AS `take` FROM `calling_lead_title` AS `clt` INNER JOIN `calling_lead` AS `cl` ON `clt`.`ID`=`cl`.`LEADTID` INNER JOIN `calling_lead_types` AS `clty` ON `clty`.`ID`=`clt`.`LEAD_TYPE` WHERE DATE(`clt`.`DATED`) BETWEEN '$DATEFROM' AND '$DATETO' $sts_query GROUP BY `clt`.`ID` ORDER BY `clt`.`DATED` DESC");
}
?>
<table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
    <thead class="cf">
        <tr>
            <th>#</th>
            <th>DATED</th>
            <th>Lead Type</th>
            <th>Lead Category</th>
            <th>Lead Date</th>
            <th>Lead Report</th>
            <th>Status</th>
            <th class="al-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $counters = '0';
        while ($rows1 = mysqli_fetch_array($result_query)) {
            $ID = $rows1['ID'];
            $DATED = $rows1['DATED'];
            $LEAD_CATEGORY = $rows1['LEAD_CATEGORY'];
            $LEAD_TYPE = $rows1['clty_HEADING'];
            $LEAD_DATE = $rows1['LEAD_DATE'];
            $used = $rows1['used'];
            $take = $rows1['take'];
            $STATUS = $rows1['STATUS'];
            $counters = $counters + 1;
        ?>
            <tr>
                <td></td>
                <td><?php echo $DATED; ?></td>
                <td><?php echo $LEAD_TYPE; ?></td>
                <td><?php echo $LEAD_CATEGORY; ?></td>
                <td><?php echo $LEAD_DATE; ?></td>
                <td><?php echo $used; ?>/<?php echo $take; ?></td>
                <td><?php if ($STATUS == '1') { ?><span class="bg-green text-white" style="padding: 5px; border-radius: 5px;">Active</span><?php } else { ?><span class="bg-red text-white" style="padding: 5px;border-radius: 5px;">InActive</span><?php } ?></td>
                <td data-title="Action" class="al-center"><a href="calling_lead_details.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a><a href="calling_lead_edit.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a><?php if ($used == 0) { ?><a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a><?php } ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>