<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once "../includes/header.php";
?>  
<link rel="stylesheet" href="../assets/css/item.css">
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
<div id="content">
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
        <form action="../controllers/watchController.php" method="post">
            <input type="hidden" name="watchId" value="<?=$watchId?>">
            <input id="title" name="name" value="<?php echo $watch['name']; ?>"></input>
            <input id="description" name="description" value="<?php echo $watch['description']; ?>"></input>
            <input id="price" name="price" value="<?php echo $watch['price']; ?>"></input><span id="eur">€</span>
            <input id="condition" name="condition" value="<?php echo $watch['wcondition']; ?>"></input>
            <p id="date" name="date"> <?php echo $watch['created_at']; ?></p>
            <button name="update" type="submit">Save</button>
        </form>
    
        
    </div>
    <div id="delete-div">
        <form action="../controllers/watchController.php" method="post">
            <input type="hidden" name="watchId" value="<?=$watchId?>">
            <button name="delete" type="submit">Delete</button>
        </form>

    </div>
</div>
</div>


<script src="../assets/js/carousel.js"></script> 
</body>
</html>
