<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";
?>



<section class="container mt-5">
    <div class="py-5">
        <div class="gray-bg p-3 row">
            <h4 class="alert alert-secondary text-center col-12" role="alert">Site Map</h4>
            <div class="p-4 col-12">
              <h5>There are many variations of passages of Lorem</h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
              <h5>Richard McClintock, a Latin professor</h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia. <br>looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
              Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32. </p>
              <h5>Lorem Ipsum passages, and more recently with desktop publishing </h5>
              <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
            </div>
            <div class="mt-5 col-2 site-link pr-2">
                <h5>Header -</h5>
                <ul class="list-group list-group-flush">
                    <a href="<?php echo SITE_URL; ?>search_list.php"><li class="list-group-item">Explore</li></a>
                    <a href="<?php echo SITE_URL; ?>help.php"><li class="list-group-item">Help Center</li></a>
                    <a href="#" data-toggle="modal" data-target="#exampleModalLong"><li class="list-group-item">Log in</li></a>
                    <a href="#" data-toggle="modal" data-target="#register-modal"><li class="list-group-item">Register</li></a>
                    <a href="<?php echo SITE_URL; ?>rent_parking_step1.php"><li class="list-group-item">Add Listing</li></a>
                    <a href="#"><li class="list-group-item">Language</li></a>
                </ul> 
            </div> 
            <div class="mt-5 col-2 site-link pr-2">
                <h5>Body -</h5>
                <ul class="list-group list-group-flush">
                    <a href="<?php echo SITE_URL; ?>"><li class="list-group-item">Search</li></a>
                    <a href="<?php echo SITE_URL; ?>"><li class="list-group-item">Popular Parking</li></a>
                    <a href="<?php echo SITE_URL; ?>"><li class="list-group-item">List a Space</li></a>
                    <a href="<?php echo SITE_URL; ?>"><li class="list-group-item">Apparker for Business</li></a>
                </ul> 
            </div>
            <div class="mt-5 col-2 site-link pr-2">
                <h5>Company -</h5>
                <ul class="list-group list-group-flush">
                    <a href="<?php echo SITE_URL; ?>about_us.php"><li class="list-group-item">About Us</li></a>
                    <a href="<?php echo SITE_URL; ?>jobs.php"><li class="list-group-item">Jobs</li></a>
                    <a href="<?php echo SITE_URL; ?>site_map.php"><li class="list-group-item">Site Map</li></a>
                    <a href="<?php echo SITE_URL; ?>help.php"><li class="list-group-item">Help</li></a>
                </ul> 
            </div>  
            <div class="mt-5 col-2 site-link pr-2">
                <h5>Terms & Conditions -</h5>
                <ul class="list-group list-group-flush">
                    <a href="<?php echo SITE_URL; ?>privacy_policy.php"><li class="list-group-item">Privacy Policy</li></a>
                    <a href="<?php echo SITE_URL; ?>terms_n_condition.php"><li class="list-group-item">Terms & Conditions</li></a>
                </ul> 
            </div> 
            <div class="mt-5 col-2 site-link pr-2">
                <h5>Follow Us -</h5>
                <ul class="list-group list-group-flush">
                    <a href=""><li class="list-group-item">Facebook</li></a>
                    <a href=""><li class="list-group-item">Twitter</li></a>
                    <a href=""><li class="list-group-item">Youtube</li></a>
                    <a href=""><li class="list-group-item">Pinterest</li></a>
                </ul> 
            </div>
            <div class="mt-5 col-2 site-link pr-2">
                <h5>App Store Link -</h5>
                <ul class="list-group list-group-flush">
                    <a href="https://play.google.com/store/apps"><li class="list-group-item" target="_blank">Google Play Store</li></a>
                    <a href="https://www.apple.com/in/ios/app-store/"><li class="list-group-item">App Store</li></a>
                </ul> 
            </div>

          </div>
        </div>

    </div>
</section>

<?php
include "include/footer.php";
?>
