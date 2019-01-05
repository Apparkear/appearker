<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>

<section class="baner">
    <div class="baner-img" style="background: url(./upload/sitebanner/aboutus.jpg) no-repeat;min-height: 300px;
    opacity: 0.6;">
        <div class="container text-center pt-4">
            <div class="baner-text text-bg">
                <h1 class="mb-0"><b>About Us</b></h1>
            </div>
        </div>
    </div>

</section>

<section class="container">
    <div class="message-body">
        <div class="row">
            <div class="col-md-3">
                <img src="./upload/parking/1535030965popular-img1.png" class="img-fluid my-2">
            </div>
            <div class="col-md-9">
                <h4 class="active-text mb-3">There are <b>many variations</b> of passages</h4>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. <br>Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature.<br>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
            </div>

            <div class="col-md-9 my-4">
                <h4 class="active-text mb-3">Contrary to popular <b>many variations</b> of passages</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
            </div>
            <div class="col-md-3 my-4">
                <img src="./upload/parking/1535032538popular-img8.png" class="img-fluid my-2">
            </div>
        </div>

    </div>
</section>

    <section class="business py-5 mt-5">
        <div class="container">
            <div class="hd">
                <h2 class="my-4">Apparkear for Business</h2>
                <p>Need parking places for your employees? We will help you find them.</p>
                <a class="btn-primary my-2" href="<?php if($_SESSION['user_id']){ ?>javascript:void(0) <?php }else{ ?>business_owner.php <?php } ?>" style="display:inline-block">More Information</a>
            </div>
        </div>
    </section>

<?php
include "include/footer.php";
?>
