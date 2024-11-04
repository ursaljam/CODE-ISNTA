<?php
session_start();
require_once('connection.php');

if (isset($_POST['register'])) {
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $address = $_POST['address'];
    $bday = $_POST['bday'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = "Customer";
    $created = date('Y-m-d H:i:s');

    $connection = (new Connection())->OpenConnection();

    // Check if the username already exists
    $stmnt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmnt->execute([$username]);
    $user = $stmnt->fetch();

    if ($user) {
        echo "Username already exists. Please choose another one.";
        header('Location: login.php');
        exit;
    } else {
        try {
            // Hash the password
            $maicaPassword = maica($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (first_name, last_name, address, birthdate, gender, username, password, role, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmnt = $connection->prepare($query);
            $stmnt->execute([$firstname, $lastname, $address, $bday, $gender, $username, $hashedPassword, $role, $created]);

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            // Log the error
            error_log("Error in registration: " . $e->getMessage());
            echo "An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #808D7C;
            margin-top: 50px;
            font-family: 'Montserrat', sans-serif;
        }
        .container {
            box-shadow: rgba(0, 0, 0, 0.44) 0px 3px 8px;
            border-radius: 20px;
            max-width: 500px;
            margin: auto;
            padding: 20px;
        }
        .login-link {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <a href="index.php" class="login-link btn btn-success">Login</a>
    <div class="container bg-light mt-4">
        <h2 class="text-center mb-4">Register</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="fname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lname" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" required>
            </div>
            <div class="mb-3">
                <label for="inputDate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="inputDate" name="bday" required>
            </div>
            <div class="mb-3">
                <label for="inputState" class="form-label">Gender</label>
                <select id="inputState" class="form-select" name="gender" required>
                    <option selected disabled>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-warning" name="register">Register</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
