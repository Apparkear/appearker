<?php
ob_start();
session_start();
include 'includes/config.php';



    $res22 = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_sitesettings` WHERE `id`='1'"));
    $imagepath1 = "../upload/social_image/" . $res22['social_share_image'];


//         //fill the image with a transparent background
      
    $stamp  = imagecreatefrompng('../images/watermarknew.png');
//     // $im     = imagecreatefromjpeg($imagepath1);

    $marge_right = 0;
    $marge_top = 310;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
//     // $stamp = imagecreatetruecolor($sx,$sy);

//     //     //make sure the transparency information is saved
//     //     imagesavealpha($stamp, true);

//     //     //create a fully transparent background (127 means fully transparent)
//     //     $trans_background = imagecolorallocatealpha($stamp, 128, 128, 128, 63);
//     //     imagefill($stamp, 0, 0, $trans_background);
    
//     // imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_top, 0, 0, imagesx($stamp), imagesy($stamp));
//     // // imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_top, 0, 0, imagesx($stamp), imagesx($stamp));

//     // header('Content-type: image/png');
//     // imagejpeg($im, $imagepath1, 100);
//     // imagedestroy($im);

   

//     // echo '1';

// //--------------- Watermark image --------------//
    
    $path = "../upload/social_image/agentwatermark22.jpeg";
//     $imagetobewatermark=imagecreatefromjpeg($imagepath1);
//     $watermarktext="RA354125";
//     $font="../font/Lato-Light.ttf";
//     $fontsize="15";

//     $white = imagecolorallocate($imagetobewatermark, 255, 255, 255);
//     imagettftext($imagetobewatermark, $fontsize, 0, 20, 10, $white, $font, $watermarktext);

//     header("Content-type:image/png");
        
//     imagejpeg($imagetobewatermark,$imagepath1,100);
//     imagedestroy($imagetobewatermark);

// //--------------- Watermark image --------------//    
// echo 'Done'; 


$font_path = "../fonts/Lato-Light.ttf"; // Font file
$font_size = 15; // in pixcels
$code = "hug354";
$water_mark_text_2 = "Referral Code:".$code; // Watermark Text

watermark_text($imagepath1,$path);

function watermark_text($oldimage_name, $new_image_name){
    global $font_path, $font_size, $water_mark_text_2 ,$marge_right,$marge_top,$sx,$sy;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    $width = $owidth;
    $height = $oheight; 
    $image = imagecreatetruecolor($width, $height);
    $image_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $owidth, $oheight, $owidth, $oheight);
    $blue = imagecolorallocate($image, 79, 166, 185);
    imagettftext($image, $font_size, 0, imagesx($image_src) - $sx - $marge_right-10, imagesy($image_src) - $sy - $marge_top, $blue, $font_path, $water_mark_text_2);
    imagejpeg($image, $new_image_name, 100);
    imagedestroy($image);
    // unlink($oldimage_name);
    return true;
}

exit;

?>







