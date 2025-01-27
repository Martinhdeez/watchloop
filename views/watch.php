<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once "../includes/header.php";
?>  
<link rel="stylesheet" href="../assets/css/item.css">
<link rel="stylesheet" href="../assets/css/carousel.css"> <!-- Nuevo archivo CSS -->
</head>
<body>
<?php
    require_once "../includes/functions.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php"; 
    require_once "../includes/layout.php";

    $user_id = $_SESSION['user_id'];
    $db = new Db();
    $w = new Watch($db, $user_id, null, null, null, null);
    $watchId = $_GET['id'];
    $watch = $w->getWatchById($watchId);
    $imagesPath = $w->setAllExtensions($watchId);
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
        <h1 id="title"><?php echo $watch['name']; ?></h1>
        <p id="description"><?php echo $watch['description']; ?></p>
        <p id="price"><?php echo $watch['price']; ?> €</p>
        <p id="condition"><?php echo $watch['wcondition']; ?></p>
        <p id="date"><?php echo $watch['created_at']; ?></p>
    </div>
</div>

<script src="../assets/js/carousel.js"></script> <!-- Nuevo archivo JS -->
</body>
</html>
