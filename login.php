<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login_css.css">
</head>

<body>
    <div class="container">
        <header>
            <h1 style="font-family: 'Playfair Display', serif;;font-size: 50px;">Ceylon Bites</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php#menu">Menu</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">My Cart</a></li>
                </ul>
            </nav>
        </header>


        <div class="login-container">
            <div class="login-form">
                <h1>Login</h1>
                <form id="loginForm" action="user_login.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" onclick="submitForm()">Login</button>
                </form>

                <p style="font-size: 20px;">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>

    <script src="login_script.js"></script>
</body>

</html>