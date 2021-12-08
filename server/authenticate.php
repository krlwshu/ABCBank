<?php

    require('session.php');

    $user = $_POST['username'];
    $password = $_POST['password'];

    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
    $sql = "SELECT * FROM sys_users WHERE username=:user and password = :pwd limit 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user',$user, SQLITE3_TEXT);
    $stmt->bindParam(':pwd',$password, SQLITE3_TEXT);
    $result= $stmt->execute();
    $arrayResult = [];
    
    while($row=$result->fetchArray(SQLITE3_NUM)){
        $arrayResult [] = $row;
    }
    
    //Authenticate, set keys
    if ($arrayResult){
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $user;
        $_SESSION["role"] = $arrayResult[0][5];
        $_SESSION['auth_start'] = "Y";
        header('Location: ../views/manageRegistrations.php');
    } else{
        header('Location: ../views/login.php?status=false');
    }