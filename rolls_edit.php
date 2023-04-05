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
	$result = mysqli_query($link, "SELECT * FROM rolls_ms WHERE ID = $RID");

		while($row = mysqli_fetch_array($result))
		  {
			  $ID= $row['ID'];
			  $ROLLID= $row['ID'];
			  $ROLLNAME= $row['ROLLNAME'];
			  $STATUS= $row['STATUS'];	
		  }

if (isset($_POST['ROLLNAME']))
	{
		if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}

$ROLLNAME = normalize_str($_POST['ROLLNAME']);

$sql="UPDATE rolls_ms SET ROLLNAME='$ROLLNAME', STATUS='$STATUS' WHERE ID = $RID";
				
	if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

//header("location: comp-pg_edit.php?id=$RID&preID=$preID&updated=y");
echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?id=$RID&updated=y'</script>");
	}
?>

<?php
if(isset($_POST['assignpages'])){
	
		$PAGESID = $_POST['PAGESID'];
		//$PAGEGROUP = $_POST['PAGEGROUP'];
		//exit;
		$RID = $_GET['id'];

		if ($PAGESID!=""){
					
		$N = count($_POST['PAGESID']);
			

			for($i=0; $i < $N; $i++)
			{	
			
					$get_pgroup = mysqli_query($link, "SELECT * FROM rolls_ms_pages WHERE ID='$PAGESID[$i]'");

					while($row_pgrup = mysqli_fetch_array($get_pgroup))
					  {
						  $ID_pgrup= $row_pgrup['ID'];
						  $PGID_pgrup= $row_pgrup['PGID'];
						  
				
					$sql="INSERT INTO `rolls_in_pages` (GROUPID, ROLLID, PAGEID, STATUS) 
	
						  VALUES ('$PGID_pgrup', '$ROLLID', '$ID_pgrup', '1')";
							
							if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
							
					  }
					
			}
		
		}
		//exit;
		echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?id=$RID&Check=y'</script>");				
		
	}
	
	if (isset($_GET['del']))
	{
	
	$RID = $_GET['id'];
	$del = $_REQUEST['del'];
	
	$sql="DELETE FROM `rolls_in_pages` WHERE PAGEID='$del' AND ROLLID='$ROLLID'";
		if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
		
	header("location: ".basename($_SERVER['PHP_SELF'])."?id=$RID&delCheck=y");
		
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
                                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $ID; ?>" method="post" name="frm">
            
        	<div class="container">
            	<?php if (isset($_GET['updated'])){ ?>
                <div class="alert alert-warning">
                	<div class="container"><strong>Data is successfully updated!</strong></div>
                </div>
                <?php } ?>
            
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Roll Name</label></div>
                    <div class="col-lg-9"><input name="ROLLNAME" class="form-control" type="text" value="<?php echo $ROLLNAME; ?>"></div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Status</label></div>
                    <div class="col-lg-9">
                    
                    	<?php if ($STATUS==1) { 
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
                    <div class="col-lg-9"><input type="submit" class="btn btn-primary" name="SupplierAddSbmt" value="Update"> <a href="rolls_list.php" class="btn btn-default">Back</a></div>
                </div>
                
                
            </div>
            
            </form>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $ID; ?>" method="post" name="frm">
            
            <div class="container">
            	<div class="col-lg-6 col-lg-offset-3">
                    <h3>Assign Page to Roll</h3>
                    <table class="col-lg-12 table-striped table-hover table-condensed cf tbl">
                    <thead class="cf">
                        <tr>
                            <th>#</th>
                            <th>Page Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php
					$counter = 0;
                	$result_GPID = mysqli_query($link, "SELECT * FROM `rolls_ms_pages_group` ORDER BY GROUPNAME");
						while($row_GPID = mysqli_fetch_array($result_GPID))
						  {
							  $PGID= $row_GPID['ID'];
							  $GROUPNAME= $row_GPID['GROUPNAME'];
						// For Counting and Put hover	  
	 					$counter =  $counter + 1; 
						//----------------------------------
				?>
                	
                    <tr>
                    	<td></td>
        				<td data-title="Roll Page Group Name" colspan="4">
                            <strong><?php echo $counter; ?> - </strong>
                            &nbsp;&nbsp;<strong><?php echo $PGID; ?> - <?php echo $GROUPNAME; ?></strong>
                        </td>
        			</tr>
                
                    
                    <?php
					
						$pagePAGESID = "";
						
						$counter2=0;
                        $result = mysqli_query($link, "SELECT * FROM `rolls_ms_pages` WHERE PGID='$PGID' AND STATUS='1' ORDER BY PAGENAME");
    
                            while($row = mysqli_fetch_array($result))
                              {
                                  $ID= $row['ID'];
                                  $PAGENAME= $row['PAGENAME'];
								  $PGID_GROUPID= $row['PGID'];
								  
								  
							
							// For Counting and Put hover	  
							$counter2 =  $counter2 + 1; 
							//----------------------------------
                  			  
								  $result2 = mysqli_query($link, "SELECT * FROM  `rolls_in_pages` WHERE PAGEID='$ID' AND ROLLID='$RID'");
									while($row2 = mysqli_fetch_array($result2))
										{
											$pageID= $row2['ID'];
											$pagePAGESID= $row2['PAGEID'];
											$pageROLLID= $row2['ROLLID'];
											$pageGROUPID= $row2['GROUPID'];
										}
                                    
                    ?>
                        <tr>
                            <td></td>
                            <td data-title="Page Name">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $counter2; ?> - &nbsp;&nbsp;
                            <?php
								
								/*echo 'GID '.$PGID_GROUPID;
								echo '<BR>PID '.$ID;*/
								
								if ($ID==$pagePAGESID && $pageROLLID==$RID){
								?>
                                	<a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?del=<?php echo $pagePAGESID; ?>&id=<?php echo $RID; ?>" data-toggle="tooltip" data-placement="top" title="Remove From Roll"><i class="fa fa-trash text-danger"></i></a>
                                <?php
									 }
								else {
									
									?>
                                                                        
                                    <!--<input type="checkbox" name="PAGEGROUP[]" value="<?php echo $PGID; ?>" style="width:15px; height:15px;">-->
                                    
                                    <input type="checkbox" name="PAGESID[]" value="<?php echo $ID; ?>" style="width:15px; height:15px;">
                                    <?php
									}
																
								 ?>
                            &nbsp;&nbsp;
                            <strong><?php echo $PAGENAME; ?></strong>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                	
                    <div class="row sml-padding">
                        <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-9"><input type="submit" class="btn btn-success" name="assignpages" value="Assign Pages"></div>
                    </div>
                    
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

		<script type="text/javascript">
$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#product_add').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'vocher_heads_add.php',
			type: 'POST',
			data: $(this).serialize() // it will serialize the form data
		})
		.done(function(data){
			$('#form-content').fadeOut('slow', function(){
				$('#form-content').fadeIn('slow').html(data);
			});
		})
		.fail(function(){
			alert('Ajax Submit Failed ...');	
		});
	});
	
});
</script>

