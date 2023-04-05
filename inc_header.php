<!-- header -->
<div class="top_nav">
<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					
					<?php if ($PICPATH_login!=NULL) { ?>
                    <img src="webpics/<?php echo $PICPATH_login; ?>" alt="">
					<?php } else { ?>
					<img src="images/default-image.png" alt="">
					<?php } ?>
					<span class="top_menu_user_name"><?php echo $PNAME_login; ?></span>
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right profile-dropdown">
                    <li><a href="user_profile.php"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>
                    <li><a href="change_password.php"><i class="fa fa fa-envelope-o" aria-hidden="true"></i>Change Password</a></li>
					<li><a href="change_pincode.php"><i class="fa fa fa-key" aria-hidden="true"></i>Change Pincode</a></li>
                    <li class="top-menu-border-top"><a href="logout.php"><i class="fa fa-sign-out"></i>Log Out</a></li>
                </ul>
            </li>
            <!-- <li> -->
                <!-- <a href="notifications.php"><i class="fa fa-bell-o"></i></a> -->
            <!-- </li> -->
        </ul>
    </nav>
    
</div>
</div>
<!-- /header -->

