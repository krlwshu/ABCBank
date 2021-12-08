<?php 
require("templates/header.php");

include_once("../server/userRegistration.php");

if (isset($_POST['submit'])){
    $createUser = processNewRequest();
    header('Location: registrationSummary.php?createUser='.$createUser);
}
?>



<div class="container animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="box-promo">
                        <div class="box-promo-register">
                            <div class="box-promo-register-header">
                                <h5>Register Today for a <b>Time Deposit Account</b></h5>
                            </div>
                            <div class="box-promo-register-content">

                                    <b</b>
                                    <p>Free £15 voucher – upon successful placementInterest rate 2.88% AER p.a. </p>
                                </p>
                            
                            <p>Register for our products today for a chance to win up to <b>£10,000!</b>


                                <div class="apply">
                                    <a id="apply" autofocus href="#register">Apply Now</a>
                                </div>
                            </div>


                        </div>


                    </div>
                  
                    <!-- https://www.hsbc.co.uk/content/dam/hsbc/gb/vam/21-9/2948-trying-on-beret-clothing-stall-cass-933x400.jpg -->
                </div>
                <div class="col-md-4">
                    <div class="card card-bulletin" style="width: 18rem;">
                        <div class="card-body">
                            <a href="#">
                                <h5 class="card-title">Mobile Banking > </h5>
                            </a>
                            <p class="card-text">Check out some of the things you can do with our mobile banking app.</p>
                        </div>
                    </div>
                    <br>
                    <div class="card card-bulletin" style="width: 18rem;">
                        <div class="card-body">
                            <a href="#">
                                <h5 class="card-title">Latest Scams > </h5>
                            </a>
                            <p class="card-text">Stay one step ahead of fraudsters by keeping up to date with the latest scams.</p>
                        </div>
                    </div>
                </div>
                <h3>Register your interest today</h3>


                <p>

                </p>

                <div class="col-lg-4">

                </div>
            </div>
            
        </div>
    </div>

    <div class="row form-row">
        <div id="register" class="col-lg-8">
        <?php require("../views/templates/forms/registerForm.php");?>
        </div>
    </div>

</div>

<script src="../assets/js/register.js"></script>
<?php require("../views/templates/footer.php");?>
