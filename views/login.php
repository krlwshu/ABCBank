<?php 


// if(isset($_SESSION['logged_in'])){
//     header('Location: manageRegistrations.php');
// }

require("../views/templates/header.php");

?>


<link rel="stylesheet" href="../assets/css/login.css">

<div class="container login-section">
    
    <div class="row login">

        <form class="animate__animated animate__fadeIn" method="post" action="../server/authenticate.php">
            <h4 class="">Online Banking</h4>

            <div class="animate__animated animate__backInDown animate__delay-1s">
                <p>Log into to manage your account</p>
            </div>

            <div class="animate__animated animate__fadeIn">
                <div>
                    <input type="text" name="username" placeholder="Enter your username" />
                </div>
                <div>
                    <input type="password" name="password" placeholder="Enter your password" />
                </div>
                <?php  if(isset($_GET['status'])){
                    echo "<label class='text-danger'>Invalid information</label>";

                }?>                
            </div>

            <button class="animate__animated animate__pulse animate__delay-2s" onclick="submit">
                Continue
            </button>
        </form>
    </div>
</div>

<?php require("templates/footer.php");?>