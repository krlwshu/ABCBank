<?php
require("../server/session.php");

if(isset($_SESSION["logged_in"])){
    $_SESSION["logged_in"] = false;
    session_unset();
    session_destroy();
}
header('Location: ../views/login.php');