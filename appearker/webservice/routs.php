<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Authorization, Accept');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS,HEAD');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require ('./vendor/autoload.php');
$app = new \Slim\Slim(array(
    'debug' => true
        ));

class AllCapsMiddleware extends \Slim\Middleware {

    public function call() {
        // Get reference to application
        $app = $this->app;

        $req = $app->request;

        //print_r($req);exit;
        // Run inner middleware and application
        $this->next->call();

        // Capitalize response body

        $res = $app->response;
        //$body = $res->getBody();
        if ($req->headers->get('Token') != "123456") {
            $res->setStatus(401);
            $res->setBody("{\"msg\":\"not authorised\"}");
        }
    }

}

$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);

$app->add($cors);



//$app->add(new \CorsSlim\CorsSlim());
//$app->add(new \AllCapsMiddleware());
//$app->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$app->response->headers->set('Content-Type', 'application/json');


$app->group('/api', function () use ($app) {
    $app->get('/test(/:name)', "test");

    //$app->post('/test1', "sample");
    //$app->get('/testpush', 'testpush');
    //$app->post('/getChatUsers', "getChatUsers");
    $app->post('/productListing', 'productListing');
    $app->post('/cuisineListing', 'cuisineListing');
    $app->post('/resturantsListing', 'resturantsListing');
});


$app->group('/users', function () use ($app) {
    $app->post('/login', 'login');
    $app->post('/signup', 'signup');
    $app->post('/mylisting', 'mylisting');
    $app->post('/myfavourite', 'myfavourite');
    $app->post('/profile_info', 'profile_info');
    $app->post('/profile_info_save', 'profile_info_save');
    $app->get('/country_list', 'country_list');
    $app->post('/state_list', 'state_list');
    $app->post('/image_upload', 'image_upload');
    
    
    
    
    
    $app->post('/gplogin', 'gplogin');
    $app->post('/gpsignup', 'gpsignup');
    $app->post('/categorylist', 'categorylist');
    $app->post('/categorylistdetails', 'categorylistdetails');
    $app->post('/categorydetails', 'categorydetails');
    
    $app->post('/userdetail', 'userdetail');
    
    $app->post('/adsdetails', 'adsdetails');
    $app->post('/homewebservice', 'homewebservice');
    $app->post('/homecarlist', 'homecarlist');
    $app->post('/forgetpassword', 'forgetpassword');
    $app->post('/verify_otp', 'verify_otp');
    $app->post('/verify_change_password', 'verify_change_password');
    $app->post('/userprofile', 'userprofile');
    $app->post('/resetpassword', 'resetpassword');
    $app->post('/updateProfilePhoto', 'updateProfilePhoto');
    $app->post('/logout', 'logout');
    $app->post('/addToCart', 'addToCart');
    $app->post('/getCart', 'getCart');
    $app->post('/removeProductFromCart', 'removeProductFromCart');
    $app->post('/getOrderList', 'getOrderList');
    $app->post('/getOederDetails', 'getOederDetails');
    $app->post('/settings', 'settings');
    $app->post('/serch', 'serch');
    $app->post('/getserchres', 'getserchres');
});

$app->group('/ads', function () use ($app) {
    $app->post('/addetails', 'addetails');
});

$app->group('/jobs', function () use ($app) {
    $app->post('/fetchcategory', 'fetchcategory');
    $app->post('/fetchsubcategory', 'fetchsubcategory');
    $app->post('/addjob', 'addjob');
    $app->post('/getcountry', 'getcountry');
    $app->post('/getcity', 'getcity');
    $app->post('/updatejob', 'updatejob');
    
    $app->post('/totalproduct', 'totalproduct');
    
    $app->post('/fetchmake', 'fetchmake');
    $app->post('/fetchfilterproduct', 'fetchfilterproduct');
    $app->post('/fetchbodytype', 'fetchbodytype');
    $app->post('/fetchmodel', 'fetchmodel');
    $app->post('/fetchsubcategorymake', 'fetchsubcategorymake');
});
?>