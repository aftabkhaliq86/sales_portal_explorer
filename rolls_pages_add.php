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
	
	$PGID = normalize_str($_POST['PGID']);
	$PAGENAME = normalize_str($_POST['PAGENAME']);
	$PAGEURL = normalize_str($_POST['PAGEURL']);
    
		$sql="INSERT INTO  `rolls_ms_pages` (PGID, PAGENAME, PAGEURL, STATUS) 
		
		VALUES ('$PGID', '$PAGENAME', '$PAGEURL', '$STATUS')";
				
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
                	<div class="col-lg-3"><label class="control-label">Select Group</label></div>
                    <div class="col-lg-9">
                    
                    	<select name="PGID" class="form-control">
                        	<option value=""></option>
							<?php
                            $result_groups = mysqli_query($link, "SELECT ID, GROUPNAME FROM `rolls_ms_pages_group` WHERE STATUS='1'");
        
                                while($rowPGID = mysqli_fetch_array($result_groups))
                                  {
                                      $PGID= $rowPGID['ID'];
                                      $GROUPNAME_PGID= $rowPGID['GROUPNAME'];
                            ?>
                            <option value="<?php echo $PGID; ?>" ><?php echo $GROUPNAME_PGID; ?></option>
                            <?php } ?>
                        </select>
                    
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Page Name</label></div>
                    <div class="col-lg-9">
                    	<input name="PAGENAME" class="form-control" type="text" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Page URL</label></div>
                    <div class="col-lg-9">
                    	<input name="PAGEURL" class="form-control" type="text" required>
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
			url: 'rolls_pages_add.php',
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