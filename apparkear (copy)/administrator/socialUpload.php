<?php

ob_start();
session_start();
include("includes/config.php");




$output_dir = "../upload/social_image/";



$stamp  = imagecreatefrompng('../images/watermarknew.png');

$marge_right = 0;
$marge_top = 310;
$sx = imagesx($stamp);
$sy = imagesy($stamp);


$font_path = "../fonts/Lato-Light.ttf"; // Font file
$font_size = 15; // in pixcels



if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];
    {

        if (!is_array($_FILES["myfile"]['name'])) { //single file

            $RandomNum = time();

            $ImageName = str_replace(' ', '-', strtolower($_FILES['myfile']['name']));
            $ImageType = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;

            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $NewImageName);
            //echo "<br> Error: ".$_FILES["myfile"]["error"];

            $ret[$fileName] = $output_dir . $NewImageName;

            // mysql_query("INSERT INTO `estejmam_image` (prop_id,image) VALUES ('" . $mainid . "','" . $NewImageName . "')");

            $agentSQL = mysql_query("SELECT * FROM `estejmam_user` WHERE `type`='2' ");

            mysql_query("UPDATE `estejmam_sitesettings` set `social_share_image`='" . $NewImageName . "' where `id`='1'");

            while ($dataUser = mysql_fetch_array($agentSQL)) {
                $imagepath1 = "../upload/social_image/". $NewImageName;
                $i1 = $dataUser['id'].'owner.jpeg'; $i2 = $dataUser['id'].'client.jpeg'; $i3 = $dataUser['id'].'agent.jpeg';
                $pathOwner       = "../upload/social_image/".$i1;
                $pathClient      = "../upload/social_image/".$i2;
                $pathAgent       = "../upload/social_image/".$i3;

                watermark_text($imagepath1,$pathOwner,$dataUser['onner_code']);
                watermark_text($imagepath1,$pathClient,$dataUser['client_code']);
                watermark_text($imagepath1,$pathAgent,$dataUser['agent_code']);

                mysql_query("UPDATE `estejmam_user` set `onner_rimage`='".$i1."', `client_rimage`='".$i2."', `agent_rimage`='".$i3."'  where `id`='".$dataUser['id']."'");
            }

        } else {
            $fileCount = count($_FILES["myfile"]['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $RandomNum = time();

                $ImageName = str_replace(' ', '-', strtolower($_FILES['myfile']['name'][$i]));
                $ImageType = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.', '', $ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;

                $ret[$NewImageName] = $output_dir . $NewImageName;
                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $NewImageName);

                mysql_query("INSERT INTO `estejmam_image` (prop_id,image) VALUES ('" . $mainid . "','" . $NewImageName . "')");
                mysql_query("update `estejmam_main_property` set `edited_date`='" . $date . "' where `id`='" . $mainid . "')");
            }
        }
    }
}





function watermark_text($oldimage_name,$new_image_name,$code){
$water_mark_text_2 = "Code:".$code; // Watermark Text

    global $font_path, $font_size, $marge_right,$marge_top,$sx,$sy;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $width = $owidth;
    $height = $oheight;
    $image = imagecreatetruecolor($width, $height);
            $extension=explode('.',$oldimage_name);
 $type=end($extension);
    if($type=='png')
    {
	 $image_src =imagecreatefrompng($oldimage_name);
    }
    else
    {
    $image_src = imagecreatefromjpeg($oldimage_name);
    }
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $owidth, $oheight, $owidth, $oheight);
    $blue = imagecolorallocate($image, 79, 166, 185);
    imagettftext($image, $font_size, 0, imagesx($image_src) - $sx - $marge_right-10, imagesy($image_src) - $sy - $marge_top, $blue, $font_path, $water_mark_text_2);
    imagejpeg($image, $new_image_name, 100);
    imagedestroy($image);
    // unlink($oldimage_name);
    return true;
}


echo json_encode($ret);
?>
