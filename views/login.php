<?php
include '../database/database.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query using MySQLi
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // Bind parameter (s = string)
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = $id; // Store user ID in session
            
            // ✅ Set a secure cookie for 30 days
            setcookie("user", $id, time() + (86400 * 30), "/", "", false, true); 

            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="../statics/css/bootstrap.min.css" rel="stylesheet">
    <script src="../statics/js/bootstrap.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f6d365, #fda085);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-title {
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
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
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
    <div class="login-container">
        <p class="login-title">🔐 Login</p>
        
        <?php if (!empty($error)) : ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-custom">Login</button>
        </form>

        <p class="mt-3">
            <a href="register.php" class="link">Don't have an account? Register</a>
        </p>
    </div>
</body>
</html>
