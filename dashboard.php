<?php include('inc_meta_header.php'); ?>
<title>Dashboard <?php include('inc_page_title.php'); ?></title>
<?php include('inc_head.php'); ?>

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
		$DATEDG = "AND DATE(DATED) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
	}
	if (!empty($srch_DATEFROM != NULL && $srch_DATETO != NULL)) {
		$DATEDG_other = "AND DATE(calls_start_time) BETWEEN '$srch_DATEFROM' AND '$srch_DATETO'";
	}
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
				<div class="breadcrumb_text">Dashboard / <!--<a href="dashboard.php">Dashboard</a> / -->
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
											<input type="radio" name="import_date" id="inlineRadio1" value="Yesterday">Import yesterday Call Cogs
										</label>
										<label class="radio-inline">
											<input type="radio" name="import_date" id="inlineRadio2" value="Today">Import Today Call Cogs
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