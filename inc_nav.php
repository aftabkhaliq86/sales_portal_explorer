<!-- top navigation -->
<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="dashboard.php" class="site_title"><img id="l-icon" src="images/logo-icon.png" alt="" /><img id="f-logo" src="images/logo-m.png" alt="" /></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu quick search -->
    <div class="profile clearfix">
        <form class="sidebar-search">
            <div class="input-group sidemenu-search-div">
                <input type="text" class="search form-control side-menu-search" placeholder="Search...">
                <span class="input-group-btn" style="">
                    <a class="btn submit sidemenu-search-icon">
                        <i class="fa fa-search"></i>
                    </a>
                </span>
            </div>
        </form>
    </div>
    <!-- /menu quick search -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section" id="menu">
            <h3>Navigation</h3>

            <?php

            if ($USERCAT_login == 1) {

                $PAGES_ID = '';
                $ROLLS_PAGEID = '';

                $select_PAGES = mysqli_query($link, "SELECT * FROM `rolls_ms_pages` WHERE PAGEURL='$page_name' AND STATUS='1'");

                while ($row_PAGES = mysqli_fetch_array($select_PAGES)) {
                    $PAGES_ID           =   $row_PAGES['ID'];


                    $select_ROLLS = mysqli_query($link, "SELECT * FROM `rolls_in_pages` WHERE PAGEID='$PAGES_ID' AND ROLLID='$ROLL_login' AND STATUS='1'");

                    while ($row_ROLLS = mysqli_fetch_array($select_ROLLS)) {
                        $ROLLS_PAGEID   =   $row_ROLLS['PAGEID'];
                    }
                }

                if ($ROLLS_PAGEID != $PAGES_ID) {
                    /*echo 'access denied! ';*/
                    echo '<script>location="dashboard.php?err=denied"</script>';
                } else {
                }
            }


            ?>


            <ul class="nav side-menu">
                <?php
                $select_rolls = mysqli_query($link, "SELECT * FROM `rolls_for_users` WHERE ROLLID='$ROLL_login' AND USERID='$EMPLOYEEID_LOGIN' AND STATUS='1'");

                while ($row_rolls = mysqli_fetch_array($select_rolls)) {
                    $USERROLL_ID        =   $row_rolls['ID'];
                    $USERROLL_ROLLID    =   $row_rolls['ROLLID'];
                    $USERROLL_USERID    =   $row_rolls['USERID'];

                    $assign_roll_groups = mysqli_query($link, "SELECT * FROM `rolls_in_pages` WHERE ROLLID='$USERROLL_ROLLID' AND STATUS='1' GROUP BY GROUPID DESC");

                    while ($row_args = mysqli_fetch_array($assign_roll_groups)) {
                        $GROUPID_args   =   $row_args['GROUPID'];

                ?>

                        <?php
                        $select_groups_rls = mysqli_query($link, "SELECT * FROM `rolls_ms_pages_group` WHERE ID='$GROUPID_args' AND STATUS='1' ORDER BY GROUPNAME");

                        while ($row_srls = mysqli_fetch_array($select_groups_rls)) {
                            $GPID_srls  =   $row_srls['ID'];
                            $GROUPNAME  =   $row_srls['GROUPNAME'];
                            $GROUPSUBTITLE  =   $row_srls['GROUPSUBTITLE'];
                            $GROUPICON  =   $row_srls['GROUPICON'];


                            $select_PAGES_GRUP = mysqli_query($link, "SELECT * FROM `rolls_ms_pages` WHERE PAGEURL='$page_name' AND STATUS='1'");
                            $PGID_ID_GP = '';

                            while ($row_PAGES_GP = mysqli_fetch_array($select_PAGES_GRUP)) {
                                $PAGES_ID_GP = $row_PAGES_GP['ID'];
                                $PGID_ID_GP = $row_PAGES_GP['PGID'];
                            }

                            $select_SPAGES_GRUP = mysqli_query($link, "SELECT * FROM `rolls_ms_pages_link` WHERE PAGEURL='$page_name' AND STATUS='1'");
                            $PGID_ID_SGP = '';

                            while ($row_SPAGES_GP = mysqli_fetch_array($select_SPAGES_GRUP)) {
                                $PAGES_ID_SGP = $row_SPAGES_GP['ID'];
                                $PGID_ID_SGP = $row_SPAGES_GP['PGID'];
                            }

                        ?>
                            <li <?php if ($PGID_ID_GP == $GPID_srls || $PGID_ID_SGP == $GPID_srls) {
                                    echo 'class="active"';
                                } ?>><a><i class="<?php echo $GROUPICON; ?>"></i><?php echo $GROUPNAME; ?> <span class=""></span></a>
                                <ul class="nav child_menu" <?php if ($PGID_ID_GP == $GPID_srls || $PGID_ID_SGP == $GPID_srls) {
                                                                echo 'style="display:block;"';
                                                            } ?>>
                                    <?php

                                    $assign_roll_pages = mysqli_query($link, "SELECT * FROM `rolls_in_pages` WHERE ROLLID='$USERROLL_ROLLID' AND GROUPID='$GPID_srls' AND STATUS='1'");

                                    while ($row_arps = mysqli_fetch_array($assign_roll_pages)) {
                                        $PAGEID_arps    =   $row_arps['PAGEID'];
                                    ?>

                                        <!-- Main Pages -->
                                        <?php

                                        $select_pages_rls = mysqli_query($link, "SELECT * FROM `rolls_ms_pages` WHERE ID='$PAGEID_arps' AND STATUS='1' GROUP BY PGID");

                                        while ($row_prls = mysqli_fetch_array($select_pages_rls)) {
                                            $PageID_srls    =   $row_prls['ID'];
                                            $PGID_srls      =   $row_prls['PGID'];
                                            $PAGENAME       =   $row_prls['PAGENAME'];
                                            $PAGEURL        =   $row_prls['PAGEURL'];


                                            $select_spages_rls = mysqli_query($link, "SELECT * FROM `rolls_ms_pages_link` WHERE PGID='$PGID_srls' AND MPID='$PageID_srls' AND PAGEURL='$page_name' AND STATUS='1'");
                                            $PAGEURL_ssrls = '';

                                            while ($row_sprls = mysqli_fetch_array($select_spages_rls)) {
                                                $PAGEURL_ssrls      =   $row_sprls['PAGEURL'];
                                            }


                                        ?>
                                            <li <?php if ($page_name == $PAGEURL || $page_name == $PAGEURL_ssrls) {
                                                    echo 'class="current-page"';
                                                } ?>><a href="<?php echo $PAGEURL; ?>"><?php echo $PAGENAME; ?></a></li>
                                        <?php
                                        }
                                        ?>
                                        <!-- Main Pages End -->

                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                    <?php } ?>

                <?php } ?>
            </ul>






        </div>


    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a href="http://104.237.3.115/altena/documentation/index.html" data-toggle="tooltip" data-placement="top" title="Documentation">
            <span class="fa fa-book" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen" onclick="toggleFullScreen();">
            <span class="fa fa-arrows-alt" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
<!-- /top navigation -->