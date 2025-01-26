<?php
require_once "../../includes/functions.php";
session_start();

if (isset($_SESSION["username"])) {
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/idStyles.css">
    <title>Watchloop</title>
</head>

<body>
    <main>
        <div class="background"></div><!--Estilos fondo-->

        <div class="allContainer">
            <div class="backbox">
                <div class="loginBackBox">
                    <h3>
                        Have you already an <br> account?
                    </h3>
                    <p>Log in to enter this website</p>
                    <button id="login">Login</button>
                </div>
                <div class="registerBackBox">
                    <h3>Don't have an account yet?</h3>
                    <p>Sing up to enter this website </p>
                    <button id="register">Sign up</button>
                </div>
            </div>

            <div class="loginRegister">
                <form action="../../controllers/loginController.php" class="login" method="POST">
                    <?php sessionStatus(); ?>
                    <h2>Login</h2>
                    <input type="text" placeholder="username" name="username" value="<?=isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : ''; ?>" required>
                    <input type="password" placeholder="password" name="password" required>
                    <button id="Enter" name="login" type="submit">Enter</button>
                </form>


                <form action="../../controllers/loginController.php" method="POST" class="singup">
                    <?php sessionStatus(); ?>
                    <h2>Sign up</h2>
                    <input type="text" placeholder="Name" name="name"value="<?=isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" required>
                    <input type="text" placeholder="Surname" name="surname"value="<?=isset($_SESSION['form_data']['surname']) ? htmlspecialchars($_SESSION['form_data']['surname']) : ''; ?>" required>
                    <input type="text" placeholder="Username" name="rusername" value="<?=isset($_SESSION['form_data']['rusername']) ? htmlspecialchars($_SESSION['form_data']['rusername']) : ''; ?>" required>
                    <input type="text" placeholder="Email" name="email" value="<?=isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
                    <input type="password" placeholder="Password" name="rpassword" required>
                    <input type="password" placeholder="Confirm Password" name="confirmPass" required>
                    <button id="register" name="register" type="submit">Sign up</button>
                </form>
            </div>

        </div>
    </main>
    <script src="../../assets/js/id.js"></script>
</body>

</html>
