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

				<form name="frmSRCH" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

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
					$resultsssfor_Lead_Converted_ego = '';

					if (isset($_POST['srchfilter'])) //submit button name
					{



						$srch_DATEFROM = $_POST['DATEFROM'];
						//echo '<br>';
						$srch_DATETO = $_POST['DATETO'];
						$srchASSDATEFROM = $_POST['srchASSDATEFROM'];
						//echo '<br>';
						$srchASSDATETO = $_POST['srchASSDATETO'];
						//echo '<hr>';

						//Get previous Date From-----------------------
						if ($srch_DATEFROM) {
							$srch_DATEFROM = strtotime($srch_DATEFROM);
							//$srch_DATEFROM = strtotime('-1 day', $srch_DATEFROM);
							$srch_DATEFROM = date('Y-m-d', $srch_DATEFROM);
						} else {
							$srch_DATEFROM = '';
						}
						//----------------------------------------------
						//echo '<br>';
						//Get previous Date To-----------------------
						if ($srch_DATETO) {
							$srch_DATETO = strtotime($srch_DATETO);
							$srch_DATETO = strtotime('+1 day', $srch_DATETO);
							$srch_DATETO = date('Y-m-d', $srch_DATETO);
						} else {
							$srch_DATETO = '';
						}
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
							$DATEDG = "AND DATE(DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
							// echo "YES";
							// exit;
						}
						if (isset($_POST['srchREGDATE']) && !empty($_POST['srchREGDATE'] != NULL)) {
							$srchREGDATE = "AND REGISTER_DATE='$_POST[srchREGDATE]'";
						}
						if (isset($_POST['srchSENDINGCOUNT']) && !empty($_POST['srchSENDINGCOUNT'] != NULL)) {
							$srchSENDINGCOUNT = "AND SENDING_COUNTRY='$_POST[srchSENDINGCOUNT]'";
							$srchSENDINGCOUNTi = $_POST['srchSENDINGCOUNT'];
						}
						if (isset($_POST['srchRECCOUNT']) && !empty($_POST['srchRECCOUNT'] != NULL)) {
							$srchRECCOUNT = "AND PREFFERED_COUNTRY='$_POST[srchRECCOUNT]'";
							$srchRECCOUNTi = $_POST['srchRECCOUNT'];
						}
						if (!empty($_POST['srchEMAIL'] != NULL)) {
							$srchEMAIL = "AND EMAIL='$_POST[srchEMAIL]'";
						}

						if (!empty($srchASSDATEFROM) && empty($srchASSDATETO)) {
							$srchASSDATE = "AND U_DATED LIKE '$srchASSDATEFROM%'";
						}
						if (!empty($srchASSDATEFROM != NULL && $srchASSDATETO != NULL)) {
							$srchASSDATE = "AND DATE(U_DATED) BETWEEN '$srchASSDATEFROM' AND '$srchASSDATETO'";
						}


						if (isset($_POST['srchAGENTS']) && !empty($_POST['srchAGENTS'] != NULL)) {
							$srchAGENTS = "AND USERID='$_POST[srchAGENTS]'";
							$srchAGENTSi = $_POST['srchAGENTS'];
						}
						if (isset($_POST['srchLEADS']) && !empty($_POST['srchLEADS'] != NULL)) {
							$srchLEADS = "AND LEADTID='$_POST[srchLEADS]'";
							$srchLEADSi = $_POST['srchLEADS'];
						}
						if (isset($_POST['srchSTATUS']) && !empty($_POST['srchSTATUS'] != NULL)) {
							$srchSTATUS = "AND LEAD_STATUS='$_POST[srchSTATUS]'";
							$srchSTATUSi = $_POST['srchSTATUS'];
						}

						if ($srchSTATUSi == 4) { // Invalid Lead
							$resultsssfor_Lead_Converted_ego = mysqli_query($link, "SELECT *, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE STATUS='0' AND LEAD_STS_INVALID='1' $srchAGENTS $srchSTATUS $DATEDG GROUP by LEAD_R_ID");
						} else { // other leads
							$resultsssfor_Lead_Converted_ego = mysqli_query($link, "SELECT *, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE STATUS='0' AND LEAD_STS_INVALID='0' $srchAGENTS $srchSTATUS $DATEDG GROUP by LEAD_R_ID");
							$result1_count = mysqli_num_rows($resultsssfor_Lead_Converted_ego);
						}
						// $result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE $srchASSDATE");
						// echo mysqli_num_rows($result1);
						// exit;
						// $row_ego = mysqli_fetch_array($resultsssfor_Lead_Converted_ego);
						// var_dump($row_ego);
						// exit;
					}
					?>

					<div class="container">
						<div class="col-lg-12">
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Registration Date</label>
								<input type="date" name="srchREGDATE" class="form-control" value="<?php if ($srchREGDATE != NULL) {
																										echo $_POST['srchREGDATE'];
																									} ?>">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Sending Country</label>
								<select name="srchSENDINGCOUNT" class="form-control">
									<option value=""></option>
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
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Receiving Country</label>
								<select name="srchRECCOUNT" class="form-control">
									<option value=""></option>
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
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Email Search</label>
								<input type="email" name="srchEMAIL" class="form-control" value="<?php if ($srchEMAIL != NULL) {
																										echo $_POST['srchEMAIL'];
																									} ?>">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Assigned Date From</label>
								<input type="date" name="srchASSDATEFROM" class="form-control" value="<?php if ($srchASSDATEFROM != NULL) {
																											echo $_POST['srchASSDATEFROM'];
																										} ?>">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Assigned Date To</label>
								<input type="date" name="srchASSDATETO" class="form-control" value="<?php if ($srchASSDATETO != NULL) {
																										echo $_POST['srchASSDATETO'];
																									} ?>">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Agents</label>
								<select name="srchAGENTS" class="form-control">
									<option value=""></option>
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
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Leads</label>
								<select name="srchLEADS" class="form-control">
									<option value=""></option>
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

						</div>
						<div class="col-lg-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label style="padding-top:7px;">Status</label>
								<select name="srchSTATUS" class="form-control">
									<option disabled hidden selected>SELECT</option>
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
									foreach ($select_lead_status as $value_ls) {
										if ($value_ls['STATUS_HEADING'] == "Lead Converted") {
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
							<div class="col-lg-8 col-md-5 col-sm-12 col-xs-12">

								<div class="form-group al-right" style="padding-top: 31px;">

									<div class="col-lg-12" style="padding: 0!important;">
										<div class="input-daterange input-group">
											<input type="date" class="form-control input-date-picker datepicker-dropdown" id="DATEFROM" name="DATEFROM" placeholder="Start Date" autocomplete="off" value="<?php if ($srch_DATEFROM != NULL) {
																																																				echo $_POST['DATEFROM'];
																																																			} ?>" />
											<span class="input-group-addon"><i class="fa fa-angle-left"></i> From DATE To <i class="fa fa-angle-right"></i></span>
											<input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" value="<?php if ($srch_DATETO != NULL) {
																																														echo $_POST['DATETO'];
																																													} ?>" />
										</div>
									</div>

								</div>


							</div>
						</div>

						<div class="col-lg-12" align="center">
							<label>&nbsp;<br><br></label>

							<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
							<a href="dashboard.php" class="btn btn-warning"><i class="fa fa-times"></i></a>
							<?php
							if (isset($_POST['srchfilter'])) //submit button name
							{
							?>
								<button type="button" id="btnExport" onclick="javascript:xport.toCSV('leads');" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
							<?php } ?>
						</div>
					</div>

				</form>


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
							<th class="al-center">Action</th>
							<td style="display: none;">Comments</td>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($resultsssfor_Lead_Converted_ego)) {
							while ($row_ego = mysqli_fetch_array($resultsssfor_Lead_Converted_ego)) {
								$LEAD_ID_ego = $row_ego['ID'];
								$LEAD_R_ID_ego = $row_ego['LEAD_R_ID'];
								$LEADTID_ego = $row_ego['LEADTID'];


								if (isset($_POST['srchfilter'])) //submit button name
								{

									$result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE ID='$LEAD_R_ID_ego' AND LEADTID='$LEADTID_ego' $srchAGENTS  $srchREGDATE $srchSENDINGCOUNT $srchRECCOUNT $srchEMAIL $srchASSDATE");
								}
								if (!empty($result1)) {
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
										$STATUS_note_s = '0';
										if (!empty($result_users_name)) {
											while ($row_usern = mysqli_fetch_array($result_users_name)) {
												$PERSON_NAME_usern = $row_usern['PERSON_NAME'];
											}
										} else {
											$PERSON_NAME_usern = '';
										}

										$result_note_s = mysqli_query($link, "SELECT * FROM `calling_lead_notes` WHERE LEADID='$LEAD_ID' AND LEAD_R_ID='$ID'");
										$STATUS_note_s = '0';
										while ($row_note_s = mysqli_fetch_array($result_note_s)) {
											$ID_note_s = $row_note_s['ID'];
											$STATUS_note_s = $row_note_s['STATUS'];
										}

										$result_calling_lead_title = mysqli_query($link, "SELECT `LEAD_CATEGORY`,`LEAD_TYPE`,`DATED` FROM `calling_lead_title` WHERE ID='$LEAD_ID'");
										$STATUS_note_s = '0';
										while ($row_clt = mysqli_fetch_array($result_calling_lead_title)) {
											$LEAD_CATEGORY_clt = $row_clt['LEAD_CATEGORY'];
											$LEAD_TYPE_clt = $row_clt['LEAD_TYPE'];
											$LEAD_DATED_clt = date('Y-m-d', strtotime($row_clt['DATED']));
										}

										// Last Status--------------------------------------
										$sel_calling_lead_comments = mysqli_query($link, "SELECT `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
										while ($row_sclc = mysqli_fetch_array($sel_calling_lead_comments)) {
											$LEAD_STATUS_sclc = $row_sclc['LEAD_STATUS'];
											$DATED_sclc = $row_sclc['DATED'];
										}
										//echo '<br>';
										$result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS_sclc'");
										$rows_ls = mysqli_fetch_array($result_lead_status);
										$STATUS_TITLE_STATUS = $rows_ls['STATUS_HEADING'];
										// Last Status End ---------------------------------

						?>
										<tr id="<?php echo $ID; ?>">
											<td></td>
											<td><?php echo $PERSON_NAME_usern; ?></td>
											<td><small><?php echo $LEAD_CATEGORY_clt; ?></small></td>
											<td><small><?php if ($LEAD_TYPE_clt == 1) {
															echo "New Reg";
														} elseif ($LEAD_TYPE_clt == 2) {
															echo "Dormant";
														} elseif ($LEAD_TYPE_clt == 3) {
															echo "Inactive";
														} else {
														} ?></small></td>
											<td><?php echo $RMS_ID; ?></td>
											<td><?php echo $LEAD_DATED_clt; ?></td>
											<td><?php echo $REGISTER_DATE; ?></td>
											<td><?php echo $PHONE; ?></td>
											<td><?php echo $EMAIL; ?></td>
											<td><?php echo $SENDING_COUNTRY; ?></td>
											<td><?php echo $PREFFERED_COUNTRY; ?></td>
											<td><?php echo $LAST_TRANSACTION_DATE; ?><br> <?php echo $TRANSACTION_COUNT; ?></td>
											<td><?php echo $STATUS_TITLE_STATUS; ?><br> <small><?php echo $DATED_sclc; ?></small></td>
											<td data-title="Action" class="al-center"></td>
											<td style="display: none;"><?php $result_calling_lead_comments = mysqli_query($link, "SELECT * FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
																		$counter = 1;
																		$query_counts = mysqli_num_rows($result_calling_lead_comments);
																		while ($row_clcs = mysqli_fetch_array($result_calling_lead_comments)) {
																			$LEAD_ID_rows = $row_clcs['ID'];
																			$LEAD_STATUS = $row_clcs['LEAD_STATUS'];
																			$LEAD_PICPATH = $row_clcs['PICPATH'];
																			$DATED = $row_clcs['DATED'];
																			$LEAD_CMT_ID = $row_clcs['LEAD_CMT_ID'];


																			$lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
																			if (mysqli_num_rows($lead_comments) > 0) {
																				$lead_comments_row = mysqli_fetch_array($lead_comments);
																				$COMMENT_HEADING = $lead_comments_row['HEADING'];
																				if ($COMMENT_HEADING == "Other") {
																					$COMMENT_AREA = $row_clcs['COMMENT_AREA'];
																				} else {
																					$COMMENT_AREA = '';
																				}
																			} else {
																				$COMMENT_HEADING = '';
																			}
																			$results1 = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
																			$rows1 = mysqli_fetch_array($results1);
																			$STATUS_HEADING = $rows1['STATUS_HEADING'];
																			// $result_statuses_i = mysqli_query($link, "SELECT `*` FROM `lead_status` WHERE ID='$row_clcs[LEAD_STATUS]'");
																			// if (mysqli_num_rows($result_statuses_i) > 0) {
																			// 	$lead_comments_row = mysqli_fetch_array($result_statuses_i);
																			// 	$COMMENT_HEADING = $lead_comments_row['STATUS_HEADING'];
																			// 	if ($COMMENT_HEADING == "Other") {
																			// 		$COMMENT_AREA = $row_clcs['COMMENT_AREA'];
																			// 	} else {
																			// 		$COMMENT_AREA = '';
																			// 	}
																			// } else {
																			// 	$COMMENT_HEADING = '';
																			// }
																			if ($counter < $query_counts) {
																				echo $COMMENT_AREA_clcs = $COMMENT_HEADING . ': ' . $COMMENT_AREA . '  [ Date: ' . $row_clcs['DATED'] . ' ]  |  ';
																			} else {
																				echo $COMMENT_AREA_clcs = $COMMENT_HEADING . ': ' . $COMMENT_AREA . '  [ Date: ' . $row_clcs['DATED'] . ' ] ';
																			}
																			$counter++;
																		} ?></td>
										</tr>
						<?php
									}
								}
							}
						}
						?>
					</tbody>
				</table>



			</div>
			<!-- /page content -->
			<?php include('inc_footer.php'); ?>
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

							<form name="frmSRCH" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

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
								$resultsssfor_Lead_Converted_ego = '';

								if (isset($_POST['srchfilter'])) //submit button name
								{



									$srch_DATEFROM = $_POST['DATEFROM'];
									//echo '<br>';
									$srch_DATETO = $_POST['DATETO'];
									$srchASSDATEFROM = $_POST['srchASSDATEFROM'];
									//echo '<br>';
									$srchASSDATETO = $_POST['srchASSDATETO'];
									//echo '<hr>';

									//Get previous Date From-----------------------
									if ($srch_DATEFROM) {
										$srch_DATEFROM = strtotime($srch_DATEFROM);
										//$srch_DATEFROM = strtotime('-1 day', $srch_DATEFROM);
										$srch_DATEFROM = date('Y-m-d', $srch_DATEFROM);
									} else {
										$srch_DATEFROM = '';
									}
									//----------------------------------------------
									//echo '<br>';
									//Get previous Date To-----------------------
									if ($srch_DATETO) {
										$srch_DATETO = strtotime($srch_DATETO);
										$srch_DATETO = strtotime('+1 day', $srch_DATETO);
										$srch_DATETO = date('Y-m-d', $srch_DATETO);
									} else {
										$srch_DATETO = '';
									}
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
										$DATEDG = "AND DATE(DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
										// echo "YES";
										// exit;
									}
									if (isset($_POST['srchREGDATE']) && !empty($_POST['srchREGDATE'] != NULL)) {
										$srchREGDATE = "AND REGISTER_DATE='$_POST[srchREGDATE]'";
									}
									if (isset($_POST['srchSENDINGCOUNT']) && !empty($_POST['srchSENDINGCOUNT'] != NULL)) {
										$srchSENDINGCOUNT = "AND SENDING_COUNTRY='$_POST[srchSENDINGCOUNT]'";
										$srchSENDINGCOUNTi = $_POST['srchSENDINGCOUNT'];
									}
									if (isset($_POST['srchRECCOUNT']) && !empty($_POST['srchRECCOUNT'] != NULL)) {
										$srchRECCOUNT = "AND PREFFERED_COUNTRY='$_POST[srchRECCOUNT]'";
										$srchRECCOUNTi = $_POST['srchRECCOUNT'];
									}
									if (!empty($_POST['srchEMAIL'] != NULL)) {
										$srchEMAIL = "AND EMAIL='$_POST[srchEMAIL]'";
									}

									if (!empty($srchASSDATEFROM) && empty($srchASSDATETO)) {
										$srchASSDATE = "AND U_DATED LIKE '$srchASSDATEFROM%'";
									}
									if (!empty($srchASSDATEFROM != NULL && $srchASSDATETO != NULL)) {
										$srchASSDATE = "AND DATE(U_DATED) BETWEEN '$srchASSDATEFROM' AND '$srchASSDATETO'";
									}


									if (isset($_POST['srchAGENTS']) && !empty($_POST['srchAGENTS'] != NULL)) {
										$srchAGENTS = "AND USERID='$_POST[srchAGENTS]'";
										$srchAGENTSi = $_POST['srchAGENTS'];
									}
									if (isset($_POST['srchLEADS']) && !empty($_POST['srchLEADS'] != NULL)) {
										$srchLEADS = "AND LEADTID='$_POST[srchLEADS]'";
										$srchLEADSi = $_POST['srchLEADS'];
									}
									if (isset($_POST['srchSTATUS']) && !empty($_POST['srchSTATUS'] != NULL)) {
										$srchSTATUS = "AND LEAD_STATUS='$_POST[srchSTATUS]'";
										$srchSTATUSi = $_POST['srchSTATUS'];
									}

									if ($srchSTATUSi == 4) { // Invalid Lead
										$resultsssfor_Lead_Converted_ego = mysqli_query($link, "SELECT *, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE STATUS='0' AND LEAD_STS_INVALID='1' $srchAGENTS $srchSTATUS $DATEDG GROUP by LEAD_R_ID");
									} else { // other leads
										$resultsssfor_Lead_Converted_ego = mysqli_query($link, "SELECT *, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE STATUS='0' AND LEAD_STS_INVALID='0' $srchAGENTS $srchSTATUS $DATEDG GROUP by LEAD_R_ID");
										$result1_count = mysqli_num_rows($resultsssfor_Lead_Converted_ego);
									}
									// $result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE $srchASSDATE");
									// echo mysqli_num_rows($result1);
									// exit;
									// $row_ego = mysqli_fetch_array($resultsssfor_Lead_Converted_ego);
									// var_dump($row_ego);
									// exit;
								}
								?>

								<div class="container">
									<div class="col-lg-12">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Registration Date</label>
											<input type="date" name="srchREGDATE" class="form-control" value="<?php if ($srchREGDATE != NULL) {
																													echo $_POST['srchREGDATE'];
																												} ?>">
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Sending Country</label>
											<select name="srchSENDINGCOUNT" class="form-control">
												<option value=""></option>
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
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Receiving Country</label>
											<select name="srchRECCOUNT" class="form-control">
												<option value=""></option>
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
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Email Search</label>
											<input type="email" name="srchEMAIL" class="form-control" value="<?php if ($srchEMAIL != NULL) {
																													echo $_POST['srchEMAIL'];
																												} ?>">
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Assigned Date From</label>
											<input type="date" name="srchASSDATEFROM" class="form-control" value="<?php if ($srchASSDATEFROM != NULL) {
																														echo $_POST['srchASSDATEFROM'];
																													} ?>">
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Assigned Date To</label>
											<input type="date" name="srchASSDATETO" class="form-control" value="<?php if ($srchASSDATETO != NULL) {
																													echo $_POST['srchASSDATETO'];
																												} ?>">
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Agents</label>
											<select name="srchAGENTS" class="form-control">
												<option value=""></option>
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
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Leads</label>
											<select name="srchLEADS" class="form-control">
												<option value=""></option>
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

									</div>
									<div class="col-lg-12">
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<label style="padding-top:7px;">Status</label>
											<select name="srchSTATUS" class="form-control">
												<option disabled hidden selected>SELECT</option>
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
												foreach ($select_lead_status as $value_ls) {
													if ($value_ls['STATUS_HEADING'] == "Lead Converted") {
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
										<div class="col-lg-8 col-md-5 col-sm-12 col-xs-12">

											<div class="form-group al-right" style="padding-top: 31px;">

												<div class="col-lg-12" style="padding: 0!important;">
													<div class="input-daterange input-group">
														<input type="date" class="form-control input-date-picker datepicker-dropdown" id="DATEFROM" name="DATEFROM" placeholder="Start Date" autocomplete="off" value="<?php if ($srch_DATEFROM != NULL) {
																																																							echo $_POST['DATEFROM'];
																																																						} ?>" />
														<span class="input-group-addon"><i class="fa fa-angle-left"></i> From DATE To <i class="fa fa-angle-right"></i></span>
														<input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" value="<?php if ($srch_DATETO != NULL) {
																																																	echo $_POST['DATETO'];
																																																} ?>" />
													</div>
												</div>

											</div>


										</div>
									</div>

									<div class="col-lg-12" align="center">
										<label>&nbsp;<br><br></label>

										<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
										<a href="dashboard.php" class="btn btn-warning"><i class="fa fa-times"></i></a>
										<?php
										if (isset($_POST['srchfilter'])) //submit button name
										{
										?>
											<button type="button" id="btnExport" onclick="javascript:xport.toCSV('leads');" class="btn btn-default"><i class="fa fa-download"></i>&nbsp;Export to CSV</button>
										<?php } ?>
									</div>
								</div>

							</form>


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
										<th class="al-center">Action</th>
										<td style="display: none;">Comments</td>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($resultsssfor_Lead_Converted_ego)) {
										while ($row_ego = mysqli_fetch_array($resultsssfor_Lead_Converted_ego)) {
											$LEAD_ID_ego = $row_ego['ID'];
											$LEAD_R_ID_ego = $row_ego['LEAD_R_ID'];
											$LEADTID_ego = $row_ego['LEADTID'];


											if (isset($_POST['srchfilter'])) //submit button name
											{

												$result1 = mysqli_query($link, "SELECT * FROM `calling_lead` WHERE ID='$LEAD_R_ID_ego' AND LEADTID='$LEADTID_ego' $srchAGENTS  $srchREGDATE $srchSENDINGCOUNT $srchRECCOUNT $srchEMAIL $srchASSDATE");
											}
											if (!empty($result1)) {
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
													$STATUS_note_s = '0';
													if (!empty($result_users_name)) {
														while ($row_usern = mysqli_fetch_array($result_users_name)) {
															$PERSON_NAME_usern = $row_usern['PERSON_NAME'];
														}
													} else {
														$PERSON_NAME_usern = '';
													}

													$result_note_s = mysqli_query($link, "SELECT * FROM `calling_lead_notes` WHERE LEADID='$LEAD_ID' AND LEAD_R_ID='$ID'");
													$STATUS_note_s = '0';
													while ($row_note_s = mysqli_fetch_array($result_note_s)) {
														$ID_note_s = $row_note_s['ID'];
														$STATUS_note_s = $row_note_s['STATUS'];
													}

													$result_calling_lead_title = mysqli_query($link, "SELECT `LEAD_CATEGORY`,`LEAD_TYPE`,`DATED` FROM `calling_lead_title` WHERE ID='$LEAD_ID'");
													$STATUS_note_s = '0';
													while ($row_clt = mysqli_fetch_array($result_calling_lead_title)) {
														$LEAD_CATEGORY_clt = $row_clt['LEAD_CATEGORY'];
														$LEAD_TYPE_clt = $row_clt['LEAD_TYPE'];
														$LEAD_DATED_clt = date('Y-m-d', strtotime($row_clt['DATED']));
													}

													// Last Status--------------------------------------
													$sel_calling_lead_comments = mysqli_query($link, "SELECT `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
													while ($row_sclc = mysqli_fetch_array($sel_calling_lead_comments)) {
														$LEAD_STATUS_sclc = $row_sclc['LEAD_STATUS'];
														$DATED_sclc = $row_sclc['DATED'];
													}
													//echo '<br>';
													$result_lead_status = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS_sclc'");
													$rows_ls = mysqli_fetch_array($result_lead_status);
													$STATUS_TITLE_STATUS = $rows_ls['STATUS_HEADING'];
													// Last Status End ---------------------------------

									?>
													<tr id="<?php echo $ID; ?>">
														<td></td>
														<td><?php echo $PERSON_NAME_usern; ?></td>
														<td><small><?php echo $LEAD_CATEGORY_clt; ?></small></td>
														<td><small><?php if ($LEAD_TYPE_clt == 1) {
																		echo "New Reg";
																	} elseif ($LEAD_TYPE_clt == 2) {
																		echo "Dormant";
																	} elseif ($LEAD_TYPE_clt == 3) {
																		echo "Inactive";
																	} else {
																	} ?></small></td>
														<td><?php echo $RMS_ID; ?></td>
														<td><?php echo $LEAD_DATED_clt; ?></td>
														<td><?php echo $REGISTER_DATE; ?></td>
														<td><?php echo $PHONE; ?></td>
														<td><?php echo $EMAIL; ?></td>
														<td><?php echo $SENDING_COUNTRY; ?></td>
														<td><?php echo $PREFFERED_COUNTRY; ?></td>
														<td><?php echo $LAST_TRANSACTION_DATE; ?><br> <?php echo $TRANSACTION_COUNT; ?></td>
														<td><?php echo $STATUS_TITLE_STATUS; ?><br> <small><?php echo $DATED_sclc; ?></small></td>
														<td data-title="Action" class="al-center"></td>
														<td style="display: none;"><?php $result_calling_lead_comments = mysqli_query($link, "SELECT `COMMENT_AREA`, `LEAD_STATUS`, `DATED` FROM `calling_lead_comments` WHERE LEAD_R_ID='$ID'");
																					$counter = 1;
																					$query_counts = mysqli_num_rows($result_calling_lead_comments);
																					while ($row_clcs = mysqli_fetch_array($result_calling_lead_comments)) {
																						$LEAD_ID_rows = $row_clcs['ID'];
																						$LEAD_STATUS = $row_clcs['LEAD_STATUS'];
																						$LEAD_PICPATH = $row_clcs['PICPATH'];
																						$DATED = $row_clcs['DATED'];
																						$LEAD_CMT_ID = $row_clcs['LEAD_CMT_ID'];
																						$lead_comments = mysqli_query($link, "SELECT * FROM `lead_comments` WHERE ID='$LEAD_CMT_ID'");
																						if (mysqli_num_rows($lead_comments) > 0) {
																							$lead_comments_row = mysqli_fetch_array($lead_comments);
																							$COMMENT_HEADING = $lead_comments_row['HEADING'];
																							if ($COMMENT_HEADING == "Other") {
																								$COMMENT_AREA = $row_clcs['COMMENT_AREA'];
																							} else {
																								$COMMENT_AREA = '';
																							}
																						} else {
																							$COMMENT_HEADING = '';
																						}
																						$results1 = mysqli_query($link, "SELECT * FROM `lead_status` WHERE ID='$LEAD_STATUS'");
																						$rows1 = mysqli_fetch_array($results1);
																						$STATUS_HEADING = $rows1['STATUS_HEADING'];
																						if ($counter < $query_counts) {
																							echo $COMMENT_HEADING . ': ' . $COMMENT_AREA . '  [ Date: ' . $row_clcs['DATED'] . ' ]  |  ';
																						} else {
																							echo $COMMENT_HEADING . ': ' . $COMMENT_AREA . '  [ Date: ' . $row_clcs['DATED'] . ' ] ';
																						}
																						$counter++;
																					} ?></td>
													</tr>
									<?php
												}
											}
										}
									}
									?>
								</tbody>
							</table>



						</div>
						<!-- /page content -->
						<?php include('inc_footer.php'); ?>

					</div>
				</div>
				<?php include('inc_foot.php'); ?>
				<script>
					$(document).ready(function() {
						$('#leads').DataTable();
					});
				</script>
		</div>
	</div>
	<?php include('inc_foot.php'); ?>
	<script>
		$(document).ready(function() {
			$('#leads').DataTable();
		});
	</script>