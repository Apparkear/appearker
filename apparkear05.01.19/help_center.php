<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>

<section class="baner mt-0">
    <div class="baner-img" style="background: url(./upload/sitebanner/help.jpg) no-repeat;min-height: 300px;
    opacity: 0.6;background-size: cover;">
        <div class="container text-center pt-4">
            <div class="baner-text text-bg">
                <h1 class="mb-0"><b>Help</b></h1>
            </div>
        </div>
    </div>   
</section>

<section class="help">
    <div class="">
        <div class="help text-center">
            <h2 class="d-block white-text">How can we help?</h2>
            <form class="example" action="/action_page.php"                 style="margin:auto;max-width:40%">
                <input type="text" placeholder="Search..." name="search2">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>           
    </div>
</section>

<div class="light-bg">
<section class="help-box container">
    <div class="row py-5">

        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Important Updates</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Parking With Us</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Need More Help</h4>
                <p class="m-0">There are many variations of passages of Lorem Ipsum available</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Renter</h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="help-bg p-4 text-center my-3">
                <h4 class="active-text">Space Owner</h4>
            </div>
        </div>

    </div>
</section>
</div>

<?php
include "include/footer.php";
?>

