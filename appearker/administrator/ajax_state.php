<?php
ob_start();
session_start();
include('includes/config.php');

$countryid = $_REQUEST['id'];
$previd = $_REQUEST['previd'];

$sql_city = mysql_query("SELECT * FROM `states` WHERE `country_id` = '" . $countryid . "'");
while ($row_city = mysql_fetch_array($sql_city)) {
    ?>
    <option value="<?php echo $row_city['id'] ?>" <?php if ($previd == $row_city['id']) { ?> selected <?php } ?>><?php echo $row_city['name'] ?></option>
    <?php
}
?>



