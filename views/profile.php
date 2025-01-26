<?php
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

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $user = $db->updateUser($username, $email, $hashed_password, $user_id);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = 'User updated successfully';

    // Redirige a la misma página para mostrar los cambios
    header("Location: profile.php");
    exit();
}

require_once "../includes/layout.php";
?>
<main class="profile-content">
    
    <div id="section">
    <h1 class="profile-title">User Profile</h1>
    <?php sessionStatus(); ?>
        <section class="profile-info">
            <img class="profile-avatar" src="../public/img/user-icon.webp" alt="User Avatar">
            <div class="profile-details">
                <form action="profile.php" method="POST">
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
                    <div>
                        <a href="index.php">Back to notes</a>
                    </div>
                </form>
        </section>
    </div>
</main>
</body>

</html>