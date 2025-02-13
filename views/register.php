<?php
include '../database/database.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $error = "Username already taken!";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) { 
            // ✅ Redirect user to login page immediately
            header("Location: login.php?success=registered");
            exit();
        } else {
            $error = "Registration failed: " . $stmt->error;
        }

        $stmt->close();
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="../statics/css/bootstrap.min.css" rel="stylesheet">
    <script src="../statics/js/bootstrap.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #ff758c, #ff7eb3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .register-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .btn-custom {
            background: linear-gradient(45deg, #845ec2, #d65db1);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #d65db1, #845ec2);
            transform: scale(1.05);
        }
        .message {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .link {
            color: #6c757d;
            text-decoration: none;
        }
        .link:hover {
            color: #333;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <p class="register-title">📝 Register</p>

        <?php if (!empty($error)) : ?>
            <p class="message error"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-custom">Register</button>
        </form>

        <p class="mt-3">
            <a href="login.php" class="link">Already have an account? Login</a>
        </p>
    </div>
</body>
</html>
