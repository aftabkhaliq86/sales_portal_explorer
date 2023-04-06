<?php include('inc_meta_header.php'); ?>
<title>Dashboard <?php include('inc_page_title.php'); ?></title>
<?php include('inc_head.php'); ?>
<?php include('backend/dashboard.php'); ?>
<?php
$DATEDG = '';
if (isset($_POST['srchfilter'])) //submit button name
{
	$srch_DATEFROM = $_POST['DATEFROM'];
	$srch_DATETO = $_POST['DATETO'];
	//Get previous Date From-----------------------
	if ($srch_DATEFROM) {
		$srch_DATEFROM = strtotime($srch_DATEFROM);
		//$srch_DATEFROM = strtotime('-1 day', $srch_DATEFROM);
		$srch_DATEFROM = date('Y-m-d', $srch_DATEFROM);
	} else {
		$srch_DATEFROM = '';
	}
	//----------------------------------------------
	//Get previous Date To-----------------------
	if ($srch_DATETO) {
		$srch_DATETO = strtotime($srch_DATETO);
		$srch_DATETO = strtotime('+1 day', $srch_DATETO);
		$srch_DATETO = date('Y-m-d', $srch_DATETO);
	} else {
		$srch_DATETO = '';
	}
	//----------------------------------------------
	if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
		$DATEDG = "AND DATE(LEAD_STATUS_DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
	}
	if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
		$DATEDG_other = "AND DATE(calls_start_time) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
	}

	$no_of_calls = call_record($link, $DATEDG_other);
	// For Profile Completed
	$Profile_Completed_arr = profile_completed($link, $DATEDG);
	// For Lead Converted
	$Lead_Converted_arr = lead_converted($link, $DATEDG);
}
?>
<script>
	window.onload = function() {
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			theme: "light", // "light1", "dark1", "dark2"
			animationDuration: 2000,
			title: {
				text: "Number of Calls"
			},
			axisX: {
				interval: 1,
				labelMaxWidth: 180,
				labelAngle: -70, //90,
				labelFontFamily: "verdana0"
			},
			data: [{
				type: "column",
				indexLabel: "{y}",
				dataPoints: <?php echo $no_of_calls; ?>
			}],
			options: {
				indexAxis: 'x',
				scales: {
					x: {
						type: 'time',
						source: 'data',
						ticks: {
							autoSkip: false
						}
					},
				}
			}
		});
		chart.render();
		//Multi Chart
		var chart_multi = new CanvasJS.Chart("chartContainer_multi", {
			animationEnabled: true,
			theme: "light2", // "light1", "dark1", "dark2"
			animationDuration: 2000,
			title: {
				text: "Targets"
			},
			axisX: {
				interval: 1,
				labelMaxWidth: 180,
				labelAngle: -70, //90,
				labelFontFamily: "verdana0"
			},
			legend: {
				cursor: "pointer",
				verticalAlign: "bottom",
				horizontalAlign: "center",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "column",
				name: "Profile Completed",
				indexLabel: "{y}",
				yValueFormatString: "#,###.##", //$#0.##
				showInLegend: true,
				dataPoints: <?php echo $Profile_Completed_arr; ?>
			}, {
				type: "column",
				name: "Lead Converted",
				indexLabel: "{y}",
				yValueFormatString: "#,###.##", //$#0.##
				showInLegend: true,
				dataPoints: <?php echo $Lead_Converted_arr; ?>
			}]
		});
		chart_multi.render();

		function toggleDataSeries(e) {
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			} else {
				e.dataSeries.visible = true;
			}
			chart_multi.render();
		}
	}
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
				<div class="breadcrumb_text">Dashboard / <!--<a href="dashboard.php">Dashboard</a> / -->
				</div>
			</div>
			<!-- /breadcrumb -->
			<!-- page content -->
			<div class="right_col bg_fff" role="main">

				<div class="container">
					<form action="" method="post">

						<div class="col-lg-12">
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1">

								<div class="form-group al-right" style="padding-top: 7px;">

									<div class="col-lg-11">
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
									<div class="col-lg-1">
										<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
									</div>

								</div>


							</div>
						</div>

					</form>
				</div>

				<div class="container">

					<div id="chartContainer_multi" style="height: 400px; width: 100%;"></div>
					<div id="chartContainer" style="height: 400px; width: 100%;margin-top: 1%;"></div>

				</div>


			</div>


			<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


			<!-- /page content -->
			<?php include('inc_footer.php'); ?>
			<?php include('inc_meta_header.php'); ?>
			<title>Dashboard <?php include('inc_page_title.php'); ?></title>
			<?php include('inc_head.php'); ?>

			<?php
			$DATEDG = '';
			if (isset($_POST['srchfilter'])) //submit button name
			{


				$srch_DATEFROM = $_POST['DATEFROM'];
				//echo '<br>';
				$srch_DATETO = $_POST['DATETO'];
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


				if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
					$DATEDG = "AND DATE(DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
				}
				if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
					$DATEDG_other = "AND DATE(calls_start_time) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
				}
			}
			?>


			<?php

			$dataPoints1 = array(
				array("label" => "Ali Ali", "y" => 36.12),
				array("label" => "", "y" => 34.87),
				array("label" => "New", "y" => 40.30),
				array("label" => "personal hai", "y" => 35.30),
				array("label" => "dishu dishu", "y" => 39.50),
				array("label" => "cancel", "y" => 50.82),
				array("label" => "hello melo", "y" => 74.70)
			);
			$dataPoints2 = array(
				array("label" => "Ali Ali", "y" => 64.61),
				array("label" => "", "y" => 70.55),
				array("label" => "New", "y" => 72.50),
				array("label" => "personal hai", "y" => 81.30),
				array("label" => "dishu dishu", "y" => 63.60),
				array("label" => "cancel", "y" => 69.38),
				array("label" => "hello melo", "y" => 98.70)
			);

			?>
			<script>
				window.onload = function() {

					var chart = new CanvasJS.Chart("chartContainer", {
						animationEnabled: true,
						theme: "light1", // "light1", "light2", "dark1", "dark2"
						title: {
							text: "Number of Calls"
						},
						axisY: {
							title: "" //Numbers
						},
						data: [{
							type: "column",
							dataPoints: <?php $result_ticki = mysqli_query($link, "SELECT count(ID) AS ID, USERID FROM `calling_comments_call` WHERE calls_start_time!='' $DATEDG_other GROUP BY USERID ");
										$num_rows_ticki = mysqli_num_rows($result_ticki);
										$ctr = 0;
										echo '[';
										while ($row_ticki = mysqli_fetch_array($result_ticki)) {
											$ctr++;
											echo '{"label":"';
											$result_users_IO = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$row_ticki[USERID]' AND STATUS=1");
											while ($row_users_IO = mysqli_fetch_array($result_users_IO)) {
												echo $row_users_IO['PERSON_NAME'] . ' - ' . $row_ticki['ID'];
											}
											echo '","y":';
											echo $row_ticki['ID'];
											echo '}';
											if ($ctr != $num_rows_ticki) {
												echo ' , ';
											} else {
												echo ']';
											}
										}
										?>
						}]
					});
					chart.render();

					//Multi Chart
					var chart_multi = new CanvasJS.Chart("chartContainer_multi", {
						animationEnabled: true,
						theme: "light2",
						title: {
							text: "Targets"
						},
						axisY: {
							includeZero: true
						},
						legend: {
							cursor: "pointer",
							verticalAlign: "center",
							horizontalAlign: "right",
							itemclick: toggleDataSeries
						},
						data: [{
							type: "column",
							name: "Profile Completed",
							indexLabel: "{y}",
							yValueFormatString: "#,###.##", //$#0.##
							showInLegend: true,
							dataPoints: <?php $resultsssfor_Profile_Completed = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE LEAD_STATUS='11' AND LEAD_STS_INVALID='0' AND STATUS='0' $DATEDG AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");


										$rowi = mysqli_num_rows($resultsssfor_Profile_Completed);
										$ctr_PC = 0;
										echo '[';
										while ($row = mysqli_fetch_array($resultsssfor_Profile_Completed)) {
											$ctr_PC++;
											echo '{"label":"';

											//echo $row['USERID'];
											$result_users_IOi = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$row[USERID]' AND STATUS='1'");
											while ($row_users_IOi = mysqli_fetch_array($result_users_IOi)) {
												echo $USERNAME = $row_users_IOi['PERSON_NAME'];
											}

											echo '","y":';
											echo $row['LEAD_STATUSi']; //$num_rows_ticki_PC;
											echo '}';
											if ($ctr_PC != $rowi) {
												echo ', ';
											} else {
												echo ']';
											}
										} ?>
						}, {
							type: "column",
							name: "Lead Converted",
							indexLabel: "{y}",
							yValueFormatString: "#,###.##", //$#0.##
							showInLegend: true,
							dataPoints: <?php $resultsssfor_Profile_Completedi = mysqli_query($link, "SELECT USERID, COUNT(LEAD_STATUS) as LEAD_STATUSi FROM `calling_lead_comments` WHERE LEAD_STATUS='12' AND LEAD_STS_INVALID='0' AND STATUS='0' $DATEDG AND USERID > 0 GROUP by USERID ORDER BY USERID ASC");
										$rowii = mysqli_num_rows($resultsssfor_Profile_Completedi);
										$ctr_PCi = 0;
										echo '[';
										while ($rowi = mysqli_fetch_array($resultsssfor_Profile_Completedi)) {
											$ctr_PCi++;
											echo '{"label":"';

											//echo $rowi['USERID'];
											$result_users_IOii = mysqli_query($link, "SELECT `PERSON_NAME` FROM `calling_lead_agents` WHERE ID='$rowi[USERID]' AND STATUS='1'");
											while ($row_users_IOii = mysqli_fetch_array($result_users_IOii)) {
												echo $USERNAMEi = $row_users_IOii['PERSON_NAME'];
											}

											echo '","y":';
											echo $rowi['LEAD_STATUSi']; //$num_rows_ticki_PC;
											echo '}';
											if ($ctr_PCi != $rowii) {
												echo ', ';
											} else {
												echo ']';
											}
										} ?>
						}]
					});
					chart_multi.render();

					function toggleDataSeries(e) {
						if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
							e.dataSeries.visible = false;
						} else {
							e.dataSeries.visible = true;
						}
						chart_multi.render();
					}


				}
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
							<div class="breadcrumb_text">Dashboard / <!--<a href="dashboard.php">Dashboard</a> / -->
							</div>
						</div>
						<!-- /breadcrumb -->

						<!-- page content -->
						<div class="right_col bg_fff" role="main">

							<div class="container">
								<form action="" method="post">

									<div class="col-lg-12">
										<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-lg-offset-1">

											<div class="form-group al-right" style="padding-top: 7px;">

												<div class="col-lg-9">
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
												<div class="col-lg-3">
													<button type="submit" name="srchfilter" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
												</div>

											</div>


										</div>
									</div>

								</form>
							</div>

							<div class="container">

								<div id="chartContainer_multi" style="height: 400px; width: 100%;"></div>
								<div id="chartContainer" style="height: 400px; width: 100%;"></div>

							</div>


						</div>


						<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


						<!-- /page content -->
						<?php include('inc_footer.php'); ?>

					</div>
				</div>
				<?php include('inc_foot.php'); ?>


		</div>
	</div>
	<?php include('inc_foot.php'); ?>