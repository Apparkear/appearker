<?php
$pagename = end(explode('/', $_SERVER['REQUEST_URI']));
/* $privilegeSettings = mysql_fetch_array(mysql_query("Select * from `proapp_tbladmin` where `id`='" . $_SESSION['admin_id'] . "'"));
  $innerPrivileges = json_decode($privilegeSettings['privilages']); */
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
            <li>
                <a href="javascript:;">
                    <i class="icon-home"></i>
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


                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-basket"></i>
                    <span class="title">Banner</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">

                    <li  <?php if ($pagename == 'add_banner.php') { ?>  class="active" <?php } ?>>
                        <a href="add_banner.php">
                            <i class="icon-home"></i>
                            Add Banner</a>
                    </li>



                    <li>
                        <a href="list_banner.php">
                            <i class="icon-basket"></i>
                            List Banner</a>
                    </li>

                </ul>
            </li>



            <li>
                <a href="javascript:void(0);">
                    <i class="icon-basket"></i>
                    <span class="title">Tenants</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">

                    <li  <?php if ($pagename == 'teant_dashboard.php') { ?>  class="active" <?php } ?>>
                        <a href="teant_dashboard.php">
                            <i class="icon-home"></i>
                            Dashboard</a>
                    </li>

                    <li  <?php if ($pagename == 'search_user.php') { ?>  class="active" <?php } ?>>
                        <a href="search_user.php">
                            <i class="icon-home"></i>
                            Members List</a>
                    </li>

                    <li>
                        <a href="add_user_type.php">
                            <i class="icon-basket"></i>
                            Add New Members</a>
                    </li>

                </ul>
            </li>




            <li>
                <a href="javascript:void(0);">
                    <i class="icon-basket"></i>
                    <span class="title">Host</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">

                    <li  <?php if ($pagename == 'host_dashboard.php') { ?>  class="active" <?php } ?>>
                        <a href="host_dashboard.php">
                            <i class="icon-home"></i>
                            Dashboard</a>
                    </li>

                    <li  <?php if ($pagename == 'search_user_host.php') { ?>  class="active" <?php } ?>>
                        <a href="search_user_host.php">
                            <i class="icon-home"></i>
                            Members List</a>
                    </li>

                    <li>
                        <a href="add_user_type_host.php">
                            <i class="icon-basket"></i>
                            Add New Members</a>
                    </li>

                </ul>
            </li>




            <li>
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
            </li>



            <li>
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
                </ul>
            </li>




            <li>
                <a href="javascript:;">
                    <i class="icon-basket"></i>
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
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Language</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="add_language.php">Add Language</a></li>
                    <li><a href="list_language.php">List Language</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Payment Gateway</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="list_payment_gateway.php">Payment Gateway List</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Currency List</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="list_currency.php">Currency List</a></li>
                </ul>
            </li>


            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Contact us</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="list_testimonial.php">Contact details</a></li>
                </ul>
            </li>


            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Coupons</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="add_coupon.php">Add Coupons</a></li>
                    <li><a href="list_coupon.php">List Coupons</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Reviews</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="list_reviews.php">List Reviews</a></li>
                </ul>
            </li> 

            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Backup</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="backup_databse.php">Database Backup</a></li>
                </ul>
            </li>

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
            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
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
            <li>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Newsletters</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">


                    <li>
                        <a href="newsletter.php">
                            Send Newsletter</a>
                    </li>



                </ul>
            </li>

            <!--            <li>
                            <a href="javascript:;">
                                <i class="icon-puzzle"></i>
                                <span class="title">User</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
            
                                <li>
                                    <a href="search_vendor.php">
                                        List Landlords</a>
                                </li>
            
                                <li>
                                    <a href="search_user.php">
                                        List Tenants</a>
                                </li>
            
            
                            </ul>
                        </li>-->

            <li>
                <a href="javascript:;">
                    <i class="icon-puzzle"></i>
                    <span class="title">Properties</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="add_property.php">Add Property</a></li>
                    <li><a href="list_product.php">List Properties</a></li>
                    <li><a href="add_amenities.php">Add Amenities</a></li>
                    <li><a href="list_amenities.php">List Amenities</a></li>
                    <?php /* ?>            <li><a href="add_subcategory.php">Add Sub Category</a></li>
                      <li><a href="list_subcategory.php">List Sub Category</a></li><?php */ ?>
                    <!--<li><a href="list_store.php">List Stores</a></li>-->




                </ul>
            </li>


            <li>
                <a href="javascript:;">
                    <i class="icon-puzzle"></i>
                    <span class="title">Bookings</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">

                    <li><a href="search_order.php">Bookings</a></li>
                    <!--<li><a href="monthly_chart.php"> Monthly order Chart</a></li>
                    <li> <a href="list_order_graph.php"> View Orders in Graph</a></li>-->



                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="icon-puzzle"></i>
                    <span class="title">Message</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="message_inbox.php">Message</a></li>
                </ul>
            </li>


            <li class="heading">
                <h3 class="uppercase">Others</h3>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-logout"></i>
                    <span class="title">Settings</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">

                    <li>
                        <a href="changeusername.php">
                            <i class="icon-pencil"></i> Change Username </a>
                    </li>

                    <li>
                        <a href="changeemail.php">
                            <i class="icon-pencil"></i> Change Email </a>
                    </li>

                    <li>
                        <a href="changepassword.php">
                            <i class="icon-pencil"></i> Change Password </a>
                    </li>

                    <li>
                        <a href="logout.php">
                            Logout</a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
</div>
