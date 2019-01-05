<?php
$pagename = end(explode('/', $_SERVER['REQUEST_URI']));
/* $privilegeSettings = mysql_fetch_array(mysql_query("Select * from `proapp_tbladmin` where `id`='" . $_SESSION['admin_id'] . "'"));
$innerPrivileges = json_decode($privilegeSettings['privilages']); */

if ($_SESSION['admin_type'] == 'subadmin') {
    $subadmin = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `estejmam_user` WHERE `id`='" . $_SESSION['admin_id'] . "'"));
    $menuAccess = unserialize($subadmin['menu_access']);
}
// print_r($_SESSION);

?>



    <div class="page-sidebar-wrapper">
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search " action="extra_search.html" method="POST">
                        <a href="javascript:;" class="remove">
                            <i class="icon-close"></i>
                        </a>
                        <!-- <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                                            </span>
                                        </div>-->
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>


                <li class="start">
                    <a href="dashboard.php">
                        <i class="icon-home"></i>
                        <span class="title">Home</span>
                        <!--<span class="arrow "></span>-->
                    </a>

                </li>
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-cogs"></i>
                            <span class="title">Site Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="site_logo.php">
                                    <i class="icon-bulb"></i>
                                    Manage Logo</a>
                            </li>


                            <li>
                                <a href="social.php">
                                    <i class="icon-bulb"></i>
                                    Manage Social Media</a>
                            </li>

                            <li>
                                <a href="cms.php">
                                    <i class="icon-bulb"></i>
                                    Manage CMS</a>
                            </li>

                            <li>
                                <a href="site_maintanance.php">
                                    <i class="icon-bulb"></i>
                                    Site Setting</a>
                            </li>

                            <!-- <li>
                                <a href="social_share.php">
                                    <i class="icon-bulb"></i>
                                    Social Share Image</a>
                            </li>

                            <li>
                                <a href="booking_text.php">
                                    <i class="icon-bulb"></i>
                                    Booking Content</a>
                            </li>
                            <li>
                                <a href="managelandlordkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Landlord Media Kit</a>
                            </li>
                            <li>
                                <a href="managetenantkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Tenant Media Kit</a>
                            </li>
                            <li>
                                <a href="manageagentkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Agent Media Kit</a>
                            </li>
                            <li>
                                <a href="manageagentteam.php">
                                    <i class="icon-bulb"></i>
                                    Manage Team</a>
                            </li>
                            <li>
                                <a href="addteam.php">
                                    <i class="icon-bulb"></i>
                                    Add Team</a>
                            </li> -->
                        </ul>
                    </li>

                    <?php } elseif (in_array('site_setting', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-cogs"></i>
                            <span class="title">Site Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="site_logo.php">
                                    <i class="icon-bulb"></i>
                                    Manage Logo</a>
                            </li>


                            <li>
                                <a href="social.php">
                                    <i class="icon-bulb"></i>
                                    Manage Social Media</a>
                            </li>

                            <li>
                                <a href="cms.php">
                                    <i class="icon-bulb"></i>
                                    Manage CMS</a>
                            </li>

                            <li>
                                <a href="site_maintanance.php">
                                    <i class="icon-bulb"></i>
                                    Site Setting</a>
                            </li>

                            <li>
                                <a href="social_share.php">
                                    <i class="icon-bulb"></i>
                                    Social Share Image</a>
                            </li>

                            <li>
                                <a href="booking_text.php">
                                    <i class="icon-bulb"></i>
                                    Booking Content</a>
                            </li>
                            <li>
                                <a href="booking_text.php">
                                    <i class="icon-bulb"></i>
                                    Booking Content</a>
                            </li>
                            <li>
                                <a href="managelandlordkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Renter Media Kit</a>
                            </li>
                            <li>
                                <a href="managetenantkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Tenant Media Kit</a>
                            </li>
                            <li>
                                <a href="manageagentkit.php">
                                    <i class="icon-bulb"></i>
                                    Manage Agent Media Kit</a>
                            </li>

                        </ul>
                    </li>
                    <?php } ?>

                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Banner</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_banner.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_banner.php">
                                    <i class="icon-home"></i>
                                    Add Banner</a>
                            </li>
                            <li>
                                <a href="list_banner.php">
                                    <i class="icon-basket"></i>
                                    List Banner</a>
                            </li>

                            <!-- <li>
                                <a href="list_video_banner.php">
                                    <i class="icon-basket"></i>
                                    List Video Banner</a>
                            </li> -->

                                        <!-- <li>
                                <a href="banner_setting.php">
                                    <i class="icon-basket"></i>
                                    Banner Setting</a>
                            </li> -->

                        </ul>
                    </li>
                    <?php } elseif (in_array('banner', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Banner</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li <?php if ($pagename == 'add_banner.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_banner.php">
                                    <i class="icon-home"></i>
                                    Add Banner</a>
                            </li>
                            <li>
                                <a href="list_banner.php">
                                    <i class="icon-basket"></i>
                                    List Banner</a>
                            </li>
                            <li>
                                <a href="list_video_banner.php">
                                    <i class="icon-basket"></i>
                                    List Video Banner</a>
                            </li>
                            <li>
                                <a href="banner_setting.php">
                                    <i class="icon-basket"></i>
                                    Banner Setting</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                      <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">How it works</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_howitworks.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_howitworks.php">
                                    <i class="icon-home"></i>
                                    Add How it works</a>
                            </li>
                            <li>
                                <a href="list_howitworks.php">
                                    <i class="icon-basket"></i>
                                    List How it works</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                          <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Home Section</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_homesection.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_homesection.php">
                                    <i class="icon-home"></i>
                                    Add Home Section</a>
                            </li>
                            <li>
                                <a href="list_homesection.php">
                                    <i class="icon-basket"></i>
                                    List Home Section</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>


                          <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Parking Space</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_homesectionsecond.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_homesectionsecond.php">
                                    <i class="icon-home"></i>
                                    Add  Space</a>
                            </li>
                            <li>
                                <a href="list_homesectionsecond.php">
                                    <i class="icon-basket"></i>
                                    List Space</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>


         <!--                  <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Parking Space</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_homesectionsecond.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_homesectionsecond.php">
                                    <i class="icon-home"></i>
                                    Add  Space</a>
                            </li>
                            <li>
                                <a href="list_homesectionsecond.php">
                                    <i class="icon-basket"></i>
                                    List Space</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?> -->

                            <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title"> Amenities</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'amenities-add.php') { ?> class="active"
                                <?php } ?>>
                                <a href="amenities-add.php">
                                    <i class="icon-home"></i>
                                    Add  Amenities</a>
                            </li>
                            <li>
                                <a href="amenities-list.php">
                                    <i class="icon-basket"></i>
                                    List Amenities</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                     <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Parking Rules</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_parkingrule.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_parkingrule.php">
                                    <i class="icon-home"></i>
                                    Add Parking Rule</a>
                            </li>
                            <li>
                                <a href="list_parkingrule.php">
                                    <i class="icon-basket"></i>
                                    List Parking Rule</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                       <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Ratings Category</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_ratings_category.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_ratings_category.php">
                                    <i class="icon-home"></i>
                                    Add Category</a>
                            </li>
                            <li>
                                <a href="ratings_category.php">
                                    <i class="icon-basket"></i>
                                    List Category</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>



                       <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">User Ratings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="user_ratings.php">
                                    <i class="icon-basket"></i>
                                    User Ratings</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                             <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Information Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_infomanagement.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_infomanagement.php">
                                    <i class="icon-home"></i>
                                    Add  Information</a>
                            </li>
                            <li>
                                <a href="list_infomanagement.php">
                                    <i class="icon-basket"></i>
                                    List Information</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                                <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Home Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'resthomesettings.php') { ?> class="active"
                                <?php } ?>>
                                <a href="resthomesettings.php">
                                    <i class="icon-home"></i>
                                   Edit Home Settings</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                              <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Footer Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_footer_category.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_footer_category.php">
                                    <i class="icon-home"></i>
                                    Add  Footer Category</a>
                            </li>
                            <li>
                                <a href="footer_category.php">
                                    <i class="icon-basket"></i>
                                    List Footer Category</a>
                            </li>
                              <li>
                                <a href="add_pages.php">
                                    <i class="icon-basket"></i>
                                    Add Footer Pages</a>
                            </li>
                              <li>
                                <a href="list_pages.php">
                                    <i class="icon-basket"></i>
                                    List Footer Pages</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Feature</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_feature.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_feature.php">
                                    <i class="icon-home"></i>
                                    Add Feature</a>
                            </li>
                            <li>
                                <a href="list_feature.php">
                                    <i class="icon-basket"></i>
                                    List Feature</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Parking</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_parking.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_parking.php">
                                    <i class="icon-home"></i>
                                    Add Parking</a>
                            </li>
                            <li>
                                <a href="list_parking.php">
                                    <i class="icon-basket"></i>
                                    List Parking</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Makes</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_make.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_make.php">
                                    <i class="icon-home"></i>
                                    Add Make</a>
                            </li>
                            <li>
                                <a href="list_make.php">
                                    <i class="icon-basket"></i>
                                    List Make</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Models</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_model.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_model.php">
                                    <i class="icon-home"></i>
                                    Add Model</a>
                            </li>
                            <li>
                                <a href="list_model.php">
                                    <i class="icon-basket"></i>
                                    List Model</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Colors</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_color.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_color.php">
                                    <i class="icon-home"></i>
                                    Add Color</a>
                            </li>
                            <li>
                                <a href="list_color.php">
                                    <i class="icon-basket"></i>
                                    List Color</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">FAQ</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_faq.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_faq.php">
                                    <i class="icon-home"></i>
                                    Add FAQ</a>
                            </li>



                            <li <?php if ($pagename == 'list_faq.php') { ?> class="active"
                                <?php } ?>>
                                <a href="list_faq.php">
                                    <i class="icon-home"></i>
                                    List FAQ</a>
                            </li>

                        </ul>
                    </li>
                    <?php } elseif (in_array('defalt_banner', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa  fa-file-image-o"></i>
                            <span class="title">Default Banner</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li <?php if ($pagename == 'add_faq.php') { ?> class="active"
                                <?php } ?>>
                                <a href="add_faq.php">
                                    <i class="icon-home"></i>
                                    Add FAQ</a>
                            </li>



                            <li <?php if ($pagename == 'list_faq.php') { ?> class="active"
                                <?php } ?>>
                                <a href="list_faq.php">
                                    <i class="icon-home"></i>
                                    List FAQ</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <!-- <li>
                        <a href="booking_viewing.php">​
                            <i class="fa fa-building"></i>
                            <span class="title">Viewing request</span>
                            <span class="arrow "></span>
                        </a>
                    </li> -->

                 <!--    <li class="nav-item <?php echo $pagename == 'parking-place-add-general-information.php' ? 'open' : ''; ?>">
                        <a href="javascript:void(0);">
                            <i class="fa fa-user"></i>
                            <span class="title">Parking Place</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?php echo $pagename == 'parking-place-add-general-information.php' ? 'active open' : ''; ?>">
                                <a href="parking-place-add-general-information.php">
                                    <i class="icon-home"></i>
                                    Add Parking Place
                                </a>
                            </li>
                            <li class="<?php $pagename == 'parking-place-list.php' ? 'active' : ''; ?>">
                                <a href="parking-place-list.php">
                                    <i class="icon-home"></i>
                                    List Parking Place
                                </a>
                            </li>
                            <li class="<?php $pagename == 'amenities-add.php' ? 'active' : ''; ?>">
                                <a href="amenities-add.php">
                                    <i class="icon-home"></i>
                                    Add amenities
                                </a>
                            </li>
                            <li class="<?php $pagename == 'amenities-list.php' ? 'active' : ''; ?>">
                                <a href="amenities-list.php">
                                    <i class="icon-home"></i>
                                    List amenities
                                </a>
                            </li>
                            <li class="<?php $pagename == 'car-type-size-add.php' ? 'active' : ''; ?>">
                                <a href="car-type-size-add.php">
                                    <i class="icon-home"></i>
                                    Add car type size
                                </a>
                            </li>
                            <li class="<?php $pagename == 'car-type-size-list.php' ? 'active' : ''; ?>">
                                <a href="car-type-size-list.php">
                                    <i class="icon-home"></i>
                                    List car type size
                                </a>
                            </li>
                        </ul>
                    </li> -->

                    <?php
                    if ($_SESSION['admin_type'] == 'superadmin') {
                        $request = explode("/", $_SERVER['SCRIPT_NAME']);
                        $request = end($request);
                        $booklistfiles = array("review_bookings.php", "accept_bookings.php");
                        if (in_array($request, $booklistfiles)) {
                            $class = "open";

                        }
                    ?>
                    <li class="<?php echo $class; ?>">
                        <a href="javascript:;">
                            <i class="fa fa-building"></i>
                            <span class="title">Booking</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu" style="<?php echo ($class) ? " display:block; " : "display:none; "; ?>">
                            <li>
                                <a href="review_bookings.php">In Review</a>
                            </li>
                            <li>
                                <a href="accept_bookings.php">​​Accepted</a>
                            </li>
                            <li>
                                <a href="disputed_bookings.php">Disputed</a>
                            </li>
                            <li>
                                <a href="canceled_bookings.php">Canceled</a>
                            </li>
                            <li>
                                <a href="list_booking.php">List</a>
                            </li>

                        </ul>
                    </li>
                    <?php } elseif (in_array('booking', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-building"></i>
                            <span class="title">Booking</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="review_bookings.php">In Review</a>
                            </li>
                            <li>
                                <a href="accept_bookings.php">​​Accepted</a>
                            </li>
                            <li>
                                <a href="disputed_bookings.php">Disputed</a>
                            </li>
                            <li>
                                <a href="canceled_bookings.php">Canceled</a>
                            </li>
                            <li>
                                <a href="list_booking.php">List</a>
                            </li>

                        </ul>
                    </li>
                    <?php } ?>


                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="javascript:;">
                                <i class="fa  fa-file-image-o"></i>
                                <span class="title">Blog Category Management</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'list_blog.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_blog.php">
                                        <i class="icon-home"></i>
                                        Category List</a>
                                </li>

                                <li <?php if ($pagename == 'add_blog.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_blog.php">
                                        <i class="icon-home"></i>
                                        Category Add</a>
                                </li>

                            </ul>
                        </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="javascript:;">
                                <i class="fa  fa-file-image-o"></i>
                                <span class="title">Blog Management</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'list_post.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_post.php">
                                        <i class="icon-home"></i>
                                        Blog List</a>
                                </li>

                                <li <?php if ($pagename == 'add_post.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_post.php">
                                        <i class="icon-home"></i>
                                        Blog Add</a>
                                </li>

                                <li <?php if ($pagename == 'list_blog_comment.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_blog_comment.php">
                                        <i class="icon-home"></i>
                                        Blog Comment List</a>
                                </li>

                                <li <?php if ($pagename == 'list_blog_comment_reply.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_blog_comment_reply.php">
                                        <i class="icon-home"></i>
                                        Blog Comment Reply List</a>
                                </li>

                            </ul>
                        </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>

                        <li>
                            <a href="javascript:;">
                                <i class="fa  fa-file-image-o"></i>
                                <span class="title">Virtual Agent Management</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'list_virtualagent.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_virtualagent.php">
                                        <i class="icon-home"></i>
                                        Virtual Agent List</a>
                                </li>

                                <li <?php if ($pagename == 'add_virtualagent.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_virtualagent.php">
                                        <i class="icon-home"></i>
                                        Virtual Agent Add</a>
                                </li>

                            </ul>
                        </li>

                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="list_agentcommision.php">
                                <i class="icon-puzzle"></i>
                                <span class="title">Virtual Agent Commision</span>
                                <span class="arrow "></span>
                            </a>
                        </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-user"></i>
                                <span class="title">Agents</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'teant_dashboard.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="teant_dashboard.php">
                                        <i class="icon-home"></i>
                                        Dashboard</a>
                                </li>

                                <li <?php if ($pagename == 'search_user.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="search_user.php">
                                        <i class="icon-home"></i>
                                        Members List</a>
                                </li>

                                <li>
                                    <a href="add_user_type.php">
                                        <i class="icon-basket"></i>
                                        Add New Members</a>
                                </li>

                                <li>
                                    <a href="add_agent_content.php">
                                        <i class="icon-basket"></i>
                                        Homepage Content</a>
                                </li>

                            </ul>
                        </li>
                    <?php } elseif (in_array('agent', $menuAccess)) { ?>
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="fa fa-user"></i>
                                    <span class="title">Agents</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">

                                    <li <?php if ($pagename == 'teant_dashboard.php') { ?> class="active"
                                        <?php } ?>>
                                        <a href="teant_dashboard.php">
                                            <i class="icon-home"></i>
                                            Dashboard</a>
                                    </li>

                                    <li <?php if ($pagename == 'search_user.php') { ?> class="active"
                                        <?php } ?>>
                                        <a href="search_user.php">
                                            <i class="icon-home"></i>
                                            Members List</a>
                                    </li>

                                    <li>
                                        <a href="add_user_type.php">
                                            <i class="icon-basket"></i>
                                            Add New Members</a>
                                    </li>

                                    <li>
                                        <a href="add_agent_content.php">
                                            <i class="icon-basket"></i>
                                            Homepage Content</a>
                                    </li>

                                </ul>
                            </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-user"></i>
                                <span class="title">Partners</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'add_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_partners.php">
                                        <i class="icon-home"></i>
                                        Add Partners</a>
                                </li>

                                <li <?php if ($pagename == 'list_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_partners.php">
                                        <i class="icon-home"></i>
                                        Partners List</a>
                                </li>

                                <!-- <li <?php if ($pagename == 'add_also_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_also_partners.php">
                                        <i class="icon-home"></i>
                                        Add other partners</a>
                                </li>

                                <li <?php if ($pagename == 'list_also_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_also_partners.php">
                                        <i class="icon-home"></i>
                                        List others Partners</a>
                                </li> -->

                            </ul>
                        </li>
                    <?php } elseif (in_array('partners', $menuAccess)) { ?>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-user"></i>
                                <span class="title">Partners</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'add_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_partners.php">
                                        <i class="icon-home"></i>
                                        Add Partners</a>
                                </li>

                                <li <?php if ($pagename == 'list_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_partners.php">
                                        <i class="icon-home"></i>
                                        Partners List</a>
                                </li>

                                <!-- <li <?php if ($pagename == 'add_also_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="add_also_partners.php">
                                        <i class="icon-home"></i>
                                        Add other partners</a>
                                </li>

                                <li <?php if ($pagename == 'list_also_partners.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="list_also_partners.php">
                                        <i class="icon-home"></i>
                                        List others Partners</a>
                                </li> -->

                            </ul>
                        </li>
                    <?php }*/ ?>


                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-user"></i>
                                <span class="title">Renter</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'host_dashboard.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="host_dashboard.php">
                                        <i class="icon-home"></i>
                                        Dashboard</a>
                                </li>

                                <li <?php if ($pagename == 'search_user_landlord.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="search_user_landlord.php">
                                        <i class="icon-home"></i>
                                        Approved Renter List</a>
                                </li>

                                <li <?php if ($pagename == 'search_pendinguser_landlord.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="search_pendinguser_landlord.php">
                                        <i class="icon-home"></i>
                                        Pending Renter List</a>
                                </li>


                                <li>
                                    <a href="add_user_type_host.php">
                                        <i class="icon-basket"></i>
                                        Add New Renter</a>
                                </li>

                            </ul>
                        </li>
                    <?php } elseif (in_array('landlord', $menuAccess)) { ?>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa fa-user"></i>
                                <span class="title">Renter</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">

                                <li <?php if ($pagename == 'host_dashboard.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="host_dashboard.php">
                                        <i class="icon-home"></i>
                                        Dashboard</a>
                                </li>

                                <li <?php if ($pagename == 'search_user_landlord.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="search_user_landlord.php">
                                        <i class="icon-home"></i>
                                        Approved Members List</a>
                                </li>

                                <li <?php if ($pagename == 'search_pendinguser_landlord.php') { ?> class="active"
                                    <?php } ?>>
                                    <a href="search_pendinguser_landlord.php">
                                        <i class="icon-home"></i>
                                        Pending Members List</a>
                                </li>


                                <li>
                                    <a href="add_user_type_host.php">
                                        <i class="icon-basket"></i>
                                        Add New Members</a>
                                </li>

                            </ul>
                        </li>
                    <?php }*/ ?>


                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-basket"></i>
                            <span class="title">Finance</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li  <?php if ($pagename == 'list_paid_payments.php') { ?>  class="active" <?php } ?>>
                                <a href="list_paid_payments.php">
                                    <i class="icon-home"></i>
                                    Paid Payment</a>
                            </li>
                            <li  <?php if ($pagename == 'list_failed_payments.php') { ?>  class="active" <?php } ?>>
                                <a href="list_failed_payments.php">
                                    <i class="icon-basket"></i>
                                    Failed Payment</a>
                            </li>
                            <li  <?php if ($pagename == 'list_all_payments.php') { ?>  class="active" <?php } ?>>
                                <a href="list_all_payments.php">
                                    <i class="icon-basket"></i>
                                    Listing Payment</a>
                            </li>
                        </ul>
                    </li>-->

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-basket"></i>
                            <span class="title">Accounts</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li  <?php if ($pagename == 'accounts.php') { ?>  class="active" <?php } ?>>
                                <a href="accounts.php">
                                    <i class="icon-home"></i>
                                    Resolvable and Paypal</a>
                            </li>
                            <li  <?php if ($pagename == 'accounts_others.php') { ?>  class="active" <?php } ?>>
                                <a href="accounts_others.php">
                                    <i class="icon-home"></i>
                                    Credit Card</a>
                            </li>
                        </ul>
                    </li>-->


                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-basket"></i>
                            <span class="title">Commission</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li  <?php if ($pagename == 'add_commission_type.php') { ?>  class="active" <?php } ?>>
                                <a href="add_commission_type.php">
                                    <i class="icon-home"></i>
                                    Add commission type</a>
                            </li>
                            <li  <?php if ($pagename == 'list_commission_type.php') { ?>  class="active" <?php } ?>>
                                <a href="list_commission_type.php">
                                    <i class="icon-home"></i>
                                    List commission type</a>
                            </li>
                            <li  <?php if ($pagename == 'add_commission.php') { ?>  class="active" <?php } ?>>
                                <a href="add_commission.php">
                                    <i class="icon-home"></i>
                                    Add a new commission</a>
                            </li>
                            <li  <?php if ($pagename == 'list_commission.php') { ?>  class="active" <?php } ?>>
                                <a href="list_commission.php">
                                    <i class="icon-home"></i>
                                    Commission List</a>
                            </li>
                        </ul>
                    </li>-->


                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-basket"></i>
                            <span class="title">Erning List</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li  <?php if ($pagename == 'add_commission.php') { ?>  class="active" <?php } ?>>
                                <a href="add_earning_list.php">
                                    <i class="icon-home"></i>
                                    Add a new erninglist</a>
                            </li>
                            <li  <?php if ($pagename == 'list_commission.php') { ?>  class="active" <?php } ?>>
                                <a href="list_earning_list.php">
                                    <i class="icon-home"></i>
                                    Earninglist List</a>
                            </li>
                        </ul>
                    </li>-->

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-globe"></i>
                            <span class="title">Country Wise City List</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <!--                    <li  <?php if ($pagename == 'add_city.php') { ?>  class="active" <?php } ?>>
                                <a href="add_city.php">
                                <i class="icon-home"></i>
                                Add City</a>
                            </li>-->

                            <li <?php if ($pagename == 'list_city.php') { ?> class="active"
                                <?php } ?>>
                                <a href="list_country.php">
                                    <i class="icon-home"></i>
                                    Country Wise City List</a>
                            </li>

                            <li <?php if ($pagename == 'featured_list_city.php') { ?> class="active"
                                <?php } ?>>
                                <a href="featured_list_city.php">
                                    <i class="icon-home"></i>
                                    Featured City List</a>
                            </li>

                        </ul>
                    </li>
                    <?php } elseif (in_array('country_wise_city_list', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-globe"></i>
                            <span class="title">Country Wise City List</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <!--                    <li  <?php if ($pagename == 'add_city.php') { ?>  class="active" <?php } ?>>
                                <a href="add_city.php">
                                    <i class="icon-home"></i>
                                    Add City</a>
                            </li>-->

                            <li <?php if ($pagename == 'list_city.php') { ?> class="active"
                                <?php } ?>>
                                <a href="list_country.php">
                                    <i class="icon-home"></i>
                                    Country Wise City List</a>
                            </li>

                            <li <?php if ($pagename == 'featured_list_city.php') { ?> class="active"
                                <?php } ?>>
                                <a href="featured_list_city.php">
                                    <i class="icon-home"></i>
                                    Featured City List</a>
                            </li>

                        </ul>
                    </li>
                    <?php }*/ ?>

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="fa  fa-hotel"></i>
                            <span class="title">Booking Status</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li  <?php if ($pagename == 'list_new_booking.php') { ?>  class="active" <?php } ?>>
                                <a href="list_new_booking.php">
                                    <i class="icon-home"></i>
                                    New Booking</a>
                            </li>
                            <li  <?php if ($pagename == 'list_complete_booking.php') { ?>  class="active" <?php } ?>>
                                <a href="list_complete_booking.php">
                                    <i class="icon-basket"></i>
                                    Complete Booking</a>
                            </li>
                            <li  <?php if ($pagename == 'list_expired_booking.php') { ?>  class="active" <?php } ?>>
                                <a href="list_expired_booking.php">
                                    <i class="icon-basket"></i>
                                    Expired Booking</a>
                            </li>

                        </ul>
                    </li>-->

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="fa fa-language"></i>
                            <span class="title">Language</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="add_language.php">Add Language</a></li>
                            <li><a href="list_language.php">List Language</a></li>
                        </ul>
                    </li>-->

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="fa fa-paypal"></i>
                            <span class="title">Payment Gateway</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="list_payment_gateway.php">Payment Gateway List</a></li>
                        </ul>
                    </li>-->

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-diamond"></i>
                            <span class="title">Currency List</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="list_currency.php">Currency List</a></li>
                        </ul>
                    </li>-->
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-at"></i>
                            <span class="title">Contact us</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="list_contact.php">Contact details</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('contact_us', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-at"></i>
                            <span class="title">Contact us</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="list_contact.php">Contact details</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-diamond"></i>
                            <span class="title">Coupons</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="add_coupon.php">Add Coupons</a></li>
                            <li><a href="list_coupon.php">List Coupons</a></li>
                        </ul>
                    </li>-->
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-star"></i>
                            <span class="title">Reviews</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="list_reviews.php">List Reviews</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('reviews', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-star"></i>
                            <span class="title">Reviews</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="list_reviews.php">List Reviews</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-download"></i>
                            <span class="title">Backup</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="backup_databse.php">Database Backup</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('backup', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-download"></i>
                            <span class="title">Backup</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="backup_databse.php">Database Backup</a>
                            </li>
                        </ul>
                    </li>
                    <?php }*/ ?>



                    <!--<li>
                        <a href="javascript:;">
                            <i class="icon-rocket"></i>
                            <span class="title">Customer Say</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                        <li>
                            <a href="add_customer_say.php">
                                Add Customer Say</a>
                        </li>
                        <li>
                            <a href="list_customer_say.php">
                                List Customer Say</a>
                        </li>
                        </ul>
                    </li>-->
                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-cc"></i>
                            <span class="title">Testimonials</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="add_testimonial.php">
                                    Add Testimonial</a>
                            </li>
                            <li>
                                <a href="list_testimonial.php">
                                    List Testimonial</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('testimonial', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-cc"></i>
                            <span class="title">Testimonials</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="add_testimonial.php">
                                    Add Testimonial</a>
                            </li>
                            <li>
                                <a href="list_testimonial.php">
                                    List Testimonial</a>
                            </li>
                        </ul>
                    </li>
                    <?php }*/ ?>



                    <!--            <li>
                        <a href="javascript:;">
                            <i class="fa fa-envelope"></i>
                            <span class="title">Mass Email Campening</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="newsletter.php">
                                    Mass Email Campening</a>
                            </li>
                        </ul>
                    </li>-->

                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-archive"></i>
                            <span class="title">Email Template</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <!--    <li>
                            <a href="add_email_temp_frnd.php">
                            Add Email Template for invite friends</a>
                            </li> -->
                            <li>
                                <a href="add_email_temp.php">
                                    Add Email Template</a>
                            </li>
                            <li>
                                <a href="email_temp.php">
                                    Email Template</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('email_template', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-archive"></i>
                            <span class="title">Email Template</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <!--    <li>
                                <a href="add_email_temp_frnd.php">
                                Add Email Template for invite friends</a>
                            </li> -->
                            <li>
                                <a href="add_email_temp.php">
                                    Add Email Template</a>
                            </li>
                            <li>
                                <a href="email_temp.php">
                                    Email Template</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-puzzle"></i>
                            <span class="title">User</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="search_vendor.php">
                                    List Renters</a>
                            </li>
                            <li>
                                <a href="search_user.php">
                                    List Tenants</a>
                            </li>
                        </ul>
                    </li>-->
                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li style="display: none;">
                        <a href="javascript:;">
                            <i class="fa fa-building"></i>
                            <span class="title">Properties</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="property_dashboard.php">Property Dashboard</a>
                            </li>
                            <li>
                                <a href="add_property_type.php">Add Property Type</a>
                            </li>
                            <li>
                                <a href="list_property_type.php">List Property Type</a>
                            </li>
                            <!--                    <li><a href="list_product.php">List Properties</a></li>-->
                            <li>
                                <a href="add_property.php">Add Property</a>
                            </li>
                            <li>
                                <a href="list_product.php">List Properties</a>
                            </li>
                            <li>
                                <a href="add_amenities.php">Add Amenities</a>
                            </li>
                            <li>
                                <a href="list_amenities.php">List Amenities</a>
                            </li>
                            <!-- <li>
                                <a href="add_bills_include.php">Add Bills Include</a>
                            </li>
                            <li>
                                <a href="list_bills_include.php">List Bills Include</a>
                            </li>
                            <li>
                                <a href="add_apartment_feature.php">Add Apartment Feature</a>
                            </li>
                            <li>
                                <a href="list_apartment_feature.php">List Apartment Feature</a>
                            </li> -->
                            <?php /* ?>
                            <li>
                            <a href="add_subcategory.php">Add Sub Category</a>
                            </li>
                            <li>
                            <a href="list_subcategory.php">List Sub Category</a>
                            </li>
                            <?php */?>
                            <!--<li><a href="list_store.php">List Stores</a></li>-->
                        </ul>
                    </li>
                    <?php } elseif (in_array('properties', $menuAccess)) { ?>
                    <li style="display: none;">
                        <a href="javascript:;">
                            <i class="fa fa-building"></i>
                            <span class="title">Properties</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="property_dashboard.php">Property Dashboard</a>
                            </li>
                            <li>
                                <a href="add_property_type.php">Add Property Type</a>
                            </li>
                            <li>
                                <a href="list_property_type.php">List Property Type</a>
                            </li>
                            <!--                    <li><a href="list_product.php">List Properties</a></li>-->
                            <li>
                                <a href="add_property.php">Add Property</a>
                            </li>
                            <li>
                                <a href="list_product.php">List Properties</a>
                            </li>
                            <li>
                                <a href="add_amenities.php">Add Amenities</a>
                            </li>
                            <li>
                                <a href="list_amenities.php">List Amenities</a>
                            </li>
                            <li>
                                <a href="add_bills_include.php">Add Bills Include</a>
                            </li>
                            <li>
                                <a href="list_bills_include.php">List Bills Include</a>
                            </li>
                            <li>
                                <a href="add_apartment_feature.php">Add Apartment Feature</a>
                            </li>
                            <li>
                                <a href="list_apartment_feature.php">List Apartment Feature</a>
                            </li>
                            <?php /* ?>
                            <li>
                                <a href="add_subcategory.php">Add Sub Category</a>
                            </li>
                            <li>
                                <a href="list_subcategory.php">List Sub Category</a>
                            </li>
                            <?php */?>
                            <!--<li><a href="list_store.php">List Stores</a></li>-->
                        </ul>
                    </li>
                    <?php } ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Our Clients</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="add_clients.php">
                                    Add Clients</a>
                            </li>
                            <li>
                                <a href="list_clients.php">
                                    List Clients</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('our_clients', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Our Clients</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">


                            <li>
                                <a href="add_clients.php">
                                    Add Clients</a>
                            </li>

                            <li>
                                <a href="list_clients.php">
                                    List Clients</a>
                            </li>


                        </ul>
                    </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Home Page Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="care_about_manage_text.php">
                                    Care About Section</a>
                            </li>

                            <li>
                                <a href="featured_city_manage_text.php">
                                    Featured City Manage Text</a>
                            </li>


                            <li>
                                <a href="our_value_manage_text.php">
                                    Our Value Manage Text</a>
                            </li>

                            <li>
                                <a href="testimonial_manage_text.php">
                                    Testimonial Manage Text</a>
                            </li>


                            <li>
                                <a href="check_home_manage_text.php">
                                    Check home Manage Text</a>
                            </li>

                            <li>
                                <a href="add_check_home.php">
                                    Add Check home Section</a>
                            </li>

                            <li>
                                <a href="list_check_home.php">
                                    List Check home Section</a>
                            </li>

                            <li>
                                <a href="homepage_thirdsection.php">
                                    List Homepage Third Section</a>
                            </li>
                            <li>
                                <a href="testimonial.php">
                                    List Testimonial Section</a>
                            </li>

                            <li>
                                <a href="add_our_value.php">
                                    Add Our Value</a>
                            </li>

                            <li>
                                <a href="list_our_value.php">
                                    List Our Value</a>
                            </li>

                            <li>
                                <a href="manage_member_header.php">
                                    Team Member Manage Text</a>
                            </li>


                            <li>
                                <a href="add_team_member.php">
                                    Add Team Member</a>
                            </li>

                            <li>
                                <a href="list_team_member.php">
                                    List Team Member</a>
                            </li>


                        </ul>
                    </li>
                    <?php } elseif (in_array('homepage_management', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Home Page Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="care_about_manage_text.php">
                                    Care About Section</a>
                            </li>

                            <li>
                                <a href="featured_city_manage_text.php">
                                    Featured City Manage Text</a>
                            </li>


                            <li>
                                <a href="our_value_manage_text.php">
                                    Our Value Manage Text</a>
                            </li>

                            <li>
                                <a href="testimonial_manage_text.php">
                                    Testimonial Manage Text</a>
                            </li>


                            <li>
                                <a href="check_home_manage_text.php">
                                    Check home Manage Text</a>
                            </li>

                            <li>
                                <a href="add_check_home.php">
                                    Add Check home Section</a>
                            </li>

                            <li>
                                <a href="list_check_home.php">
                                    List Check home Section</a>
                            </li>


                            <li>
                                <a href="add_our_value.php">
                                    Add Our Value</a>
                            </li>

                            <li>
                                <a href="list_our_value.php">
                                    List Our Value</a>
                            </li>

                            <li>
                                <a href="manage_member_header.php">
                                    Team Member Manage Text</a>
                            </li>


                            <li>
                                <a href="add_team_member.php">
                                    Add Team Member</a>
                            </li>

                            <li>
                                <a href="list_team_member.php">
                                    List Team Member</a>
                            </li>


                        </ul>
                    </li>
                    <?php }*/ ?>


                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Footer Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="footer_category.php">
                                    Footer Category</a>
                            </li>


                            <li>
                                <a href="footer_help_text.php">
                                    Footer Help Button Text</a>
                            </li>

                            <li>
                                <a href="footer_contain_management.php">
                                    Footer Contact Management</a>
                            </li>

                            <li>
                                <a href="add_payment_logo.php">
                                    Add Payment Logo</a>
                            </li>

                            <li>
                                <a href="list_payment_logo.php">
                                    List Payment Logo</a>
                            </li>


                        </ul>
                    </li>
                    <?php } elseif (in_array('footer_management', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Footer Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="footer_category.php">
                                    Footer Category</a>
                            </li>


                            <li>
                                <a href="footer_help_text.php">
                                    Footer Help Button Text</a>
                            </li>

                            <li>
                                <a href="footer_contain_management.php">
                                    Footer Contact Management</a>
                            </li>

                            <li>
                                <a href="add_payment_logo.php">
                                    Add Payment Logo</a>
                            </li>

                            <li>
                                <a href="list_payment_logo.php">
                                    List Payment Logo</a>
                            </li>


                        </ul>
                    </li>
                    <?php }*/ ?>

                    <?php /*if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Header Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">


                            <li>
                                <a href="header_text.php">
                                    Header Text</a>
                            </li>



                        </ul>
                    </li>
                    <?php } elseif (in_array('header_management', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-university"></i>
                            <span class="title">Header Management</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">


                            <li>
                                <a href="header_text.php">
                                    Header Text</a>
                            </li>



                        </ul>
                    </li>
                    <?php }*/ ?>

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-puzzle"></i>
                            <span class="title">Bookings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="search_order.php">Bookings</a></li>
                        </ul>
                    </li>-->

                    <!--            <li>
                        <a href="javascript:;">
                            <i class="icon-puzzle"></i>
                            <span class="title">Message</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="message_inbox.php">Message</a></li>
                        </ul>
                    </li>-->

                    <li class="heading">
                        <h3 class="uppercase">Others</h3>
                    </li>

                    <?php if ($_SESSION['admin_type'] == 'superadmin') { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="icon-logout"></i>
                            <span class="title">Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="changeusername.php">
                                    <i class="icon-pencil"></i>
                                    Change Username
                                </a>
                            </li>

                            <li>
                                <a href="changeemail.php">
                                    <i class="icon-pencil"></i>
                                    Change Email
                                </a>
                            </li>

                            <li>
                                <a href="changepassword.php">
                                    <i class="icon-pencil"></i>
                                    Change Password
                                </a>
                            </li>

                            <!-- <li>
                                <a href="statictext.php">
                                    <i class="icon-pencil"></i>
                                    Static Text
                                </a>
                            </li> -->

                            <li>
                                <a href="logout.php">
                                    Logout</a>
                            </li>
                        </ul>
                    </li>
                    <?php } elseif (in_array('settings', $menuAccess)) { ?>
                    <li>
                        <a href="javascript:;">
                            <i class="icon-logout"></i>
                            <span class="title">Settings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="changeusername.php">
                                    <i class="icon-pencil"></i>
                                    Change Username
                                </a>
                            </li>

                            <li>
                                <a href="changeemail.php">
                                    <i class="icon-pencil"></i>
                                    Change Email
                                </a>
                            </li>

                            <li>
                                <a href="changepassword.php">
                                    <i class="icon-pencil"></i>
                                    Change Password
                                </a>
                            </li>

                            <li>
                                <a href="statictext.php">
                                    <i class="icon-pencil"></i>
                                    Static Text
                                </a>
                            </li>

                            <li>
                                <a href="logout.php">
                                    Logout</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
            </ul>

        </div>
    </div>