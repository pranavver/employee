<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION["user_id"])){
    // $response=['status' => 'unauthorised'];
    echo json_encode(['status' => 'unauthorised']);
    exit;
}

$user_id=intval($_SESSION["user_id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fieldName = $_POST['fieldName'] ?? '';
    $fieldValue = $_POST['fieldValue'] ?? '';

    if (empty($fieldName) || empty($fieldValue)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
        exit;
    }

     // Insert new record
     if ($fieldName === 'experience') {
        $stmt = $conn->prepare("INSERT INTO experiences (experience, user_id) VALUES (?, ?)");
    } elseif ($fieldName === 'qualification') {
        $stmt = $conn->prepare("INSERT INTO qualifications (qualification, user_id) VALUES (?, ?)");
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field name.']);
        exit;
    }

    $stmt->bind_param("si", $fieldValue, $user_id);

    if ($stmt->execute()) {
        $newId = $stmt->insert_id;
        echo json_encode(['status' => 'success', 'id' => $newId]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert record.']);
    }
    $stmt->close();
    $conn->close();
}
?>
