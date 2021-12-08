<?php

function getApplicationDetails ($appId = false){

    $db = new SQLITE3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');


    // Get filters
    $filterString = "";
    if(isset($_GET['filter_by_status'])){
        $filterId = intval($_GET['filter_by_status']);
        $filter = "";
        switch($filterId) {
            case 1: $filter = 'New'; break;
            case 2: $filter = 'In-process'; break;
            case 3: $filter = 'On-Hold'; break;
            case 4: $filter = 'Withdrawn'; break;
            case 5: $filter = 'Complete'; break;
        }
        $filterString = " where a.status like '%$filter%'";
        
    }


    // Get count for pagination
    $rows_per_page = 5;
    $page  = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $rows_per_page;

    


    // Get data
    $sql = "select 
            c.app_id,
            c.first_name,
            c.last_name,
            c.dob,
            c.postcode,
            c.contact_no,
            a.status as application_status,
            p.placement as selected_product 
            from customers c 
            inner join applications a on c.app_id = a.app_id 
            inner join products p on p.id = a.selected_product  $filterString ";

        if($appId){
            $sql.= " where c.app_id=:appId";
        }

    // $sql = "select * from customers ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':appId',$appId, SQLITE3_TEXT);
    $result = $stmt->execute();

    $arrayResult = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult [] = $row; //adding a record until end of records
    }

    // $count_rows = count($arrayResult[0]);
    // $total_pages = ceil($count_rows / $rows_per_page);
    // $data['pagination']= array(
    //     'rows_per_page'=>$rows_per_page,
    //     'count_rows'=> $count_rows,
    //     'page'=> $page,
    //     'total_pages'=> $total_pages);         

    // return $data;
    return $arrayResult;
}

function getApplicationHistory ($appId = false){
    $db = new SQLITE3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');
    $sql = "select 
            app_id,
            status,
            selected_product,
            updated,
            comments from application_history where app_id=:appId order by updated desc";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':appId',$appId, SQLITE3_TEXT);
    $result = $stmt->execute();

    $arrayResult = [];//prepare an empty array first
    while ($row = $result->fetchArray()){ // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult [] = $row; //adding a record until end of records
    }
    return $arrayResult;
}
