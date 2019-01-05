<?php
header("HTTP/1.0 404 Not Found");
include('include/header.php');
?>
<style>
  .c-404__bg {
    background: url("/img/404-bg.jpg");
    padding: 100px 0;
  }

  .c-404__bg h1,
  .c-404__bg p {
    color: white !important;
  }

  .c-404__bg h1 {
    font-size: 50px;
    font-weight: 900;
  }

  .c-404__info {
    padding: 60px 0;
  }
</style>


<div class="c-404">
  <div class="c-404__bg">


    <br>
    <br>
    <br>
    <br>

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="text-center">Page not found</h1>
          <p class="text-center">Error code: 404</p>

        </div>
      </div>
    </div>
  </div>

  <div class="container c-404__info">
    <div class="row" style="display: flex;">
      <div class="col-sm-6 center-block">
        <p>
          Sorry! We couldn't find the page you're looking for. Maybe the link you followed was broken or the page has been removed. You can:
          <br>
          <br>
          <a href="/">Return to our homepage.</a></p>
        <!-- <p>Have a look at our help center for tips and information about renting a new home.</p>
        <p>Contact us directly via email at hello@roomarate.com.</p> -->

      </div>
    </div>
  </div>
</div>


<?php include('include/footer.php'); ?>
