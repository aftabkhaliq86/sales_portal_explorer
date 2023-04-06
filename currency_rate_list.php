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

if (isset($_POST['RATE']))
	{
	
	if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}
	
	$RID = $_GET['id'];
	$RATE = $_POST['RATE'];
		
	$select_currencies = mysqli_query($link, "SELECT * FROM `currencies` WHERE id='$RID'");
                                        
	while($row_curnsies =  mysqli_fetch_array($select_currencies))
	  {
			$iso= $row_curnsies['iso'];
			$iso3= $row_curnsies['iso3'];
		    $code= $row_curnsies['code'];
	  }
	
	$select_currencies_rates = mysqli_query($link, "SELECT * FROM `currencies_rates` WHERE cid='$RID'");
    $DATED_curnsies_rts=''; 
	$cid_curnsies_rts='';
	while($row_curnsies_rts =  mysqli_fetch_array($select_currencies_rates))
	  {
			$id_curnsies_rts= $row_curnsies_rts['id'];
			$cid_curnsies_rts= $row_curnsies_rts['cid'];
			$DATED_curnsies_rts= $row_curnsies_rts['DATED'];
			$iso3_curnsies_rts= $row_curnsies_rts['iso3'];
	 }
	
	if ($POSTINGDATE_cp==$DATED_curnsies_rts && $cid_curnsies_rts==$RID) {
		//echo 'update';
		$sql2="UPDATE `currencies_rates` SET STATUS='$STATUS' WHERE cid='$$cid_curnsies_rts'";
			
			if(!mysqli_query($link, $sql2)){
				echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
			}
		
		$sql="UPDATE `currencies_rates` SET RATE='$RATE', REVALUERATE='$RATE' WHERE id='$id_curnsies_rts'";
			
			if(!mysqli_query($link, $sql)){
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			}
		
	}
	else {
		//echo 'insert';
		
		/*$sql3="UPDATE `currencies_rates` SET STATUS='$STATUS' WHERE cid='$cid_curnsies_rts'";
			
			if(!mysqli_query($link, $sql3)){
				echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
			}*/
		
		$sql="INSERT INTO  `currencies_rates` (cid, DATED, iso, iso3, code, RATE, REVALUERATE, STATUS) 
		VALUES ('$RID', '$POSTINGDATE_cp', '$iso', '$iso3', '$code', '$RATE', '$RATE', '$STATUS')";

				if(!mysqli_query($link, $sql)){
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
	}
	
	
	
	
			//exit;
			echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?updated=y'</script>");
	}



?>
<?php
if (isset($_REQUEST['actc']))
{
	$RID = $_REQUEST['id'];
	
	if ($_REQUEST['actc']=='app')
	{
		$sql="UPDATE `currencies_rates` SET STATUS='1' WHERE id=$RID ";
	}
	else if ($_REQUEST['actc']=='unapp')
	{
		$sql="UPDATE `currencies_rates` SET STATUS='0' WHERE id=$RID ";
	}

	if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?updated=y'</script>");
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
                                        <ul class="nav navbar-right panel_toolbox">

                                        	<li><a href="<?php echo basename($_SERVER['REQUEST_URI']) ?>" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Page Refresh"><i class="fa fa-refresh"></i></a></li>
                                            
                                        </ul>
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
										
                                       <?php if (isset($_GET['delete'])){ ?>
                                    <div class="alert alert-danger">
                                        <div class="container"><strong>Row is successfully deleted!</strong></div>
                                    </div>
                                    <?php } ?>
                                	<div id="filterForm" class="widget-block" style="padding-bottom:0px;">
                                
                                
                                    	
                                </div>
									<div id="no-more-tables">
                                        <table  class="table table-striped dt-table">
                                            <thead class="cf">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Currency Name</th>
                                                    <th>Country</th>
                                                    <th>Type</th>
                                                    <th>Mini Rate Limit</th>
													<th>Max Rate Limit</th>
													<th>Rate</th>
													<th>Revalue Rate</th>
                                                    <th class="al-center">Status</th>
                                                    <th class="al-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            
                                                <?php
                                                $counter = 0;
												
												
												$result = mysqli_query($link, "SELECT * FROM `currencies` WHERE MINIRLIMIT > 0 AND MAXRLIMIT > 0");
											
                                                    while($row = mysqli_fetch_array($result))
                                                      {
                                                          
														$RID= $row['id'];
														$ID= $row['id'];
														  $iso3= $row['iso3'];
														  $country= $row['country'];
														  $currency= $row['currency'];
														  $code= $row['code'];
														  $symbol= $row['symbol'];

														$TYPE= $row['TYPE'];
														$REVALUE= $row['REVALUE'];
														$PROFIT= $row['PROFIT'];
														$MINIRLIMIT= $row['MINIRLIMIT'];
														$MAXRLIMIT= $row['MAXRLIMIT'];
														$AUTOACCOUNT= $row['AUTOACCOUNT'];
														$UNEADMINFEE= $row['UNEADMINFEE'];
														$UNESERVICEFEE= $row['UNESERVICEFEE'];

														//$RATE= $row['RATE'];
														//$REVALUERATE= $row['REVALUERATE'];

														  //$STATUS= $row['STATUS'];
														
														
										$select_currencies_ratesI = mysqli_query($link, "SELECT * FROM `currencies_rates` WHERE cid='$ID' AND DATED='$POSTINGDATE_cp'");
										
										$RATE=0;
										$REVALUERATE=0;
										$STATUS=0;
														
										while($row_curnsies_rtsI =  mysqli_fetch_array($select_currencies_ratesI))
										  {
												$ID_CUR_RATE= $row_curnsies_rtsI['id'];
												$RATE= $row_curnsies_rtsI['RATE'];
											    $REVALUERATE= $row_curnsies_rtsI['REVALUERATE'];
												$STATUS= $row_curnsies_rtsI['STATUS'];
										 }
														
                                                    $counter=$counter+1;
                                                ?>
                                                <tr>
                                                    <td valign="top"><?php echo $counter; ?></td>
                                                    <td data-title="currency"><?php echo $currency; ?></td>
                                                    <td data-title="country"><?php echo $country; ?> - <?php echo $code; ?></td>
                                                    <td data-title="TYPE">
														<?php
															if ($TYPE==0) { echo 'Divide'; }
															else { echo 'Multiply'; }
														?>
													</td>
													<td data-title="MINIRLIMIT"><?php echo $MINIRLIMIT; ?></td>
													<td data-title="MAXRLIMIT"><?php echo $MAXRLIMIT; ?></td>
													<td data-title="RATE"><?php echo $RATE; ?></td>
													<td data-title="REVALUERATE"><?php echo $REVALUERATE; ?></td>
                                                    <td data-title="Status" class="al-center">
                                                    
                                                        <?php
														if ($STATUS == 0)
														{
														?>

														<a href="<?php echo basename($_SERVER['PHP_SELF'])."?id=".$ID_CUR_RATE."&actc=app" ?>" class="btn btn-warning btn-xs">Inactive</a>
														<?php
														}
														elseif ($STATUS == 1)
														{
														?>
														<a href="<?php echo basename($_SERVER['PHP_SELF'])."?id=".$ID_CUR_RATE."&actc=unapp" ?>" class="btn btn-success btn-xs">Active</a>
														<?php
														}
														?>
                                                        
                                                    
                                                    </td>
                                                    <td data-title="Action" class="al-center">
                                                        
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ProductAdd<?php echo $ID; ?>">
	                                          <i class="fa fa-edit"></i>
	                                        </button>		
														
														
														
		<!-- Modal -->
		<div class="modal fade " id="ProductAdd<?php echo $ID; ?>" tabindex="-1" role="dialog" aria-labelledby="ProductAdd">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="window.location='<?php echo basename($_SERVER['PHP_SELF']) ?>'"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Currency Rate Update</h4>
		      </div>
		      
		      <div id="form-content">
		      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $RID; ?>" class="form-horizontal" method="post" name="frm" autocomplete="off">
		      <div class="modal-body">
		        	<div class="widget-block" align="left">
		        		
		            	<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
								<label class="control-label text-left">Currency Name</label>
		                    	<input name="currency" class="form-control" type="text" value="<?php echo $currency; ?>" readonly>
		                    </div>
							<div class="col-lg-6">
								<label class="control-label text-left">ISO Code</label>
		                    	<input name="code" class="form-control" type="text" value="<?php echo $code; ?>" readonly>
		                    </div>
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Country</label>    
								<select name="COUNTRY" class="form-control" readonly>
								<option value=""></option>
	                        	<?php

								$result_country = mysqli_query($link, "SELECT iso, country FROM `currencies`");

									while($row_country = mysqli_fetch_array($result_country))
									  {
										  $iso_country= $row_country['iso'];
										  $country_country= $row_country['country'];
								?>
	                        	<option value="<?php echo $iso_country; ?>" <?php if ($country==$country_country){ echo 'selected'; } ?> ><?php echo $country_country; ?></option>
	                            <?php } ?>

	                        </select>
								
		                    </div>
							
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Rate</label>    
								<input name="RATE" type="text" class="form-control" value="<?php echo $RATE; ?>">
								
		                    </div>
		                    <div class="col-lg-6">
		                    	<label class="control-label text-left">Revalue Rate</label>    
								<input name="REVALUERATE" type="text" class="form-control" value="<?php echo $REVALUERATE; ?>" readonly>
								
								
		                    </div>
		                </div>
						<div class="form-group form-group-sm">
							<div class="col-lg-6">
		                    	<label class="control-label text-left">Status</label>    
									<?php if ($STATUS==1) { ?>
									<label><input type="checkbox" name="STATUS" value="1" checked="checked"  /> Active</label>
									<?php } else { ?>	
									<label><input type="checkbox" name="STATUS" value="1"  /> In-Active</label>
									<?php } ?>
								</div>
						</div>
		            </div>
		      </div>
		      <div class="modal-footer al-center">
				  <input type="submit" class="btn btn-primary" name="ProductAddSbmt" value="Update">
		      </div>
		      </form>
		      </div>
		      
		    </div>
		  </div>
		</div>
                                                    </td>
                                                    
                                                </tr>
                                                
                                                
                                                
                                                <?php } ?>
                                            </tbody>
                                        </table>
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

