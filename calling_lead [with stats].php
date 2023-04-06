<?php include('inc_meta_header.php'); ?>
<title>
    <?php
    $page_link_url = basename($_SERVER['PHP_SELF']);
    $plu_del_ext = rtrim($page_link_url, ' .php');
    echo $plu_del_rep = ucwords(str_replace("_", " ", $plu_del_ext));
    ?>
    <?php include('inc_page_title.php'); ?>
</title>
<?php include('inc_head.php'); ?>
<?php
if (isset($_GET['del'])) {
    $del = $_GET['del'];
    //UPDATE SQL Statement
    $sql = "DELETE FROM calling_lead_title WHERE ID = $del";
    $sql1 = "DELETE FROM calling_lead WHERE LEADTID = $del";
    mysqli_query($link, $sql);
    mysqli_query($link, $sql1);
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?delete=y'</script>");
}
//============ Approve Unapprove in List ================
if (isset($_REQUEST['actc'])) {
    $RID = $_REQUEST['id'];
    if ($_REQUEST['actc'] == 'app') {
        $sql = "UPDATE calling_lead_agents SET STATUS='1' WHERE ID=$RID ";
    } else if ($_REQUEST['actc'] == 'unapp') {
        $sql = "UPDATE calling_lead_agents SET STATUS='0' WHERE ID=$RID ";
    }
    if (!mysqli_query($link, $sql)) {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "'</script>");
}
?>

<body class="nav-md">
    <!-- Modal -->
    <div class="modal fade" id="ProductAdd" tabindex="-1" role="dialog" aria-labelledby="ProductAdd">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='<?php echo basename($_SERVER['PHP_SELF']) ?>'"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Roll Page Details</h4>
                </div>
                <div id="form-content">
                    <form method="post" id="product_add" name="productAdd" autocomplete="off">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Person Name<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="PERSON_NAME" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Email Name<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="EMAIL_ADDRESS" class="form-control" type="email" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Password<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="PASSWORD" class="form-control" type="password" required>
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Department<span class="text-danger">*</span></label></div>
                                    <div class="col-lg-9">
                                        <input name="DEPARTMENT" class="form-control" type="text" required>
                                        <!-- <select name="DEPARTMENT" id="" class="form-control" required>
                                            <option value="Compalaince"> 
                                                Compalaince
                                            </option>
                                            <option value="">
                                                Sales
                                            </option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="row sml-padding">
                                    <div class="col-lg-3"><label class="control-label">Status</label></div>
                                    <div class="col-lg-9"><label><input type="checkbox" name="STATUS" value="1" /> Active</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="reset" class="btn btn-default pull-left" value="Clear">
                            <input type="submit" class="btn btn-primary" name="ProductAddSbmt" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <?php include('inc_nav.php'); ?>
            </div>
            <?php include('inc_header.php'); ?>
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
						
						<?php
							date_default_timezone_set("Asia/Karachi");
							$today_datei = date('Y-m-d');
							$month = date('Y-m');
						
							$select_calling_lead = "SELECT SUM(ID) AS ID FROM `calling_lead` WHERE STATUS='1' GROUP BY LEADTID";
							$result_calling_lead = mysqli_query($link,$select_calling_lead);
							$Total_calling_lead = mysqli_num_rows($result_calling_lead);

							$select_calling_lead_title = "SELECT * FROM `calling_lead_title` WHERE STATUS='0'";
							$result_calling_lead_title = mysqli_query($link,$select_calling_lead_title);
							$Total_calling_lead_title = mysqli_num_rows($result_calling_lead_title);

							$select_calling_lead_title_ina = "SELECT * FROM `calling_lead_title` WHERE STATUS='1'";
							$result_calling_lead_title_ina = mysqli_query($link,$select_calling_lead_title_ina);
							$Total_calling_lead_title_ina = mysqli_num_rows($result_calling_lead_title_ina);
							
						
							$resultsssforcalls = mysqli_num_rows(mysqli_query($link, "SELECT * FROM calling_comments_call WHERE calls_start_time!='' AND calls_start_time LIKE '$today_datei%'"));
							$resultsssfortotalcalls = mysqli_num_rows(mysqli_query($link, "SELECT * FROM calling_comments_call WHERE  calls_start_time!='' AND calls_start_time LIKE '$month%'"));
						?>
						
						<div class="row top_tiles">
							<div class="animated col-lg-6 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats tile-white bg-blue-sky">
									<div class="icon"><i class="fa fa-shopping-cart"></i></div>
									<div class="count"><?php echo $Total_calling_lead_title; ?> / <?php echo $Total_calling_lead_title_ina; ?></div>
									<h3>Active / Used</h3>
									<p>Total: <?php echo $Total_calling_lead_title_ina+$Total_calling_lead_title; ?></p>
								</div>
							</div>
							<div class="animated col-lg-6 col-md-3 col-sm-6 col-xs-12">
								<div class="tile-stats tile-white bg-blue">
									<div class="icon"><i class="fa fa-phone-square"></i></div>
									<div class="count"><?php echo $resultsssforcalls; ?></div>
									<h3>No of Calls</h3>
									<p>Total: <?php echo $resultsssfortotalcalls; ?></p>
								</div>
							</div>
						</div>
						<div class="row">
							
							<?php
								$sts='';
								if (isset($_GET['sts'])) {
									$sts = $_GET['sts'];
								}
							?>
							<div class="col-lg-6">
								<a href="calling_lead.php?sts=1" class="col-lg-12 btn <?php if ($sts==1) { echo 'btn-success'; } else { echo 'btn-default'; } ?>  al-center">
								<h5 class="col-lg-6"><i class="fa fa-check fa-2x"></i><br>Active</h5>
								<h5 class="col-lg-6 fa-3x">
									<?php		
										echo $select_actives = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='1'"));
									?>
								</h5>
								</a>
							</div>
							<div class="col-lg-6">
								<a href="calling_lead.php?sts=2" class="col-lg-12 btn <?php if ($sts==2) { echo 'btn-success'; } else { echo 'btn-default'; } ?>  al-center">
								<h5 class="col-lg-6"><i class="fa fa-times fa-2x"></i><br>InActive</h5>
								<h5 class="col-lg-6 fa-3x">
									<?php		
										echo $select_actives = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='0'"));
									?>
								</h5>
								</a>
							</div>
						</div>
						
                    </div>
					<div class="container">
					<?php
					$result_person_counter = mysqli_query($link, "SELECT COUNT(USERID) AS USERIDC, USERID FROM `calling_lead` GROUP BY USERID");
						$counters = '0';
						$USERIDC = '';
						$USERID = '';
						while ($row_pc = mysqli_fetch_array($result_person_counter)) {
							$USERIDC = $row_pc['USERIDC'];
							$USERID = $row_pc['USERID'];

							$result_person_counteri = mysqli_query($link, "SELECT COUNT(USERID) AS USERIDC, USERID FROM `calling_lead` WHERE USERID='$USERID' AND STATUS='1' GROUP BY USERID");
								$USERIDCI='';
								while ($row_pci = mysqli_fetch_array($result_person_counteri)) {
									$USERIDCI = $row_pci['USERIDC'];
								}

							$result_person_names = mysqli_query($link, "SELECT PERSON_NAME FROM `calling_lead_agents` WHERE ID='$USERID'");
								$PERSON_NAME='';
								while ($row_pn = mysqli_fetch_array($result_person_names)) {
									$PERSON_NAME = $row_pn['PERSON_NAME'];
								}

							$counters = $counters + 1;
					?>
					<div class="col-lg-2 c2i btn btn-default al-center">
						<span class="fa-2x"><?php echo $USERIDC; ?> / <?php echo $USERIDCI; ?></span><br>
						<?php echo $counters; ?>. <?php echo $PERSON_NAME; ?>
					</div>
					<?php } ?>

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
									
									<div class="container" id="filters">
										<form name="frmSRCH" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
						
											<div class="form-group al-right">

											<label class="col-lg-1 control-label" style="padding:10px;">Dated :</label>
											<div class="col-lg-8">
												<div class="input-daterange input-group">
													<input type="date" class="form-control input-date-picker datepicker-dropdown" id="DATEFROM" name="DATEFROM" placeholder="Start Date" autocomplete="off" />
													<span class="input-group-addon">to</span>
													<input type="date" class="form-control input-date-picker" id="DATETO" name="DATETO" placeholder="End Date" autocomplete="off" />
												</div>
											</div>
											<div class="col-lg-2">
												<button type="submit" name="srchfilter" class="btn btn-success btn-block">Search <i class="fa fa-search"></i></button>
											</div>
											<div class="col-lg-1">
												<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class="btn btn-warning"><i class="fa fa-times"></i></a>
											</div>

										</div>


										</form>
									</div>
                                    
									<?php if (isset($_GET['delete'])) { ?>
                                        <div class="alert alert-danger">
                                            <div class="container"><strong>Row is successfully deleted!</strong></div>
                                        </div>
                                    <?php } ?>
									
                                    <table class="col-lg-12 table-striped table-condensed cf tbl">
                                        <thead class="cf">
                                            <tr>
                                                <th>#</th>
                                                <th>DATED</th>
                                                <th>Lead Category</th>
                                                <th>Lead Date</th>
												<th>Lead Report</th>
												<th>Status</th>
                                                <th class="al-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
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
													
													if ($srch_DATEFROM!=NULL && $srch_DATETO!=NULL) {
														
														$result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE DATED BETWEEN '$srch_DATEFROM' AND '$srch_DATETO' ORDER BY DATED");
														
													}
												
												} else {
													
													if ($sts==1) {
														$result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='1' ORDER BY DATED DESC");
													}
													elseif ($sts==2) {
														$result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='0' ORDER BY DATED DESC");
													}
													else {
														$result = mysqli_query($link, "SELECT * FROM `calling_lead_title` WHERE STATUS='1' ORDER BY DATED DESC");
													}
												
												
												}
                                            $counters = '0';
                                            while ($row = mysqli_fetch_array($result)) {
                                                $ID = $row['ID'];
                                                $DATED = $row['DATED'];
                                                $LEAD_CATEGORY = $row['LEAD_CATEGORY'];
                                                $LEAD_DATE = $row['LEAD_DATE'];
                                                $STATUS = $row['STATUS'];
                                                $counters = $counters + 1;
                                                $result_calling_lead = mysqli_num_rows(mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS='1'"));
												
												$results = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID'");
                                                $result_count = mysqli_num_rows($results);
												
                                                $results1 = mysqli_query($link, "SELECT * FROM calling_lead WHERE LEADTID='$ID' AND STATUS ='1'");
                                                $result_count1 = mysqli_num_rows($results1);
												
                                            ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <?php echo $DATED; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $LEAD_CATEGORY; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $LEAD_DATE; ?>
                                                    </td>
													<td>
                                                       <?php echo $result_count1; ?>/<?php echo $result_count; ?>
                                                    </td>
													<td>
                                                        <?php
                                                        if ($STATUS == '1') {
                                                        ?>
                                                            <span class="bg-green text-white" style="padding: 5px; border-radius: 5px;">Active</span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="bg-red text-white" style="padding: 5px;border-radius: 5px;">InActive</span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    </td>
                                                    <td data-title="Action" class="al-center">
                                                        <a href="calling_lead_details.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>

                                                        <a href="calling_lead_edit.php?id=<?php echo $ID; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>

                                                        <?php
                                                        if ($result_calling_lead == 0) {
                                                        ?>
                                                            <a href="<?php echo basename($_SERVER['PHP_SELF']) . "?del=" . $ID ?>" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
            // submit form using $.ajax() method
            $('#product_add').submit(function(e) {
                e.preventDefault(); // Prevent Default Submission
                $.ajax({
                        url: 'calling_lead_agents_add.php',
                        type: 'POST',
                        data: $(this).serialize() // it will serialize the form data
                    })
                    .done(function(data) {
                        $('#form-content').fadeOut('slow', function() {
                            $('#form-content').fadeIn('slow').html(data);
                        });
                    })
                    .fail(function() {
                        alert('Ajax Submit Failed ...');
                    });
            });
        });
    </script>