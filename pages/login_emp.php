<?php

require_once "../database/db_connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?"); //prepared statement (stmt)
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch user data
        $stmt->bind_result($id, $hashedPassword);// binds the result columns from the database to the PHP variables $id and $hashedPassword
        $stmt->fetch();// from the local memory buffer
        
        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables
            session_start();
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            
            // Redirect to dashboard
            $stmt->close();
            header("Location: ../pages/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='../index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found. Please register.'); window.location.href='../index.php';</script>";
        exit();
    }
    
    
}

$conn->close();
?>