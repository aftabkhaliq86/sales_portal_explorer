<?php include('inc_meta_header.php'); ?>
<title>Dashboard <?php include('inc_page_title.php'); ?></title>
<?php include('inc_head.php'); ?>

<script>
	var xport = {
		_fallbacktoCSV: true,
		toXLS: function(tableId, filename) {
			this._filename = (typeof filename == 'undefined') ? tableId : filename;

			//var ieVersion = this._getMsieVersion();
			//Fallback to CSV for IE & Edge
			if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
				return this.toCSV(tableId);
			} else if (this._getMsieVersion() || this._isFirefox()) {
				alert("Not supported browser");
			}

			//Other Browser can download xls
			var htmltable = document.getElementById(tableId);
			var html = htmltable.outerHTML;

			this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
		},
		toCSV: function(tableId, filename) {

			this._filename = (typeof filename === 'undefined') ? tableId : filename;
			// Generate our CSV string from out HTML Table
			var csv = this._tableToCSV(document.getElementById(tableId));
			// Create a CSV Blob
			var blob = new Blob([csv], {
				type: "text/csv"
			});

			// Determine which approach to take for the download
			if (navigator.msSaveOrOpenBlob) {
				// Works for Internet Explorer and Microsoft Edge
				navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
			} else {
				this._downloadAnchor(URL.createObjectURL(blob), 'csv');
			}
		},
		_getMsieVersion: function() {
			var ua = window.navigator.userAgent;

			var msie = ua.indexOf("MSIE ");
			if (msie > 0) {
				// IE 10 or older => return version number
				return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
			}

			var trident = ua.indexOf("Trident/");
			if (trident > 0) {
				// IE 11 => return version number
				var rv = ua.indexOf("rv:");
				return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
			}

			var edge = ua.indexOf("Edge/");
			if (edge > 0) {
				// Edge (IE 12+) => return version number
				return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
			}

			// other browser
			return false;
		},
		_isFirefox: function() {
			if (navigator.userAgent.indexOf("Firefox") > 0) {
				return 1;
			}

			return 0;
		},
		_downloadAnchor: function(content, ext) {
			var anchor = document.createElement("a");
			anchor.style = "display:none !important";
			anchor.id = "downloadanchor";
			document.body.appendChild(anchor);

			// If the [download] attribute is supported, try to use it

			if ("download" in anchor) {
				anchor.download = this._filename + "." + ext;
			}
			anchor.href = content;
			anchor.click();
			anchor.remove();
		},
		_tableToCSV: function(table) {
			// We'll be co-opting `slice` to create arrays
			var slice = Array.prototype.slice;

			return slice
				.call(table.rows)
				.map(function(row) {
					return slice
						.call(row.cells)
						.map(function(cell) {
							return '"t"'.replace("t", cell.textContent);
						})
						.join(",");
				})
				.join("\r\n");
		}
	};
</script>


<body class="nav-md">

	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<?php include('inc_nav.php'); ?>
			</div>
			<?php include('inc_header.php'); ?>
			<!-- breadcrumb -->
			<div class="breadcrumb_content">
				<div class="breadcrumb_text">Dashboard /
					<!--<a href="dashboard.php">Dashboard</a> / -->
				</div>
			</div>
			<!-- /breadcrumb -->

			<!-- page content -->
			<div class="right_col bg_fff" role="main">
				<div class="">
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
									<?php if (isset($_GET['date'])) { ?>
										<div class="alert alert-warning">
											<div class="container"><strong>Data diffrence is not More than two months!</strong></div>
										</div>
									<?php } ?>
									<form name="frmSRCH" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
										<?php
										$sts = '';
										$srch_DATEFROM = '';
										$srch_DATETO = '';
										$DATEDG = '';
										$srchREGDATE = '';
										$srchSENDINGCOUNT = '';
										$srchSENDINGCOUNTi = '';
										$srchRECCOUNT = '';
										$srchRECCOUNTi = '';
										$srchEMAIL = '';
										$srchASSDATE = '';
										$srchASSDATEFROM = '';
										$srchASSDATETO = '';
										$srchAGENTS = '';
										$srchAGENTSi = '';
										$srchLEADS = '';
										$srchLEADSi = '';
										$srchSTATUS = '';
										$srchSTATUSi = '';
										$srchLEADS_TYPE = '';
										$srchLEADS_TYPEi = '';
										$resultsssfor_Lead_Converted_ego = '';
										if (isset($_GET['srchfilter'])) //submit button name
										{
											$srch_DATEFROM = $_GET['DATEFROM'];
											$srch_DATETO = $_GET['DATETO'];
											$srchASSDATEFROM = $_GET['srchASSDATEFROM'];
											$srchASSDATETO = $_GET['srchASSDATETO'];
											//echo '<hr>';

											//Get previous Date From-----------------------
											if ($srch_DATEFROM) {
												$srch_DATEFROM = strtotime($srch_DATEFROM);
												//$srch_DATEFROM = strtotime('-1 day', $srch_DATEFROM);
												$srch_DATEFROM = date('Y-m-d', $srch_DATEFROM);
											} else {
												$srch_DATEFROM = '';
											}
											//------------------------------------------
											//Get previous Date To-----------------------
											if ($srch_DATETO) {
												$srch_DATETO = strtotime($srch_DATETO);
												// $srch_DATETO = strtotime('+1 day', $srch_DATETO);
												$srch_DATETO = date('Y-m-d', $srch_DATETO);
											} else {
												$srch_DATETO = '';
											}
											// echo $srch_DATEFROM;
											// echo $srch_DATETO;
											//----------------------------------------------

											//Get Assignee previous Date From-----------------------
											if ($srchASSDATEFROM) {
												$srchASSDATEFROM = strtotime($srchASSDATEFROM);
												$srchASSDATEFROM = date('Y-m-d', $srchASSDATEFROM);
											} else {
												$srchASSDATEFROM = '';
											}
											//----------------------------------------------
											//Get Assignee previous Date To-----------------------
											if ($srchASSDATETO) {
												$srchASSDATETO = strtotime($srchASSDATETO);
												// $srchASSDATETO = strtotime('+1 day', $srchASSDATETO);
												$srchASSDATETO = date('Y-m-d', $srchASSDATETO);
											} else {
												$srchASSDATETO = '';
											}
											//----------------------------------------------


											if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
												//date diffrence Start
												$srch_DATEFROM = new DateTime($srch_DATEFROM);
												$srch_DATETO = new DateTime($srch_DATETO);
												$interval = $srch_DATEFROM->diff($srch_DATETO);
												$monthsDiff = $interval->m;
												if ($monthsDiff <= 2) {
													$DATEDG = "AND DATE(LEAD_STATUS_DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
												} else {
													echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?date=high'</script>");
												}
												//date diffrence End
											}
											if (isset($_GET['srchREGDATE']) && !empty($_GET['srchREGDATE'] != NULL)) {
												$srchREGDATE = "AND REGISTER_DATE='$_GET[srchREGDATE]'";
											}
											if (isset($_GET['srchSENDINGCOUNT']) && !empty($_GET['srchSENDINGCOUNT'] != NULL)) {
												$srchSENDINGCOUNT = "AND SENDING_COUNTRY='$_GET[srchSENDINGCOUNT]'";
												$srchSENDINGCOUNTi = $_GET['srchSENDINGCOUNT'];
											}
											if (isset($_GET['srchRECCOUNT']) && !empty($_GET['srchRECCOUNT'] != NULL)) {
												$srchRECCOUNT = "AND PREFFERED_COUNTRY='$_GET[srchRECCOUNT]'";
												$srchRECCOUNTi = $_GET['srchRECCOUNT'];
											}
											if (!empty($_GET['srchEMAIL'] != NULL)) {
												$srchEMAIL = "AND EMAIL='$_GET[srchEMAIL]'";
											}

											if (!empty($srchASSDATEFROM) && empty($srchASSDATETO)) {
												$srchASSDATE = "AND DATE(U_DATED) = '$srchASSDATEFROM'";
											} elseif (!empty($srchASSDATEFROM != NULL && $srchASSDATETO != NULL)) {
												$srchASSDATE = "AND DATE(U_DATED) BETWEEN '$srchASSDATEFROM' AND '$srchASSDATETO'";
											}
											if (isset($_GET['srchAGENTS']) && !empty($_GET['srchAGENTS'] != NULL)) {
												$srchAGENTS = "AND USERID='$_GET[srchAGENTS]'";
												$srchAGENTSi = $_GET['srchAGENTS'];
											}
											if (isset($_GET['srchLEADS']) && !empty($_GET['srchLEADS'] != NULL)) {
												$srchLEADS = "AND LEADTID='$_GET[srchLEADS]'";
												$srchLEADSi = $_GET['srchLEADS'];
											}
											if (isset($_GET['srchSTATUS']) && !empty($_GET['srchSTATUS'] != NULL)) {
												$srchSTATUS = "AND LEAD_STATUS='$_GET[srchSTATUS]'";
												$srchSTATUSi = $_GET['srchSTATUS'];
											}
											if (isset($_GET['srchLEADS_TYPE']) && !empty($_GET['srchLEADS_TYPE'] != NULL)) {
												$srchLEADS_TYPE = "AND `clt`.`LEAD_TYPE`='$_GET[srchLEADS_TYPE]'";
												$srchLEADS_TYPEi = $_GET['srchLEADS_TYPE'];
											}
											if (!empty($srchAGENTS) || !empty($srchSTATUS) || !empty($DATEDG) || !empty($srchASSDATE) || !empty($srchLEADS) || !empty($srchEMAIL) || !empty($srchLEADS_TYPE)) {
												// Determine current page number
												$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

												// Number of records to display per page
												$records_per_page = 10;

												// Query string parameters
												$params = $_GET;
												unset($params['page']); // Remove the 'page' parameter

												// Calculate the starting point of the records
												$offset = ($page - 1) * $records_per_page;
												$invalid_lead_sts = 0;
												$total_records = 0;

												// Calculate the starting point of the records
												$calling_leads = mysqli_query($link, "SELECT `cl`.*,`clt`.`LEAD_CATEGORY` AS `LEAD_CATEGORY_clt`,`clt`.`LEAD_TYPE` AS `LEAD_TYPE_clt`,DATE(`clt`.`DATED`) AS `LEAD_DATED_clt`,`cla`.`PERSON_NAME` AS `PERSON_NAME`,`ls`.`STATUS_HEADING` AS `STATUS_TITLE_STATUS`,`curr`.`name` AS `SENDING_COUNTRY_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_title` AS `clt` ON `cl`.`LEADTID`=`clt`.`ID` INNER JOIN `calling_lead_agents` AS `cla` ON `cl`.`USERID`=`cla`.`ID` INNER JOIN `lead_status` AS `ls` ON `cl`.`LEAD_STATUS`=`ls`.`ID` INNER JOIN `currencies` AS `curr` ON `cl`.`SENDING_COUNTRY`=`curr`.`iso3` WHERE INACTIVE_LEAD_TITLE='1' $srchAGENTS $srchSTATUS $srchLEADS_TYPE $DATEDG $srchASSDATE $srchLEADS $srchEMAIL LIMIT " . $offset . "," . $records_per_page);
												$calling_leads_all = "SELECT `cl`.*,`clt`.`LEAD_CATEGORY` AS `LEAD_CATEGORY_clt`,`clt`.`LEAD_TYPE` AS `LEAD_TYPE_clt`,DATE(`clt`.`DATED`) AS `LEAD_DATED_clt`,`cla`.`PERSON_NAME` AS `PERSON_NAME`,`ls`.`STATUS_HEADING` AS `STATUS_TITLE_STATUS`,`curr`.`name` AS `SENDING_COUNTRY_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_title` AS `clt` ON `cl`.`LEADTID`=`clt`.`ID` INNER JOIN `calling_lead_agents` AS `cla` ON `cl`.`USERID`=`cla`.`ID` INNER JOIN `lead_status` AS `ls` ON `cl`.`LEAD_STATUS`=`ls`.`ID` INNER JOIN `currencies` AS `curr` ON `cl`.`SENDING_COUNTRY`=`curr`.`iso3` WHERE INACTIVE_LEAD_TITLE='1' $srchAGENTS $srchSTATUS $srchLEADS_TYPE $DATEDG $srchASSDATE $srchLEADS $srchEMAIL";

												$total_records = $link->query("SELECT `cl`.*,`clt`.`LEAD_CATEGORY` AS `LEAD_CATEGORY_clt`,`clt`.`LEAD_TYPE` AS `LEAD_TYPE_clt`,DATE(`clt`.`DATED`) AS `LEAD_DATED_clt`,`cla`.`PERSON_NAME` AS `PERSON_NAME`,`ls`.`STATUS_HEADING` AS `STATUS_TITLE_STATUS`,`curr`.`name` AS `SENDING_COUNTRY_NAME` FROM `calling_lead` AS `cl` INNER JOIN `calling_lead_title` AS `clt` ON `cl`.`LEADTID`=`clt`.`ID` INNER JOIN `calling_lead_agents` AS `cla` ON `cl`.`USERID`=`cla`.`ID` INNER JOIN `lead_status` AS `ls` ON `cl`.`LEAD_STATUS`=`ls`.`ID` INNER JOIN `currencies` AS `curr` ON `cl`.`SENDING_COUNTRY`=`curr`.`iso3` WHERE INACTIVE_LEAD_TITLE='1' $srchAGENTS $srchSTATUS $srchLEADS_TYPE $DATEDG $srchASSDATE $srchLEADS $srchEMAIL")->num_rows;
												$total_pages = ceil($total_records / $records_per_page);
												$postData =  "&srchAGENTS=$srchAGENTS&srchSTATUS=$srchSTATUS&srchLEADS=$srchLEADS&srchLEADS_TYPE=$srchLEADS_TYPE&DATEDG=$DATEDG&srchASSDATE=$srchASSDATE&srchEMAIL=$srchEMAIL";

												// Encode the POST data into a query string
												// $queryString = http_build_query($postData);
											} else {
												$calling_leads = '';
											}
										}
										?>
										<div class="container">
											<div class="col-lg-12">
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Registration Date</label>
													<input type="date" name="srchREGDATE" class="form-control" value="<?php if ($srchREGDATE != NULL) {
																															echo $_GET['srchREGDATE'];
																														} ?>">
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Sending Country</label>
													<select name="srchSENDINGCOUNT" class="form-control">
														<option value="" hidden disabled selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$select_currencies_sc = mysqli_query($link, "SELECT * FROM `currencies`");
														foreach ($select_currencies_sc as $value_sc) {
														?>
															<option value="<?php echo $value_sc['iso3']; ?>" <?php if ($srchSENDINGCOUNTi == $value_sc['iso3']) {
																													echo 'selected';
																												} ?>><?php echo $value_sc['name'] ?></option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Receiving Country</label>
													<select name="srchRECCOUNT" class="form-control">
														<option value="" hidden disabled selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$select_currencies_rc = mysqli_query($link, "SELECT * FROM `currencies`");
														foreach ($select_currencies_rc as $value_rc) {
														?>
															<option value="<?php echo $value_rc['name'] ?>" <?php if ($srchRECCOUNTi == $value_rc['name']) {
																												echo 'selected';
																											} ?>><?php echo $value_rc['name'] ?></option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Email Search</label>
													<input type="email" name="srchEMAIL" class="form-control" value="<?php if ($srchEMAIL != NULL) {
																															echo $_GET['srchEMAIL'];
																														} ?>">
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Assigned Date From</label>
													<input type="date" name="srchASSDATEFROM" class="form-control" value="<?php if ($srchASSDATEFROM != NULL) {
																																echo $_GET['srchASSDATEFROM'];
																															} ?>">
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Assigned Date To</label>
													<input type="date" name="srchASSDATETO" class="form-control" value="<?php if ($srchASSDATETO != NULL) {
																															echo $_GET['srchASSDATETO'];
																														} ?>">
												</div>
											</div>
											<div class="col-lg-12">
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Agents</label>
													<select name="srchAGENTS" class="form-control">
														<option value="" hidden disabled selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$Agent_query = mysqli_query($link, "SELECT * FROM `calling_lead_agents`");
														foreach ($Agent_query as $value) {
														?>
															<option value="<?php echo $value['ID'] ?>" <?php if ($srchAGENTSi == $value['ID']) {
																											echo 'selected';
																										} ?>><?php echo $value['PERSON_NAME'] ?></option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Lead Type</label>
													<select name="srchLEADS_TYPE" class="form-control">
														<option value="" hidden disabled selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$calling_lead_types = mysqli_query($link, "SELECT * FROM `calling_lead_types`");
														foreach ($calling_lead_types as $calling_lead_type) {
														?>
															<option value="<?php echo $calling_lead_type['ID'] ?>" <?php if ($srchLEADS_TYPEi == $calling_lead_type['ID']) {
																														echo 'selected';
																													} ?>><?php echo $calling_lead_type['HEADING'] ?></option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Leads</label>
													<select name="srchLEADS" class="form-control">
														<option value="" hidden disabled selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$select_lead_title = mysqli_query($link, "SELECT * FROM `calling_lead_title`");
														foreach ($select_lead_title as $value_lt) {
														?>
															<option value="<?php echo $value_lt['ID'] ?>" <?php if ($srchLEADSi == $value_lt['ID']) {
																												echo 'selected';
																											} ?>><?php echo $value_lt['LEAD_CATEGORY'] ?></option>
														<?php
														}
														?>
													</select>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
													<label style="padding-top:7px;">Status</label>
													<select name="srchSTATUS" class="form-control">
														<option disabled hidden selected>SELECT</option>
														<option value="" style="font-weight: bold;text-align: center;">Reset</option>
														<?php
														$select_lead_status = mysqli_query($link, "SELECT * FROM `lead_status`");
														foreach ($select_lead_status as $value_ls) {
															if ($value_ls['STATUS_HEADING'] != "Lead Converted") {
														?>
																<option value="<?php echo $value_ls['ID'] ?>" <?php if ($srchSTATUSi == $value_ls['ID']) {
																													echo 'selected';
																												} ?>><?php echo $value_ls['STATUS_HEADING'] ?></option>
														<?php
															}
														}
														?>
													</select>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
													<div class="form-group al-right" style="padding-top: 31px;">
														<div class="col-lg-12" style="padding: 0!important;">
															<div class="input-daterange input-group">
																<input type="date" class="form-control input-date-picker datepicker-dropdown" id="DATEFROM" name="DATEFROM" placeholder="Start Date" autocomplete="off" value="<?php if ($srch_DATEFROM != NULL) {
																																																									echo $_GET['DATEFROM'];
																																																								} ?>" />
																<span class="input-group-addon"><i class="fa fa-angle-left"></i> From DATE To <i class="fa fa-angle-right"></i></span>
																<input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" value="<?php if ($srch_DATETO != NULL) {
																																																			echo $_GET['DATETO'];
																																																		} ?>" />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-12" align="center">
												<label>&nbsp;<br><br></label>
												<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
												<a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-warning"><i class="fa fa-times"></i></a>
												<?php if (isset($_GET['srchfilter'])) {
												?>
													<button type="button" id="btnExport" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
												<?php }
												?>

											</div>
										</div>
									</form>
									<div class="progress" style="margin: 10px;display: none;">
										<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											<span class="sr-only">0% Complete</span>
										</div>
									</div>
									<table id="leads" class="col-lg-12 table-striped table-condensed cf tbl">
										<thead class="cf">
											<tr>
												<th>#</th>
												<th>Calling Agent</th>
												<th>Lead Name</th>
												<th>Lead Type</th>
												<th>RMS ID</th>
												<th>Lead Upload Date</th>
												<th>Registration Date</th>
												<th>Phone</th>
												<th>Email</th>
												<th>Sending Country</th>
												<th>Preffered Country</th>
												<th>Last Transaction Details</th>
												<th>Status</th>
												<th style="display: none;">Call Summary</th>
												<td style="display: none;">Comments</td>
											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($calling_leads)) {
												foreach ($calling_leads as $calling_lead) {
													$ID = $calling_lead['ID'];
													$calling_lead_comments = mysqli_query($link, "SELECT `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
													if (!empty($calling_lead_comments)) {
														$RMS_ID = $calling_lead['RMS_ID'];
														$PHONE = $calling_lead['PHONE'];
														$EMAIL = $calling_lead['EMAIL'];
														$PREFFERED_COUNTRY = $calling_lead['PREFFERED_COUNTRY'];
														$REGISTER_DATE = $calling_lead['REGISTER_DATE'];
														$TRANSACTION_COUNT = $calling_lead['TRANSACTION_COUNT'];
														$LAST_TRANSACTION_DATE = $calling_lead['LAST_TRANSACTION_DATE'];
														$STATUS = $calling_lead['STATUS'];
														$active_calls = $calling_lead['calls'];
														// --------------------------------- Lead Status Start --------------------------------------
														$LEAD_STATUS = $calling_lead['LEAD_STATUS'];
														$LEAD_STATUS_DATED = $calling_lead['LEAD_STATUS_DATED'];
														$STATUS_TITLE_STATUS = $calling_lead['STATUS_TITLE_STATUS'];
														// --------------------------------- Lead Status End ----------------------------------------
														// --------------------------------- Lead Agent Start ---------------------------------------
														$USERID = $calling_lead['USERID'];
														$U_DATED = $calling_lead['U_DATED'];
														$PERSON_NAME = $calling_lead['PERSON_NAME'];
														// --------------------------------- Lead Agent End -----------------------------------------
														// --------------------------------- Lead Category Start ------------------------------------
														$LEAD_ID = $calling_lead['LEADTID'];
														$LEAD_CATEGORY_clt = $calling_lead['LEAD_CATEGORY_clt'];
														$LEAD_TYPE_clt = $calling_lead['LEAD_TYPE_clt'];
														$LEAD_DATED_clt = $calling_lead['LEAD_DATED_clt'];
														// --------------------------------- Lead Category End --------------------------------------
														// --------------------------------- Lead Country Start -------------------------------------
														$SENDING_COUNTRY = $calling_lead['SENDING_COUNTRY_NAME'];
														// --------------------------------- Lead Country End ---------------------------------------

											?>
														<tr id="<?php echo $ID; ?>">
															<td></td>
															<td><?php echo $PERSON_NAME; ?></td>
															<td><small><?php echo $LEAD_CATEGORY_clt; ?></small></td>
															<td><small><?php if ($LEAD_TYPE_clt == 1) {
																			echo "New Reg";
																		} elseif ($LEAD_TYPE_clt == 2) {
																			echo "Dormant";
																		} elseif ($LEAD_TYPE_clt == 3) {
																			echo "Inactive";
																		} ?></small></td>
															<td><?php echo $RMS_ID; ?></td>
															<td><?php echo $LEAD_DATED_clt; ?></td>
															<td><?php echo $REGISTER_DATE; ?></td>
															<td><?php echo $PHONE; ?></td>
															<td><?php echo $EMAIL; ?></td>
															<td><?php echo $SENDING_COUNTRY; ?></td>
															<td><?php echo $PREFFERED_COUNTRY; ?></td>
															<td><?php echo $LAST_TRANSACTION_DATE; ?><br> <?php echo $TRANSACTION_COUNT; ?></td>
															<td><?php echo $STATUS_TITLE_STATUS; ?><br> <small><?php echo $LEAD_STATUS_DATED; ?></small></td>
															<?php
															$calling_lead_comments = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
															$query_counts = mysqli_num_rows($calling_lead_comments);
															?>
															<td style="display: none;"><?php $counter = 1;
																						foreach ($calling_lead_comments as $call_summary) {
																							$LEAD_STATUS = $call_summary['LEAD_STATUS'];
																							$results1 = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
																							$rows1 = mysqli_fetch_array($results1);
																							$STATUS_HEADING = $rows1['STATUS_HEADING'];
																							if ($counter < $query_counts) {
																								echo $STATUS_HEADING . ' | ';
																							} else {
																								echo $STATUS_HEADING;
																							}
																							$counter++;
																						} ?></td>
															<td style="display: none;"><?php $counter1 = 1;
																						foreach ($calling_lead_comments as $all_comments) {
																							$LEAD_CMT_ID = $all_comments['LEAD_CMT_ID'];
																							$lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
																							if (mysqli_num_rows($lead_comments) > 0) {
																								$lead_comments_row = mysqli_fetch_array($lead_comments);
																								$COMMENT_HEADING = $lead_comments_row['HEADING'];
																								if ($COMMENT_HEADING == "Other") {
																									$COMMENT_AREA = $all_comments['COMMENT_AREA'];
																								} else {
																									$COMMENT_AREA = '';
																								}
																							} else {
																								$COMMENT_HEADING = '';
																								$COMMENT_AREA = '';
																							}
																							if ($counter1 < $query_counts) {
																								echo $COMMENT_HEADING . ': ' . $COMMENT_AREA . ' | ';
																							} else {
																								echo $COMMENT_HEADING . ': ' . $COMMENT_AREA;
																							}
																							$counter1++;
																						} ?></td>
														</tr>
											<?php
													}
												}
											}
											?>
										</tbody>
									</table>
								</div>
								<?php if (!empty($page)) {
									include('pagination.php');
								} ?>
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
	<script>
		// $('#btnExport').click(function(e) {
		// 	e.preventDefault();
		// 	$('#btnExport').button('loading');
		// 	$('.progress').show();
		// 	let calling_leads = "<?php //echo $calling_leads_all; 
									?>";
		// 	$.get('export/report_all.php?calling_leads=' + calling_leads, function(data) {
		// 		var progressBar = $('.progress-bar');
		// 		var progressWidth = 1;
		// 		var interval = setInterval(function() {
		// 			progressWidth += 1;
		// 			// progressBar.css('width', progressWidth + '%').attr('aria-valuenow', progressWidth).text(progressWidth + '%');
		// 			// if (progressWidth >= 100) {
		// 			// 	clearInterval(interval);
		// 			// 	var tableId = "leads_export"; // assign an id to the new table element
		// 			// 	var newTable = $("<table>").attr("id", tableId).html(data);
		// 			// 	$("body").append(newTable); // append the new table to the body
		// 			// 	xport.toCSV(tableId);
		// 			// 	newTable.remove(); // remove the new table after the export is done
		// 			// 	$('#btnExport').button('reset');
		// 			// }
		// 			progressBar.css('width', progressWidth + '%').attr('aria-valuenow', progressWidth).text(progressWidth + '%');
		// 			if (progressWidth >= 100) {
		// 				var tableId = "leads_export"; // assign an id to the new table element
		// 				var newTable = $("<table>").attr("id", tableId).html(data);
		// 				$("body").append(newTable); // append the new table to the body
		// 				xport.toCSV(tableId);
		// 				newTable.remove(); // remove the new table after the export is done
		// 				$('#btnExport').button('reset');
		// 				clearInterval(interval);
		// 			}
		// 		}, 20000);
		// 	});
		// });
		$('#btnExport').click(function(e) {
			e.preventDefault();
			$('#btnExport').button('loading');
			$('.progress').show();
			let calling_leads = "<?php echo $calling_leads_all; ?>";
			$.get('export/report_all.php?calling_leads=' + calling_leads, function(data) {
				var progressBar = $('.progress-bar');
				var progressWidth = 0;
				var interval = setInterval(function() {
					progressWidth += 1;
					progressBar.css('width', progressWidth + '%').attr('aria-valuenow', progressWidth).text(progressWidth + '%');
					$('.progress-text').text(progressWidth + '%'); // Update text element with progress percentage
					if (progressWidth >= 100) {
						var tableId = "leads_export"; // assign an id to the new table element
						var newTable = $("<table>").attr("id", tableId).html(data);
						$("body").append(newTable); // append the new table to the body
						xport.toCSV(tableId);
						newTable.remove(); // remove the new table after the export is done
						$('#btnExport').button('reset');
						clearInterval(interval);
						setInterval(function() {
                                $('.progress').hide();
                        },5000);
					}
				}, 200); // Set interval to 100ms for faster updates
				setInterval(function() {
                        $('.progress').hide();
                },5000);
			});
		});
	</script>