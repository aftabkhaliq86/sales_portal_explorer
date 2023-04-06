<?php
$errstmt='';

if(isset($_GET['err'])){
	$err = $_GET['err']; 
	
	if ($err=="2")
	$errstmt='<div class="alert alert-success"><i class="fa fa-check"></i> Your have successfully logout!</div>';
	elseif ($err=="3")
	$errstmt='<div class="alert alert-warning"><i class="fa fa-warning"></i> Your session is expired!</div>';
	elseif ($err=="4")
	$errstmt='<div class="alert alert-danger"><i class="fa fa-warning"></i> Login or password is invalid!</div>';
}


	 //echo md5("admin");

?>
<?php include ('inc_meta_header.php'); ?>
<title>Dashboard <?php include ('inc_page_title.php'); ?></title>
<?php include ('inc_head.php'); ?>
<script language="JavaScript" src="md5.js"></script>
<body class="login">

    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
				  
					<div class="container bg-white text-center"><img src="images/logo-m.png" alt="" vspace="10" /></div>
                  
					<form action="login.php" method="post" name="frm" class="form-signin">
                        <h1>Login Form</h1>
                        
                        <?php echo $errstmt; ?>
                        
                        <div>
                            <input name="LOGINID" type="text" id="inputEmail" class="form-control floatlabel" placeholder="User Name" required autofocus>
                        </div>
                        <div>
                            <input type="password" name="LOGINPWD" autocomplete="off" class="form-control floatlabel" placeholder="Password" aria-describedby="sizing-addon2" id="LOGINPWD" onChange="PWDHASH.value = calcMD5(LOGINPWD.value)" required>
                            <input type="hidden" name="PWDHASH">
                        </div>
                        <div class="text-left">
                            <button class="btn btn-default btn-block submit" type="submit">Log in</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">

                            <p class="change_link" ><a href="#signup" class="to_register">I can't access my account!</a> </p>

                        </div>
                    </form>

                    <div>
                        <p style="color: #999;">© <?php echo date('Y'); ?> <?php include ('inc_page_title.php'); ?><br>Multi Currency Accounting Software<br><a href="http://dpanel.co/" target="_blank" class="text-primary">dpanel.co</a></p>
                    </div>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <h1><a href="index.html" class="site_title"><i class="fa fa-adjust"></i> <span class="logo-f">Alte<span class="logo-s">na</span></span></a></h1>
                    <form>
                        <h1>Recover Password</h1>
                        <h5>Enter Your Registered Email Address</h5>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Check your email after success!
                                <a href="#signin" class="to_register"> Sign In! </a>
                            </p>
                        </div>
                    </form>
                    <div>
                        <p style="color: #999;">© <?php echo date('Y'); ?> <?php include ('inc_page_title.php'); ?><br>Sales Portal<br><a href="http://dpanel.co/" target="_blank" class="text-primary">dpanel.co</a></p>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include ('inc_foot.php'); ?>

