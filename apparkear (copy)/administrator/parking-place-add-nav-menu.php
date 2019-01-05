<?php
$currentPage = end(explode('/', $_SERVER['REQUEST_URI']));
$navMenuPages = array(
    array('General Information', 'parking-place-add-general-information.php'),
    array('Contact Information', 'parking-place-add-contact-information.php'),
    array('Property Description', 'parking-place-add-property-description.php'),
    array('Parking Place & Price', 'parking-place-add-parking-place-n-price.php'),
    array('Reservation and Time Preferences', 'parking-place-add-reservation-n-time-preferences.php'),
    array('Cancellation/Refund Policy/Availability', 'parking-place-add-cancellation-refund-policy-availability.php'),
    array('Add a Co-owner', 'parking-place-add-add-a-co-owner.php')
);
?>
<div class="col-md-12">
    <ul class="nav nav-pills">
        <?php
        foreach($navMenuPages as $navMenuPage) {
            echo '<li role="presentation" class="'.($currentPage == $navMenuPage[1] ? 'active' : '').'">'
                    . '<a href="'.$navMenuPage[1].'">'.$navMenuPage[0].'</a>'
                    . '</li>';
        }
        ?>
    </ul>
</div>