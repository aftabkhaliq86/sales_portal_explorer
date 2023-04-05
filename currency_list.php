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
if (isset($_POST['currency']))
	{
	
	$RID = $_GET['id'];
	$TYPE = $_POST['TYPE'];
	$REVALUE = $_POST['REVALUE'];
	$PROFIT = $_POST['PROFIT'];
	$MINIRLIMIT = $_POST['MINIRLIMIT'];
	$MAXRLIMIT = $_POST['MAXRLIMIT'];
	
	if(isset($_POST['AUTOACCOUNT']) && $_POST['AUTOACCOUNT'] == '1')
		{
			$AUTOACCOUNT = 1;
		}
		else {
			$AUTOACCOUNT = 0;
		}
	if(isset($_POST['UNEADMINFEE']) && $_POST['UNEADMINFEE'] == '1')
		{
			$UNEADMINFEE = 1;
		}
		else {
			$UNEADMINFEE = 0;
		}
	if(isset($_POST['UNESERVICEFEE']) && $_POST['UNESERVICEFEE'] == '1')
		{
			$UNESERVICEFEE = 1;
		}
		else {
			$UNESERVICEFEE = 0;
		}
	if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}
	
	
		//UPDATE SQL Statement
		$sql="UPDATE `currencies` SET TYPE='$TYPE', REVALUE='$REVALUE', PROFIT='$PROFIT', MINIRLIMIT='$MINIRLIMIT', MAXRLIMIT='$MAXRLIMIT', AUTOACCOUNT='$AUTOACCOUNT', UNEADMINFEE='$UNEADMINFEE', UNESERVICEFEE='$UNESERVICEFEE', STATUS='$STATUS' WHERE ID='$RID'";
			
			if(!mysqli_query($link, $sql)){
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
			}
			//exit;
			echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?updated=y'</script>");
	}



if (isset($_POST['unpaidtranxsbmt']))
	{
	if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}
	
	$RID = normalize_str($_POST['RID']);
	
	$HID = normalize_str($_POST['HID']);
	$CURN = normalize_str($_POST['CURN']);
	$HEADING = normalize_str($_POST['HEADING']);
	$PREFIX = normalize_str($_POST['PREFIX']);
	//$COUNTRY_ID = normalize_str($_POST['COUNTRY_ID']);
	//$COUNTRY = normalize_str($_POST['COUNTRY']);
	
	$master_q=$_POST["COUNTRYi"];
	$result_explode = explode(',', $master_q);
	$COUNTRY_ID = $result_explode[0]; //id
	//echo '<br>';
	$COUNTRY = $result_explode[1]; //iso
	//exit;
	$REVALUE = normalize_str($_POST['REVALUE']);
	$DLIMIT = normalize_str($_POST['DLIMIT']);
	$CLIMIT = normalize_str($_POST['CLIMIT']);
	
    
		$sql="INSERT INTO  `vocher_sub_heads` (SESSID, AGENTID, HID, HEADING, CURN, PREFIX, COUNTRY_ID, CURNCY_ID, COUNTRY, REVALUE, DLIMIT, CLIMIT, STATUS) 
		
		VALUES ('$SESSID', '$AgentID', '$HID', '$HEADING', '$CURN', '$PREFIX', '$COUNTRY_ID', '$RID', '$COUNTRY', '$REVALUE', '$DLIMIT', '$CLIMIT', '$STATUS')";
				
				if(!mysqli_query($link, $sql)){
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
	
	if(isset($_POST['AUTOACCOUNT']) && $_POST['AUTOACCOUNT'] == '1')
		{
			$AUTOACCOUNT = '1';
			
			$sql2="UPDATE `currencies` SET AUTOACCOUNT='$AUTOACCOUNT' WHERE ID='$RID'";
			
			if(!mysqli_query($link, $sql2)){
				echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
			}
		
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
                                                    <th>Currency Code</th>
                                                    <th>Type</th>
													<th>Revalue</th>
                                                    <th>Mini Rate Limit</th>
													<th>Max Rate Limit</th>
													<th class="al-center"></th>
                                                    <th class="al-center">Status</th>
                                                    <th class="al-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            
                                                <?php
                                                $counter = 0;
												$iso3='';
												
												$result = mysqli_query($link, "SELECT * FROM `currencies`");
													
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
                                                          
                                                          $STATUS= $row['STATUS'];
														
													$result_vsh = mysqli_query($link, "SELECT * FROM `vocher_sub_heads` WHERE CURNCY_ID='$RID'");
													
														while($row_vsh = mysqli_fetch_array($result_vsh))
														  {

															$vsh_ID= $row_vsh['ID'];
														  }
														
                                                    $counter=$counter+1;
                                                ?>
                                                <tr>
                                                    <td valign="top"><?php echo $counter; ?></td>
                                                    <td data-title="currency"><?php echo $currency; ?></td>
                                                    <td data-title="country"><?php echo $country; ?></td>
                                                    <td data-title="code"><?php echo $code; ?></td>
                                                    <td data-title="TYPE">
														<?php
															if ($TYPE==0) { echo 'Divide'; }
															else { echo 'Multiply'; }
														?>
													</td>
													<td data-title="REVALUE"><?php echo $REVALUE; ?></td>
													<td data-title="MINIRLIMIT"><?php echo $MINIRLIMIT; ?></td>
													<td data-title="MAXRLIMIT"><?php echo $MAXRLIMIT; ?></td>
													<td data-title="code">
														<?php
                                                        if ($AUTOACCOUNT == 1)
                                                        {
                                                        ?>
                                                        <span class="btn btn-success btn-xs">Yes</span>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <span class="btn btn-warning btn-xs">No</span>
                                                        <?php
                                                        }
                                                        ?>
														<?php
                                                        if ($UNEADMINFEE == 1)
                                                        {
                                                        ?>
                                                        <span class="btn btn-success btn-xs">UnEarned Admin Fee Yes!</span>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <span class="btn btn-warning btn-xs">UnEarned Admin Fee No!</span>
                                                        <?php
                                                        }
                                                        ?>
														<?php
                                                        if ($UNESERVICEFEE == 1)
                                                        {
                                                        ?>
                                                        <span class="btn btn-success btn-xs">UnEarned Serivce Fee Yes!</span>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <span class="btn btn-warning btn-xs">UnEarned Serivce Fee No!</span>
                                                        <?php
                                                        }
                                                        ?>
													</td>
                                                    <td data-title="Status" class="al-center">
                                                    
                                                        <?php
                                                        if ($STATUS == 1)
                                                        {
                                                        ?>
                                                        <span class="btn btn-success btn-xs">Active</span>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                        <span class="btn btn-warning btn-xs">UnActive</span>
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
		        <h4 class="modal-title" id="myModalLabel">Currency <?php echo $iso3; ?> Edit</h4>
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
							<div class="col-lg-6">
		                    	<label class="control-label text-left">Type</label>    
								<select name="TYPE" class="form-control">
									<option value="0" <?php if ($TYPE==0){ echo 'selected'; } ?>>Divide</option>
									<option value="1" <?php if ($TYPE==1){ echo 'selected'; } ?>>Multiply</option>
								</select>
								
		                    </div>
		                    
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Revalue</label>    
								<select name="REVALUE" class="form-control">
									<option value="0" <?php if ($REVALUE==0){ echo 'selected'; } ?>>No</option>
									<option value="1" <?php if ($REVALUE==1){ echo 'selected'; } ?>>Yes</option>
								</select>
								
		                    </div>
		                    <div class="col-lg-6">
		                    	<label class="control-label text-left">Profit</label>    
								<select name="PROFIT" class="form-control">
									<option value="0" <?php if ($PROFIT==0){ echo 'selected'; } ?>>No</option>
									<option value="1" <?php if ($PROFIT==1){ echo 'selected'; } ?>>Yes</option>
								</select>
								
		                    </div>
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Mini Rate Value</label>    
								<input name="MINIRLIMIT" type="text" class="form-control" value="<?php echo $MINIRLIMIT; ?>">
								
		                    </div>
		                    <div class="col-lg-6">
		                    	<label class="control-label text-left">Max Rate Value</label>    
								<input name="MAXRLIMIT" type="text" class="form-control" value="<?php echo $MAXRLIMIT; ?>">
								
								
		                    </div>
		                </div>
						
						<div class="form-group form-group-sm">
							<div class="col-lg-12">
								  <?php if ($AUTOACCOUNT==1) { ?>
								  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#unpaidtranx<?php echo $ID; ?>">
									  Unpaid Tranx <?php echo $iso3; ?> Account Created
									</button>
								  <?php } else { ?>	
								  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#unpaidtranx<?php echo $ID; ?>">
									  Auto create Unpaid Tranx <?php echo $iso3; ?> Account
									</button>
								  <?php } ?>
								
								  
								
							</div>
		                </div>
						<!--<div class="form-group form-group-sm">
							<div class="col-lg-12">
								<?php if ($UNEADMINFEE==1) { ?>
								  <label><input type="checkbox" name="UNEADMINFEE" value="1" checked="checked"  /> Auto create UnEarned Admin Service Fee Account</label>
								  <?php } else { ?>	
								  <label><input type="checkbox" name="UNEADMINFEE" value="1"  /> Auto create UnEarned Admin Service Fee Account</label>
								  <?php } ?>
							</div>
		                </div>
						<div class="form-group form-group-sm">
							<div class="col-lg-12">
								<?php if ($UNESERVICEFEE==1) { ?>
								  <label><input type="checkbox" name="UNESERVICEFEE" value="1" checked="checked"  /> Auto create UnEarned Agent Service Fee Account</label>
								  <?php } else { ?>	
								  <label><input type="checkbox" name="UNESERVICEFEE" value="1"  /> Auto create UnEarned Agent Service Fee Account</label>
								  <?php } ?>
							</div>
		                </div>-->
						
		                <div class="form-group form-group-sm">
		                    <div class="col-lg-12">
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
														
														
		<!-- Unpaid Tranx -->
		<div class="modal fade " id="unpaidtranx<?php echo $ID; ?>" tabindex="-1" role="dialog" aria-labelledby="ProductAdd">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="unpaidtranx">Create Unpaid <?php echo $iso3; ?> Account</h4>
		      </div>
		      
		      <div id="form-contenti">
		      <form class="form-horizontal al-left" method="post" id="unpaidtranx" name="unpaidtranx" autocomplete="off">
		      <div class="modal-body">
		        	<div class="widget-block">
		        		<div class="form-group form-group-sm">
	                	
	                    <div class="col-lg-12">
							<label class="control-label">Head Title</label>
	                        <select name="HID" class="form-control" required>
								<option value=""></option>
	                        	<?php

								$result_prdcats = mysqli_query($link, "SELECT ID, HEADING FROM vocher_heads WHERE STATUS=1 AND FINANCIAL_CATEGORY='4'");

									while($row_prdcats = mysqli_fetch_array($result_prdcats))
									  {
										  $HEADID= $row_prdcats['ID'];
										  $HEADING= $row_prdcats['HEADING'];
								?>
	                        	<option value="<?php echo $HEADID; ?>"><?php echo $HEADING; ?></option>
	                            <?php } ?>

	                        </select>
	                    </div>
	                    
	                </div>
		            	<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
								<label class="control-label text-left">Sub Head Title</label>
		                    	<input name="HEADING" class="form-control" type="text" value="UnPaid Tranx <?php echo $iso3; ?> Account" required readonly>
		                    </div>
							<div class="col-lg-6">
								<label class="control-label text-left">Prefix</label>
		                    	<input name="PREFIX" class="form-control" value="UnPaidTranx<?php echo $iso3; ?>" type="text" readonly>
		                    </div>
		                </div>
		                <div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Country</label>    
								<select id="COUNTRY" name="COUNTRYi" class="form-control" onChange="showSubCur(this.value);" required readonly>
	                        	<?php

								$result_country = mysqli_query($link, "SELECT id, iso3, country FROM `currencies` WHERE STATUS='1' AND iso3='$iso3'");

									while($row_country = mysqli_fetch_array($result_country))
									  {
										  $id_country= $row_country['id'];
										  $iso3_country= $row_country['iso3'];
										  $country_country= $row_country['country'];
								?>
	                        	<option value="<?php echo $id_country; ?>,<?php echo $iso3_country; ?>" selected><?php echo $country_country; ?></option>
	                            <?php } ?>

	                        </select>
								
		                    </div>
		                    <div id="contry_currencies" class="col-lg-6">
		                    	<label class="control-label text-left">Currency</label>    
									<select name="CURN" class="form-control" readonly >
<?php

$result_currencies = mysqli_query($link, "SELECT id, code, country FROM `currencies` WHERE id='$id_country' AND iso3='$iso3_country'");

	while($row_curn = mysqli_fetch_array($result_currencies))
	  {
		  $id_curn= $row_curn['id'];
		  $code_curn= $row_curn['code'];
		  $country_curn= $row_curn['country'];
?>
<option value="<?php echo $code_curn; ?>" ><?php echo $code_curn; ?> - <?php echo $country_curn; ?></option>
<?php } ?>

</select>
		                    </div>
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Revalue It?</label>    
								<select name="REVALUE" class="form-control" required>
								<option value="0">No</option>
								<option value="1">Yes</option>
	                        </select>
								
		                    </div>
		                </div>
						<div class="form-group form-group-sm">
		                	<div class="col-lg-6">
		                    	<label class="control-label text-left">Debit Limit</label>    
								<input name="DLIMIT" type="text" class="form-control" value="0">
								
		                    </div>
		                    <div class="col-lg-6">
		                    	<label class="control-label text-left">Credit Limit</label>    
								<input name="CLIMIT" type="text" class="form-control" value="0">
								
								
		                    </div>
		                </div>
		                <div class="form-group form-group-sm">
		               	  	<div class="col-lg-3"><label class="control-label text-left">Status</label></div>
		                    <div class="col-lg-9"><label><input type="checkbox" name="STATUS" value="1" checked="checked" /> Active</label></div>
		                </div>
		            </div>
		      </div>
			  <?php if ($AUTOACCOUNT==1) { ?>
				  <div class="modal-footer" align="center">
				  	  <a class="btn btn-primary btn-sm" href="vocher_subheads_edit.php?id=<?php echo $vsh_ID; ?>"><i class="fa fa-edit"></i></a>
					  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#unpaidtranx<?php echo $ID; ?>">
					  Unpaid Tranx <?php echo $code; ?> has been Created.
					</button>
				  </div>
			  <?php } else { ?>
		      <div class="modal-footer">
				  <?php
				  if ($STATUS==1) {
				  ?>
				  <input type="hidden" name="AUTOACCOUNT" value="1" />
				  <input type="hidden" name="RID" value="<?php echo $RID; ?>" />
				  
		        <input type="reset" class="btn btn-default pull-left" value="Clear">
		       	<input type="submit" class="btn btn-primary" name="unpaidtranxsbmt" value="Submit">
				  <?php } else { ?>
				  <h4 class="text-danger al-center" align="center">Country is not active!</h4>
				  <?php } ?>
		      </div>
			  <?php } ?>
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

		

