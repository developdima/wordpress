<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Registration Form</h2>
        <form id="registrationForm">
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter phone number">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="/js/registration.js"></script>
</body>
</html>
