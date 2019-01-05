<?php
session_start();
include 'administrator/includes/config.php';


 if ($_FILES['image']['tmp_name'] != '') {
        $target_path = "./upload/user_image/";
        $userfile_name = $_FILES['image']['name']; 
        $userfile_tmp = $_FILES['image']['tmp_name'];
        $img_name = $userfile_name;
        $img = $target_path . $img_name;
        move_uploaded_file($userfile_tmp, $img);

        $image = mysqli_query($link, "UPDATE `estejmam_user` SET `image`='" . $img_name . "' WHERE `id` = '" . mysqli_real_escape_string($link, $user_id) . "'");
    }
    
    echo $img_name;exit;
    
    ?> 