<?php
require_once("administrator/includes/config.php");
require_once("include/helpers.php");
session_start();

 ?>
<?php 


if($_SESSION['user_type'] == 1){  
    $location = SITE_URL;
    header("Location: $location");
    
}

if($_SESSION['add_session'] != 2 && $_SESSION['three']==''){
   $location = SITE_URL;
    header("Location: $location"); 
}

/**********************header********************/
include("include/header.php");

$get_parking_id = $_SESSION['new_parking'];

if($get_parking_id){
    $get_details= mysqli_fetch_object(mysqli_query($link,"SELECT * FROM `parking` WHERE `id`={$get_parking_id}"));
}

?>
<style type="text/css">
 #map {
        height: 200px;
        width: 335px;
            position: relative;
    overflow: hidden;
      }
</style>
<!--<p>Work is in progress</p>-->
<div class="container">
       <div class="row my-5">
           <div class="col-md-2">              
           </div>
           <div class="col-md-8">
                <div class="shadow-bg">

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Parking Place and Price</h4>
                            <div class="row my-4 pt-3">
                                <form class="col-md-9 hints-div pb-5" method="post" action="ajax_placeprice.php">

                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Street - 1:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Street" name="street" value="<?php if($get_parking_id){ echo $get_details->street; } ?>" >
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Intersection:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Intersection" name="intersection" value="<?php if($get_parking_id){ echo $get_details->intersection; } ?>">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                   <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Number:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Number" name="number" value="<?php if($get_parking_id){ echo $get_details->number; } ?>">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Building Name:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Building Name" name="building_name" value="<?php if($get_parking_id){ echo $get_details->building_name; } ?>">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Parking Lot No:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Parking Lot No" name="parkinglot_number" value="<?php if($get_parking_id){ echo $get_details->parkinglot_number; } ?>">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Geographical zone:</label>
                                                <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <select class="form-control" name="geographical_zone" id="geographical_zone">
                                                    <?php foreach ($tzlist as $key => $value) { ?>
                                                    <option value="<?php echo $value; ?>" <?php if($get_details->geographical_zone==$value){ echo "selected"; } ?>><?php echo $value; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    
                                    
                                </select>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Address:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="Address" name="address" id="autocomplete1" value="<?php if($get_parking_id){ echo $get_details->address; } ?>" required>
                                                    <input type="hidden" name="lat" id="latbox" value="<?php echo $get_details->lat; ?>" />
                                                    <input type="hidden" name="lon" id="lngbox" value="<?php echo $get_details->lon; ?>" />
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mt-sm-5">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right mt-2">Map Location:</label>
                                                
                                                <div id="map"></div>
                                            </div>                                                                  
                                        </div>
                                    </div>
                                    <h5 class="ml-2">Price:</h5>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Monthly Price Currency:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <select class="form-control" name="currency" value="<?php if($get_parking_id){ echo $get_details->currency; } ?>">
                                                		<option value="0">---select---</option>
                                                                <option <?php if($get_details->currency == 'usd'){ ?>selected<?php } ?> value="usd">USD</option>
                                            		</select>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Minimum Monthly Price:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control" id="amount" placeholder="$" name="price" required value="<?php if($get_parking_id){ echo $get_details->price; } ?>" required>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                     <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Maximum Monthly Price:</label>
                                                <div class="col-sm-9 edit-pro-frmfield">
                                                    <input class="form-control"  placeholder="$" name="maximum_price" value="<?php if($get_parking_id){ echo $get_details->maximum_price; } ?>" disabled="disabled" id="maxPrice">
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12 row">
                                        <div class="col-sm-3"></div>
                                            <div class="col-sm-9 edit-pro-frmfield mt-1 pl-lg-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline" name="is_dynamic" <?php if($get_parking_id){ if($get_details->is_dynamic == 1){ echo "checked"; } } ?>>
                                                    <label class="custom-control-label" for="customControlInline">Dynamic Price ( if not selected then it will be the minimum )</label>
                                                 </div>
                                             </div>                                                               
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mb-0">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Only when the parking place is available and is going to be rented"><img src="images/Question.png" class="pr-1">
                                                    </a>
                                                </div>
                                            </div>
                                         </div>
                                </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-11">
                                            <div class="form-group row edit-pro-row">
                                                <label  class="col-sm-3 col-form-label pr-0 pl-lg-0 text-right">Discount for months:</label>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <select class="form-control" name="discount_month" value="<?php if($get_parking_id){ echo $get_details->discount_month; } ?>" style="width: 100% !important; font-size: 12px;">
                                                		<option value="0">--Select--</option>
                                                		<!-- <option <?php if($get_details->discount_month == 1){ echo "selected"; } ?> value="1">1 Months</option>
                                                		<option <?php if($get_details->discount_month == 2){ echo "selected"; } ?> value="2">2 Months</option>
                                                		<option <?php if($get_details->discount_month == 3){ echo "selected"; } ?> value="3">3 Months</option>
                                                		<option <?php if($get_details->discount_month == 4){ echo "selected"; } ?> value="4">4 Months</option>
                                                		<option <?php if($get_details->discount_month == 5){ echo "selected"; } ?> value="5">5 Months</option>
                                                		<option <?php if($get_details->discount_month == 6){ echo "selected"; } ?> value="6">6 Months</option>
                                                		<option <?php if($get_details->discount_month == 7){ echo "selected"; } ?> value="7">7 Months</option>
                                                		<option <?php if($get_details->discount_month == 8){ echo "selected"; } ?> value="8">8 Months</option>
                                                		<option <?php if($get_details->discount_month == 9){ echo "selected"; } ?> value="9">9 Months</option>
                                                		<option <?php if($get_details->discount_month == 10){ echo "selected"; } ?> value="10">10 Months</option>
                                                		<option <?php if($get_details->discount_month == 11){ echo "selected"; } ?> value="11">11 Months</option>
                                                		<option <?php if($get_details->discount_month == 12){ echo "selected"; } ?> value="12">12 Months</option> -->
                                                        <option <?php if($get_details->discount_month == 3){ echo "selected"; } ?> value="3">3 Months</option>
                                                        <option <?php if($get_details->discount_month == 6){ echo "selected"; } ?> value="6">6 Months</option>
                                                        <option <?php if($get_details->discount_month == 9){ echo "selected"; } ?> value="9">9 Months</option>
                                            		</select>
                                                </div>
                                                <div class="col-sm-3 edit-pro-frmfield">
                                                    <select class="form-control" name="discount" value="<?php if($get_parking_id){ echo $get_details->discount; } ?>" style="width: 100% !important; font-size: 12px;">
                                                		<option value="0">--Select--</option>
                                                                <option <?php if($get_details->discount == 10){ echo "selected"; } ?> value="10">10%</option>
                                                		<option <?php if($get_details->discount == 15){ echo "selected"; } ?> value="15">15%</option>
                                                		<option <?php if($get_details->discount == 20){ echo "selected"; } ?> value="20">20%</option>
                                                		<option <?php if($get_details->discount == 25){ echo "selected"; } ?> value="25">25%</option>
                                            		</select>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                   <div class="row justify-content-center">
                                        <div class="col-sm-12 row">
                                        <div class="col-sm-3"> <h5 class="ml-2">Extras:</h5></div>
                                        <div class="col-sm-9 row">
                                            <div class="col-sm-6 edit-pro-frmfield mt-1 pl-lg-0">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline1" <?php if($get_parking_id){  if($get_details->extrakey){ ?>checked<?php } } ?>>
                                                    <label class="custom-control-label" for="customControlInline1">Keys</label>
                                                    <input class="form-control ml-2" disabled="disabled" placeholder="$" id="extrakey" name="extrakey" value="<?php if($get_parking_id){ echo $get_details->extrakey; } ?>">
                                                 </div>
                                             </div> 
                                             <div class="col-sm-6 edit-pro-frmfield mt-1 pl-lg-0 pr-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline2" <?php if($get_parking_id){  if($get_details->access_card){ ?>checked<?php } } ?>>
                                                    <label class="custom-control-label" for="customControlInline2">Access Card</label>
                                                    <input class="form-control ml-2" disabled="disabled" placeholder="$ Price" id="access_card" name="access_card" value="<?php if($get_parking_id){ echo $get_details->access_card; } ?>">
                                                 </div>
                                             </div> 
                                             <div class="col-sm-6 edit-pro-frmfield mt-1 pl-lg-0 pr-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?php if($get_parking_id){ if($get_details->remote_control){ echo "checked"; } } ?> id="customControlInline3">
                                                    <label class="custom-control-label" for="customControlInline3">Remote Control</label>
                                                    <input class="form-control ml-2" disabled="disabled" placeholder="$ Price" id="remote_control" name="remote_control" value="<?php if($get_parking_id){ echo $get_details->remote_control; } ?>">

                                                </div>
                                             </div> 
                                             
                                          </div>                                                                
                                        </div>
                                    </div>
                                    <div class="row ml-2">
                                        <div class="col-sm-12">
                                            <div class="form-group row edit-pro-row mt-4">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-primary my-2 edit-pro-sv-chng" href="rent_parking_step3.php">Back</a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="btn btn-primary my-2 edit-pro-sv-chng" type="submit" name="submit" value="Next" />
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

<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?php
include("include/footer.php");
unset($_SESSION["msg"]);

?>

<script>
    $(document).ready(function(){
        $('#customControlInline1').change(function(){
		if ($(this).is(':checked')){
                    $('#extrakey').attr("disabled", false);
                }
                else{
                    $('#extrakey').attr("disabled","true");
                }
                
        });
        $('#customControlInline2').change(function(){
        if ($(this).is(':checked')){
                    $('#access_card').attr("disabled", false);
                }
                else{
                    $('#access_card').attr("disabled","true");
                }
                
        });
        $('#customControlInline3').change(function(){
        if ($(this).is(':checked')){
                    $('#remote_control').attr("disabled", false);
                }
                else{
                    $('#remote_control').attr("disabled","true");
                }
                
        });
        
        $("#amount").on("keypress keyup", function(){
            var valid = /^\d{0,10}(\.\d{0,2})?$/.test(this.value),
                val = this.value;

            if(!valid){
                console.log("Invalid input!");
                this.value = val.substring(0, val.length - 1);
            }
        });
        $("#amount").on("blur", function(event){
            if($("#amount").val() ==  ""){
                event.preventdefault();
            }
        });

        $('#customControlInline').change(function(){
            if ($(this).is(':checked')){
                $('#maxPrice').attr("disabled", false);
            }
            else{
                $('#maxPrice').attr("disabled","true");
            }
        });
    });
</script>
<script type="text/javascript">
    var map;
    var marker;
    var geocoder = new google.maps.Geocoder();

    function initialize() {
        var latitude2 ='<?php echo $get_details->lat; ?>';
        var longitude2 ='<?php echo $get_details->lon; ?>';
        if(latitude2=='' || longitude2==''){
        var latitude2 = 28.538336;
        var longitude2 = -81.379234;
        }

        var mapOptions = {
            zoom: 12
        };
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        // Get GEOLOCATION
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = new google.maps.LatLng(position.coords.latitude,
                position.coords.longitude);

                map.setCenter(pos);
                marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    draggable: true
                });
            }, function() {
              handleNoGeolocation(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
        }

        function handleNoGeolocation(errorFlag) {
            if (errorFlag) {
                var content = 'Error: The Geolocation service failed.';
            } else {
                var content = 'Error: Your browser doesn\'t support geolocation.';
            }

            var options = {
                map: map,
                position: new google.maps.LatLng(latitude2,longitude2),
                content: content
            };

            map.setCenter(options.position);
            marker = new google.maps.Marker({
                position: options.position,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                //console.log(event);
                //$('#autocomplete1').val(event.geometry.location);
                // var getlat = event.latLng.lat();
                // var getlng = event.latLng.lng();
                $('#latbox').val(event.latLng.lat());
                $('#lngbox').val(event.latLng.lng());
                GetAddress();
                
            });
        }
        function GetAddress() {
            var lat = parseFloat(document.getElementById("latbox").value);
            var lng = parseFloat(document.getElementById("lngbox").value);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        //alert("Location: " + results[1].formatted_address);
                        $('#autocomplete1').val(results[1].formatted_address);
                    }
                }
            });
        }


        // get places auto-complete when user type in location-text-box
        var input = /** @type {HTMLInputElement} */
        (
          document.getElementById('autocomplete1'));


        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();
        
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
            marker.setIcon( /** @type {google.maps.Icon} */ ({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            if (place.address_components) {
                $('input[name="lat"]').val(place.geometry.location.lat());
                $('input[name="lon"]').val(place.geometry.location.lng());
            }
        });
        
        

    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initialize&key=AIzaSyCukYKThEmFJrGmTegQI4xMqkE3YIeBnJY " async defer type="text/javascript"></script><!--
