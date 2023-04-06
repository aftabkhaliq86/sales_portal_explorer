<?php include('inc_php_funtions.php'); ?>
<?php
//if (isset($_POST['HEADING']))
if ($_POST) {
	if (isset($_POST['STATUS']) && $_POST['STATUS'] == '1') {
		$STATUS = 1;
	} else {
		$STATUS = 0;
	}
	$PERSON_NAME = normalize_str($_POST['PERSON_NAME']);
	$EMAIL_ADDRESS = normalize_str($_POST['EMAIL_ADDRESS']);
	$DEPARTMENT = normalize_str($_POST['DEPARTMENT']);
	$Passwordi = normalize_str($_POST['PASSWORD']);
    $PASSWORD = md5($Passwordi);
	$sql = "INSERT INTO  `calling_lead_agents` (DATED,PERSON_NAME,EMAIL_ADDRESS,PASSWORD,DEPARTMENT, STATUS) 
		VALUES (NOW(),'$PERSON_NAME','$EMAIL_ADDRESS','$PASSWORD','$DEPARTMENT', '$STATUS')";
	if (!mysqli_query($link, $sql)) {
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
	/*echo ("<script>location='comp-pg_edit.php?id=$MXID&preID=$preID&page=$page&added=y'</script>");*/
}
?>
<div class="alert alert-success" role="alert">
	<strong>Success!</strong> Product Successfully Added!
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
						<input name="EMAIL_ADDRESS" class="form-control" type="text" required>
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

<script type="text/javascript">
	/*autohide alert*/
	$(document).ready(function() {

		window.setTimeout(function() {
			$(".alert").fadeTo(1500, 0).slideUp(500, function() {
				$(this).remove();
			});
		}, 6000);

	});
	/*autohide alert*/

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