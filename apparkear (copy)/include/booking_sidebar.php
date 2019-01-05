<div class="col-lg-4">
                    <div class="whitebox-bg">
                        <div class="parking-img">
                            <div class="img-tag">$<?php echo $mainprice+ $cleaning_fee + $service_fee; ?>
                                    month</div>
                            <img src="images/booking-step-1-img.png" class="img-fluid">
                        </div>
                        <div class="place-name p-3">
                            <h5><?php echo $parking_spaces->name; ?></h5>
                            <ul class="p-0 m-0">
                                <li class="pr-3"><img src="images/security-guard.png"><p>Security Guard</p></li>
                                <li><img src="images/cars.png"><p>More than 300 cars</p></li>
                                <li><img src="images/cctv.png"><p>CCTV camera</p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your booking dates</h4>
                            <ul>
                                <li><h5>Move in</h5><p><?php echo $get_start_date; ?></p></li>
                                <li><h5>Move out</h5><p><?php echo $get_end_date; ?></p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your payment</h4>
                            <ul>
                                <li><p>Per month's rent</p><p>Cleaning fee</p><p>Service fee</p><p>Total</p></li>
                                <li><p>$ <?php echo $mainprice; ?></p><p>$ <?php echo $cleaning_fee; ?></p><p>$ <?php echo $service_fee; ?></p><p>$ <?php echo $actual_price; ?></p></li>
                            </ul>
                            <a href="#">What is this?</a>
                        </div>
                    </div>
                    <div class="whitebox-bg">
                        <div class="step-left p-3">
                            <h4>Your payment</h4>
                            <ul>
                                <li><p>Contract type</p></li>
                                <li><p>monthly</p></li>
                            </ul>
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                    <div class="grey-bg">
                        <div class="step-left p-3">
                            <h4>Other information</h4>
                            <ul>
                                <li><p>Contract type</p></li>
                                <li><p>monthly</p></li>
                            </ul>
                            <h4 class="pt-3 pb-0">This fee will be paid directly to the provider to cover administrative and other costs.</h4>
                        </div>
                    </div>
                </div>