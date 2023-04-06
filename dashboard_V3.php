<?php include ('inc_meta_header.php'); ?>
<title>Dashboard <?php include ('inc_page_title.php'); ?></title>
<?php include ('inc_head.php'); ?>

    <body class="nav-md">
	
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                <?php include ('inc_nav.php'); ?>
                </div>
                <?php include ('inc_header.php'); ?>
                <!-- breadcrumb -->
                <div class="breadcrumb_content">
                    <div class="breadcrumb_text">Dashboard / <!--<a href="dashboard.php">Dashboard</a> / -->
                    </div>
                </div>
                <!-- /breadcrumb -->
                
                <!-- page content -->
                <div class="right_col bg_fff" role="main">
					
					<form name="frmSRCH" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        
						<div class="container">
							<div class="col-lg-12">
								<div class="col-lg-3">
									<label style="padding-top:7px;">Registration Date</label>
									<input type="date" name="srchREGDATE" class="form-control">
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Sending Country</label>
									<select name="srchSENDINGCOUNT" class="form-control">
										<option value=""></option>
										<?php
										$select_currencies_sc = mysqli_query($link, "SELECT * FROM `currencies`");
										foreach ($select_currencies_sc as $value_sc) {
										?>
											<option value="<?php echo $value_sc['iso3'] ?>"><?php echo $value_sc['country'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Receiving Country</label>
									<select name="srchRECCOUNT" class="form-control">
										<option value=""></option>
										<?php
										$select_currencies_rc = mysqli_query($link, "SELECT * FROM `currencies`");
										foreach ($select_currencies_rc as $value_rc) {
										?>
											<option value="<?php echo $value_rc['country'] ?>"><?php echo $value_rc['country'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Email Search</label>
									<input type="email" name="" class="form-control">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="col-lg-3">
									<label style="padding-top:7px;">Assigned Date</label>
									<input type="date" name="" class="form-control">
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Agents</label>
									<select name="srchAGENTS" class="form-control">
										<option value=""></option>
										<?php
										$Agent_query = mysqli_query($link, "SELECT * FROM `calling_lead_agents`");
										foreach ($Agent_query as $value) {
										?>
											<option value="<?php echo $value['ID'] ?>"><?php echo $value['PERSON_NAME'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Leads</label>
									<select name="USERID" class="form-control">
										<option value="" ></option>
										<?php
										$select_lead_title = mysqli_query($link, "SELECT * FROM `calling_lead_title`");
										foreach ($select_lead_title as $value_lt) {
										?>
											<option value="<?php echo $value_lt['ID'] ?>"><?php echo $value_lt['LEAD_CATEGORY'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-3">
									<label style="padding-top:7px;">Status</label>
									<select name="USERID" class="form-control">
										<option value=""></option>
										<?php
										$select_lead_status = mysqli_query($link, "SELECT * FROM `lead_status`");
										foreach ($select_lead_status as $value_ls) {
										?>
											<option value="<?php echo $value_ls['ID'] ?>"><?php echo $value_ls['STATUS_HEADING'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="col-lg-6 col-md-5 col-sm-12 col-xs-12 col-lg-offset-3">

										<div class="form-group al-right" style="padding-top: 7px;">

										<div class="col-lg-12">
											<div class="input-daterange input-group">
												<input type="date" class="form-control input-date-picker datepicker-dropdown" id="DATEFROM" name="DATEFROM" placeholder="Start Date" autocomplete="off" value="<?php //echo $srch_DATEFROM_i; ?>" />
												<span class="input-group-addon"><i class="fa fa-angle-left"></i> From DATE To <i class="fa fa-angle-right"></i></span>
												<input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" value="<?php //echo $srch_DATETO_i; ?>" />
											</div>
										</div>
										
									</div>


								</div>
							</div>
							
							<div class="col-lg-12" align="center">
								<label>&nbsp;<br><br></label>
								
								<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
							</div>
							
						</div>
						
						</form>
						
						
                             <table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
								<thead class="cf">
									<tr>
										<th>#</th>
										<th>Calling Agent</th>
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
									
										$sts='';
										$srch_DATEFROM='0';
										$srch_DATETO='0';
										$srchREGDATE='';

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
												
												echo $srchREGDATE = $_POST['srchREGDATE'];	
											
												if ($srch_DATEFROM!=NULL && $srch_DATETO!=NULL || $srchREGDATE!=NULL) {
													$result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE DATED BETWEEN '$srch_DATEFROM' AND '$srch_DATETO' AND REGISTER_DATE='2020-12-13' AND STATUS='1'");
												}
											
											} else {

												$result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE STATUS='1'");
									
											}
									
										while ($row1 = mysqli_fetch_array($result1)) {
											$ID = $row1['ID'];
											$RMS_ID = $row1['RMS_ID'];
											$PHONE = $row1['PHONE'];
											$EMAIL = $row1['EMAIL'];
											$PREFFERED_COUNTRY = $row1['PREFFERED_COUNTRY'];
											$REGISTER_DATE = $row1['REGISTER_DATE'];
											$SENDING_COUNTRY = $row1['SENDING_COUNTRY'];
											$TRANSACTION_COUNT = $row1['TRANSACTION_COUNT'];
											$LAST_TRANSACTION_DATE = $row1['LAST_TRANSACTION_DATE'];
											$USERID = $row1['USERID'];
											$U_DATED = $row1['U_DATED'];
											$LEAD_STATUS = $row1['LEAD_STATUS'];
											$LEAD_STATUS_DATED = $row1['LEAD_STATUS_DATED'];
											$LEAD_ID = $row1['LEADTID'];
											$STATUS = $row1['STATUS'];
											$active_calls = $row1['calls'];	
											
											$result_users_name = mysqli_query($link, "SELECT PERSON_NAME FROM `calling_lead_agents` WHERE ID='$USERID'");
												$STATUS_note_s='0';	
												while ($row_usern = mysqli_fetch_array($result_users_name)) {
														$PERSON_NAME_usern = $row_usern['PERSON_NAME'];
													}
											
											$result_note_s = mysqli_query($link, "SELECT * FROM `calling_lead_notes` WHERE LEADID='$LEAD_ID' AND LEAD_R_ID='$ID'");
												$STATUS_note_s='0';	
												while ($row_note_s = mysqli_fetch_array($result_note_s)) {
														$ID_note_s = $row_note_s['ID'];
														$STATUS_note_s = $row_note_s['STATUS'];
													}
											
											if ($LEAD_STATUS!=NULL) {
												$result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
												$rows_ls = mysqli_fetch_array($result_lead_status);
												$STATUS_TITLE_STATUS = $rows_ls['STATUS_HEADING'];
											}

											$result1s = mysqli_query($link, "SELECT * FROM calling_lead_comments");
											$result1s_count = mysqli_num_rows($result1s);
											
									?>
												<tr id="<?php echo $ID; ?>">
													<td>&nbsp;</td>
													<td><?php echo $PERSON_NAME_usern; ?></td>
													<td>
														<?php echo $RMS_ID; ?><br>
														<small><?php echo $REGISTER_DATE; ?></small>

													</td>
													<td>
														<?php echo $PHONE; ?>
													</td>
													<td>
														<?php echo $EMAIL; ?>
													</td>
													<td>
														<?php echo $SENDING_COUNTRY; ?>
													</td>
													<td>
														<?php echo $PREFFERED_COUNTRY; ?>
													</td>
													<td>
														<?php echo $LAST_TRANSACTION_DATE; ?><br>
														<?php echo $TRANSACTION_COUNT; ?>
													</td>
													<td>
														<?php if ($LEAD_STATUS!=NULL) { ?>
														<?php echo $STATUS_TITLE_STATUS; ?><br>
														<small><?php echo $LEAD_STATUS_DATED; ?></small>
														<?php } ?>
													</td>
													<td data-title="Action" class="al-center">&nbsp;</td>
												</tr>
									<?php
											
										}
									?>
								</tbody>
							</table>

                                    
					
                </div>
                <!-- /page content -->
				<?php include ('inc_footer.php'); ?>
                
            </div>
        </div>
		<?php include ('inc_foot.php'); ?>

