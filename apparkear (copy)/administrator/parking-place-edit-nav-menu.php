<?php
$currentPage = end(explode('/', $_SERVER['REQUEST_URI']));
$navMenuPages = array(
    array('General Information', 'parking-place-edit-general-information.php'),
    array('Contact Information', 'parking-place-edit-contact-information.php'),
    array('Property Description', 'parking-place-edit-property-description.php'),
    array('Parking Place & Price', 'parking-place-edit-parking-place-n-price.php'),
    array('Reservation and Time Preferences', 'parking-place-edit-reservation-n-time-preferences.php'),
    array('Cancellation/Refund Policy/Availability', 'parking-place-edit-cancellation-refund-policy-availability.php'),
    array('Add a Co-owner', 'parking-place-edit-add-a-co-owner.php')
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