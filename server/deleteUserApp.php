<?php 

require("../server/session.php");

// print_r($_SESSION);

if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){


  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  if ($contentType === "application/json") {
    $data = trim(file_get_contents("php://input"));
    $data = json_decode($data, true);
    $appId = $data['appId'];
    $res['status'] = false;

    if (checkIsWithdrawn($appId)){
        $res['status'] = deleteApplication($appId);
        $res['appId'] = $appId;
    }

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($res);
  }  
}
else{
    header("Content-Type: application/json; charset=UTF-8");
    $res['status'] = "UNAUTHORIZED";
    echo json_encode($res);
}



function deleteApplication ($appId){
    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
    $sql = "delete from customers WHERE app_id=:app_id;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':app_id',$appId, SQLITE3_TEXT);
    $result= $stmt->execute();
    $arrayResult = [];
    
    while($row=$result->fetchArray(SQLITE3_NUM)){
        $arrayResult [] = $row;
    }
    
    $res['status'] = false;

    if($stmt){
        return "DELETED";
       
    } else {
        return "NOT_DELETED";
    }
}

// Always good to double check from the backend too (security)
function checkIsWithdrawn ($appId){
    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
    $sql = "SELECT status FROM applications WHERE app_id=:app_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':app_id',$appId, SQLITE3_TEXT);
    $result= $stmt->execute();
    $arrayResult = [];
    
    while($row=$result->fetchArray(SQLITE3_NUM)){
        $arrayResult [] = $row;
    }
    
    return count($arrayResult);
}

