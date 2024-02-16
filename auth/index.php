<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
if (isset($_SESSION['user_id'])) {
    require_once 'db.php';
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    }
} else {
    echo 'Welcome!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <?php if($userData): ?>
            <div class="card-body">
                <h5 class="card-title">Welcome, <?=$userData['first_name'];?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Email: <strong><?=$userData['email'];?></strong></li>
                <li class="list-group-item">Phone: <strong><?=$userData['phone'];?></strong></li>
                <li class="list-group-item">Gender: <strong><?=$userData['gender'];?></strong></li>
            </ul>
            <div class="card-body">
                <a href="/logout.php" class="btn btn-warning js-exit">exit</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.getElementById('logoutButton').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'logout.php', true);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location.href = '/login';
            }
        };
        xhr.send();
    });
    </script>
</body>
</html>

<?php
    $stmt->close();
    closeDbConnection($conn);
?>