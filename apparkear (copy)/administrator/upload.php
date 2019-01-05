<?php

ob_start();
session_start();
include("includes/config.php");



$date = date("Y-m-d");
if (isset($_SESSION['prop_id']) && $_SESSION['prop_id'] != '') {
    $mainid = $_SESSION['prop_id'];
}
if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
    $mainid = $_REQUEST['id'];
}

//$output_dir = "../upload/property/";
//$output_dir_thumb='../upload/property/thumb/';
    $target_path ="../upload/property/";
        $thumb_path ='../upload/property/thumb/';
if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];
    {

        if (!is_array($_FILES["myfile"]['name'])) { //single file
           /* $RandomNum = time();

            $ImageName = str_replace(' ', '-', strtolower($_FILES['myfile']['name']));
            $ImageType = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.

            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt = str_replace('.', '', $ImageExt);
            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);*/

$field_name="myfile";
        //file name setup
        $filename_err = explode(".", $_FILES[$field_name]['name']);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count - 1];
        if ($file_name != '') {
            $fileName = time() . $file_name . '.' . $file_ext;
        } else {
            $fileName = time() . $_FILES[$field_name]['name'];
        }

        $fileName=NewImageName($fileName);
$thumb=TRUE;
        //upload image path
        $upload_image = $target_path . basename($fileName);

        //upload image
        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_image)) {
            //thumbnail creation
            if ($thumb == TRUE) {
                $thumbnail = $thumb_path . $fileName;
                list($width, $height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor(640,480);
                switch ($file_ext) {
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }
                imagecopyresized($thumb_create, $source, 0, 0, 0, 0, 640, 480, $width, $height);
                switch ($file_ext) {
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create, $thumbnail, 100);
                        break;
                    case 'png':
                        imagepng($thumb_create, $thumbnail, 100);
                        break;
                    case 'gif':
                        imagegif($thumb_create, $thumbnail, 100);
                        break;
                    default:
                        imagejpeg($thumb_create, $thumbnail, 100);
                }
            }

            //return $fileName;
	    $ret[$fileName] = $thumb_path . $fileName;
        } else {
            return false;
        }

            //$ret[$fileName] = $output_dir . $NewImageName;

            mysql_query("INSERT INTO `estejmam_image` (prop_id,image) VALUES ('" . $mainid . "','" . $fileName . "')");
            mysql_query("update `estejmam_main_property` set `edited_date`='" . $date . "' where `id`='" . $mainid . "')");
        } else {
            $fileCount = count($_FILES["myfile"]['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $RandomNum = time();

                $ImageName = str_replace(' ', '-', strtolower($_FILES['myfile']['name'][$i]));
                $ImageType = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.
		$NewImageName=cwUpload('myfile',$output_dir,$_FILES['myfile']['name'][$i],FALSE,$output_dir_thumb,640,480);
		$ret[$NewImageName] = $output_dir . $NewImageName;
                /*$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.', '', $ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;

                $ret[$NewImageName] = $output_dir . $NewImageName;
                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $NewImageName);*/

                mysql_query("INSERT INTO `estejmam_image` (prop_id,image) VALUES ('" . $mainid . "','" . $NewImageName . "')");
                mysql_query("update `estejmam_main_property` set `edited_date`='" . $date . "' where `id`='" . $mainid . "')");
            }
        }
    }
}
echo json_encode($ret);
function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = '') {
        //folder path setup
        $target_path = $target_folder;
        $thumb_path = $thumb_folder;

        //file name setup
        $filename_err = explode(".", $_FILES[$field_name]['name']);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count - 1];
        if ($file_name != '') {
            $fileName = time() . $file_name . '.' . $file_ext;
        } else {
            $fileName = time() . $_FILES[$field_name]['name'];
        }
        $fileName=NewImageName($fileName);
        //upload image path
        $upload_image = $target_path . basename($fileName);

        //upload image
        if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_image)) {
            //thumbnail creation
            if ($thumb == TRUE) {
                $thumbnail = $thumb_path . $fileName;
                list($width, $height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
                switch ($file_ext) {
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }
                imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
                switch ($file_ext) {
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create, $thumbnail, 100);
                        break;
                    case 'png':
                        imagepng($thumb_create, $thumbnail, 100);
                        break;
                    case 'gif':
                        imagegif($thumb_create, $thumbnail, 100);
                        break;
                    default:
                        imagejpeg($thumb_create, $thumbnail, 100);
                }
            }

            return $fileName;
        } else {
            return false;
        }
    }
    
?>