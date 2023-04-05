<?php include ('inc_meta_header.php'); ?>
<title>
<?php
$page_link_url = basename($_SERVER['PHP_SELF']);
$plu_del_ext = rtrim($page_link_url, ' .php');
echo $plu_del_rep = ucwords(str_replace("_", " ", $plu_del_ext));
?>

 <?php include ('inc_page_title.php'); ?>
</title>
<?php include ('inc_head.php'); ?>

<?php
$RID = $_GET['id'];
	$result = mysqli_query($link, "SELECT * FROM `admin` WHERE ID = $RID");

		while($row = mysqli_fetch_array($result))
		  {
			  $ID= $row['ID'];
			  $USERID= $row['ID'];
			  $FRMUSERID= $row['FRMUSERID'];
			  $PASSWORD= $row['PWDHASH'];
			  $EMAIL= $row['EMAIL'];
			  $PNAME= $row['PNAME'];
			  $PCAT= $row['PCAT'];
			  $STATUS= $row['STATUS'];
			  
			  $ROLL_USER_as= $row['ROLL'];
			  
			  $NEWPURCHASE= $row['NEWPURCHASE'];
			  $NEWORDER= $row['NEWORDER'];
			  $REVERSEORDER= $row['REVERSEORDER'];
			  $REVERSEPURCHASE= $row['REVERSEPURCHASE'];
			  
			  $NEWPURCHASE_EDIT= $row['NEWPURCHASE_EDIT'];
			  $NEWORDER_EDIT= $row['NEWORDER_EDIT'];
			  $REVERSEORDER_EDIT= $row['REVERSEORDER_EDIT'];
			  $REVERSEPURCHASE_EDIT= $row['REVERSEPURCHASE_EDIT'];
			  
			  $DEPOSITADD= $row['DEPOSITADD'];
			  $DEPOSITDELETE= $row['DEPOSITDELETE'];
			  $DEPOSITAPPROVE= $row['DEPOSITAPPROVE'];
			  
			  $PP_CANSEE= $row['PP_CANSEE'];
			  
			  $WORKTIMEIN= $row['WORKTIMEIN'];
			  $WORKTIMEOUT= $row['WORKTIMEOUT'];	
		  }

if (isset($_POST['FRMUSERID']))
	{
		if(isset($_POST['STATUS']) && $_POST['STATUS'] == '1')
		{
			$STATUS = 1;
		}
		else {
			$STATUS = 0;
		}
		
$FRMUSERID = normalize_str($_POST['FRMUSERID']);
$PASSWORD = normalize_str($_POST['PASSWORD']);
$PWDHASH = md5($PASSWORD);
$EMAIL = normalize_str($_POST['EMAIL']);
$PNAME = normalize_str($_POST['PNAME']);
$PCAT = normalize_str($_POST['PCAT']);

$WORKTIMEIN = normalize_str($_POST['WORKTIMEIN']);
$WORKTIMEOUT = normalize_str($_POST['WORKTIMEOUT']);

if ($PASSWORD!=NULL) {
	$sql="UPDATE `admin` SET PNAME='$PNAME', PCAT='$PCAT', EMAIL='$EMAIL', PWDHASH='$PWDHASH', FRMUSERID='$FRMUSERID', WORKTIMEIN='$WORKTIMEIN', WORKTIMEOUT='$WORKTIMEOUT', STATUS='$STATUS' WHERE ID = $RID";
}
else {
	$sql="UPDATE `admin` SET PNAME='$PNAME', PCAT='$PCAT', EMAIL='$EMAIL', FRMUSERID='$FRMUSERID', WORKTIMEIN='$WORKTIMEIN', WORKTIMEOUT='$WORKTIMEOUT', STATUS='$STATUS' WHERE ID = $RID";
}
				
	if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}

//header("location: comp-pg_edit.php?id=$RID&preID=$preID&updated=y");
echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?id=$RID&updated=y'</script>");
	}
?>

<?php


if(isset($_POST['assignpages'])){
		
$PAGESID ='';
		//Order Pages------------------------------------------
		
		if(isset($_POST['NEWPURCHASE']) && $_POST['NEWPURCHASE'] == '1')
		{
			$NEWPURCHASE = 1;
		}
		else {
			$NEWPURCHASE = 0;
		}
		if(isset($_POST['NEWORDER']) && $_POST['NEWORDER'] == '1')
		{
			$NEWORDER = 1;
		}
		else {
			$NEWORDER = 0;
		}
		if(isset($_POST['REVERSEORDER']) && $_POST['REVERSEORDER'] == '1')
		{
			$REVERSEORDER = 1;
		}
		else {
			$REVERSEORDER = 0;
		}
		if(isset($_POST['REVERSEPURCHASE']) && $_POST['REVERSEPURCHASE'] == '1')
		{
			$REVERSEPURCHASE = 1;
		}
		else {
			$REVERSEPURCHASE = 0;
		}
		
		if(isset($_POST['NEWPURCHASE_EDIT']) && $_POST['NEWPURCHASE_EDIT'] == '1')
		{
			$NEWPURCHASE_EDIT = 1;
		}
		else {
			$NEWPURCHASE_EDIT = 0;
		}
		if(isset($_POST['NEWORDER_EDIT']) && $_POST['NEWORDER_EDIT'] == '1')
		{
			$NEWORDER_EDIT = 1;
		}
		else {
			$NEWORDER_EDIT = 0;
		}
		if(isset($_POST['REVERSEORDER_EDIT']) && $_POST['REVERSEORDER_EDIT'] == '1')
		{
			$REVERSEORDER_EDIT = 1;
		}
		else {
			$REVERSEORDER_EDIT = 0;
		}
		if(isset($_POST['REVERSEPURCHASE_EDIT']) && $_POST['REVERSEPURCHASE_EDIT'] == '1')
		{
			$REVERSEPURCHASE_EDIT = 1;
		}
		else {
			$REVERSEPURCHASE_EDIT = 0;
		}
		
		if(isset($_POST['DEPOSITADD']) && $_POST['DEPOSITADD'] == '1')
		{
			$DEPOSITADD = 1;
		}
		else {
			$DEPOSITADD = 0;
		}
		if(isset($_POST['DEPOSITDELETE']) && $_POST['DEPOSITDELETE'] == '1')
		{
			$DEPOSITDELETE = 1;
		}
		else {
			$DEPOSITDELETE = 0;
		}
		if(isset($_POST['DEPOSITAPPROVE']) && $_POST['DEPOSITAPPROVE'] == '1')
		{
			$DEPOSITAPPROVE = 1;
		}
		else {
			$DEPOSITAPPROVE = 0;
		}
		if(isset($_POST['PP_CANSEE']) && $_POST['PP_CANSEE'] == '1')
		{
			$PP_CANSEE = 1;
		}
		else {
			$PP_CANSEE = 0;
		}
		
		$sqli="UPDATE `admin` SET NEWPURCHASE='$NEWPURCHASE', NEWORDER='$NEWORDER', REVERSEORDER='$REVERSEORDER', REVERSEPURCHASE='$REVERSEPURCHASE', NEWPURCHASE_EDIT='$NEWPURCHASE_EDIT', NEWORDER_EDIT='$NEWORDER_EDIT', REVERSEORDER_EDIT='$REVERSEORDER_EDIT', REVERSEPURCHASE_EDIT='$REVERSEPURCHASE_EDIT', DEPOSITADD='$DEPOSITADD', DEPOSITDELETE='$DEPOSITDELETE', DEPOSITAPPROVE='$DEPOSITAPPROVE', PP_CANSEE='$PP_CANSEE', STATUS='$STATUS' WHERE ID = $RID";
				
	if(!mysqli_query($link, $sqli)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
		
		//=====================================================
		
		$PAGESID = $_POST['PAGESID'];
		$RID = $_GET['id'];

		if ($PAGESID!=""){
					
		$N = count($_POST['PAGESID']);
			

		for($i=0; $i < $N; $i++)
		{	
			
				$unassign_otherall ="DELETE FROM `rolls_for_users` WHERE USERID='$USERID'";
					if(!mysqli_query($link, $unassign_otherall)){
		echo "ERROR: Could not able to execute $unassign_otherall. " . mysqli_error($link);
	}
				$update_roll="UPDATE `admin` SET ROLL='$PAGESID[$i]' WHERE ID='$USERID'";
				
					if(!mysqli_query($link, $update_roll)){
		echo "ERROR: Could not able to execute $update_roll. " . mysqli_error($link);
	}
				
				$sql="INSERT INTO `rolls_for_users` (USERID, ROLLID, STATUS) 

					  VALUES ('$USERID', '$PAGESID[$i]', '1')";
						
						if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
				
		}
		
		}
		//exit;
		echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?id=$RID&Check=y'</script>");				
		
	}
	
	if (isset($_GET['del']))
	{
	
	$RID = $_GET['id'];
	$del = $_REQUEST['del'];
	
	$update_rolli="UPDATE `admin` SET ROLL='$PAGESID[$i]' WHERE ID='$USERID'";
				
		if(!mysqli_query($link, $update_rolli)){
		echo "ERROR: Could not able to execute $update_rolli. " . mysqli_error($link);
	}
	$sql="DELETE FROM `rolls_for_users` WHERE ROLLID='$del' AND USERID='$USERID'";
		if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
		
	header("location: ".basename($_SERVER['PHP_SELF'])."?id=$RID&delCheck=y");
		
	}
?>

    <body class="nav-md">

        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                <?php include ('inc_nav.php'); ?>
                </div>
                <?php include ('inc_header.php'); ?>
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
										
                                        <div id="form-content">
                                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $ID; ?>" method="post" name="frm">
            
        	<div class="container">
            	<?php if (isset($_GET['updated'])){ ?>
                <div class="alert alert-warning">
                	<div class="container"><strong>Data is successfully updated!</strong></div>
                </div>
                <?php } ?>
            
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Person Name <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PNAME" class="form-control" type="text" value="<?php echo $PNAME; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Designation on System <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PCAT" class="form-control" type="text" value="<?php echo $PCAT; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">System Timing - HH:MM <small>AM/PM</small> <span class="text-danger">*</span></label></div>
                    <div class="col-lg-4">
                    	<input name="WORKTIMEIN" class="form-control" type="text" placeholder="Work Start / System Login" value="<?php echo $WORKTIMEIN; ?>" required>
                    </div>
                    <div class="col-lg-5">
                    	<input name="WORKTIMEOUT" class="form-control" type="text" placeholder="Work Off / System Closed" value="<?php echo $WORKTIMEOUT; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Email Address <span class="text-danger">*</span><small><br><em>(for recoving password or alerts)</em></small></label></div>
                    <div class="col-lg-9">
                    	<input name="EMAIL" class="form-control" type="email" value="<?php echo $EMAIL; ?>" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">User ID <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="FRMUSERID" class="form-control" type="text" value="<?php echo $FRMUSERID; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Password <span class="text-danger">*</span></label></div>
                    <div class="col-lg-9">
                    	<input name="PASSWORD" class="form-control" type="password" value="" autocomplete="off">
                        <input name="USERCAT" type="hidden" value="1">
                    </div>
                </div>
                <div class="row sml-padding">
                	<div class="col-lg-3"><label class="control-label">Status</label></div>
                    <div class="col-lg-9">
                    
                    	<?php if ($STATUS==1) { 
						?>
                        <label><input type="checkbox" name="STATUS" value="1" checked="checked"  /> Active</label>
                        <?php
						} else {
						?>	
                        <label><input type="checkbox" name="STATUS" value="1"  /> In-Active</label>
                        <?php
						} ?>
                    
                    </div>
                </div>
                
                <hr>
                
                <div class="row sml-padding">
                	<div class="col-lg-3">&nbsp;</div>
                    <div class="col-lg-9"><input type="submit" class="btn btn-primary" name="SupplierAddSbmt" value="Update"> <a href="users_list.php" class="btn btn-default">Back</a></div>
                </div>
                
                
            </div>
            
            </form>
            
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $ID; ?>" method="post" name="frm">
            
            <div class="container">
            	<div class="col-lg-6 col-lg-offset-3">
                    <h3>Assign Roll to User</h3>
                    <h5><em>Only one roll can be assigned for the user!</em></h5>
                    
                    <div class="container">
                    
                    	<div class="row">
                        	<div class="col-lg-6">
                            	<?php if ($NEWPURCHASE==1) { 
								?>
                                <label><input type="checkbox" name="NEWPURCHASE" value="1" checked="checked"> New Purchase</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="NEWPURCHASE" value="1"> New Purchase</label>
								<?php
								} ?>
                            </div>
                            <div class="col-lg-6">
                            	<?php if ($NEWORDER==1) { 
								?>
                                <label><input type="checkbox" name="NEWORDER" value="1" checked="checked"> New Order</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="NEWORDER" value="1"> New Order</label>
								<?php
								} ?>
                            	
                            </div>
                        </div>
                        <div class="row" style="border-bottom:#CCC 1px solid;">
                        	<div class="col-lg-6">
                                <?php if ($REVERSEORDER==1) { 
								?>
                                <label><input type="checkbox" name="REVERSEORDER" value="1" checked="checked"> Reverse Order</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="REVERSEORDER" value="1"> Reverse Order</label>
								<?php
								} ?>
                            </div>
                            <div class="col-lg-6">
                            	<?php if ($REVERSEPURCHASE==1) { 
								?>
                                <label><input type="checkbox" name="REVERSEPURCHASE" value="1" checked="checked"> Reverse Purchase Order</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="REVERSEPURCHASE" value="1"> Reverse Purchase Order</label>
								<?php
								} ?>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-6">
                            	<?php if ($NEWPURCHASE_EDIT==1) { 
								?>
                                <label><input type="checkbox" name="NEWPURCHASE_EDIT" value="1" checked="checked"> New Purchase Edit</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="NEWPURCHASE_EDIT" value="1"> New Purchase Edit</label>
								<?php
								} ?>
                            </div>
                            <div class="col-lg-6">
                            	<?php if ($NEWORDER_EDIT==1) { 
								?>
                                <label><input type="checkbox" name="NEWORDER_EDIT" value="1" checked="checked"> New Order Edit</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="NEWORDER_EDIT" value="1"> New Order Edit</label>
								<?php
								} ?>
                            	
                            </div>
                        </div>
                        <div class="row" style="border-bottom:#CCC 1px solid;">
                        	<div class="col-lg-6">
                                <?php if ($REVERSEORDER_EDIT==1) { 
								?>
                                <label><input type="checkbox" name="REVERSEORDER_EDIT" value="1" checked="checked"> Reverse Order Edit</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="REVERSEORDER_EDIT" value="1"> Reverse Order Edit</label>
								<?php
								} ?>
                            </div>
                            <div class="col-lg-6">
                            	<?php if ($REVERSEPURCHASE_EDIT==1) { 
								?>
                                <label><input type="checkbox" name="REVERSEPURCHASE_EDIT" value="1" checked="checked"> Reverse Purchase Order Edit</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="REVERSEPURCHASE_EDIT" value="1"> Reverse Purchase Edit</label>
								<?php
								} ?>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-6">
                                <?php if ($DEPOSITADD==1) { 
								?>
                                <label><input type="checkbox" name="DEPOSITADD" value="1" checked="checked"> Deposit Add</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="DEPOSITADD" value="1"> Deposit Add</label>
								<?php
								} ?>
                            </div>
                            <div class="col-lg-6">
                            	<?php if ($DEPOSITDELETE==1) { 
								?>
                                <label><input type="checkbox" name="DEPOSITDELETE" value="1" checked="checked"> Deposit Delete</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="DEPOSITDELETE" value="1"> Deposit Delete</label>
								<?php
								} ?>
                            </div>
                        </div>
                        <div class="row" style="border-bottom:#CCC 1px solid;">
                        	<div class="col-lg-6">
                                <?php if ($DEPOSITAPPROVE==1) { 
								?>
                                <label><input type="checkbox" name="DEPOSITAPPROVE" value="1" checked="checked"> Deposit Approve</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="DEPOSITAPPROVE" value="1"> Deposit Approve</label>
								<?php
								} ?>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-6">
                                <?php if ($PP_CANSEE==1) { 
								?>
                                <label><input type="checkbox" name="PP_CANSEE" value="1" checked="checked"> Purchase Price Can See?</label>
								<?php
								} else {
								?>	
								<label><input type="checkbox" name="PP_CANSEE" value="1"> Purchase Price Can See</label>
								<?php
								} ?>
                            </div>
                        </div>
                    
                    </div>
                    
                    <table class="col-lg-12 table-striped table-hover table-condensed cf tbl">
                    <thead class="cf">
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Roll Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					
						$pageUSERID = "";
						$pageROLLID = "";
					
                        $result = mysqli_query($link, "SELECT * FROM `rolls_ms` WHERE STATUS='1' ORDER BY ROLLNAME");
    
                            while($row = mysqli_fetch_array($result))
                              {
                                  $ID= $row['ID'];
                                  $ROLLNAME= $row['ROLLNAME'];
								  
								  $result2 = mysqli_query($link, "SELECT * FROM  `rolls_for_users` WHERE ROLLID='$ID' AND USERID='$RID'");
									while($row2 = mysqli_fetch_array($result2))
										{
											$pageID= $row2['ID'];
											$pageROLLID= $row2['ROLLID'];
											$pageUSERID= $row2['USERID'];
										}
                                    
                    ?>
                        <tr>
                            <td></td>
                            <td data-title="Checkbox">
                            
                            	<?php
								
								if ($ID==$pageROLLID && $pageUSERID==$RID){
								?>
                                	<a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?del=<?php echo $pageROLLID; ?>&id=<?php echo $RID; ?>" data-toggle="tooltip" data-placement="top" title="Remove From Roll"><i class="fa fa-trash text-danger"></i></a>
                                    <input type="hidden" name="PAGESID[]" value="<?php echo $ID; ?>">
                                <?php
									 }
								else {
									?>
                                    
                                    
                                    <input type="radio" name="PAGESID[]" value="<?php echo $ID; ?>" style="width:15px; height:15px;">
                                    <?php
									}
																
								 ?>
                            
                            </td>
                            <td data-title="Roll Name">
                            <strong><?php echo $ROLLNAME; ?></strong>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                	
                    <div class="row sml-padding">
                        <div class="col-lg-3">&nbsp;</div>
                        <div class="col-lg-9"><input type="submit" class="btn btn-success" name="assignpages" value="Assign Roll"></div>
                    </div>
                    
            	</div>
            </div>
            
            </form>
                                     </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- /page content -->
				<?php include ('inc_footer.php'); ?>
                
            </div>
        </div>



		<?php include ('inc_foot.php'); ?>

		<script type="text/javascript">
$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#product_add').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'vocher_heads_add.php',
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

