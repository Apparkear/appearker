<?php
require_once "administrator/includes/config.php";
require_once "include/helpers.php";

include "include/header.php";


$searchQuery = "SELECT `parking`.* ,`parking_images`.`image` as `parking_image` FROM `parking` LEFT JOIN `parking_images` ON `parking_images`.`parking_id`= `parking`.`id` ORDER by `parking`.`id` DESC limit 0,5";
$resultAll = mysqli_query($link, $searchQuery);
//while ($row_parking = mysqli_fetch_object($resultAll)) {
//   // print_r($row_parking);
//    
//}
//exit;

?>
<section class="help">
    <div class="">
        <div class="help text-center">
            <form class="example" action="javascript:void(0)" style="margin:auto;max-width:40%">
                <input name="location" id="location" type="text" placeholder="Search..." onFocus="geolocate()">                      
                <input type="hidden" name="lat" id="lat" value=""/>
                <input type="hidden" name="lon" id="lon" value=""/>    
                <button class="search_explore" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>           
    </div>
</section>
<section class="container py-5">
    <div class="message-body html_append">
    </div>
    <div class="message-body html_hide">
        <?php while ($row_parking = mysqli_fetch_object($resultAll)) { 
            //print_r($eachrow); 
            if ($row_parking->parking_image == '') {
                $img_parking = './upload/parking.jpg';
            } else {
                $img_parking = './upload/parking/' . $row_parking->parking_image;
            }
        ?> 
        <div class="row explore-sec border-bottom p-3 m-3">
            <div class="col-md-3">
                <img src="<?php echo $img_parking; ?>">
            </div>
            <div class="col-md-7">
                <h3><?php echo $row_parking->name; ?></h3>
                <h5><?php echo $row_parking->address; ?></h5>
                <h5>KM: 3.5</h5>
                <p>25 reviews</p>
                <a href="#" class="btn btn-primary">Car Park</a>
            </div>
            <div class="col-md-2 d-flex justify-content-between" style="flex-direction: column">
                <div class="">
                    <a href="#"><i class="ion-checkmark-circled"></i></a>
                    <a href="#"><i class="ion-ios-heart-outline"></i></a>
                </div>
        <h5 class="mt-4 text-baseline"><?php if($row_parking->currency == "usd"){ ?>$<?php } ?><?php echo $row_parking->price; ?>/<?php if($row_parking->price_rate_type == "per month"){ ?>Month<?php  } ?></h5>
            </div>
        </div>
        <?php } ?>

<!--        <div class="row explore-sec border-bottom p-3 m-3">
            <div class="col-md-3">
                <img src="./images/explore-img2.png">
            </div>
            <div class="col-md-7">
                <h3>City Center 2, Newtown</h3>
                <h5>KM: 3.5</h5>
                <p>25 reviews</p>
                <a href="#" class="btn btn-primary">Car Park</a>
            </div>
            <div class="col-md-2 d-flex justify-content-between" style="flex-direction: column">
                <div class="">
                    <a href="#"><i class="ion-checkmark-circled"></i></a>
                    <a href="#"><i class="ion-ios-heart-outline"></i></a>
                </div>
                <h5 class="mt-4 text-baseline">$15/Month</h5>
            </div>
        </div>

        <div class="row explore-sec border-bottom p-3 m-3">
            <div class="col-md-3">
                <img src="./images/explore-img3.png">
            </div>
            <div class="col-md-7">
                <h3>City Center 2, Newtown</h3>
                <h5>KM: 3.5</h5>
                <p>25 reviews</p>
                <a href="#" class="btn btn-primary">Car Park</a>
            </div>
            <div class="col-md-2 d-flex justify-content-between" style="flex-direction: column">
                <div class="">
                    <a href="#"><i class="ion-checkmark-circled"></i></a>
                    <a href="#"><i class="ion-ios-heart-outline"></i></a>
                </div>
                <h5 class="mt-4 text-baseline">$15/Month</h5>
            </div>
        </div>

        <div class="row explore-sec p-3 m-3">
            <div class="col-md-3">
                <img src="./images/explore-img4.png">
            </div>
            <div class="col-md-7">
                <h3>City Center 2, Newtown</h3>
                <h5>KM: 3.5</h5>
                <p>25 reviews</p>
                <a href="#" class="btn btn-primary">Car Park</a>
            </div>
            <div class="col-md-2 d-flex justify-content-between" style="flex-direction: column">
                <div class="">
                    <a href="#"><i class="ion-checkmark-circled"></i></a>
                    <a href="#"><i class="ion-ios-heart-outline"></i></a>
                </div>
                <h5 class="mt-4 text-baseline">$15/Month</h5>
            </div>
        </div>-->
            
    </div>
</section>

<?php
include "include/footer.php";
?>
<script>
    $(document).ready(function(){
        $(".search_explore").click(function(){
            var lat= $("#lat").val();
            var lon= $("#lon").val();
            var location= $("#location").val();
            $.ajax({
              type:"post",  
              url:"ajax_explore.php",
              data:{lat:lat,lon:lon,location:location},
              dataType: 'json',
              success:function(data){
                  console.log(data);
                  $(".html_hide").hide();
                  if(data.res != ""){
                    $(".html_append").html(data.res);
                  }else{
                    $(".html_append").html("<p>No Data Found</p>");  
                  }
              }
            });
        });
    });
</script>
<script>
        
        var placeSearch, autocomplete1;
//        var componentForm = {
//          
//        };

        function initAutocomplete() {        
           autocomplete1 = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */
            (document.getElementById('location')),
                    {types: ['geocode']});

            autocomplete1.addListener('place_changed', fillInAddress);
        }



        function fillInAddress() {

          var place = autocomplete1.getPlace();

          $('input[name="lat"]').val(place.geometry.location.lat());
          $('input[name="lon"]').val(place.geometry.location.lng());

        }

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete1.setBounds(circle.getBounds());
                });
            }

        }
      </script>
      <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY" async defer type="text/javascript"></script><!--
