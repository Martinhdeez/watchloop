<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../auth/auth.php";
require_once "../config/Db.php";
require_once "../includes/functions.php";

$db = new Db();


$user_id = $_SESSION['user_id'];

$user = $db->getUser($user_id);

// Manejo del formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $name = $_POST['name'];
    $surname = $_POST['surname'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user = $db->updateUser($name, $surname, $username, $email, $hashed_password, $user_id);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = 'User updated successfully';

    header("Location:index.php");
    exit();
}
require_once "../includes/header.php";
?>
<link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<?php require_once "../includes/layout.php"; ?>
    <div id="section">
    <h1 class="profile-title">User Profile</h1>
    <?php sessionStatus(); ?>
        <section class="profile-info">
            <div class="profile-details">
                <form action="profile.php" method="POST">
                    
                    <div class="input">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name"
                            value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>

                    <div class="input">
                        <label for="surname">Surname:</label>
                        <input type="text" id="surname" name="surname"
                            value="<?= htmlspecialchars($user['surname']) ?>" required>
                    </div>


                    <div class="input">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username"
                            value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>

                    <div class="input">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                            required>
                    </div>

                    <div class="input">
                        <label for="password">New password :</label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div>
                        <button type="submit" class="edit-profile-button">Save changes</button>
                    </div>
                </form>
        </section>
    </div>
</body>

</html>