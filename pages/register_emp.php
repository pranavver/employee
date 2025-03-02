<?php

require_once '../database/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        // Gather form data
        $fullName = $_POST['fullName'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $passwd = $_POST['password'];

        // Hash the password using bcrypt
        $hashedPassword = password_hash($passwd, PASSWORD_BCRYPT);

        // Handle profile picture (if uploaded)
        $profilePic = "../uploads/default-profile.png";
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $profilePic = '../uploads/' . uniqid() . '-' . $_FILES['profile_pic']['name'];
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic);
        }

        // Gather permanent and current address data
        $permAddressLine1 = $_POST['perm_address_line1'];
        $permAddressLine2 = $_POST['perm_address_line2'] ?? null;
        $permCity = $_POST['perm_city'];
        $permState = $_POST['perm_state'];

        $currAddressLine1 = $_POST['curr_address_line1'];
        $currAddressLine2 = $_POST['curr_address_line2'] ?? null;
        $currCity = $_POST['curr_city'];
        $currState = $_POST['curr_state'];

        // Gather qualifications and experiences
        $qualifications = $_POST['qualifications'] ?? [];
        $experiences = $_POST['experiences'] ?? [];

        // Insert user data into the database
        $query = "INSERT INTO users (full_name, dob, profile_pic, email, password, permanent_address_line1, permanent_address_line2, permanent_city, permanent_state, current_address_line1, current_address_line2, current_city, current_state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssss", $fullName, $dob, $profilePic, $email, $hashedPassword, $permAddressLine1, $permAddressLine2, $permCity, $permState, $currAddressLine1, $currAddressLine2, $currCity, $currState);
        $stmt->execute();

        // Get the last inserted user ID
        $userId = $conn->insert_id;
        echo $userId." ";

        // Insert qualifications
        foreach ($qualifications as $qualification) {
            if (!empty($qualification)) {
                $query = "INSERT INTO qualifications (user_id, qualification) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("is", $userId, $qualification);
                $stmt->execute();
            }
        }
            
        // Insert experiences
        foreach ($experiences as $experience) {
            if (!empty($experience)) {
                $query = "INSERT INTO experiences (user_id, experience) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("is", $userId, $experience);
                $stmt->execute();
            }
        }

        $response['success'] = true;
        $response['message'] = 'Registration successful!';
        // echo json_encode($response);
        $stmt->close();
        $conn->close();
        header('location: register.php?register=successfully');
    } catch (Exception $e) {
        unlink($profilePic);//if failed then remove uploaded image from uploads folder
        $response['success'] = false;
        $response['message'] = 'Error: ' . $e->getMessage();
        echo $e->getMessage();
        $conn->close();
    }
}
?>
