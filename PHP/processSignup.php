<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['user_type']; // 'patient' or 'therapist'
    
    // Common fields
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Handle file upload
    $profilePicture = null;
    if (isset($_FILES['profile_picture'])) {
        $targetDir = "../uploads/profile_pictures/";
        $fileName = time() . basename($_FILES["profile_picture"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
            $profilePicture = $fileName;
        }
    }
    
    if ($userType === 'patient') {
        $sql = "INSERT INTO patients (first_name, last_name, email, password, dob, gender, 
                mobile, nid, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $password, 
                         $_POST['dob'], $_POST['gender'], $_POST['mobile'], 
                         $_POST['nid'], $profilePicture);
    } else {
        // Handle therapist registration with additional fields
        $sql = "INSERT INTO therapists (first_name, last_name, email, password, 
                specialization, license_number, service_type, experience, 
                availability, service_area, service_mode, profile_picture) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $firstName, $lastName, $email, $password,
                         $_POST['specialization'], $_POST['license_number'],
                         $_POST['service_type'], $_POST['experience'],
                         $_POST['availability'], $_POST['service_area'],
                         $_POST['service_mode'], $profilePicture);
    }
    
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = true;
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: signup.php");
        exit();
    }
}
?>
