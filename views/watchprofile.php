<?php
    require_once "../config/Db.php";
    require_once "../models/Watch.php";
    require_once "../includes/functions.php";

        
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $watchId = $_GET['id'];

    $db = new Db();

    $w = new Watch($db, null, null, null, null, null, null);
    $watch = $w->getWatchById($watchId);
    $user = $db->getUser($watch['user_id']);

    $w->user_id = $watch['user_id'];
    $imagesPath = $w->setAllExtensions($watchId);

    require_once "../includes/header.php";
?>
<link rel="stylesheet" href="../assets/css/watchprofile.css">
</head>
<body>
<?php
    require_once "../includes/layout.php";
    sessionStatus();
?>
<div id="container">
    <div id="image-carousel">
        <div class="carousel-images">
            <?php foreach ($imagesPath as $image): ?>
                <img class="image" src="<?php echo $image; ?>" alt="Product Image">
            <?php endforeach; ?>
        </div>
        <button id="prev" class="carousel-arrow">&#9664;</button>
        <button id="next" class="carousel-arrow">&#9654;</button>
    </div>

    <div id="details">
        <h2 id="title"><?php echo htmlspecialchars($watch['name']); ?></h2>
        <p id="description"><?php echo nl2br(htmlspecialchars($watch['description'])); ?></p>
        <p id="price"><?php echo htmlspecialchars($watch['price']); ?> €</p>
        <p id="condition"><strong>Condition:</strong> <?php echo htmlspecialchars($watch['wcondition']); ?></p>
        <p id="date"><strong>Created at:</strong> <?php echo htmlspecialchars($watch['created_at']); ?></p>
    </div>

    <div id="owner-info">
        <!--<img class="user-avatar" src="<?php //echo htmlspecialchars($user['avatar']); ?>" alt="User Avatar"> -->
        <form class="user-details" action="../controllers/chatController.php" method="post">
            <input type="hidden" name="receiver_id" value="<?php echo $user['id']; ?>">
            <input type="hidden" name="watch_id" value="<?php echo $watchId; ?>">
            <input type="hidden" name="sender_id" value="<?php echo $_SESSION['user_id']; ?>">
            <p class="user-name"><?php echo htmlspecialchars($user['name']); ?></p>
            <p class="user-location"><?php echo htmlspecialchars($user['location']); ?></p> <!-- Mostrar ubicación -->
            <button class="contact-button" >Contact</button>
        </form>
    </div>
</div>
<script src="../assets/js/carousel.js"></script>
</body>
</html>
