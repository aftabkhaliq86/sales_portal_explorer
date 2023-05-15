<?php include('inc_meta_header.php'); ?>
<title>Dashboard <?php include('inc_page_title.php'); ?></title>
<?php include('inc_head.php'); ?>
<?php include('backend/dashboard.php'); ?>
<?php
if (isset($_POST['submit'])) //submit button name
{
	$date_from = !empty($_POST['date_from']) ? date('Y-m-d', strtotime($_POST['date_from'])) : '';
	$date_to = !empty($_POST['date_to']) ? date('Y-m-d', strtotime($_POST['date_to'])) : '';
	$date_from_to = !empty($date_from) && !empty($date_to) ? "AND DATE(DATED) BETWEEN '$date_from' AND '$date_to'" : '';
	$date_from_to_call = !empty($date_from) && !empty($date_to) ? "AND DATE(call_time) BETWEEN '$date_from' AND '$date_to'" : '';
	//----------------------------------------------

	$no_of_calls = call_record($link, $date_from_to_call)['name'];
	$no_of_calls_count = call_record($link, $date_from_to_call)['count'];
	// For Profile Completed
	$Profile_Completed_arr = profile_completed($link, $date_from_to);
	// For Lead Converted
	$Lead_Converted_arr = lead_converted($link, $date_from_to);
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
					// maximum: //$no_of_calls_count;,
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
<?php
}
?>


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
				</div>
			</div>
			<!-- /breadcrumb -->
			<!-- page content -->
			<div class="right_col bg_fff" role="main">
				<div class="container" style="margin-bottom: 20px;">
					<form action="" method="post" id="import-logs">
						<div class="col-lg-12 mt-2">
							<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 col-lg-offset-1">
								<h3>Import 3cx Call Logs</h3>
								<div class="form-group al-right" style="padding-top: 7px;">

									<div class="col-lg-9 text-left">
										<label class="radio-inline">
											<input type="radio" name="import_date" id="inlineRadio1" value="Yesterday">Import yesterday Call logs
										</label>
										<label class="radio-inline">
											<input type="radio" name="import_date" id="inlineRadio2" value="Today">Import Today Call logs
										</label>
									</div>
									<div class="col-lg-3">
										<button type="button" data-loading-text="Loading..." name="start_import" id="start-import" class="btn btn-success rounded"><i class="fa fa-cloud-download"></i>Start Import</button>
									</div>


								</div>


							</div>
						</div>

					</form>
					<div class="progress " style="margin: 10px">
						<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
							<span class="sr-only">0% Complete</span>
						</div>
					</div>

				</div>
				<div class="container">
					<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

						<div class="col-lg-12">
							<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-lg-offset-1">

								<div class="form-group al-right" style="padding-top: 7px;">

									<div class="col-lg-11">
										<div class="input-daterange input-group">
											<input type="date" class="form-control input-date-picker datepicker-dropdown" id="date_from" name="date_from" placeholder="Start Date" autocomplete="off" value="<?= ($_POST['date_from'] ?? '') ? $_POST['date_from'] : '' ?>" />
											<span class="input-group-addon"><i class="fa fa-angle-left"></i> From DATE To <i class="fa fa-angle-right"></i></span>
											<input type="date" class="form-control input-date-picker" id="date_to" name="date_to" placeholder="End Date" autocomplete="off" value="<?= ($_POST['date_to'] ?? '') ? $_POST['date_to'] : '' ?>" />
										</div>
									</div>
									<div class="col-lg-1">
										<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
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
	<script>
		$("#start-import").on('click', function() {
			if ($('#import-logs').serialize() == '') {
				alert('Please select  Import Date');
				exit();
			}
			var $btn = $(this);
			console.log($('#import-logs').serialize());
			$.ajax({
				type: "POST",
				url: "three_cx_call_logs.php",
				data: $('#import-logs').serialize(),
				cache: false,
				beforeSend: function() {
					$btn.button('loading');
					var progressBar = $('.progress-bar');
					var progressWidth = 1;
					var interval = setInterval(function() {
						progressWidth += 1;
						if (progressWidth >= 100) {
							clearInterval(interval);
						} else {
							progressBar.css('width', progressWidth + '%').attr('aria-valuenow', progressWidth).text(progressWidth + '%');
						}
					}, 20000);
				},
				success: function(data) {

				},
				complete: function() {
					$btn.button('reset');
					$('.progress').addClass('hidden');
					alert('Well done! You successfully Imported call logs.');
				}
			});
		})
	</script>
	<?php include('inc_foot.php'); ?>