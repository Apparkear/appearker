<?php
ob_start();
session_start();
include 'includes/config.php';


?>



<?php
if ($_REQUEST['action'] == 'edit') {
    $res22 = mysql_fetch_array(mysql_query("SELECT * FROM `estejmam_image` WHERE `id`='" . $_REQUEST['id'] . "'"));
}

// print_r($_REQUEST) ; exit;


if (isset($_REQUEST['submit'])) {

    $imagepath1 = "../upload/property/" . $res22['image'];
    if(!is_dir("../upload/property_orig/"))
    {
        mkdir("../upload/property_orig/",0777);

    }
    copy("../upload/property/" . $res22['image'],"../upload/property_orig/". $res22['image']);

        //fill the image with a transparent background


    $extension=end(explode('.',$imagepath1));
    $extension1=end(explode('/',$imagepath1));
    $max_size = 1280; //max image size in Pixels

    $destination_folder ="../upload/property/";

    //watermark_png_file = 'watermark.png'; //path to watermark image

    /*$image_name = $_FILES['image_file']['name']; //file name
    $image_size = $_FILES['image_file']['size']; //file size
    $image_temp = $_FILES['image_file']['tmp_name']; //file temp
    $image_type = $_FILES['image_file']['type']; //file type
*/
    switch(strtolower($extension)){ //determine uploaded image type
            //Create new image from file

            case 'png':
                $image_resource =  imagecreatefrompng($imagepath1);
                break;
            case 'gif':
                $image_resource =  imagecreatefromgif($imagepath1);
                break;
            case 'jpeg': case 'jpg':
              $image_resource = imagecreatefromjpeg($imagepath1);
                break;
            default:
                $image_resource = false;
        }

    if($imagepath1){
	   //echo "i am here";
	   //exit;
        //Copy and resize part of an image with resampling
        list($img_width, $img_height) = getimagesize($imagepath1);
        if($img_width < $max_size && $img_height < $max_size)
        {
            $max_size=max(array($img_width, $img_height));
        }
        //Construct a proportional size of new image
        $image_scale        = min($max_size / $img_width, $max_size / $img_height);
        $new_image_width    = ceil($image_scale * $img_width);
        $new_image_height   = ceil($image_scale * $img_height);
        $new_canvas         = imagecreatetruecolor($new_image_width,$new_image_height);
        //$new_canvas         = imagecreatetruecolor(640 ,480);

        //Resize image with new height and width
        if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width,$new_image_height, $img_width, $img_height))
        {
            //echo "i am here";
            //exit;

            if(!is_dir($destination_folder)){
                mkdir($destination_folder);//create dir if it doesn't exist
            }

            //calculate center position of watermark image
            $watermark_left = 450; //watermark left
            $watermark_bottom = 50; //watermark bottom
            // 
            

            //$watermark = imagecreatefrompng($watermark_png_file); //watermark image

            //use PHP imagecopy() to merge two images.
	        $watermark_png_file = imagecreatefrompng('../images/watermarknew.png');
            $sx = imagesx($watermark_png_file);
            $sy = imagesy($watermark_png_file);
            $water_left=imagesx($new_canvas) - $sx;
            $water_bottom=imagesy($new_canvas) - $sy - (imagesy($new_canvas) -$sy - 50);
            echo($water_bottom);

            imagecopy($new_canvas, $watermark_png_file, $water_left, $water_bottom, 0, 0, 190, 52); //merge image

            //output image direcly on the browser.
            header('Content-Type: image/jpeg');
            //imagejpeg($new_canvas, NULL , 100);
            //Or Save image to the folder
            imagejpeg($new_canvas, $destination_folder.$extension1 , 100);

            //free up memory
            imagedestroy($new_canvas);
            imagedestroy($image_resource);
            //die();
        }
    }



    echo '1';

    // header("location:".$_REQUEST['url']);
}


?>
