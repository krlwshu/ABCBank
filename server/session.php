<?php 


if (!isset($_SESSION)){
    ob_start();
    session_start();
}

function checkSession () {
    
    if(isset($_SESSION['logged_in'] )){

        if($_SESSION['auth_start'] = "Y"){
            $uri = '../views/manageRegistrations.php';
            $_SESSION['auth_start'] = "N";

        } else{
            $uri = $_SERVER['REQUEST_URI'];
            header("Location:".$uri);//return to the login page
        }


        $expireAfter = 10; //this value is in minutes

        //Check the interval since "last action" session
        if(isset($_SESSION['last_action'])){
            
            //Figure out how many seconds have passed
            //since the user was last active.
            $secondsInactive = time() - $_SESSION['last_action'];
            
            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfter * 10;
            
            //Check to see if they have been inactive for too long.
            if($secondsInactive >= $expireAfterSeconds){
                //User has been inactive for too long.
                //Kill their session.
                session_unset();
                session_destroy();
                header("Location:login.php ");//return to the login page
            }
        }
        $_SESSION['last_action'] = time(); //this variable is set for the very first time upon login
        $timeOut = ($expireAfter*10)+1; //1 second after the max session allowed. 
        header("Refresh: $timeOut; URL=$uri"); //refresh the screen    

    } else{
        session_unset();
        session_destroy();
        header("Location: login.php");
    }
}
