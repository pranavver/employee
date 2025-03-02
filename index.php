<?php $version=time()?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/login.css?v=<?=$version?>">
</head>
<body>
    <h3>Employee Login</h3>
    <div id="container">
        <form id="login-form" action="./pages/login_emp.php" method="post">
            <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            </div>

            <input id="btn" type="submit" value="Login"/>
        </form>
    <p class="create-account">
      Don’t have an account? <a href="./pages/register.php">Create Account</a>
    </p>
    </div>
    <script src="./js/login.js?v=<?=$version?>"></script>
</body>
</html>