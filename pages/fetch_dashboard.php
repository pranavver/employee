<?php

session_start();
if (!isset($_SESSION["user_id"]) && $_SESSION["email"]) {
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

require_once '../database/db_connect.php';

$employeeId = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE id = $employeeId";
$result = $conn->query($sql);

// Initialize variables for employee details
$profilePic = '../uploads/default-profile.png';
$profileName = 'N/A';
$userEmail = 'N/A';
$dob = 'N/A';
$qualifications = [];
$experiences = [];
$currAddressLine1 = 'N/A';
$currAddressLine2 = 'N/A';
$currCity = 'N/A';
$currState = 'N/A';
$permAddressLine1 = 'N/A';
$permAddressLine2 = 'N/A';
$permCity = 'N/A';
$permState = 'N/A';

if ($result->num_rows > 0) {
    // Fetch employee data
    $row = $result->fetch_assoc();
    $profileName = $row['full_name'] ?? $profileName;
    $dob = $row['dob'] ?? $dob;
    $profilePic = $row['profile_pic'] ?? $profilePic;
    $userEmail = $row['email'] ?? $userEmail;

    $currAddressLine1 = $row['permanent_address_line1'] ?? $currAddressLine1;
    $currAddressLine2 = $row['permanent_address_line2'] ?? $currAddressLine2;
    $currCity = $row['permanent_city'] ?? $currCity;
    $currState = $row['permanent_state'] ?? $currState;

    $permAddressLine1 = $row['current_address_line1'] ?? $permAddressLine1;
    $permAddressLine2 = $row['current_address_line2'] ?? $permAddressLine2;
    $permCity = $row['current_city'] ?? $permCity;
    $permState = $row['current_state'] ?? $permState;

    // Query to fetch qualifications
    $qualificationsSql = "SELECT id, qualification FROM qualifications WHERE user_id = $employeeId";
    $qualificationsResult = $conn->query($qualificationsSql);
    if ($qualificationsResult->num_rows > 0) {
        while ($row = $qualificationsResult->fetch_assoc()) {
            $qualifications[] = [
                'id' => $row['id'],
                'qualification' => $row['qualification']
            ];
        }
    }

    // Query to fetch experiences
    $experiencesSql = "SELECT id, experience FROM experiences WHERE user_id = $employeeId";
    $experiencesResult = $conn->query($experiencesSql);
    if ($experiencesResult->num_rows > 0) {
        while ($row = $experiencesResult->fetch_assoc()) {
            $experiences[] = [
                'id' => $row['id'],
                'experience' => $row['experience']
            ];
        }
    }
}



    // // Decode qualifications and experiences if stored as JSON (or update query to match your DB structure)
    // $qualifications = json_decode($row['qualifications'], true) ?? [];
    // $experiences = json_decode($row['experiences'], true) ?? [];


$conn->close();
?>
