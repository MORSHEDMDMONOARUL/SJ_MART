<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: dashboard.php');
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SJ MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h1 {
            font-size: 32px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .cart-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 20px; 
        }

        .login-container p {
            font-size: 14px;
            color: red;
            margin-bottom: 15px;
        }

        .login-container label {
            display: block;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .login-container input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>SJ MART</h1>
        <img src="https://cdn-icons-png.flaticon.com/512/1170/1170576.png" alt="Shopping Cart Icon" class="cart-icon">
        <?php if (isset($error)): ?>
            <p><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <div class="footer">
            <p>MORSHED MD MONOARUL</p>
            <span>Your trusted shopping partner!</span>
        </div>
    </div>
</body>
</html>
