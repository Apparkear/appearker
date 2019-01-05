<?php
//echo "hiiii";exit;
//error_reporting(1);
require 'vendor/autoload.php';
require 'PHPMailer/class.phpmailer.php';
require 'config.php';
include('routs.php');
include('crud.php');
//include('Stripe.php');

$stripe_api_sk_key = "sk_test_5K401tpKS27cCLjkYe3LTXCv";
$stripe_api_pk_key = "pk_test_avhCsvHAaou7xWu7SxVCzptC";

//$app->get('/test(/:name)',"test");
//header("Access-Control-Allow-Origin:192.168.1.234:8101");
header('Access-Control-Allow-Origin:192.168.1.234:8101');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization, Accept');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS,HEAD');


date_default_timezone_set('UTC');

function test($name = "kkkk") {
    $app = \Slim\Slim::getInstance();
    $dataArray = array('id' => "aa", 'somethingElse' => $name);
    if ($name) {
        $app->response->setStatus(200);
        $app->response->write(json_encode($dataArray));
    } else {
        $app->response->setStatus(401);
        $app->response->write("{\"msg\":\"not found\"}");
    }
}


function login() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body =$request->post();
    $email = $body['email'];
    $password = $body['password'];

    $sql = "SELECT * FROM `estejmam_user` WHERE `email`=:email AND `password`=:password";

    try {
        
        $pass = md5($password);
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("password", $pass);
        $stmt->execute();
        

        $user = $stmt->fetchObject();
        //print_r($user);exit;
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
            $data['id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'Username Or Password Is Invalid !!!';

            $app->response->setStatus(200);
        } else {
            $data['id'] = $user->id;
            $data['email'] = $user->email;
            $data['Ack'] = 1;
            $data['msg'] = 'Loggedin Successfully';


            $sql = "SELECT * FROM `estejmam_user` WHERE `id`=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user->id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = array(
                "id" => stripslashes($getUserdetails->id),
                "full_name" => stripslashes($getUserdetails->fname) . ' ' . stripslashes($getUserdetails->lname),
                "email" => stripslashes($getUserdetails->email),
                "address" => stripslashes($getUserdetails->address),
                "type" => stripslashes($getUserdetails->type),
                "phone" => $getUserdetails->phone,
                "profile_image" => stripslashes($profile_image));

            $userID = $getUserdetails->id;
            $is_logged_in = 1;

            $app->response->setStatus(200);
        }

        $db = null;
    } catch (PDOException $e) {
        //echo 2;exit;
        print_r($e);
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function signup() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body =$request->post();
    
    $first_name = isset($body['fname']) ? $body['fname'] : '';
    $last_name = isset($body['lname']) ? $body['lname'] : '';
    $email = isset($body['email']) ? $body['email'] : '';
    $password = isset($body['password']) ? $body['password'] : '';
    $type = isset($body['user_type']) ? $body['user_type'] : '';
    $status = 1;
    $join_date = date('Y-m-d');
    $db = getConnection();
    $sql = "SELECT * FROM `estejmam_user` WHERE  `email`=:email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $usersCount = $stmt->rowCount();

    if ($usersCount == 0) {
        $newpass = md5($password);
        $sql = "INSERT INTO `estejmam_user` (`fname`,`lname`,`email`,`password`,`type`,`status`,`add_date`) VALUES (:first_name, :last_name, :email, :password, :type, :status, :add_date)";
        try {

            $stmt = $db->prepare($sql);
            $stmt->bindParam("first_name", $first_name);
            $stmt->bindParam("last_name", $last_name);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("password", $newpass);
            $stmt->bindParam("type", $type);
            $stmt->bindParam("status", $status);
            $stmt->bindParam("add_date", $join_date);
            $stmt->execute();

            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            
            $sql = "SELECT * FROM `estejmam_user` WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $lastID);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = $getUserdetails;

            $to = $email;
            
            $admin_query = "SELECT * FROM estejmam_tbladmin WHERE `id` = 1";
            $stmt1 = $db->prepare($admin_query);
            $stmt1->execute();
            $adminDetails = $stmt1->fetchObject();
            $adminEmail = $adminDetails->email;
            $phonenoAdmin = $adminDetails->phone_no;
            $Subject = "Welcome Apparkear";
            $TemplateMessage ="Welcome to Apparkear Please login";
            
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'mail@natitsolved.com';
            $mail->Password = 'Natit#2019';


            $mail->IsHTML(true);
            $mail->From = $adminEmail;
            $mail->FromName = "Apparkear";
            $mail->Sender = $adminEmail; 
            $mail->AddReplyTo($adminEmail, "Apparkear");
           
            $mail->Subject = $Subject;
            $mail->Body = $TemplateMessage;
            $mail->AddAddress($email);
            if($mail->Send()){
                $data['Ack'] = 1;
                $data['msg'] = 'Registered Successfully...';
            }else{
                $data['Ack'] = 0;
                $data['msg'] = 'Mail not sent';
            }
            $app->response->setStatus(200);
            

            $db = null;
        } catch (PDOException $e) {
            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = 'Registration Error !!!';
            $app->response->setStatus(200);
        }
    } else {
        $data['user_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'User already exists';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function mylisting(){
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body =$request->post();
    
    $user_id = isset($body['my_id']) ? $body['my_id'] : '';
    
    $sql = "SELECT * FROM `parking` WHERE `user_id`=:user_id AND `status`=1 ORDER BY `id` DESC";
    
    try{
        
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $my_list = $stmt->fetchAll();
        
        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($my_list as $key => $parking_list) {
                
                $sql_image = "SELECT `parking_images`.`image` FROM `parking_images` WHERE `parking_id`=".$parking_list['id']; 
                $stmt = $db->prepare($sql_image);
                $stmt->execute();
                $image_list = $stmt->fetchAll();
                //print_r($image_list); 
                if(!empty($image_list)){
                    $total_image = $stmt->rowCount();
                }else{
                    $total_image =0;
                }
                $image_array =array();
                if($total_image >1){
                    
                    foreach($image_list as $imglist){
                       
                        $image_array[] = array(
                            "image" => SITE_URL . 'upload/user_image/' .stripslashes($imglist['image'])
                        );
                    }
                    
                }
               
                $allorders[] = array(
                    "id" => stripslashes($parking_list['id']),
                    "image" => $image_array,
                    "price" => stripslashes($parking_list['price']),
                    "booking_date_start" => stripslashes($parking_list['available_start']),
                    "booking_date_end" => stripslashes($parking_list['avaliable_end']),
                    "name" => stripslashes($parking_list['name']),
                    "address" => stripslashes($parking_list['address']),
                    "currency" => stripslashes($parking_list['currency']),
                    "price_rate_type" => stripslashes($parking_list['price_rate_type'])
                );
            }
            
            $data['alllist'] = $allorders;
        }
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        
    }catch (PDOException $e) {
        
        $data['user_id'] = $user_id;
        $data['Ack'] = 0;
        $data['listing']= null;
        $data['msg'] = 'Listing Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}
function myfavourite(){
    $data= array();
    $allorders =array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->post();
    
    $user_id = isset($body['my_id']) ? $body['my_id'] : '';
    
    $sql = "SELECT `parking`.* FROM `estejmam_favourite_property` LEFT JOIN `parking` ON `parking`.`id`=`estejmam_favourite_property`.`prop_id` WHERE `estejmam_favourite_property`.`user_id`=:user_id ORDER BY `id` DESC";
    
    try{
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $my_list = $stmt->fetchAll();
        //print_r($my_list);exit;
        $count = $stmt->rowCount();
        
        if ($count > 0) {
            foreach ($my_list as $key => $my_parkng_list) {
                
                $sql_image = "SELECT `parking_images`.`image` FROM `parking_images` WHERE `parking_id`=".$my_parkng_list['id']; 
                
                $stmt = $db->prepare($sql_image);
                $stmt->execute();
                $image_list = $stmt->fetchAll(PDO::FETCH_OBJ);
                //print_r($image_list); 
                if(!empty($image_list)){
                    $total_image = $stmt->rowCount();
                }else{
                    $total_image =0;
                }
                //echo $total_image;
                $image_array =array();
                if($total_image >=1){
                    
                    foreach($image_list as $imglist){
                       //print_r($imglist);
                        $image_array[] = array(
                            "image" => SITE_URL . 'upload/user_image/' .stripslashes($imglist->image)
                        );
                    }
                    
                }

               //print_r($image_array);
                $allorders[] = array(
                    "id" => $my_parkng_list['id'],
                    "image" => $image_array,
                    "price" => stripslashes($my_parkng_list['price']),
                    "booking_date_start" => stripslashes($my_parkng_list['available_start']),
                    "booking_date_end" => stripslashes($my_parkng_list['avaliable_end']),
                    "name" => stripslashes($my_parkng_list['name']),
                    "address" => stripslashes($my_parkng_list['address']),
                    "currency" => stripslashes($my_parkng_list['currency']),
                    "price_rate_type" => stripslashes($my_parkng_list['price_rate_type']),
                    "description" => stripslashes($my_parkng_list['description'])
                );
                
            
            }
             
            $data['alllist'] = $allorders;
            // print_r($data); exit;
            
        }
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        
        
    }catch (PDOException $e) {
        //print_r($e);exit;
        $data['user_id'] = $user_id;
        $data['Ack'] = 0;
        $data['listing']= null;
        $data['msg'] = 'Listing Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function profile_info(){
    $data = array();
    $allorders =array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body =$request->post();
    
    $user_id = isset($body['my_id']) ? $body['my_id'] : '';
    
    $sql = "SELECT * FROM `estejmam_user` WHERE `id`=:user_id";

    try {
        
        
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        
        $stmt->execute();
        

        $user = $stmt->fetchObject();
        //print_r($user);exit;
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
            $data['id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'Usere Is Invalid !!!';

            $app->response->setStatus(200);
        } else {
            $data['id'] = $user->id;
            $data['email'] = $user->email;
            $data['Ack'] = 1;
            $data['msg'] = 'Details Found';


            $sql = "SELECT * FROM `estejmam_user` WHERE `id`=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user->id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = '';
            }
//print_r($getUserdetails);exit;
            $data['UserDetails'] = array(
                "id" => stripslashes($getUserdetails->id),
                "full_name" => stripslashes($getUserdetails->fname) . ' ' . stripslashes($getUserdetails->lname),
                "email" => stripslashes($getUserdetails->email),
                "address" => stripslashes($getUserdetails->address),
                "type" => stripslashes($getUserdetails->type),
                "phone" => $getUserdetails->phone,
                "profile_image" => stripslashes($profile_image));

            $userID = $getUserdetails->id;
            $is_logged_in = 1;

            $app->response->setStatus(200);
        }

        $db = null;
    } catch (PDOException $e) {
        //echo 2;exit;
        print_r($e);
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Fetch Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}


function profile_info_save(){
    $data = array();
    $allorders =array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body =$request->post();
    
    $owner_id = isset($body['owner_id']) ? $body['owner_id'] : '';
    
    $sql = "SELECT * FROM `estejmam_user` WHERE id=:id ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $owner_id);
    $stmt->execute();
    $Userdetails = $stmt->fetchObject();
    
    $first_name = isset($body['fname']) ? $body['fname'] : '';
    $last_name = isset($body['lname']) ? $body['lname'] : '';
    $address = isset($body['address']) ? $body['address'] : '';
    $country = isset($body['country']) ? $body['country'] : '';
    $state = isset($body['state']) ? $body['state'] : '';
    $city = isset($body['city']) ? $body['city'] : '';
    //$email = isset($body['email']) ? $body['email'] : '';
    $phone = isset($body['phone']) ? $body['phone'] : '';
    $ocupation = isset($body['ocupation']) ? $body['ocupation'] : '';
    $dob = isset($body['dob']) ? $body['dob'] : '';
    $gender = isset($body['gender']) ? $body['gender'] : '';
    $client_code = isset($body['client_code']) ? $body['client_code'] : '';
    
    $db = getConnection();
    $sql = "SELECT * FROM `estejmam_user` WHERE  `email`=:email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $usersCount = $stmt->rowCount();
    
    if ($usersCount == 1) {
        
        if(isset($_FILES['image'])) {
                if(!empty($_FILES['image'])){
                    $pathpart = pathinfo($_FILES['image']['name']);
                    $logoEach = $_FILES['image'];
                    $ext = $pathpart['extension'];
                    $extensionValid = array('jpg', 'jpeg', 'png', 'gif', 'svg');

                    if (in_array(strtolower($ext), $extensionValid)) {

                        //$uploadPath = IMAGE_PATH. $get_id . '/Images';
                        $filename = date('Y-m-d H:i:s') . '_' . $_FILES['image']['name'];
                        $full_flg_path = IMAGE_PATH . '/' . $filename;
                        move_uploaded_file($logoEach['tmp_name'], $full_flg_path);            
                        $user_image = $filename;
                    } else {
                        $user_image = '';

                    }
                // exit;
                }else{
                    $user_image='';
                }
            } else {
                $user_image='';
            }
        
        $sql = "UPDATE `estejmam_user` SET `fname`=:fname,`lname`=:lname,`address`=:address,`country`=:country,`state`=:state,`city`=:city,`phone`=:phone,`work`=:work,`dob`=:dob,`gender`=:gender,`client_code`=:client_code, `image`=:image WHERE `id`=:owner_id";
        try {

            $stmt = $db->prepare($sql);
            $stmt->bindParam("owner_id", $owner_id);
            $stmt->bindParam("fname", $first_name);
            $stmt->bindParam("lname", $last_name);
           
            $stmt->bindParam("address", $address);
            $stmt->bindParam("country", $country);
            $stmt->bindParam("state", $state);
            $stmt->bindParam("city", $city);
            $stmt->bindParam("phone", $phone);
            $stmt->bindParam("work", $ocupation);
            $stmt->bindParam("dob", $dob);
            $stmt->bindParam("gender", $gender);
            $stmt->bindParam("client_code", $client_code);
            $stmt->bindParam("image", $user_image);
            
            $stmt->execute();

            $sql = "SELECT * FROM `estejmam_user` WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $owner_id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->image != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->image;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = $getUserdetails;

            
                $data['Ack'] = 1;
                $data['msg'] = 'Successfully Found ...';
           
            $app->response->setStatus(200);
            

            $db = null;
        } catch (PDOException $e) {
            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = 'Edit profile Error !!!';
            $app->response->setStatus(200);
        }
    } else {
        $data['user_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'User does not exists';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function country_list(){
    $data= array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->get();
    $sql = "SELECT * FROM `countries` ORDER BY `countries`.`id` ASC ";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $country =$stmt->fetchAll();
    $country_array= array();
    foreach($country as $ckey =>$cval){
        $country_array[$ckey]['id']= $cval['id'];
        $country_array[$ckey]['sortname']= $cval['sortname'];
        $country_array[$ckey]['name']= $cval['name'];
    }

    if(count($country) >0){
        $data['Ack']=1;
        $data['total_countries'] = count($country);
        $data['msg']='Jobs Found';
        $data['alljob']= $country_array;
    }else{
        $data['Ack']=0;
        $data['total_countries'] = 0;
        $data['msg']='Jobs not Found';
        $data['alljob']= $country_array;
    }
    $app->response->write(json_encode($data));
}

function state_list(){
    $data= array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->post();
    $country_id = $body['country_id'];


    $sql = "SELECT * FROM `states` WHERE `country_id`=:country_id ORDER BY `id` ASC ";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("country_id", $country_id);
    $stmt->execute();

    $state =$stmt->fetchAll();
    //print_r($state);exit;
    $state_array= array();
    foreach($state as $ckey =>$cval){
        $state_array[$ckey]['id']= $cval['id'];
        $state_array[$ckey]['country_id']= $cval['country_id'];
        $state_array[$ckey]['name']= $cval['name'];
    }

    if(count($state) >0){
        $data['Ack']=1;
        $data['total_states'] = count($state);
        $data['msg']='Jobs Found';
        $data['allstate']= $state_array;
    }else{
        $data['Ack']=0;
        $data['total_states'] = 0;
        $data['msg']='Jobs not Found';
        $data['allstate']= $state_array;
    }
    $app->response->write(json_encode($data));

}

function city_list(){
    $data= array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->post();
    $state_id = $body['state_id'];


    $sql = "SELECT * FROM `cities` WHERE `state_id`=:state_id ORDER BY `id` ASC ";
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->bindParam("state_id", $state_id);
    $stmt->execute();

    $state =$stmt->fetchAll();
    //print_r($state);exit;
    $state_array= array();
    foreach($state as $ckey =>$cval){
        $state_array[$ckey]['id']= $cval['id'];
        $state_array[$ckey]['state_id']= $cval['state_id'];
        $state_array[$ckey]['name']= $cval['name'];
    }

    if(count($state) >0){
        $data['Ack']=1;
        $data['total_cities'] = count($state);
        $data['msg']='Jobs Found';
        $data['allcity']= $state_array;
    }else{
        $data['Ack']=0;
        $data['total_states'] = 0;
        $data['msg']='Jobs not Found';
        $data['allcity']= $state_array;
    }
    $app->response->write(json_encode($data));

}

function image_upload(){
    //echo IMAGE_PATH;exit;
    $data= array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->post();
    $user_id = $body['user_id'];
    
    if(isset($_FILES['image'])) {
        if(!empty($_FILES['image'])){
            $pathpart = pathinfo($_FILES['image']['name']);
            $logoEach = $_FILES['image'];
            $ext = $pathpart['extension'];
            $extensionValid = array('jpg', 'jpeg', 'png', 'gif', 'svg');

            if (in_array(strtolower($ext), $extensionValid)) {
                
                //$uploadPath = IMAGE_PATH. $get_id . '/Images';
                $filename = date('Y-m-d H:i:s') . '_' . $_FILES['image']['name'];
                $full_flg_path = IMAGE_PATH . '/' . $filename;
                move_uploaded_file($logoEach['tmp_name'], $full_flg_path);            
                $user_image = $filename;
                $sql = "update `estejmam_user` set image='" . $user_image . "' where id=" . $user_id;
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $data['Ack'] =1;
                $data['image_name'] =$user_image;
            } else {
                $user_image = '';

            }
        // exit;
        }else{
            $user_image='';
        }
    } else {
        $user_image='';
    }
    
    
    $app->response->write(json_encode($data));
}














function homecarlist() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    //$body = json_decode($body2);
    $db = getConnection();

    $subcatId = $body->subcatid;

    try {
        $sql1 = "SELECT * FROM products WHERE `sub_category_id`='" . $subcatId . "' and status=1";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getfooddetails = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();
        if ($usersCount1 == 0) {
            
        } else {
            foreach ($getfooddetails as $key => $data2) {
                $sqlval1 = "SELECT * FROM `product_images` WHERE `product_id`=" . $data2->id;
                $stmt4 = $db->prepare($sqlval1);
                $stmt4->execute();
                $getUserdetails4 = $stmt4->fetchObject();
                $now = time(); // or your date as well
                $your_date = strtotime($data2->createdby);
                $datediff = $now - $your_date;
                $homeproduct[] = array('id' => $data2->id, 
                                        'name' => $data2->product_name, 
                                        'slug' => $data2->slug,
                                        'condition' => $data2->carcondition,
                                        'colors' => $data2->colors, 
                                        'category' => $data2->category_id,
                                        'location' => $data2->location,
                                        'price' => $data2->price, 
                                        'days' => floor($datediff / (60 * 60 * 24)), 
                                        'year' => $data2->year,
                                        'urgent' => $data2->is_urgent,
                                        'image' => SITE_URL . "img/cat_img/" . $getUserdetails4->originalpath, 
                                        'kilometer' => $data2->kilometer);
            }
        }
        $data['homegalary'] = $homeproduct;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function fetchfilterproduct() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    //$body = json_decode($body2);
    $db = getConnection();
    $authId = $body->authId;
    $subcatId = $body->subcatid;
    
    $lat = $body->lat;
    $lng = $body->lng;
    $distance = ($body->distance)/100;
    
    $bodytype = '';
    $make='';
    $model='';
    $falert ='';
    $adpostdate = '';
    $sql1 = "SELECT * FROM products WHERE `sub_category_id`='" . $subcatId . "' and status=1";
    if (isset($body->make)) {
        $make = $body->make;
        $sql1 .= " and `make`='".$make."'";
    }
    if (isset($body->model)) {
        $model = $body->model;
        $sql1 .= " and `models`='".$model."'";
    }
    if (isset($body->bodytype)) {
        $bodytype = $body->bodytype;
        $sql1 .= " and `bodytype`='".$bodytype."'";
    }
    if (isset($body->falert)) {
        $falert = $body->falert;
    }
    if (isset($body->adpostdate)) {
        $adpostdate = $body->adpostdate;
    }else{
        $adpostdate = 1000;
    }
    if ($distance > 0) {
        $latmax = $lat+$distance;
        $latmin = $lat-$distance;

        $lngmax = $lng+$distance;
        $lngmin = $lng-$distance;

        $sql1 .= " and `lat` <= '".$latmax."' and `lat` >= '".$latmin."' and `lon` <= '".$lngmax."' and `lon` >= '".$lngmin."'";
    }
    //echo $latmax;die;
    //echo $sql1;die;
    $usrsql = "UPDATE users SET `filter_use`='true', `filter_make` ='".$make."', `filter_model` ='".$model."', `filter_bodytype` ='".$bodytype."', `filter_alert` ='".$falert."', `filter_adposted` ='".$adpostdate."', `filter_distance` ='".$body->distance."'  WHERE `id`='".$authId."'";
        
    //echo $body->falert; die;
    $usrstmt = $db->prepare($usrsql);
    $usrstmt->execute();
    try {
        
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getfooddetails = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();
        if ($usersCount1 == 0) {
            
        } else {
            foreach ($getfooddetails as $key => $data2) {
                $sqlval1 = "SELECT * FROM `product_images` WHERE `product_id`=" . $data2->id;
                $stmt4 = $db->prepare($sqlval1);
                $stmt4->execute();
                $getUserdetails4 = $stmt4->fetchObject();
                $now = time(); // or your date as well
                $your_date = strtotime($data2->createdby);
                $datediff = $now - $your_date;
                $prodcdate = floor($datediff / (60 * 60 * 24));

                if ($prodcdate <= $adpostdate) {
                    $homeproduct[] = array('id' => $data2->id, 
                            'name' => $data2->product_name, 
                            'slug' => $data2->slug,
                            'condition' => $data2->carcondition,
                            'colors' => $data2->colors, 
                            'category' => $data2->category_id,
                            'location' => $data2->location,
                            'price' => $data2->price, 
                            'days' => $prodcdate, 
                            'year' => $data2->year,
                            'urgent' => $data2->is_urgent,
                            'image' => SITE_URL . "img/cat_img/" . $getUserdetails4->originalpath, 
                            'kilometer' => $data2->kilometer);
                }
            
            }
        }
        $data['homegalary'] = $homeproduct;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function homewebservice() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    $sql = "SELECT * FROM settings WHERE  id=1";
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $usersCount = $stmt->rowCount();

        if ($usersCount == 0) {
            
        } else {
            $getUserdetails = $stmt->fetchObject();
            $data['sitelogo'] = SITE_URL . "site_logo/" . $getUserdetails->logo;
            $sql1 = "SELECT * FROM products WHERE  status=1 and show_in_homepage=1 limit 0,4";
            $stmt1 = $db->prepare($sql1);
            $stmt1->execute();
            $usersCount1 = $stmt1->rowCount();
            $getfooddetails = $stmt1->fetchAll(PDO::FETCH_OBJ);
            $homeproduct = array();
            if ($usersCount1 == 0) {
                
            } else {
                foreach ($getfooddetails as $key => $data2) {
                    $sqlval1 = "SELECT * FROM `product_images` WHERE `product_id`=" . $data2->id;
                    $stmt4 = $db->prepare($sqlval1);
                    $stmt4->execute();
                    $getUserdetails4 = $stmt4->fetchObject();
                    $now = time(); // or your date as well
                    $your_date = strtotime($data2->createdby);
                    $datediff = $now - $your_date;
                    $homeproduct[] = array('id' => $data2->id, 'name' => $data2->product_name, 'slug' => $data2->slug, 'location' => $data2->location, 'price' => $data2->price, 'days' => floor($datediff / (60 * 60 * 24)), 'image' => SITE_URL . "img/cat_img/" . $getUserdetails4->originalpath);
                }
            }
            $data['homegalary'] = $homeproduct;
            $sqlval = "SELECT * FROM `advertisement_images` WHERE `advertisement_id`=3";
            $stmt3 = $db->prepare($sqlval);
            $stmt3->execute();
            $getUserdetails3 = $stmt3->fetchObject();
            $data['homeadvertiselogo'] = SITE_URL . "img/advertisement_img/" . $getUserdetails3->originalpath;
        }
        $data['Ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function userdetail() {

    $data = array();
    $allshops = array();
    $allCategories = array();
    $allSubCategories = array();
    $app = \Slim\Slim::getInstance();

    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $email = $body->email;

    $sql = "SELECT * FROM users WHERE 	email_address=:email";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $stmt->queryString;

        $user = $stmt->fetchObject();
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
            $data['user_id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'Username Or Password Is Invalid !!!';
            $app->response->setStatus(200);
            //$app->response->setStatus(401);
        } else {
            $data['user_id'] = $user->id;
            $data['Ack'] = 1;
            $data['msg'] = 'Loggedin Successfully';


            $sql = "SELECT * FROM users WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user->id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->user_logo != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->profile_img;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = array(
                "id" => stripslashes($getUserdetails->id),
                "full_name" => stripslashes($getUserdetails->first_name) . ' ' . stripslashes($getUserdetails->last_name),
                "email" => stripslashes($getUserdetails->email_address),
                "address" => stripslashes($getUserdetails->address),
                "profile_image" => stripslashes($profile_image));



            $userID = $getUserdetails->id;
            $is_logged_in = 1;

            $app->response->setStatus(200);
        }

        $db = null;
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}



function getserchres() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = $body->user_id;
    $sql = "SELECT * FROM users WHERE id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $tabdata = $stmt->fetchObject();

        if ($tabdata->filter_make) {
            $sql1 = "SELECT * FROM makes WHERE id=:makeid";
            $stmt = $db->prepare($sql1);
            $stmt->bindParam("makeid", $tabdata->filter_make);
            $stmt->execute();
            $make = $stmt->fetchObject();
        }
        
        if ($tabdata->filter_model) {
            $sql2 = "SELECT * FROM models WHERE id=:modelid";
            $stmt = $db->prepare($sql2);
            $stmt->bindParam("modelid", $tabdata->filter_model);
            $stmt->execute();
            $model = $stmt->fetchObject();
        }
        $data['makename'] = $make->name;
        $data['makeid'] = $make->id;
        $data['modelid'] = stripslashes($tabdata->filter_model);
        $data['modelname'] = stripslashes($model->name);
        $data['price'] = stripslashes($tabdata->filter_price);
        $data['bodytype'] = stripslashes($tabdata->filter_bodytype);
        $data['adposted'] = stripslashes($tabdata->filter_adposted);
        $data['alert'] = stripslashes($tabdata->filter_alert);

        $data['distance'] = stripslashes($tabdata->filter_distance);

        $data['total'] = stripslashes($tabdata->id);
        $data['Ack'] = '1';
        $data['msg'] = 'Success';

        $app->response->setStatus(200);
        $db = null;

    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = 'Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function totalproduct() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $sql = "SELECT COUNT(id) AS count FROM products ";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $tabdata = $stmt->fetchObject();

        $data['total'] = stripslashes($tabdata->count);
        $data['Ack'] = '1';
        $data['msg'] = 'Success';

        $app->response->setStatus(200);
        $db = null;

    } catch (PDOException $e) {

        $data['Ack'] = 0;
        $data['msg'] = 'Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function logout() {
    $data = array();

    $app = \Slim\Slim::getInstance();

    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    $is_loggedin = '0';

    $sql = "UPDATE users SET is_logged_in=:is_logged_in WHERE id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("is_logged_in", $is_loggedin);
        $stmt->execute();

        $data['user_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Logout Successfully';

        $app->response->setStatus(200);
        $db = null;
//    print_r($user);
    } catch (PDOException $e) {
//print_r($e);
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function settings() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    //$field = $body->field;
    $val = $body->val;

    $sql = "UPDATE users SET notification_send=:val WHERE id=:user_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("val", $val);
        $stmt->execute();

        $data['user_id'] = $user_id;
        $data['Ack'] = '1';
        $data['status'] = $val;
        $data['msg'] = 'Success';

        $app->response->setStatus(200);
        $db = null;
//    print_r($user);
    } catch (PDOException $e) {
//print_r($e);
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Error!!!';

        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}



function forgetpassword() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $email = $body->email;

    $byeamil = findByConditionArray(array('email_address' => $email), 'users');
    if (!empty($byeamil)) {
        $sql = "SELECT * FROM users WHERE email_address=:email ";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        $forgot_pass_otp = rand(1111, 9999);
        //$pass = md5($forgot_pass_otp);
        $pass = $forgot_pass_otp;
        $sql = "UPDATE users SET otp=:forgot_pass_otp WHERE email_address=:email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("forgot_pass_otp", $pass);
        $stmt->bindParam("email", $email);
        $stmt->execute();

        $to = $email;
        $from = 'mail@natitsolved.com';
        $name = 'yabbelah.com';
        $subject = "yabbelah.com- Your Password Request";
        $TemplateMessage = "Hello " . $getUserdetails->first_name . $getUserdetails->last_name . "<br />";
        $TemplateMessage .= "You have asked for your new password. Your OTP is below.<br />";
        $TemplateMessage .= "OTP: " . $forgot_pass_otp . "<br>";

        $TemplateMessage .= "Thanks,<br />";
        $TemplateMessage .= "yabbelah.com<br />";

        $header = "From:info@yabbelah.com \r\n";

        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = 'mail@natitsolved.com';
        $mail->Password = 'Natit@2017';

        $mail->IsHTML(true);
        $mail->From = $from;
        $mail->FromName = $name;
        $mail->Sender = $from; // indicates ReturnPath header
        $mail->AddReplyTo($from, $name); // indicates ReplyTo headers
        //$mail->AddCC('cc@site.com.com', 'CC: to site.com');
        $mail->Subject = $subject;
        $mail->Body = $TemplateMessage;
        $mail->AddAddress($to);
        
        if ($mail->Send()) {
            $data['ack'] = 1;
            $data['msg'] = 'Mail Send Successfully';
        } else {
            $data['ack'] = 0;
            $data['msg'] = 'Failed to send email!!!';
        }
        $db = null;
        $app->response->setStatus(200);

    } else {
        $data['last_id'] = '';
        $data['ack'] = 0;
        $data['msg'] = 'Email not found in our database';
        $app->response->setStatus(200);
    }


    $app->response->write(json_encode($data));
}

function verify_otp(){
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $email = $body->email;
    $otp = $body->otp;

    $db = getConnection();

    try{
        $sql = "SELECT * FROM `users` WHERE `email_address`=:email AND `otp`=:otp";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('otp', $otp);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        if ($rowCount) {
            $data['ack'] = 1;
        } else {
            $data['ack'] = 0;
            $data['msg'] = "Invalid otp!!!";
        }
    } catch(Exception $ex) {
        $data['ack'] = 0;
        $data['msg'] = $ex->getMessage();
        $data['line'] = $ex->getLine();
    }

    $app->response->write(json_encode($data));
}

function verify_change_password(){
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $email = $body->email;
    $password = $body->password;

    $db = getConnection();

    try{
        $sql = "UPDATE `users` SET `user_pass`=md5(:password), `otp`='' WHERE `email_address`=:email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('password', $password);

        if ($stmt->execute()) {
            $data['ack'] = 1;
            $data['msg'] = 'Password changed successfully';
        } else {
            $data['ack'] = 0;
            $data['msg'] = "Failed to change password";
        }
    } catch(Exception $ex) {
        $data['ack'] = 0;
        $data['msg'] = $ex->getMessage();
        $data['line'] = $ex->getLine();
    }

    $app->response->write(json_encode($data));
}

function userprofile() {
    $friendlist = array();
    $data = array();
    $followingList = array();
    $followerList = array();
    $allPortfolios = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;

    try {
        $db = getConnection();


        $sql = "SELECT * FROM users WHERE id=:id ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        // if ($getUserdetails->profile_img != '') {
        //     $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->profile_img;
        // } else {
        //     $profile_image = '';
        // }

        $data['UserDetails'] = array(
            "user_id" => stripslashes($getUserdetails->id),
            "first_name" => stripslashes($getUserdetails->first_name),
            "last_name" => stripslashes($getUserdetails->last_name),
            "date_of_birth" => stripslashes($getUserdetails->date_of_birth),
            "nationality" => stripslashes($getUserdetails->nationality),
            "user_type" => stripslashes($getUserdetails->user_type),
            "email" => stripslashes($getUserdetails->email_address),
            "phone" => stripslashes($getUserdetails->Phone_number),
            "about" => stripslashes($getUserdetails->biography),
            "address" => stripslashes($getUserdetails->address),
            "country" => stripslashes($getUserdetails->country),
            "city" => stripslashes($getUserdetails->city),
            //"profile_image" => stripslashes($profile_image),
            "device_type" => stripslashes($getUserdetails->devicetype),
            "device_token_id" => stripslashes($getUserdetails->deviceid),
            "notification_send" => stripslashes($getUserdetails->notification_send),
            "site_notification" => stripslashes($getUserdetails->site_notification),
            // "date" => stripslashes($getUserdetails->join_date),
            "facebook_link" => stripslashes($getUserdetails->facebook_link),
            "google_link" => stripslashes($getUserdetails->google_link),
        );

        $data['Ack'] = 1;
        $data['msg'] = 'Success';
        $app->response->setStatus(200);


        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function resetpassword() {
    $friendlist = array();
    $data = array();
    $followingList = array();
    $followerList = array();
    $allPortfolios = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    $old_pass = md5($body->old_password);
    $user_pass = md5($body->new_password);

    try {
        $db = getConnection();

        $sql = "SELECT * FROM users WHERE id=:id ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        if ($getUserdetails->user_pass == $old_pass) {

            $sql = "UPDATE users SET user_pass = :user_pass WHERE id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user_id);
            $stmt->bindParam("user_pass", $user_pass);
            $stmt->execute();
            $status = "Success";
            
        }else{
            $status = "Failed";
        }
        

        $data['UserDetails'] = array(
            "user_id" => stripslashes($getUserdetails->id),
            "oldpass" => $old_pass,
            "newpass" => $user_pass,
            "status" => $status
        );

        $data['Ack'] = '1';
        $data['msg'] = 'Success';
        $app->response->setStatus(200);


        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function updateProfilePhoto() {

    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    try {
        $db = getConnection();

        if ($_FILES['profile_image']['tmp_name'] != '') {
            $id = $request->post("user_id");

            $target_path = "../app/webroot/user_image/";

            $userfile_name = $_FILES['profile_image']['name'];
            $userfile_tmp = $_FILES['profile_image']['tmp_name'];
            $image = time() . $userfile_name;
            $img = $target_path . $image;
            move_uploaded_file($userfile_tmp, $img);

            $sqlimg = "UPDATE users SET profile_img=:image WHERE id=:id";
            $stmt1 = $db->prepare($sqlimg);
            $stmt1->bindParam("id", $id);
            $stmt1->bindParam("image", $image);
            $stmt1->execute();


            $sql = "SELECT * FROM users WHERE id=:id ";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->profile_img != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->profile_img;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = array(
                "user_id" => stripslashes($getUserdetails->id),
                "user_type" => stripslashes($getUserdetails->user_type),
                "full_name" => stripslashes($getUserdetails->first_name . " " . $getUserdetails->last_name),
                "email" => stripslashes($getUserdetails->email),
                "phone" => stripslashes($getUserdetails->phone),
                "profile_image" => stripslashes($profile_image),
                "device_type" => stripslashes($getUserdetails->device_type),
                "device_token_id" => stripslashes($getUserdetails->device_token_id),
                "lat" => stripslashes($getUserdetails->lat),
                "lang" => stripslashes($getUserdetails->lang),
                "location" => stripslashes($getUserdetails->address),
                "date" => stripslashes($getUserdetails->join_date));
            $data['id'] = $id;
            $data['Ack'] = '1';
            $data['msg'] = 'Image Added.';
            $app->response->setStatus(200);
        } else {
            $data['id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = 'Image Not Added.';
            $app->response->setStatus(401);
        }

        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Image Not Added. Please Try Again.';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function cuisineListing() {

    $cuisineList = array();
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    $text = $body->text;

    try {
        $db = getConnection();



        $sql = "SELECT * FROM cuisines WHERE id <> ''";
        if ($text != '') {
            $sql .= " AND `name` Like '%" . $text . "%'";
        }
        //	echo $sql;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getcuisinesdetails = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($getcuisinesdetails)) {
            foreach ($getcuisinesdetails as $showCuisine) {

                if ($showCuisine->image != '') {
                    //$cusineImage = SITE_URL . 'upload/cuisin_image/' . $showCuisine->image;
                    $cusineImage = SITE_URL . 'cuisin_image/' . $showCuisine->image;
                } else {
                    $cusineImage = '';
                }



                $cuisineList[] = array(
                    'id' => stripslashes($showCuisine->id),
                    'name' => stripslashes($showCuisine->name),
                    'description' => stripslashes($showCuisine->description),
                    'image' => stripslashes($cusineImage),
                );
            }


            $data['allCusines'] = $cuisineList;
            $app->response->setStatus(200);
            $data['Ack'] = 1;
        } else {
            $data['Ack'] = 0;
            $app->response->setStatus(401);
        }

        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function productListing() {

    $productList = array();
    $proImg = array();
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $restaurant_id = $body->cuisine_id;
    $search_text = $body->text;
    try {
        $db = getConnection();


        // $sql = "SELECT * FROM users WHERE id=:id ";

        if ($search_text == '') {
            $sql = "SELECT * FROM listings WHERE restaurant_id =:restaurant_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("restaurant_id", $restaurant_id);
            $stmt->execute();
            $getfooddetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {


            $sql = "SELECT * FROM listings WHERE restaurant_id =:restaurant_id AND item_tittle LIKE '%" . $search_text . "%'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("cuisine_id", $cuisine_id);
            $stmt->execute();
            $getfooddetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        //print_r($getfooddetails);

        if (!empty($getfooddetails)) {
            foreach ($getfooddetails as $showProduct) {



                // if ($showProduct->image != '') {
                //     $productImage = SITE_URL . 'product_img/' . $showProduct->image;
                // } else {
                //     $productImage = '';
                // }
                //get the images
                // $sql_images = "SELECT * FROM list_images where list_id = '".$showProduct->id."'";
                // $stmt_img = $db->prepare($sql_images);
                // $getfoodimg = $stmt_img->fetchAll(PDO::FETCH_OBJ);
                // if(!empty($getfoodimg)){
                // foreach ($getfoodimg as $showimg) {
                //     if($showimg->image_name != ''){
                //         $image = SITE_URL . 'product_img/'.$showimg->image_name;
                //     }else{
                //         $image = '';
                //     }    
                //       $proImg[] = array(
                //             'id' => $showimg->id,
                //             'image' => $image,
                //         );  
                //     }
                // }

                $sql_images = "SELECT * FROM list_images where list_id = '" . $showProduct->id . "' LIMIT 0,1";
                $stmt_img = $db->query($sql_images);
                $getfoodimg = $stmt_img->fetchObject();
                $getfoodimgCount = $stmt_img->rowCount();


                if ($getfoodimgCount == 0) {
                    $image = SITE_URL . 'webservice/noimg.png';
                } else {
                    $image = SITE_URL . 'product_img/' . $getfoodimg->image_name;
                }







                //Get the categhory name

                $sqlCategory = "SELECT * FROM categories  WHERE id='" . $showProduct->category_id . "'";
                $stmtCategory = $db->prepare($sqlCategory);
                $stmtCategory->execute();
                $getCategory = $stmtCategory->fetchObject();

                //print_r($getCategory);
                //Get the cuisine name
                //   if($getCategory->name != ''){
                //     $catname =   $getCategory->name;
                // }else{
                //   $catname =  '';
                // }

                $sqlCuisine = "SELECT * FROM cuisines  WHERE id=:id";
                $stmtCuisine = $db->prepare($sqlCuisine);
                $stmtCuisine->bindParam("id", $showProduct->cuisine_id);
                $stmtCuisine->execute();
                $getCuisine = $stmtCuisine->fetchObject();


                //Get the cuisine name

                $sqlresturant = "SELECT * FROM cuisines  WHERE id=:id";
                $stmtresturant = $db->prepare($sqlresturant);
                $stmtresturant->bindParam("id", $showProduct->restaurant_id);
                $stmtresturant->execute();
                $getresturant = $stmtresturant->fetchObject();

                $productList[] = array(
                    'id' => stripslashes($showProduct->id),
                    'user_id' => stripslashes($showProduct->user_id),
                    'item_tittle' => stripslashes($showProduct->item_tittle),
                    'description' => strip_tags(stripslashes($showProduct->description)),
                    'creation_date' => stripslashes($showProduct->creation_date),
                    'active' => stripslashes($showProduct->active),
                    'category_id' => stripslashes($showProduct->category_id),
                    //'category_name' => $getCategory->name,
                    'sub_category_id' => stripslashes($showProduct->sub_category_id),
                    // 'sub_category_name' => $productList->sub_category_id,
                    'sub_sub_category_id' => stripslashes($showProduct->sub_sub_category_id),
                    // 'sub_sub_category_name' => $productList->sub_sub_category_id,
                    'item_type' => stripslashes($showProduct->item_type),
                    'price' => stripslashes($showProduct->price),
                    'offer_price' => stripslashes($showProduct->offer_price),
                    'quantity' => stripslashes($showProduct->quantity),
                    'is_featured' => stripslashes($showProduct->is_featured),
                    'meta_title' => stripslashes($showProduct->meta_title),
                    'veg_nonvage' => stripslashes($showProduct->veg_nonvage),
                    'plate' => stripslashes($showProduct->plate),
                    'spicy' => stripslashes($showProduct->spicy),
                    'cuisine_id' => stripslashes($showProduct->cuisine_id),
                    //'cuisine_name'=> $getCuisine->name,
                    'restaurant_id' => stripslashes($showProduct->restaurant_id),
                    //'restaurant_name' => $getresturant->name,
                    'ingredients' => strip_tags(stripslashes($showProduct->ingredients)),
                    'order_type' => stripslashes($showProduct->order_type),
                    'image' => $image
                );
            }

            // die;
            $data['allProducts'] = $productList;
            $app->response->setStatus(200);
            $data['Ack'] = 1;
        } else {
            $data['Ack'] = 0;
            $app->response->setStatus(401);
        }

        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function resturantsListing() {

    $resturantsList = array();
    $proImg = array();
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $cuisine_id = $body->cuisine_id;
    $search_text = $body->text;
    try {
        $db = getConnection();


        // $sql = "SELECT * FROM users WHERE id=:id ";

        if ($search_text == '') {
            $sql = "SELECT * FROM restaurants WHERE FIND_IN_SET(:cuisine_id,`cuisine_id`)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("cuisine_id", $cuisine_id);
            $stmt->execute();
            $getResturantsdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {


            $sql = "SELECT * FROM restaurants WHERE cuisine_id =:cuisine_id AND name LIKE '%" . $search_text . "%'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("cuisine_id", $cuisine_id);
            $stmt->execute();
            $getResturantsdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        //print_r($getfooddetails);

        if (!empty($getResturantsdetails)) {
            foreach ($getResturantsdetails as $showResturants) {

                if ($showResturants->image == '') {
                    $image = SITE_URL . 'webservice/noimg.png';
                } else {
                    $image = SITE_URL . 'restuarent_image/' . $showResturants->image;
                }







                //Get the categhory name

                /* 	$sqlCategory = "SELECT * FROM categories  WHERE id='".$showProduct->category_id."'";
                  $stmtCategory = $db->prepare($sqlCategory);
                  $stmtCategory->execute();
                  $getCategory = $stmtCategory->fetchObject(); */

                //print_r($getCategory);
                //Get the cuisine name
                //   if($getCategory->name != ''){
                //     $catname =   $getCategory->name;
                // }else{
                //   $catname =  '';
                // }

                /* 	$sqlCuisine = "SELECT * FROM cuisines  WHERE id=:id";
                  $stmtCuisine = $db->prepare($sqlCuisine);
                  $stmtCuisine->bindParam("id", $showProduct->cuisine_id);
                  $stmtCuisine->execute();
                  $getCuisine = $stmtCuisine->fetchObject(); */

                $resturantsList[] = array(
                    'id' => stripslashes($showResturants->id),
                    'user_id' => stripslashes($showResturants->user_id),
                    'name' => stripslashes($showResturants->name),
                    'description' => strip_tags(stripslashes($showResturants->description)),
                    'address' => stripslashes($showResturants->address),
                    'opening_time' => stripslashes($showResturants->opening_time),
                    'restuarent_type' => stripslashes($showResturants->restuarent_type),
                    'lat' => stripslashes($showResturants->lat),
                    'lang' => stripslashes($showResturants->lang),
                    'is_featured' => stripslashes($showResturants->is_featured),
                    'phone' => stripslashes($showResturants->phone),
                    'website' => stripslashes($showResturants->website),
                    'image' => $image
                );
            }

            //print_r($resturantsList);
            // die;
            $data['resturantsList'] = $resturantsList;
            $app->response->setStatus(200);
            $data['Ack'] = 1;
        } else {

            $data['resturantsList'] = '';
            $data['Ack'] = 0;
            $app->response->setStatus(200);
        }

        $db = null;
    } catch (PDOException $e) {
        $data['id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function addToCart() {

    $data = array();
    $productList = array();
    $proImg = array();
    $data = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    $product_id = $body->product_id;
    $quantity = $body->quantity;

    try {

        $sql = "SELECT * FROM carts WHERE list_id=:list_id AND user_id=:user_id ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("list_id", $product_id);
        $stmt->execute();
        $product = $stmt->fetchObject();

        $count = $stmt->rowCount();
        if ($count == 0) {

            $sqlproductDetails = "SELECT * FROM listings  WHERE id='" . $product_id . "'";
            $stmtProductDetails = $db->prepare($sqlproductDetails);
            $stmtProductDetails->execute();
            $getProductDetails = $stmtProductDetails->fetchObject();

            $uploder_user_id = $getProductDetails->user_id;
            $time = date('Y-m-d H:i:s');
            $shippingcost = 0;
            $price = $getProductDetails->price;
            $restaurant_id = $getProductDetails->restaurant_id;
            $cuisine_id = $getProductDetails->cuisine_id;
            $category_id = $getProductDetails->category_id;


            $sql = "INSERT INTO carts (user_id, list_id, quantity, uploder_user_id, price,shippingcost,time,cuisine_id,category_id,restaurant_id) VALUES (:user_id, :list_id, :quantity, :uploder_user_id, :price, :shippingcost, :time, :cuisine_id, :category_id, :restaurant_id)";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("list_id", $product_id);
            $stmt->bindParam("quantity", $quantity);
            $stmt->bindParam("uploder_user_id", $uploder_user_id);
            $stmt->bindParam("price", $price);
            $stmt->bindParam("shippingcost", $shippingcost);
            $stmt->bindParam("time", $time);
            $stmt->bindParam("cuisine_id", $cuisine_id);
            $stmt->bindParam("category_id", $category_id);
            $stmt->bindParam("restaurant_id", $restaurant_id);
            $stmt->execute();
            $data['last_id'] = $db->lastInsertId();
            $data['Ack'] = '1';
            $data['msg'] = 'Product Added To Cart';
            $app->response->setStatus(200);
        } else {

            if ($quantity == 0) {
                $sql = "DELETE FROM carts WHERE user_id=:user_id AND list_id=:list_id ";
                //$db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("list_id", $product_id);
                $stmt->execute();
                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Cart Updated';
                $app->response->setStatus(200);
            } else {
                $status = 0;
                $sql = "UPDATE carts SET quantity=:quantity WHERE user_id=:user_id AND list_id=:list_id";
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("list_id", $product_id);
                $stmt->bindParam("quantity", $quantity);
                $stmt->execute();

                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Product Updated Successfully';
                $app->response->setStatus(200);
            }
        }


        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }


    $app->response->write(json_encode($data));
}

function getCart() {
    $data = array();
    $allproducts = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;


    try {

        $sql = "SELECT * FROM carts WHERE user_id=:user_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        $finalPriceSubTotal = 0;
        if ($count > 0) {
            foreach ($getproducts as $products) {

                $productDetails = "select * FROM listings WHERE `id`='" . $products->list_id . "'";
                $stmtProductDetails = $db->query($productDetails);
                $productData = $stmtProductDetails->fetchObject();


                $sql_images = "SELECT * FROM list_images where list_id = '" . $productData->id . "' LIMIT 0,1";
                $stmt_img = $db->query($sql_images);
                $getfoodimg = $stmt_img->fetchObject();
                $getfoodimgCount = $stmt_img->rowCount();


                if ($getfoodimgCount == 0) {
                    $itemImage = SITE_URL . 'webservice/noimg.png';
                } else {
                    $itemImage = SITE_URL . 'product_img/' . $getfoodimg->image_name;
                }


                $finalPrice = ($productData->price * $products->quantity);
                $finalPriceSubTotal = $finalPriceSubTotal + ($productData->price * $products->quantity);

                $restaurant_id = $products->restaurant_id;

                $allproducts[] = array(
                    "id" => stripslashes($productData->id),
                    "name" => stripslashes($productData->item_tittle),
                    "desc" => stripslashes(strip_tags($productData->description)),
                    "quantity" => stripslashes($products->quantity),
                    "unit_price" => stripslashes($productData->price),
                    "total_price" => $finalPrice,
                    "itemImage" => stripslashes($itemImage));
            }

            $sql_resturants = "SELECT `service_charge` FROM restaurants where id = '" . $restaurant_id . "'";
            $stmt_resturants = $db->query($sql_resturants);
            $getresturantsCharge = $stmt_resturants->fetchObject();


            $data['all_cart_products'] = $allproducts;
            $data['sub_total'] = $finalPriceSubTotal;
            $data['delivery_charge'] = $getresturantsCharge->service_charge;
            $data['grand_total'] = $finalPriceSubTotal + $getresturantsCharge->service_charge;

            $data['ACK'] = 1;
            $app->response->setStatus(200);
        } else {

            $data['all_cart_products'] = '';
            $data['ACK'] = 0;
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {

        $data['all_cart_products'] = '';
        $data['ACK'] = 0;
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function removeProductFromCart() {

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $user_id = $body->user_id;
    $product_id = $body->product_id;

    $sql = "DELETE FROM carts WHERE user_id=:user_id AND list_id=:list_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("list_id", $product_id);
        $stmt->execute();
        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Item Removed Successfully';
        $app->response->setStatus(200);
    } catch (PDOException $e) {
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function addetails() {

    $app = \Slim\Slim::getInstance();
    $request = $app->request();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);

    $id = $body->id;
    $sql = "SELECT * FROM products WHERE id=:id ";
    try {
        
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        $sqlqry = "SELECT * FROM product_images WHERE product_id = '$getUserdetails->id'";
        $stmt1 = $db->prepare($sqlqry);
        $stmt1->execute();
        $getprodimgdetails = $stmt1->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt1->rowCount();
        foreach ($getprodimgdetails as $showings) {

            $imgs[] = array(
                'imgs' => stripslashes($showings->originalpath),
            );
        }

        // $data['prodimgs'] = array(
        //     "imgs" => stripslashes($getprodimgdetails->originalpath),
        // );
        $now = time(); // or your date as well
        $your_date = strtotime($getUserdetails->createdby);
        $datediff = $now - $your_date;
        $data['adsDetails'] = array(
            "product_name" => stripslashes($getUserdetails->product_name),
            "slug" => stripslashes($getUserdetails->slug),
            "product_description" => stripslashes($getUserdetails->product_description),
            "location" => stripslashes($getUserdetails->location),
            "city" => stripslashes($getUserdetails->city),
            "country" => stripslashes($getUserdetails->country),
            "price" => stripslashes($getUserdetails->price),
            "phone" => stripslashes($getUserdetails->phone),
            "make" => stripslashes($getUserdetails->make),
            "saleby" => stripslashes($getUserdetails->saleby),
            "trim" => stripslashes($getUserdetails->trim),
            "carcondition" => stripslashes($getUserdetails->carcondition),
            "kilometer" => stripslashes($getUserdetails->kilometer),
            "colors" => stripslashes($getUserdetails->colors),
            "company_name" => stripslashes($getUserdetails->company_name),
            "years" => stripslashes($getUserdetails->years),
            "createdby" => stripslashes($getUserdetails->createdby),
            "lat" => stripslashes($getUserdetails->lat),
            "lon" => stripslashes($getUserdetails->lon),
            "website" => stripslashes($getUserdetails->website),
            "view_count" => stripslashes($getUserdetails->view_count),
            'days' => floor($datediff / (60 * 60 * 24)),
            "images" => $imgs
        );

        $data['Ack'] = '1';
        $data['msg'] = 'Success';
        $app->response->setStatus(200);
    } catch (PDOException $e) {
        
        $data['Ack'] = '0';
        $data['msg'] = $e->getMessage();
        $app->response->setStatus(401);
    }

    $app->response->write(json_encode($data));
}

function serch() {
$data = array();
    $data1 = array();
    $data2 = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();

    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $value = $body->value;

    $productsql = "SELECT * FROM `categories` WHERE category_name LIKE '$value%'";
    try {
        $db = getConnection();
        $stmt = $db->prepare($productsql);
        $stmt->bindParam("value", $value);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            $k = 0;
            foreach ($getproducts as $orders) {

                $categoryimagesql1 = "select * from `products` where `category_id`=" . $orders->id;
                $stmt1 = $db->prepare($categoryimagesql1);
                $stmt1->execute();
                $getUserdetails5 = $stmt1->rowCount();

                $data1['parent'][] = array(
                    'category_name' => $orders->category_name, 
                    'id' => $orders->id,
                    'count' => $getUserdetails5,
                );
            }
            $data['msg'] = 'Category List';
            $data['Ack'] = 1;
            $data['all_products'] = $data1;
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(200);
    }
    $app->response->write(json_encode($data));
}

function getOrderList() {
    $data = array();
    $allorders = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $user_id = $body->user_id;

    try {

        $sql = "SELECT * FROM orders WHERE user_id=:user_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {

                /* 	if ($products->status == "0") {
                  $order_status = "Processing Order";
                  }
                  if ($products->status == "1") {
                  $order_status = "Delivered";
                  }
                  if ($products->status == "2") {
                  $order_status = "Completed";
                  } */

                //$tans_id=$products->order_from_device.$products->unique_trans_id;


                $allorders[] = array(
                    "id" => stripslashes($orders->id),
                    "total_amount" => stripslashes($orders->total_amount),
                    "transaction_id" => stripslashes($orders->transaction_id),
                    "order_date" => stripslashes($orders->order_date));
            }
            $data['allorders'] = $allorders;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        } else {
            $data['allorders'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['allorders'] = '';
        $data['ACK'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function getOederDetails() {
    $data = array();
    $allproducts = array();

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $order_id = $body->order_id;


    try {

        $sql = "SELECT * FROM order_details WHERE order_id=:order_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("order_id", $order_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $orders) {

                $productDetails = "select * FROM listings WHERE `id`='" . $orders->list_id . "'";
                $stmtProductDetails = $db->query($productDetails);
                $productData = $stmtProductDetails->fetchObject();

                $sql_images = "SELECT * FROM list_images where list_id = '" . $productData->id . "' LIMIT 0,1";
                $stmt_img = $db->query($sql_images);
                $getfoodimg = $stmt_img->fetchObject();
                $getfoodimgCount = $stmt_img->rowCount();


                if ($getfoodimgCount == 0) {
                    $itemImage = SITE_URL . 'webservice/noimg.png';
                } else {
                    $itemImage = SITE_URL . 'product_img/' . $getfoodimg->image_name;
                }




                $allproducts[] = array(
                    "id" => stripslashes($orders->id),
                    "name" => stripslashes($productData->item_tittle),
                    "price" => stripslashes($orders->price),
                    "quantity" => stripslashes($orders->quantity),
                    "total_amount" => stripslashes($orders->amount),
                    "order_status" => stripslashes($orders->order_status),
                    "itemImage" => stripslashes($itemImage));
            }

            $sql = "SELECT * FROM orders WHERE id=:id ";
            //$db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $order_id);
            $stmt->execute();
            $orderUserdetails = $stmt->fetchObject();

            $billing_id = $orderUserdetails->billing_id;

            $sqlBilling = "SELECT * FROM billings  WHERE id='" . $billing_id . "'";
            $stmtBilling = $db->prepare($sqlBilling);
            $stmtBilling->execute();
            $getBillingDetails = $stmtBilling->fetchObject();

            $data['order_details'] = array(
                "order_id" => stripslashes($orderUserdetails->id),
                "total_amount" => stripslashes($orderUserdetails->total_amount),
                "order_date" => stripslashes($orderUserdetails->order_date),
                "fname" => stripslashes($getBillingDetails->fname),
                "lname" => stripslashes($getBillingDetails->lname),
                "phone" => stripslashes($getBillingDetails->phone),
                "email" => stripslashes($getBillingDetails->email),
                "address1" => stripslashes($getBillingDetails->address1),
                "zip" => stripslashes($getBillingDetails->zip),
                "address2" => stripslashes($getBillingDetails->address2),
                "shipping_address1" => stripslashes($getBillingDetails->shipping_address1),
                "shipping_address2" => stripslashes($getBillingDetails->shipping_address2));


            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
            $app->response->setStatus(200);
        } else {
            $data['all_products'] = '';
            $data['order_details'] = '';
            $data['Ack'] = 2;
            $data['msg'] = 'No Records Found';
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function adsdetails() {
    $data = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $slug = $body->slug;
    $productsql = "select p.*, c.category_name cat_name, sc.category_name subcat_name from `products` p "
            . "LEFT JOIN `categories` c "
            . "ON p.category_id = c.id "
            . "LEFT JOIN `categories` sc "
            . "ON p.sub_category_id = sc.id "
            . "WHERE `p`.`slug`='$slug'";
    try {
        $db = getConnection();
        $stmt = $db->prepare($productsql);
        //$stmt->bindParam("slug", $slug);
        $stmt->execute();
        $getproducts = $stmt->fetchObject();

        $count = $stmt->rowCount();
        if ($count > 0) {
            $sqlval1 = "SELECT * FROM `product_images` WHERE `product_id`='{$getproducts->id}'";
            $stmt4 = $db->prepare($sqlval1);
            $stmt4->execute();
            $getUserdetails4 = $stmt4->fetchAll(PDO::FETCH_OBJ);
            $data['Ack'] = 1;

            $data['productdetails'] = $getproducts;
            $data['productimage'] = $getUserdetails4;
        }
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(401);
    }
    $app->response->write(json_encode($data));
}

function categorylist() {
    $data = array();
    $data1 = array();
    $data2 = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();
    $imageurl = "http://111.93.169.90/team4/Kijiji/img/cat_img/";
    $productsql = "select * from `categories` where parent_id=0";
    try {
        $db = getConnection();
        $stmt = $db->prepare($productsql);
        //$stmt->bindParam("slug", $slug);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            $k = 0;
            foreach ($getproducts as $orders) {
                $categoryimagesql = "select * from `category_images` where `category_id`=" . $orders->id . " limit 0,1";
                $stmt3 = $db->prepare($categoryimagesql);
                $stmt3->execute();
                $getUserdetails4 = $stmt3->fetchObject();
                
                if (empty($getUserdetails4)) {
                    $image = 'http://111.93.169.90/team4/Kijiji/images/no_image.png';
                    $appimage = 'http://111.93.169.90/team4/Kijiji/images/no_image.png';
                } else {
                    $image = ($getUserdetails4->originalpath != '' ? $imageurl.$getUserdetails4->originalpath : 'http://111.93.169.90/team4/Kijiji/images/no_image.png');
                    $appimage = ($getUserdetails4->resizepath != '' ? $imageurl.$getUserdetails4->resizepath : 'http://111.93.169.90/team4/Kijiji/images/no_image.png');
                }
                $categoryimagesql1 = "select * from `products` where `category_id`=" . $orders->id;
                $stmt1 = $db->prepare($categoryimagesql1);
                $stmt1->execute();
                $getUserdetails5 = $stmt1->rowCount();
                $data1['parent'][] = array('category_name' => $orders->category_name, 'id' => $orders->id, 'image' => $image, 'count' => $getUserdetails5, 'appimage' => $appimage);
            }
            $data['msg'] = 'Category List';
            $data['Ack'] = 1;
            $data['all_products'] = $data1;
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(200);
    }
    $app->response->write(json_encode($data));
}

function categorylistdetails() {
    $imageurl = "http://111.93.169.90/team4/Kijiji/img/cat_img/";
    $data = array();
    $data1 = array();
    $data2 = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $categoryid = $body->id;
    $productsql = "select * from `categories` where parent_id=" . $categoryid;
    try {
        $db = getConnection();
        $stmt = $db->prepare($productsql);
        //$stmt->bindParam("slug", $slug);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            $k = 0;
            foreach ($getproducts as $orders) {
                $categoryimagesql = "select * from `category_images` where `category_id`=" . $orders->id . " limit 0,1";
                $stmt3 = $db->prepare($categoryimagesql);
                $stmt3->execute();
                $getUserdetails4 = $stmt3->fetchObject();
                if (empty($getUserdetails4)) {
                    $image = 'http://111.93.169.90/team4/Kijiji/images/no_image.png';
                } else {
                    $image = $imageurl . $getUserdetails4->originalpath;
                }
                $categoryimagesql1 = "select * from `products` where `sub_category_id`=" . $orders->id;
                $stmt1 = $db->prepare($categoryimagesql1);
                $stmt1->execute();
                $getUserdetails5 = $stmt1->rowCount();
                $data1['child'][] = array('category_name' => $orders->category_name, 'id' => $orders->id, 'image' => $image, 'count' => $getUserdetails5);
            }
            $data['msg'] = 'Sub Category LIst';
            $data['Ack'] = 1;
            $data['catid'] = $categoryid;
            $data['all_products'] = $data1;
            $app->response->setStatus(200);
        }
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(200);
    }
    $app->response->write(json_encode($data));
}

function categorydetails(){
    $imageurl = "http://111.93.169.90/team4/Kijiji/img/cat_img/";
    $data = array();
    $data1 = array();
    $data2 = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $categoryid = $body->id;
    $productsql = "select * from `categories` where id=" . $categoryid;
    try {
        $db = getConnection();
        $stmt = $db->prepare($productsql);
        
        $stmt->execute();
        $getproducts = $stmt->fetchObject();

        $categoryimagesql = "select * from `category_images` where `category_id`=" . $getproducts->id . " limit 0,1";
        $stmt3 = $db->prepare($categoryimagesql);
        $stmt3->execute();
        $getUserdetails4 = $stmt3->fetchObject();


        if (empty($getUserdetails4)) {
            $image = 'http://111.93.169.90/team4/Kijiji/images/no_image.png';
            $appimage = 'http://111.93.169.90/team4/Kijiji/images/no_image.png';
        } else {
            $image = ($getUserdetails4->originalpath != '' ? $imageurl.$getUserdetails4->originalpath : 'http://111.93.169.90/team4/Kijiji/images/no_image.png');
            $appimage = ($getUserdetails4->resizepath != '' ? $imageurl.$getUserdetails4->resizepath : 'http://111.93.169.90/team4/Kijiji/images/no_image.png');
        }
        
        $data1 = array('category_name' => $getproducts->category_name, 'id' => $getproducts->id, 'image' => $image, 'appimage' => $appimage);
            
        $data['msg'] = 'Sub Category LIst';
        $data['Ack'] = 1;
        $data['catdet'] = $data1;
        $app->response->setStatus(200);

    } catch (PDOException $e) {
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
        $app->response->setStatus(200);
    }
    $app->response->write(json_encode($data));
}

function gplogin() {
    $app = \Slim\Slim::getInstance();
    $data = array();
    $db = getConnection();
    $request = $app->request();
    $getBody = $request->getBody();
    $body = json_decode($getBody);

    $fb_id = $body->id;

    $sql = "SELECT * FROM users WHERE gp_id = :gp_id";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam('gp_id', $fb_id);
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        if ($rowCount) {
            $obj = $stmt->fetchObject();

            $data['ack'] = 1;
            $data['email'] = $obj->email_address;
            $data['id'] = $obj->id;
        } else {
            $data['ack'] = 0;
        }
    } catch (Exception $ex) {
        $data['ack'] = 0;
        $data['error'] = $ex->getMessage();
        $data['line'] = $ex->getLine();
    }

    $db = NULL;
    $app->response->write(json_encode($data));
}

function gpsignup() {
    $data = array();
    $allproducts = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $getBody = $request->getBody();
    $body = json_decode($getBody);
    $first_name = isset($body->fname) ? $body->fname : '';
    $last_name = isset($body->lname) ? $body->lname : '';
    $email = isset($body->email) ? $body->email : '';
    $gpid = isset($body->gpid) ? $body->gpid : '';
    $join_date = date('Y-m-d H:i:s');
    $db = getConnection();
    $sql = "SELECT * FROM users WHERE  `email_address`=:email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $usersCount = $stmt->rowCount();

    if ($usersCount == 0) {
        $sql = "INSERT INTO users (`first_name`,`last_name`,`email_address`,`gp_id`) VALUES (:first_name, :last_name, :email, :password)";
        try {

            $stmt = $db->prepare($sql);
            $stmt->bindParam("first_name", $first_name);
            $stmt->bindParam("last_name", $last_name);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("password", $gpid);
            $stmt->execute();

            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Registered Successfully...';


            $sql = "SELECT * FROM users WHERE id=:id ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $lastID);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

            if ($getUserdetails->user_logo != '') {
                $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->user_logo;
            } else {
                $profile_image = '';
            }

            $data['UserDetails'] = $getUserdetails;

            $to = $email;

            $subject = "yabbelah- Thank you for registering";
            $TemplateMessage = "Wellcome and thank you for registering at yabbelah.com!<br />";
            $TemplateMessage .= "Your account has now been created and you can login using your email address and password.<br />";

            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "yabbelah.com<br />";

            $header = "From:info@yabbelah.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);

            $app->response->setStatus(200);

            $db = null;
        } catch (PDOException $e) {
            $data['user_id'] = '';
            $data['Ack'] = '0';
            $data['msg'] = 'Registration Error !!!';
            $app->response->setStatus(200);
        }
    } else {
        $obj = $stmt->fetchObject();
        $sql1 = "update `users` set gp_id='" . $gpid . "' where id=" . $obj->id;
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $obj->id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        if ($getUserdetails->user_logo != '') {
            $profile_image = SITE_URL . 'upload/user_image/' . $getUserdetails->user_logo;
        } else {
            $profile_image = '';
        }

        $data['UserDetails'] = $getUserdetails;
        $data['Ack'] = '1';
        $data['msg'] = 'Registered Successfully...';
        $app->response->setStatus(200);
    }

    $app->response->write(json_encode($data));
}

function fetchcategory() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    try {
        $sql1 = "SELECT * FROM categories WHERE `parent_id`= 0";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getfooddetails = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['categorylist'] = $getfooddetails;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Category Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function fetchsubcategory() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();


    $id = $body->id;

    try {
        $sql1 = "SELECT * FROM categories WHERE `parent_id`= '" . $id . "'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getfooddetailscat = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['subcategorylist'] = $getfooddetailscat;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Sub Category Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

//function createSlug($string, $id = null) {
//    $slug = Inflector::slug($string, '-');
//    $slug = strtolower($slug);
//    $i = 0;
//    $params = array();
//    $params ['conditions'] = array();
//    $params ['conditions'][$this->name . '.slug'] = $slug;
//    if (!is_null($id)) {
//        $params ['conditions']['not'] = array($this->name . '.id' => $id);
//    }
//    while (count($this->find('all', $params))) {
//        if (!preg_match('/-{1}[0-9]+$/', $slug)) {
//            $slug .= '-' . ++$i;
//        } else {
//            $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
//        }
//        $params ['conditions'][$this->name . '.slug'] = $slug;
//    }
//    return $slug;
//}

function addjob() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $app->request->post();


    //echo "<pre>";
    //print_r($body);
    //exit;

    $registrstion_date = date('Y-m-d H:i:s');


    //// Common Section


    if (isset($body['user_id']) && $body['user_id'] != '') {
        $user_id = $body['user_id'];
    } else {
        $user_id = '';
    }


    if (isset($body['title']) && $body['title'] != '') {
        $title = $body['title'];
    } else {
        $title = '';
    }

    $slug = strtolower($title);



    if (isset($body['description']) && $body['description'] != '') {
        $description = $body['description'];
    } else {
        $description = '';
    }

    if (isset($body['category']) && $body['category'] != '') {
        $category = $body['category'];
    } else {
        $category = '';
    }

    if (isset($body['subcategory']) && $body['subcategory'] != '') {
        $subcategory = $body['subcategory'];
    } else {
        $subcategory = '';
    }


    if (isset($body['youtube_url']) && $body['youtube_url'] != '') {
        $youtube_url = $body['youtube_url'];
    } else {
        $youtube_url = '';
    }

    if (isset($body['website']) && $body['website'] != '') {
        $website = $body['website'];
    } else {
        $website = '';
    }


    //////for Job



    if (isset($body['jobtype']) && $body['jobtype'] != '') {
        $jobtype = $body['jobtype'];
    } else {
        $jobtype = '';
    }

    if (isset($body['offerdby']) && $body['offerdby'] != '') {
        $offerdby = $body['offerdby'];
    } else {
        $offerdby = '';
    }

    if (isset($body['company']) && $body['company'] != '') {
        $company = $body['company'];
    } else {
        $company = '';
    }



    /////for Car

    if (isset($body['make']) && $body['make'] != '') {
        $make = $body['make'];
    } else {
        $make = '';
    }

    if (isset($body['model']) && $body['model'] != '') {
        $model = $body['model'];
    } else {
        $model = '';
    }

    if (isset($body['trim']) && $body['trim'] != '') {
        $trim = $body['trim'];
    } else {
        $trim = '';
    }

    if (isset($body['vin']) && $body['vin'] != '') {
        $vin = $body['vin'];
    } else {
        $vin = '';
    }

    if (isset($body['adtype']) && $body['adtype'] != '') {
        $adtype = $body['adtype'];
    } else {
        $adtype = '';
    }

    if (isset($body['saleby']) && $body['saleby'] != '') {
        $saleby = $body['saleby'];
    } else {
        $saleby = '';
    }

    if (isset($body['bodytype']) && $body['bodytype'] != '') {
        $bodytype = $body['bodytype'];
    } else {
        $bodytype = '';
    }

    if (isset($body['year']) && $body['year'] != '') {
        $year = $body['year'];
    } else {
        $year = '';
    }

    if (isset($body['condition']) && $body['condition'] != '') {
        $condition = $body['condition'];
    } else {
        $condition = '';
    }

    if (isset($body['kilometer']) && $body['kilometer'] != '') {
        $kilometer = $body['kilometer'];
    } else {
        $kilometer = 0;
    }

    if (isset($body['transmission']) && $body['transmission'] != '') {
        $transmission = $body['transmission'];
    } else {
        $transmission = '';
    }

    if (isset($body['drivetrain']) && $body['drivetrain'] != '') {
        $drivetrain = $body['drivetrain'];
    } else {
        $drivetrain = '';
    }

    if (isset($body['color']) && $body['color'] != '') {
        $color = $body['color'];
    } else {
        $color = '';
    }

    if (isset($body['fule']) && $body['fule'] != '') {
        $fule = $body['fule'];
    } else {
        $fule = '';
    }

    if (isset($body['doors']) && $body['doors'] != '') {
        $doors = $body['doors'];
    } else {
        $doors = '';
    }

    if (isset($body['seats']) && $body['seats'] != '') {
        $seats = $body['seats'];
    } else {
        $seats = '';
    }

    if (isset($body['price']) && $body['price'] != '') {
        $price = $body['price'];
    } else {
        $price = '0.00';
    }

    if (isset($body['carcc']) && $body['carcc'] != '') {
        $carcc = $body['carcc'];
    } else {
        $carcc = '';
    }




//    $address = $address; // Google HQ
//    $prepAddr = str_replace(' ', '+', $address);
//    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
//    $output = json_decode($geocode);
//    $latitude = $output->results[0]->geometry->location->lat;
//    $longitude = $output->results[0]->geometry->location->lng;

    $db = getConnection();
    try {

        $sql = "INSERT INTO `products`(`user_id`, `product_name`, `product_description`, `category_id`,`sub_category_id`,`jobtype`,`offerdby`,`company`,`youtube_url`,`website`,`make`,`models`,`trim`,`vin`,`adtype`,`saleby`,`bodytype`,`years`,`carcondition`,`kilometer`,`transmission`,`drivetrain`,`colors`,`fule`,`doors`,`seats`,`price`,`car_cc`,`ad_type`,`createdby`,`slug`) VALUES ('" . $user_id . "','" . $title . "','" . $description . "','" . $category . "','" . $subcategory . "','" . $jobtype . "','" . $offerdby . "','" . $company . "','" . $youtube_url . "','" . $website . "','" . $make . "','" . $model . "','" . $trim . "','" . $vin . "','" . $adtype . "','" . $saleby . "','" . $bodytype . "','" . $year . "','" . $condition . "','" . $kilometer . "','" . $transmission . "','" . $drivetrain . "','" . $color . "','" . $fule . "','" . $doors . "','" . $seats . "','" . $price . "','" . $carcc . "','" . $adtype . "','" . $registrstion_date . "','" . $slug . "')";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $lastId = $db->lastInsertId();

        if ($lastId) {
            if (isset($_FILES["image"])) {
                $i = 0;
                foreach ($_FILES['image']['tmp_name'] as $key => $file) {
                    if (isset($_FILES["image"]["name"][$key])) {
                        $time = time();
                        $img = $time . "_" . $_FILES["image"]["name"][$key];
                        $imagepath = '/var/www/html/team4/Kijiji/app/webroot/img/cat_img/' . $img;

                        if (move_uploaded_file($_FILES["image"]["tmp_name"][$key], $imagepath)) {
                            $sql1 = "INSERT INTO `product_images` " . "SET `product_id`='" . $lastId . "',`originalpath`=:img,`resizepath`=:img";
                            $stmt1 = $db->prepare($sql1);
                            $stmt1->bindParam('img', $img);
                            $stmt1->execute();
                        }
                    }
                    $i++;
                }
            }
        }

        $sql = "SELECT * FROM product_images WHERE product_id=:id order by id DESC LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $lastId);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();





        $data['ack'] = 1;
        $data['id'] = $lastId;
        $data['image'] = 'http://192.168.1.118/team4/Kijiji/img/cat_img/' . $getUserdetails->originalpath;
        $data['msg'] = 'Successfully job added';
    } catch (PDOException $ex) {
        $data['ack'] = 0;
        $data['msg'] = $ex->getMessage();
    }

    $app->response->write(json_encode($data));
}

function getcountry() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    try {
        $sql1 = "SELECT * FROM states WHERE `country_id`= '38'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $countrylist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['countrylist'] = $countrylist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No State Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function getcity() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();

    $stateid = $body->id;


    try {
        $sql1 = "SELECT * FROM cities WHERE `state_id`= '" . $stateid . "'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $citieslist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['citieslist'] = $citieslist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No City Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function updatejob() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $app->request->post();


    //echo "<pre>";
    //print_r($body);
    //exit;

    $registrstion_date = date('Y-m-d h:m:s');


    if (isset($body['country']) && $body['country'] != '') {
        $country = $body['country'];
    } else {
        $country = '';
    }


    if (isset($body['city']) && $body['city'] != '') {
        $city = $body['city'];
    } else {
        $city = '';
    }

    if (isset($body['address']) && $body['address'] != '') {
        $address = $body['address'];
    } else {
        $address = '';
    }

    if (isset($body['postcode']) && $body['postcode'] != '') {
        $postcode = $body['postcode'];
    } else {
        $postcode = '';
    }

    if (isset($body['email']) && $body['email'] != '') {
        $email = $body['email'];
    } else {
        $email = '';
    }


    if (isset($body['phone']) && $body['phone'] != '') {
        $phone = $body['phone'];
    } else {
        $phone = '';
    }

    if (isset($body['post_id']) && $body['post_id'] != '') {
        $post_id = $body['post_id'];
    } else {
        $post_id = '';
    }





    $address = $address; // Google HQ
    $prepAddr = str_replace(' ', '+', $address);
    $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    $output = json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    $db = getConnection();
    try {

        $sql = "update `products` set state_id='" . $country . "',city_id='" . $city . "',email='" . $email . "',phone='" . $phone . "',postcode='" . $postcode . "',location='" . $address . "',location='" . $address . "',lat='" . $latitude . "',lon='" . $longitude . "' where id=" . $post_id;

        $stmt = $db->prepare($sql);

        $stmt->execute();





        $data['ack'] = 1;
        $data['msg'] = 'Successfully job added';
    } catch (PDOException $ex) {
        $data['ack'] = 0;
        $data['msg'] = $ex->getMessage();
    }

    $app->response->write(json_encode($data));
}

function fetchmake() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    try {
        $sql1 = "SELECT * FROM makes WHERE 1";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getmakelist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['getmakelist'] = $getmakelist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Make Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function fetchbodytype() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();
    try {
        $sql1 = "SELECT * FROM products WHERE 1";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getmakelist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['getmakelist'] = $getmakelist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Make Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function fetchmodel() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();

    $id = $body->id;


    try {
        $sql1 = "SELECT * FROM models WHERE makes_id='" . $id . "'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getmodellist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['getmodellist'] = $getmodellist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Model Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

function fetchsubcategorymake() {
    $data = array();
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body2 = $app->request->getBody();
    $body = json_decode($body2);
    $db = getConnection();


    $id = $body->id;

    try {
        $sql1 = "SELECT * FROM makes WHERE `sub_category_id`='" . $id . "'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();
        $usersCount1 = $stmt1->rowCount();
        $getmakelist = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $homeproduct = array();

        $data['getmakelist'] = $getmakelist;
        $data['ack'] = 1;
        $db = null;
    } catch (PDOException $e) {
        $data['ack'] = 0;
        $data['msg'] = 'No Make Found';

        $app->response->setStatus(401);
    }
    $app->response->setStatus(200);
    $app->response->write(json_encode($data));
}

$app->run();
?>