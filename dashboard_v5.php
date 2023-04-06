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

		</div>
	</div>
	<?php include('inc_foot.php'); ?>