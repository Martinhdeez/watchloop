<?php 
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    
    require_once "../auth/auth.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php";
    require_once "../models/Chat.php";
   
    require_once "../includes/header.php";
    
 ?>   
 <link rel="stylesheet" href="../assets/css/mychats.css">
 </head> 
<body>
<?php
    require_once "../includes/functions.php"; 
    require_once "../includes/layout.php";

    $db = new Db();

    $chat = new Chat();

    $w = new Watch($db, null, null, null, null, null, null);

    $chats = $chat->listChatsForUser($_SESSION['user_id']);
?>
    <header class="chat-header">
        <h2>My Chats</h2>
    </header>
    
    <div class="chats-container">
        <?php foreach ($chats as $chat): 
            $watch = $w->getWatchById($chat['watch_id']);
            $receiver_id = ($chat['user1_id'] == $_SESSION['user_id']) ? $chat['user2_id'] : $chat['user1_id'];
            $w->user_id = $watch['user_id'];
            $imagePath = $w->setExtension($watch['id'], "main");
          
            $user = $db->getUser($receiver_id);
            ?>
            <a href="chat.php?watch_id=<?=$chat['watch_id']?>&receiver_id=<?=$receiver_id?>&chat_id=<?=$chat['id']?>" >
                <div class="watch-info">
                    <img src="<?= htmlspecialchars($imagePath); ?>" alt="Watch Image">
                    <div class="watch-details">
                        <h3><?= htmlspecialchars($watch['name']); ?></h3>
                        <p class="price"><?= htmlspecialchars($watch['price']); ?>€</p>
                        <p class="name"><?= htmlspecialchars($user['name'])." ".htmlspecialchars($user['surname']); ?></p>
                    </div>
                    <span class="material-symbols-rounded chat-icon">chevron_right</span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</body>
</html>

