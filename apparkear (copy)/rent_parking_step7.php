<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}
if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: $location");   
}

if($_SESSION['add_session'] != 2 && $_SESSION['six']==''){  
    $location = SITE_URL;
    header("Location: $location");   
}

include("include/header.php");
 ?>
<?php 


if($_SESSION['user_id'] == ''){  
    $location = SITE_URL;
    header("Location: index.php");
    
}

$parking_id = $_SESSION['new_parking'];
//echo "moi";
if($parking_id != ""){
    $get_details = mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$parking_id}"));
    $co_ownerid = $get_details->co_ownerid;
    
    $get_co_owner_details =  mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `coowner` WHERE `id`={$co_ownerid}"));
    $fname = $get_co_owner_details->fname;
    $lname = $get_co_owner_details->lname;
    $email = $get_co_owner_details->email;
    
}else{
    $fname = "";
    $lname = "";
    $email = "";
    $co_ownerid = "";
}

?>
<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Add a Co-owner</h4>
                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div" method="post" action="ajax_coowner.php">

                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">First Name:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="First Name" name="fname" type="text" value="<?php echo $fname; ?>">
                                                    <input class="form-control" name="co_ownerid" value="<?php echo $$co_ownerid; ?>" type="hidden">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Last Name:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Last Name" name="lname" type="text" value="<?php echo $lname; ?>">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right"> Email:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Email" name="email" type="email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                    <div class="row ml-2">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" href="rent_parking_step6.php">Back</a>
                                                    
                                                </div>
                                                <div class="col-sm-5">
                                                    <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" name="submit" value="Submit" />
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-6">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" href="rent_parking_step6.php">Skip</a>
                                                </div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-3 hints">
                                    <img src="images/hints.png">
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
           </div>
           <div class="col-md-2">              
            </div>
       </div>
   </div>
  <?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>