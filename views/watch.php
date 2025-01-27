<?php 
    require_once "../includes/header.php";
 ?>   
 </head> 
<body>
<?php
    require_once "../includes/functions.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php"; 
    require_once "../includes/layout.php";

    $db = new Db();
    $w = new Watch($db, null, null, null, null, null);
    $watchId = $_GET['id'];
    echo $watchId;
    $watch = $w->getWatchById( $watchId);
    echo $watch['name'];
    $imagesPath = $w->setAllExtensions($watchId);
    echo $imagesPath[1];
    $user_id = $_SESSION['user_id'];

?>
<div>
   <?php displayImages( $imagesPath); ?>
</div>


</body>
</html>