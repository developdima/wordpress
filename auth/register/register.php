<?php
require_once '../db.php';

$first_name = $conn->real_escape_string($_POST['first_name']);
$phone = $conn->real_escape_string($_POST['phone']);
$email = $conn->real_escape_string($_POST['email']);
$gender = $conn->real_escape_string($_POST['gender']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (first_name, phone, email, gender, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $first_name, $phone, $email, $gender, $password);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed']);
}

$stmt->close();
closeDbConnection($conn);
?>
