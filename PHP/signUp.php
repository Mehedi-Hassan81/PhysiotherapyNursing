<?php
session_start();

$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = "Mehedi@2310"; // Replace with your DB password
$dbname = "db1";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle patient signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_type']) && $_POST['user_type'] === 'patient') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $nid = $_POST['nid'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $captcha_response = $_POST['g-recaptcha-response'];
    $secret_key = 'your-secret-key'; // Replace with your reCAPTCHA secret key
    $captcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha_response");
    $captcha_result = json_decode($captcha_verify);

    if (!$captcha_result->success) {
        die("reCAPTCHA verification failed.");
    }

    $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, dob, gender, mobile, email, nid, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $dob, $gender, $mobile, $email, $nid, $password);

    if ($stmt->execute()) {
        echo "Patient account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle therapist/nurse signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_type']) && $_POST['user_type'] === 'therapist') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $nid = $_POST['nid'];
    $license_no = $_POST['license_no'];
    $service_type = $_POST['service_type'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $captcha_response = $_POST['g-recaptcha-response'];
    $secret_key = 'your-secret-key'; // Replace with your reCAPTCHA secret key
    $captcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha_response");
    $captcha_result = json_decode($captcha_verify);

    if (!$captcha_result->success) {
        die("reCAPTCHA verification failed.");
    }

    $certificates = [];
    if (!empty($_FILES['certificates']['name'][0])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['certificates']['tmp_name'] as $key => $tmp_name) {
            $filename = basename($_FILES['certificates']['name'][$key]);
            $target_file = $upload_dir . $filename;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $certificates[] = $target_file;
            }
        }
    }

    $certificates_json = json_encode($certificates);

    $stmt = $conn->prepare("INSERT INTO therapists (first_name, last_name, dob, gender, mobile, email, nid, license_no, service_type, password, certificates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $first_name, $last_name, $dob, $gender, $mobile, $email, $nid, $license_no, $service_type, $password, $certificates_json);

    if ($stmt->execute()) {
        echo "Therapist account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>