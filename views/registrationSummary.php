<?php require("templates/header.php");
include_once("../server/userRegistration.php");

if(isset($_GET['createUser'])){
    $result = $_GET['createUser'];
} else{
    $result = '';
}

$entries = getEntries( $_SESSION['app_id'])[0]['entries'];

?>

<div class="container registration-container">

    <div class="row">

        <div class="col-lg-6">


            <div>
                <?php

                if($result){
                    echo "<h2>Successful Registration</h2>";
                    echo "<p>Thank you for your interest to open a Time Deposit Account with us under this campaign. Your application ID is <b>". $_SESSION['app_id']. "</b>. Only one application is allowed per customer.
                    You will have <b>$entries</b>  entries for the lucky draw (stand a chance to win <b>£10,000</b>) upon successful deposit placement until the end of account tenure.
                    Your record has been successfully submitted. You may update your record as long as your application status is “new” by providing the application ID from this link</p>";
                }
                else{
                    echo "<h2>Something went wrong...</h2>";
                    echo "<p>Please contact us for support. We apologise for any inconvenience.</p>";
                }
            ?>
                <div><a href="index.php">Back</a></div>
            </div>
        </div>

    </div>
</div>
<?php require("templates/footer.php");?>
