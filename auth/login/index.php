<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Login</h2>
        <form id="loginForm" onsubmit="loginUser(event)">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-auto">
                    <a href="/register" class="btn btn-link">Registration</a>
                </div>
            </div>
        </form>
    </div>
    
    <script src="/js/login.js"></script>
</body>
</html>
