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



if (isset($_POST['update'])) {



$PNAME = normalize_str($_POST['PNAME']);

$PCAT = normalize_str($_POST['PCAT']);





		$sql="UPDATE `admin` SET PNAME='$PNAME', PCAT='$PCAT' WHERE ID='$EMPLOYEEID_LOGIN'";



		if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}



	echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?updated=y'</script>");

}


if (isset($_POST['PICPATH2STATUS']))
	{
		$PICPATH2STATUS = $_POST['PICPATH2STATUS'];
		//exit;
		
	//Picture Upload Code =================	
	$FileName = "";
	$FileType = "";
	$FileSize = "";
	
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/png")
	|| ($_FILES["file"]["type"] == "image/jpg"))
	&& ($_FILES["file"]["size"] < 99999999))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			$StrNotice = "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
		$FileType = "Type: " . $_FILES["file"]["type"] . "<br />";
		$FileSize = "Size: " . ($_FILES["file"]["size"] / 99999999) . " Kb<br />";
		
			//Change your Gallery Name here==>
			
			if (file_exists("webpics/" . $_FILES["file"]["name"]))
			{
			$PIN = rand(100000, 999999);
			
			move_uploaded_file($_FILES["file"]["tmp_name"],
			
			//Change your Gallery Name here==>
			
			"webpics/" . $PIN.  $_FILES["file"]["name"]);
			
			//Change your Gallery Name here==>
			
			$StrNotice = "File Uploaded and Renamed in: " . "webpics/" . $PIN. $_FILES["file"]["name"];
			
			$FileName =  $PIN. $_FILES["file"]["name"];
			
			}
			else
			{
			/*move_uploaded_file($_FILES["file"]["tmp_name"],
			
			//Change your Gallery Name here==>
			
			"../webpics/" . $_FILES["file"]["name"]);
			
			//Change your Gallery Name here==>
			
			$StrNotice = "File Uploaded in: " . "../webpics/" . $_FILES["file"]["name"];
			
			$FileName = $_FILES["file"]["name"];*/
			
			$main = str_replace(" ", "_", $_FILES["file"]["name"]);				
			$pici = $main;
				
			move_uploaded_file($_FILES["file"]["tmp_name"],
			
			//Change your Gallery Name here==>
			
			"webpics/" . $pici);
			
			//Change your Gallery Name here==>
			
			$StrNotice = "File Uploaded in: " . "webpics/" . $pici;
			
			$FileName = $pici;
			
			}
		}

}
	else
	{
		$StrNotice = "This type of file is not allowed to upload.";
	}
	// for still saving file code---place a hidden input on submit left
		if ($FileName==NULL)
		
		{
		$FileName = $_POST['file'];
		}
	//=============== Upload Code End // 

	
		   
			$sql="UPDATE `admin` SET PICPATH='$FileName' WHERE ID='$EMPLOYEEID_LOGIN'";
		
				if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
			echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?upic=y'</script>");	  
		   
			
	
	}
	
//===== DELETE SCROLLING BANNER =============================

if (isset($_REQUEST['scrlban']))
{
		 	$RID = $_REQUEST['id'];
	
	if ($_REQUEST['scrlban']=='rem')
	{
		$path2 = 'webpics/'. $PICPATH_login;
		unlink ($path2);

		$sql="UPDATE `admin` SET PICPATH='' WHERE ID='$RID' ";
	}

	if(!mysqli_query($link, $sql)){
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
echo ("<script>location='".basename($_SERVER['PHP_SELF'])."?iscrlban=y'</script>");

}
//===== DELETE SCROLLING BANNER END =============================
 

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
										
                                        <?php echo $str; ?>
			
            <div class="col-lg-3">
            
            	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form" enctype="multipart/form-data">
            
                    	<div class="row" style="padding-bottom:10px;">
                        	
                            <?php
                            	if ($PICPATH_login!=NULL){
							?>
                            
                    		<div class="resp-img-wrap"><img src="webpics/<?php echo $PICPATH_login; ?>" alt=""></div>
                            
                            <?php
								}
								else {
							?>
                            
                            <div class="resp-img-wrap"><img src="images/default-image.png" alt="" style="width:100%;"></div>
                            
                            <?php
								}
							?>
                            
                        </div>
                        
                        <div>
                        <?php
                        	if ($PICPATH_login!=NULL) {
						?>
                        <div class="row">
                        	<div class="col-lg-12 al-center">
                            	<a href="<?php echo basename($_SERVER['PHP_SELF']) ?>?id=<?php echo $EMPLOYEEID_LOGIN; ?>&scrlban=rem" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete');">Remove</a>
                            </div>
                        </div>
                        <?php
							}
							else {
						?>
                        <div class="row table-bordered sml-padding">
                        	<div class="container">
                                <label>
                                    <span>Upload Picture <span class="text-danger">*</span></span>
                                    <input name="file" type="file" class="form-control" required>
                                    <input name="PICPATH2STATUS" type="hidden" value="1">
                                    <input name="submit" type="submit" class="btn btn-primary btn-sm" value="Upload" style="margin-top:5px;">
                                </label>
                            </div>
                        </div>
                        <?php
							}
						?>
                        </div>
                        <div class="sml-padding"></div>
                        
                        </form>
                    </div>
        	<div class="col-lg-9">
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form">
		
        	<div class="container">

            	<div class="row sml-padding">

                	<div class="col-lg-3 col-lg-offset-2"><label>Your Name <span class="default-pink">*</span></label></div>

                    <div class="col-lg-5">

                        <input class="form-control" name="PNAME" type="text" value="<?php echo $PNAME_login; ?>" required>

                    </div>

                </div>

                <div class="row sml-padding">

                	<div class="col-lg-3 col-lg-offset-2"><label>Designation <span class="default-pink">*</span></label></div>

                    <div class="col-lg-5">

                        <input class="form-control" name="PCAT" type="text" value="<?php echo $PCAT_login; ?>" required>

                    </div>

                </div>

                <div class="row sml-padding">

                	<div class="col-lg-3 col-lg-offset-2">&nbsp;</div>

                    <div class="col-lg-5">

                        <input name="update" type="submit" class="btn btn-primary" value="Update Profile">

                        <a href="change_password.php" class="btn btn-warning">Change Password</a>

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