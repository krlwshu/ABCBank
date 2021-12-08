<?php

function processNewRequest(){

    // Generate Registration id
    $appId = genRegistrationID($_POST['fname'],$_POST['lname'],$_POST['pcode']);


    // Success counter - two queries to execute
    $c =0;

    // Prepare first statement
    $created = false;//this variable is used to indicate the creation is successfull or not
    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db'); // db connection - get your db file here. Its strongly advised to place your db file outside htdocs. 
    
    // Start transaction
    $db->exec('BEGIN');

    
    $sql = 'INSERT INTO customers(first_name,last_name,dob,birth_month,postcode,contact_no, app_id) VALUES (:fname, :lname, :dob, :mob, :pcode, :tel, :appId)';
    $stmt = $db->prepare($sql); //prepare the sql statement


    // Create customer record
    $stmt->bindParam(':fname', $_POST['fname'], SQLITE3_TEXT);
    $stmt->bindParam(':lname', $_POST['lname'], SQLITE3_TEXT);
    $stmt->bindParam(':dob', $_POST['dob'], SQLITE3_TEXT);
    $stmt->bindParam(':mob', $_POST['mob'], SQLITE3_TEXT);
    $stmt->bindParam(':pcode', $_POST['pcode'], SQLITE3_TEXT);
    $stmt->bindParam(':tel', $_POST['tel'], SQLITE3_TEXT);
    $stmt->bindParam(':appId',$appId , SQLITE3_TEXT);

    //execute the sql statement
    $stmt->execute();

    if($stmt){
        ++$c;
    }

    // Create application record
    $sql = 'INSERT INTO applications(app_id, selected_product) VALUES (:appId, :prod )';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':appId', $appId, SQLITE3_TEXT);
    $stmt->bindParam(':prod', $_POST['prod'], SQLITE3_NUM);
    $stmt->execute();

    if($stmt){
        ++$c;
    }    


    if($c==2){
        $db->exec('COMMIT');
        $created = true;
        $_SESSION['app_id'] = $appId;
    }else{
        $db->exec('ROLLBACK');
    }
    
    //Close DB
    $db->close();
    unset($db);

    // Return status
    return $created;

}



// Generate application ID
function genRegistrationID($fName, $lName,$pCode){

    $f_first2 = substr($fName,0,2);
    $l_first2 = substr($lName,0,2);
    $p_last2 = substr($pCode,2);
    
    $randNumber = str_pad(rand(0,999999),6,"0",STR_PAD_LEFT);

    return strtolower($f_first2.$l_first2.$p_last2.$randNumber);
}


function getEntries($appId){

    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
    $sql = 'select p.entries from applications a left join products p on a.selected_product = p.id where a.app_id =:appId;';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':appId',$appId, SQLITE3_TEXT);
    $result= $stmt->execute();
    $arrayResult = [];
    
    while($row=$result->fetchArray(SQLITE3_ASSOC)){
        $arrayResult [] = $row;
    }
    
    return $arrayResult;
}