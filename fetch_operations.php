<?php

include('db.php');

if($_SERVER['REQUEST_METHOD']){
    $data = json_decode(file_get_contents('php://input'), true);
    $api_name = $data['api_name'];
    $url = $data['url'];

    if(isset($data['id'])){
        $id = $data['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        insertData($api_name, $url);

    }else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        updateData($id, $api_name, $url);

    }else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        deleteData($id, $api_name, $url);

    }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $id = $_GET['id'];

        $data = getDataById($id);
        echo json_encode($data);
    }
}

function insertData($api_name, $url) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO apis (api_name, url) VALUES (?, ?)");
    $stmt->bind_param("ss", $api_name, $url);
    $stmt->execute();

    // Get new data from apis table after the insert
    $data = getData();
    echo json_encode($data);
}

function updateData($id, $api_name, $url) {
    global $conn;

    $stmt = $conn->prepare("UPDATE apis SET api_name = ?, url = ? WHERE id = ?");
    $stmt->bind_param("ssi", $api_name, $url, $id);
    $stmt->execute();

    // Get new data from apis table after the update
    $data = getData();
    echo json_encode($data);
}

function deleteData($id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM apis WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Get new data from apis table after the delete
    $data = getData();
    echo json_encode($data);
}

function getData(){
    global $conn;

    $query = "SELECT id, api_name, url FROM apis";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}

function getDataById($id){
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM apis WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data;
}