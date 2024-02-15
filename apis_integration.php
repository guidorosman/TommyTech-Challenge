<?php
include "db.php";

apisIntegration();

function apisIntegration(){
    global $conn;

    // Get all the apis inserted in apis table
    $sql = "SELECT * FROM apis";
    $result = $conn->query($sql);

    // Get a response for each api
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $apiName = $row["api_name"];
            $url = $row["url"];

            $response = file_get_contents($url);
            $jsonData = json_decode($response, true);

            // For each api I first parse the response and then insert into the database
            switch ($apiName) {
                case "api_1":
                    $parsedArray = parseApi_1($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_2":
                    $parsedArray = parseApi_2($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_3":
                    $parsedArray = parseApi_3($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_4":
                    $parsedArray = parseApi_4($apiName, $response);
                    storeData($parsedArray);
                    break;
                case "api_5":
                    $parsedArray = parseApi_5($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_6":
                    $parsedArray = parseApi_6($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_7":
                    $parsedArray = parseApi_7($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
                case "api_8":
                    $parsedArray = parseApi_8($apiName, $jsonData);
                    storeData($parsedArray);
                    break;
            }
        }
    }
}

function parseApi_1($apiName, $jsonData){
    $parsedArray = array();

    foreach ($jsonData['data'] as $dataRow) {
        $parsedData = array(
            'subid' => $dataRow[1],
            'dday' => $dataRow[0],
            'geo' => $dataRow[2],
            'partner' => $apiName,
            'searches' => $dataRow[3],
            'monetized' => $dataRow[4],
            'clicks' => $dataRow[5],
            'revenue' => $dataRow[6],
            'ctr' => NULL,
            'cpc' => NULL,
        );

        $parsedArray[] = $parsedData;
    }

    return $parsedArray;
}

function parseApi_2($apiName, $jsonData){
    $parsedArray = array();
    
    foreach ($jsonData['items'] as $item) {
    
        foreach ($item['stats'] as $stat) {
            $parsedData = array(
                'subid' => $stat['SubId'],
                'dday' => $stat['Date'],
                'geo' => $stat['Country'],
                'partner' => $apiName,
                'searches' => $stat['TotalSearches'],
                'monetized' => $stat['MonetizedSearches'],
                'clicks' => $stat['Clicks'],
                'revenue' => $stat['AmountNet'],
                'ctr' => NULL,
                'cpc' => NULL,
            );
    
            $parsedArray[] = $parsedData;
        }
    }

    return $parsedArray;
}

function parseApi_3($apiName, $jsonData){
    $parsedArray = array();
    foreach ($jsonData as $data) {
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $parsedData = array(
                    'subid' => $item['SubId'],
                    'dday' => $item['Date'],
                    'geo' => $item['Country'],
                    'partner' => $apiName,
                    'searches' => $item['TotalSearches'],
                    'monetized' => $item['MonetizedSearches'],
                    'clicks' => $item['Clicks'],
                    'revenue' => $item['AmountNet'],
                    'ctr' => NULL,
                    'cpc' => NULL,
                );
                
                $parsedArray[] = $parsedData;
            }
        }
    }
  
    return $parsedArray;
}

function parseApi_4($apiName, $response){
    $parsedArray = array();

    $lines = explode("\n", $response);

    for ($i = 1; $i < count($lines); $i++) {
        $line = $lines[$i];

        if (!empty($line)) {
            $values = str_getcsv($line, ';');
            $parsedData = array(
                'subid' => $values[1],
                'dday' => $values[0],
                'geo' => $values[2],
                'partner' => $apiName,
                'searches' => $values[8],
                'monetized' => $values[4],
                'clicks' => $values[7],
                'revenue' => $values[3],
                'ctr' => $values[6],
                'cpc' => $values[5],
            );

            $parsedArray[] = $parsedData;
        }
    }

    return $parsedArray;
}

function parseApi_5($apiName, $jsonData){
    $parsedArray = array();

    foreach ($jsonData['data'] as $item) {
        $parsedData = array(
            'subid' => $item['Subid'],
            'dday' => $item['Date'],
            'geo' => $item['Country'],
            'partner' => $apiName,
            'searches' => $item['Total Searches'],
            'monetized' => $item['Monetized Searches'],
            'clicks' => $item['Clicks'],
            'revenue' => $item['Net Revenue'],
            'ctr' => NULL,
            'cpc' => NULL,
        );

        $parsedArray[] = $parsedData;
    }

    return $parsedArray;
}

function parseApi_6($apiName, $jsonData){
    $parsedArray = array();

    foreach ($jsonData as $item) {
        $parsedData = array(
            'subid' => $item['subid'],
            'dday' => $item['date'],
            'geo' => $item['geo'],
            'partner' => $apiName,
            'searches' => $item['searches'],
            'monetized' => $item['monetized searches'],
            'clicks' => $item['clicks'],
            'revenue' => $item['net revenue'],
            'ctr' => NULL,
            'cpc' => NULL,
        );

        $parsedArray[] = $parsedData;
    }

    return $parsedArray;
}

function parseApi_7($apiName, $jsonData){
    $parsedArray = array();

    foreach ($jsonData['data'] as $item) {
        $parsedData = array(
            'subid' => $item['Subid'],
            'dday' => $item['Date'],
            'geo' => $item['Country'],
            'partner' => $apiName,
            'searches' => $item['Total Searches'],
            'monetized' => $item['Monetized Searches'],
            'clicks' => $item['Clicks'],
            'revenue' => $item['Net Revenue'],
            'ctr' => NULL,
            'cpc' => NULL,
        );

        $parsedArray[] = $parsedData;
    }

    return $parsedArray;
}

function parseApi_8($apiName, $jsonData){
    $parsedArray = array();

    foreach ($jsonData['data'] as $item) {
        $parsedData = array(
            'subid' => $item['campaign'],
            'dday' => $item['date'],
            'geo' => $item['geo'],
            'partner' => $apiName,
            'searches' => $item['searches'],
            'monetized' => 0,
            'clicks' => $item['clicks'],
            'revenue' => $item['revenue'],
            'ctr' => NULL,
            'cpc' => NULL,
        );

        $parsedArray[] = $parsedData;
    }

    return $parsedArray;
}

function storeData($parsedArray) {
    global $conn;

    foreach ($parsedArray as $dataRow) {
        // Check if a record already exists with the same values ​​in dday, geo and subid
        $checkStmt = $conn->prepare("
            SELECT subid FROM stats_2
            WHERE dday = ? AND geo = ? AND subid = ?
            LIMIT 1
        ");

        $checkStmt->bind_param("sss", $dataRow['dday'], $dataRow['geo'], $dataRow['subid']);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // If exist update new changes
            $stmt = $conn->prepare("
                UPDATE stats_2
                SET searches = ?,
                    monetized = ?,
                    clicks = ?,
                    revenue = ?,
                    ctr = ?,
                    cpc = ?
                WHERE dday = ? AND geo = ? AND subid = ?
            ");

            $stmt->bind_param("iiidddsss", $dataRow['searches'], $dataRow['monetized'], $dataRow['clicks'], $dataRow['revenue'], $dataRow['ctr'], $dataRow['cpc'], $dataRow['dday'], $dataRow['geo'], $dataRow['subid']);
        } else {
            // If not exist insert the new record
            $stmt = $conn->prepare("
                INSERT INTO stats_2 (subid, dday, geo, partner, searches, monetized, clicks, revenue, ctr, cpc)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param("ssssiiiddd", $dataRow['subid'], $dataRow['dday'], $dataRow['geo'], $dataRow['partner'], $dataRow['searches'], $dataRow['monetized'], $dataRow['clicks'], $dataRow['revenue'], $dataRow['ctr'], $dataRow['cpc']);
        }

        $stmt->execute();
    }
}



