<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Board</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .signup-container {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .signup-container h2 {
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    label {
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="submit"] {
      width: 250px;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }

    input[type="submit"] {
      background-color: #3498db;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }

    a {
      text-decoration: none;
      color: #3498db;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Sign Up</h2>
    <!-- 회원 가입 폼 -->
    <form action="../controllers/SignUpController.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      <input type="submit" value="Sign Up">
    </form>
    <!-- 로그인 링크 -->
    <p>Already have an account? <a href="../login.php">Login</a></p>
  </div>
</body>
</html>
