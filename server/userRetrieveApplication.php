<?php


require('session.php');

$appId = strtolower($_POST['appId']);
$pCode = strtolower($_POST['pCode']);
$lName = strtolower($_POST['lName']);

$db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');

$sql = "select * from customers
where lower(postcode)=:pCode and lower(app_id)=:appId and lower(last_name)=:lName";


$stmt = $db->prepare($sql);
$stmt->bindParam(':appId',$appId, SQLITE3_TEXT);
$stmt->bindParam(':lName',$lName, SQLITE3_TEXT);
$stmt->bindParam(':pCode',$pCode, SQLITE3_TEXT);

$result= $stmt->execute();
$arrayResult = [];

while($row=$result->fetchArray(SQLITE3_NUM)){
    $arrayResult [] = $row;
}

//Check Authentication
if ($arrayResult){
echo "success";
    $_SESSION['session_type'] = "CUST";
    $_SESSION['app_id'] = $appId;
    header('Location: ../views/manageMyApplication.php');
} else {
    header('Location: ../views/updateApplication.php?status=false');
}