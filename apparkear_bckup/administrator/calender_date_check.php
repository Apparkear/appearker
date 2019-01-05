<?php

ob_start();
session_start();
include 'includes/config.php';
//include 'functions/functions.php';
?>

<?php

if ($_REQUEST['id'] != '') {

    $sql = "update `estejmam_main_property` set `availability`='" . $_REQUEST['id'] . "' where `id`='" . $_REQUEST['propid'] . "'";
    mysql_query($sql);

    echo '1';
}
?>