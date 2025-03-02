<?php

session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION["user_id"])){
    // $response=['status' => 'unauthorised'];
    echo json_encode(['status' => 'unauthorised']);
    exit;
}

$user_id=intval($_SESSION["user_id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir .uniqid(). basename($_FILES['profile_picture']['name']);

    // Validate that the uploaded file is an image
    if (getimagesize($_FILES['profile_picture']['tmp_name'])) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
            // Assuming the user ID is set
            $imageUrl = htmlspecialchars($uploadFile);

            // Update the profile picture in the database
            $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->bind_param("si", $imageUrl, $user_id); // Bind user ID and the image URL to the query

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'image_url' => $imageUrl]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update the profile picture in the database.']);
            }

            $stmt->close();
        } else {
            unlink($uploadFile);
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload the image.']);
        }
    } else {
        unlink($uploadFile);
        echo json_encode(['status' => 'error', 'message' => 'Uploaded file is not an image.']);
    }
}
?>
