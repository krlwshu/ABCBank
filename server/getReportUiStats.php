<?php 

getStatusCounts();
function getStatusCounts (){
    $db = new SQLITE3('C:\xampp\server\sqlite\dbw-assignment-db\abcbank.db');

    // Status counts
    $sql = "select r.status, count(a.status) as count, color_code from report_statuses r
    left join applications a on a.status = r.status
    group by r.status order by 2 desc ";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $counts = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $counts [] = $row; //adding a record until end of records
    }


    //New Registrations (24hrs)
    $sql = "select count(*) as new_reg24h from applications where date_created > datetime('now','-1 day')";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $newDaily = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $newDaily [] = $row; //adding a record until end of records
    }

    //New Registrations (7 days)
    $sql = "select count(*) as new_reg7d from applications where date_created > datetime('now','-7 day')";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $newSeven = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $newSeven [] = $row; //adding a record until end of records
    }    
    
    //Processed (daily)
    $sql = "select count(*) as proc_24h from application_history where updated > datetime('now','-1 day') and status <> 'New'";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $procDaily = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $procDaily [] = $row; //adding a record until end of records
    }    

    //Processed (Week)
    $sql = "select count(*) as proc_7d from application_history where updated > datetime('now','-7 day') and status <> 'New'";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $procSeven = [];//prepare an empty array first
    while ($row = $result->fetchArray(SQLITE3_ASSOC)){ // use fetchArray(SQLITE3_NUM) - another approach
        $procSeven [] = $row; //adding a record until end of records
    }
    
    
    $data['new_24h'] = $newDaily;
    $data['new_7d'] = $newSeven;
    $data['proc_24h'] = $procDaily;
    $data['proc_7d'] = $procSeven;
    $data['counts'] = $counts;
    
    echo json_encode($data);
}
