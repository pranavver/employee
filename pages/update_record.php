<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION["user_id"])){
    // $response=['status' => 'unauthorised'];
    echo json_encode(['status' => 'unauthorised']);
    exit;
}

$user_id=intval($_SESSION["user_id"]);

if ($_SERVER["REQUEST_METHOD"] ==='POST' && isset($_POST['fieldName'], $_POST['fieldValue'], $_POST['id'])){
    
    $fieldName = $_POST['fieldName'];
    $fieldValue = trim($_POST['fieldValue']);
    $recordId = intval($_POST['id']);
    try {

        // Update 'address' fields in the 'users' table
        if (in_array($fieldName, ['permanent_address_line1',
                                  'permanent_address_line2', 'permanent_city', 'permanent_state',
                                  'current_address_line1', 'current_address_line2', 'current_city', 'current_state'])) {
            $stmt = $conn->prepare("UPDATE users SET $fieldName = ? WHERE id = ?"); 
            $stmt->bind_param("si", $fieldValue, $user_id);

        // Update 'experience' field in the 'experience' table
        } else if ($fieldName === 'experience') {
            $stmt = $conn->prepare("UPDATE experiences SET experience = ? WHERE user_id = ? AND id = ?");
            $stmt->bind_param("sii", $fieldValue, $user_id, $recordId);
        }
        // Update 'qualification' field in the 'qualifications' table 
        else if ($fieldName === 'qualification') {
            $stmt = $conn->prepare("UPDATE qualifications SET qualification = ? WHERE user_id = ? AND id = ?");
            $stmt->bind_param("sii", $fieldValue, $user_id, $recordId);
        }
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => ucfirst($fieldName) . ' updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        $stmt->close();
    } catch (Exception $e) {
        // http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    $conn->close();

}