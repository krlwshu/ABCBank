<?php

// getProducts();

function getProducts(){
    $db = new SQLite3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db'); // db connection - get your db file here. Its strongly advised to place your db file outside htdocs. 
    $sql = 'select * from products';
    $stmt = $db->prepare($sql); //prepare the sql statement

    $result = $stmt->execute();

    $arrayResult = [];//prepare an empty array first
    while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult [] = $row; //adding a record until end of records
    }
    return $arrayResult;


}