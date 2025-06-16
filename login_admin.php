<?php
session_start();
$error = "";
$email_cookie = "";

if (isset($_COOKIE["remember_email"])) {
    $email_cookie = trim($_COOKIE["remember_email"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $remember = isset($_POST["remember"]);

    $conn = new mysqli("localhost", "root", "", "pemilihan_ketos");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM admin WHERE BINARY TRIM(email) = ? AND BINARY TRIM(password) = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['email'] = $email;

        if ($remember) {
            setcookie("remember_email", $email, time() + (30 * 24 * 60 * 60)); // 30 hari
        } else {
            setcookie("remember_email", "", time() - 3600);
        }

        header("Location: menu-admin.php");
        exit();
    } else {
        $error = "Email atau password salah.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #74ebd5, #ACB6E5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      width: 420px;
      padding-left: 20px;
    
    }

    h1 {
      text-align: center;
      color: rgb(18, 73, 133);
      margin-bottom: 25px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 16px;
    }

    label {
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
      text-align: left;
      width: 100%;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    input:focus {
      border-color: #007bff;
      outline: none;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.4);
    }

    .remember-me-container {
      margin-top: 10px;
      font-size: 14px;
      display: flex;
      align-items: center;
    }

    .remember-me-container input {
      margin-right: 6px;
    }

    button {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      background-color: rgb(0, 119, 247);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    .pesan-error {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login Admin</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= htmlspecialchars($email_cookie) ?>" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="remember-me-container">
        <input type="checkbox" name="remember" id="remember" <?= $email_cookie ? 'checked' : '' ?>>
        <label for="remember">Remember Me</label>
      </div>
      <button type="submit">Sign In</button>
      <div class="pesan-error"><?= htmlspecialchars($error) ?></div>
    </form>
  </div>
</body>
</html>