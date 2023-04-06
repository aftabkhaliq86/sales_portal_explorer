<?php include ('inc_meta_header.php'); ?>
<title>
<?php
$page_link_url = basename($_SERVER['PHP_SELF']);
$plu_del_ext = rtrim($page_link_url, ' .php');
echo $plu_del_rep = ucwords(str_replace("_", " ", $plu_del_ext));
?>

 <?php include ('inc_page_title.php'); ?>
</title>
<?php include ('inc_head.php'); ?>

<?php
$RID = $_GET['id'];
	$result = mysqli_query($link, "SELECT * FROM `rolls_ms_pages_group` WHERE ID = $RID");

		while($row = mysqli_fetch_array($result))
		  {
			  $ID_ro= $row['ID'];
			  $GROUPNAME_ro= $row['GROUPNAME'];
			  $GROUPSUBTITLE_ro= $row['GROUPSUBTITLE'];
			  $GROUPICON_ro= $row['GROUPICON'];
			  $STATUS_ro= $row['STATUS'];	
		  }

if (isset($_POST['GROUPNAME']))
	{
		if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}

$GROUPNAME = normalize_str($_POST['GROUPNAME']);
$GROUPSUBTITLE = normalize_str($_POST['GROUPSUBTITLE']);
$GROUPICON = normalize_str($_POST['GROUPICON']);

$sql="UPDATE `rolls_ms_pages_group` SET GROUPNAME='$GROUPNAME', GROUPSUBTITLE='$GROUPSUBTITLE', GROUPICON='$GROUPICON', STATUS='$STATUS' WHERE ID = $RID";
				
	if(!mysqli_query($link, $sql)){
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

//header("location: comp-pg_edit.php?id=$RID&preID=$preID&updated=y");
echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?id=$RID&updated=y'</script>");
	}
?>

    <body class="nav-md">

        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                <?php include ('inc_nav.php'); ?>
                </div>
                <?php include ('inc_header.php'); ?>
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
										
                                        <div id="form-content">
                                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $ID_ro; ?>" method="post" name="frm">
            
        	<div class="container">
            	<?php if (isset($_GET['updated'])){ ?>
                <div class="alert alert-warning">
                	<div class="container"><strong>Data is successfully updated!</strong></div>
                </div>
                <?php } ?>
            
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Group Name</label></div>
                    <div class="col-lg-9">
                    	<input name="GROUPNAME" class="form-control" type="text" value="<?php echo $GROUPNAME_ro; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Group Sub Title</label></div>
                    <div class="col-lg-9">
                    	<input name="GROUPSUBTITLE" class="form-control" type="text" value="<?php echo $GROUPSUBTITLE_ro; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Group Icon</label></div>
                    <div class="col-lg-9">
                    	<input name="GROUPICON" class="form-control" type="text" value="<?php echo $GROUPICON_ro; ?>" required>						<p class="text-muted"><small>Use Font Awesome for Icon/s - URL: https://fontawesome.com/v4.7.0/icons/</small></p>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Status</label></div>
                    <div class="col-lg-9">
                    
                    	<?php if ($STATUS_ro==1) { 
						?>
                        <label><input type="checkbox" name="STATUS" value="1" checked="checked"  /> Active</label>
                        <?php
						} else {
						?>	
                        <label><input type="checkbox" name="STATUS" value="1"  /> In-Active</label>
                        <?php
						} ?>
                    
                    </div>
                </div>
                
                <hr>
                
                <div class="row sml-padding">
                	<div class="col-lg-3">&nbsp;</div>
                    <div class="col-lg-9"><input type="submit" class="btn btn-primary" name="SupplierAddSbmt" value="Update"> <a href="rolls_pages_group_list.php" class="btn btn-default">Back</a></div>
                </div>
                
                
            </div>
            
            </form>
                                     </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- /page content -->
				<?php include ('inc_footer.php'); ?>
                
            </div>
        </div>



		<?php include ('inc_foot.php'); ?>

		

