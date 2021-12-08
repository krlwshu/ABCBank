<?php 

require("../server/session.php");

// print_r($_SESSION);

if($_SESSION['app_id'] ){


    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if ($contentType === "application/json") {
      $data = trim(file_get_contents("php://input"));
      $data = json_decode($data, true);
      $appId = $data['app_id'];
      $status = $data['withdraw'];
      $prod = intval($data['prod']);
      $res['status'] = false;
  
      header("Content-Type: application/json; charset=UTF-8");
      $res['status'] = updateApplication($appId, $prod, $status);
      $res['appId'] = $appId;
      echo json_encode($res);
    }  else{
      header("Content-Type: application/json; charset=UTF-8");
      $res['status'] = "UNAUTHORIZED";
      echo json_encode($res);
  }
}
  
  

  function updateApplication ($appId, $prod, $status){
    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');

    $updStatus = ($status) ? ", status = 'Withdrawn' ": "";
    $sql = "UPDATE applications set comments='CUSTOMER_UPDATE',  last_modified=CURRENT_TIMESTAMP, selected_product=:prod $updStatus where app_id=:appid"; 
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':prod',$prod, SQLITE3_INTEGER);
    $stmt->bindParam(':appid',$appId, SQLITE3_TEXT);
    
    $stmt->execute();
    if($stmt){
        return "UPDATED";
       
    } else {
        return "NOT_UPDATED";
    }
  }
