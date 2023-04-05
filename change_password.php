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

<!--- Password Confirm Script --->
<script language="javascript">
<!--
function verify(form)
{
      var val,errorstr="";
  //check for catname
   if (form.nspwd.value!=form.cnspwd.value){errorstr=errorstr+"\n Confirm New  Password and New Password should have same values !" ;}
 
  if(errorstr!="")  
    {
      alert(errorstr);
      return false ;
    }
  
  else 
    {
      //form.submit();
      return (true);
    }
}




//-->
</script>
<!--- Password Confirm Script End --->
<?php
//errors--------------
$updated = '';
if(isset($_GET['updated'])) {
    $updated=$_GET['updated'];
    if($updated=='y') {
        $updated = 'Your password is successfully updated!';
    }
}
//--------------------
?>
<?php
$str = "";

if (isset($_POST['submit'])) {

$oldpwd = $_POST['spwd']; 
$newpwd = $_POST['nspwd']; 


$oldpwdHash = md5($oldpwd); 

$result_change_password = mysqli_query($link, "SELECT PWDHASH, ID FROM `admin` WHERE ID = '$EMPLOYEEID_LOGIN'");
while($row_change_password = mysqli_fetch_array($result_change_password))
  {
      $dbpwdHash= $row_change_password['PWDHASH'];
  }

if ($oldpwdHash == $dbpwdHash)
{       
        $newpwdHash = md5($newpwd);

        $sql="UPDATE `admin` SET PWDHASH='$newpwdHash' WHERE ID = '$EMPLOYEEID_LOGIN'";

        if(!mysqli_query($link, $sql)){
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    } 

$str = '

<div class="col-lg-8 col-lg-offset-2">
    <div class="alert alert-success al-center">Your Password has been changed!</div>
</div>

';
}
else
{
    $str = '
    
<div class="col-lg-8 col-lg-offset-2">
    <div class="alert alert-warning al-center">Old Password is invalid!</div>
</div>

';
}

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
                                      <?php echo $str; ?>
        
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form" onSubmit="return verify(this);">
            <div class="container">
                <div class="row sml-padding">
                    <div class="col-lg-3 col-lg-offset-2"><label>Current Password <span class="text-danger">*</span></label></div>
                    <div class="col-lg-5">
                        <input class="form-control" name="spwd" type="password" required>
                    </div>
                </div>
                <div class="row sml-padding">
                    <div class="col-lg-3 col-lg-offset-2"><label>New Password <span class="text-danger">*</span></label></div>
                    <div class="col-lg-5">
                        <input class="form-control" name="nspwd" type="password" required>
                    </div>
                </div>
                <div class="row sml-padding">
                    <div class="col-lg-3 col-lg-offset-2"><label>Repeat Password <span class="text-danger">*</span></label></div>
                    <div class="col-lg-5">
                        <input class="form-control" name="cnspwd" type="password" required>
                    </div>
                </div>
                <div class="row sml-padding">
                    <div class="col-lg-3 col-lg-offset-2">&nbsp;</div>
                    <div class="col-lg-5">
                        <input name="submit" type="submit" class="btn btn-primary" value="Update Password">
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