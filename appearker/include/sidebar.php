<?php //$all = explode('/',$_SERVER['REQUEST_URI']); $total = count($all); $page_name = $all[$total-1]; ?>
<?php //echo $_SESSION['user_type']."Moi"; ?>
<div class="col-md-3">
    <div class="left-nav">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action <?php if($page_name == 'dashboard_user.php'){ ?> active <?php } ?>" href="dashboard_user.php"><img src="images/dashboard-icon.png" alt="">Dashboard</a>
            <?php if($_SESSION['user_type'] == 0){ ?>
            
            <a class="list-group-item list-group-item-action <?php if($page_name == 'editprofile.php'){ ?> active <?php } ?>" href="editprofile.php" ><img src="images/edit-pro-icon.png" alt="">Edit Profile</a>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'my_properties.php'){ ?> active <?php } ?>" href="my_properties.php" ><img src="images/my-properties-icon.png" alt="">My Properties</a>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'change_password.php'){ ?> active <?php } ?>" href="change_password.php" ><img src="images/chng-pswrd.png" alt="">Change Password</a>
            <?php } ?>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'message_list.php'){ ?> active<?php } ?>" href="message_list.php"><img src="images/mesg-icon.png" alt=""> Message</a>
            <?php if($_SESSION['user_type'] == 0){ ?>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'booking_history.php'){ ?> active<?php } ?>" href="booking_history.php"><img src="images/book-his-icon.png" alt="">Booking History</a>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'review_user.php'){ ?> active<?php } ?>" href="review_user.php"><img src="images/my-rev-icon.png" alt="">My Reviews</a>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'payment_method.php'){ ?> active<?php } ?>" href="payment_method.php"> <img src="images/pay-meth-icon.png" alt=""> Payment Method</a>
            <a class="list-group-item list-group-item-action <?php if($page_name == 'setting.php'){ ?> active<?php } ?>" href="setting.php"> <img src="images/settings-icon.png" alt=""> Settings</a>
            <?php } ?>
            <a class="list-group-item list-group-item-action" href="logout.php" ><img src="images/sign-out-icon.png" alt="">Logout</a>

        </div>
    </div>
</div>