<?php 
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once "../auth/auth.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php";
    
    $db = new Db();

    $watch = new Watch($db, $_SESSION['user_id'], null, null, null, null);
    require_once "../includes/header.php";
    
 ?>   
 <link rel="stylesheet" href="../assets/css/watch.css">
 </head> 
<body>
<?php
    require_once "../includes/functions.php"; 
    require_once "../includes/layout.php";
    sessionStatus();
    ?>
    <h1 id="title">MY WATCHES</h1>
    <div id = "container" >
        <?php $watch->displayWatches(); ?>
    </div>

</body>
</html>