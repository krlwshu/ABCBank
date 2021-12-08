<?php 


if(isset($_SESSION['logged_in'])){
    header('Location: manageRegistrations.php');
}

require("../views/templates/header.php");

?>


<link rel="stylesheet" href="../assets/css/login.css">

<div class="container login-section">
    
    <div class="row login">

        <form class="animate__animated animate__fadeIn" method="post" action="../server/userRetrieveApplication.php">
            <h4 class="">Manage Application</h4>

            <div class="animate__animated animate__backInDown animate__delay-1s">
                <p>Please enter the details below to access your application</p>
            </div>

            <div class="animate__animated animate__fadeIn">
                <div>
                    <input type="text" name="appId" placeholder="Application ID" />
                </div>
                <div>
                    <input type="text" name="pCode" placeholder="Postcode" />
                </div>
                <div>
                    <input type="text" name="lName" placeholder="Last Name" />
                </div>
                <?php  if(isset($_GET['status'])){
                    echo "<label class='text-danger'>Invalid information</label>";

                }?>                
            </div>

            <div style="padding-top:1rem;" class="col-12">
                <input class="btn btn-primary animate__animated animate__pulse animate__delay-2s" type="submit" value="Continue" name="submit">
            </div>
        </form>
    </div>
</div>

<?php require("templates/footer.php");?>