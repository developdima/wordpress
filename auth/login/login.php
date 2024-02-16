<?php
require_once '../db.php';

$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

$query = "SELECT id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['user_id'] = $row['id'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid login credentials']);
    }
} else {
    echo json_encode(['success' => false, 'message' => $email]);
}

$stmt->close();
closeDbConnection($conn);
?>
