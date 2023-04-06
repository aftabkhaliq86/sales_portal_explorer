<?php include ('inc_php_funtions.php'); ?>
<?php
//if (isset($_POST['HEADING']))
if($_POST) {
	
	if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}
	
	$PNAME = normalize_str($_POST['PNAME']);
	$PCAT = normalize_str($_POST['PCAT']);
	$EMAIL = normalize_str($_POST['EMAIL']);
	$FRMUSERID = normalize_str($_POST['FRMUSERID']);
	$PASSWORD = normalize_str($_POST['PASSWORD']);
	$USERCAT = normalize_str($_POST['USERCAT']);
	$PWDHASH = md5($PASSWORD);
	
    
		$sql="INSERT INTO  `admin` (PNAME, PCAT, EMAIL, FRMUSERID, PWDHASH, USERCAT, STATUS) 
		
		VALUES ('$PNAME', '$PCAT', '$EMAIL', '$FRMUSERID', '$PWDHASH', '$USERCAT', '$STATUS')";
				
				if(!mysqli_query($link, $sql)){
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
                	<div class="col-lg-3"><label class="control-label">Person Name <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PNAME" class="form-control" type="text" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Designation on System <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PCAT" class="form-control" type="text" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Email Address <span class="text-danger">*</span><small><br><em>(for recoving password or alerts)</em></small></label></div>
                    <div class="col-lg-9">
                    	<input name="EMAIL" class="form-control" type="email" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">User ID <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="FRMUSERID" class="form-control" type="text" autocomplete="off" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Password <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PASSWORD" class="form-control" type="password" autocomplete="off" required>
                        <input name="USERCAT" type="hidden" value="1">
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Status</label></div>
                    <div class="col-lg-9"><label><input type="checkbox" name="STATUS" value="1" checked="checked" /> Active</label></div>
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
$(document).ready(function () {
 
window.setTimeout(function() {
    $(".alert").fadeTo(1500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 6000);
 
});
/*autohide alert*/

$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#product_add').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'users_add.php',
			type: 'POST',
			data: $(this).serialize() // it will serialize the form data
		})
		.done(function(data){
			$('#form-content').fadeOut('slow', function(){
				$('#form-content').fadeIn('slow').html(data);
			});
		})
		.fail(function(){
			alert('Ajax Submit Failed ...');	
		});
	});
	
});
</script>