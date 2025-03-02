<?php
//  require_once '../database/db_connect.php';

// // Get email from POST request
// $email = $_POST['email'];

// // Query to check if email exists
// $sql = "SELECT full_name FROM users WHERE email = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $email);
// $stmt->execute();
// $stmt->store_result();

// if ($stmt->num_rows > 0) {
//     echo "exists"; // Email already exists
// } else {
//     echo "available"; // Email is available
// }

// $stmt->close();
// $conn->close();


require_once '../database/db_connect.php';

// Get email from POST request
$email = $_POST['email'];

// Initialize response array
$response = [];

try {
    // Query to check if email exists
    $sql = "SELECT full_name FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response['status'] = 'exists'; // Email already exists
        $response['message'] = 'Email already exists. Please use a different email.';
    } else {
        $response['status'] = 'available'; // Email is available
        $response['message'] = 'Email is available.';
    }

    $stmt->close();
} catch (Exception $e) {
    // Handle errors
    $response['status'] = 'error';
    $response['message'] = 'Error : '.$e->getMessage();
}

$conn->close();

// Set the content type to JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);
?>
