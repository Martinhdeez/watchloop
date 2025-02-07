<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once "../config/Db.php";
require_once "../models/Watch.php";
require_once "../models/Chat.php";
require_once "../includes/header.php";
?>   
<link rel="stylesheet" href="../assets/css/chat.css">
</head> 
<body>
<?php
require_once "../includes/functions.php"; 
require_once "../includes/layout.php";

// Get chat and user IDs from URL
$receiver_id = $_GET['receiver_id'] ?? null;
$sender_id = $_SESSION['user_id'];
$watch_id = $_GET['watch_id'] ?? null;
$chat_id = $_GET['chat_id'] ?? null;

if (!$receiver_id || !$sender_id) {
    die("Error: Invalid user ID.");
}

// Fetch messages
$chat = new Chat();
$messages = $chat->getMessages($chat_id);

$db = new Db();
// Fetch watch details
$w = new Watch($db, null, null, null, null, null);
$watch = $w->getWatchById($watch_id);

$imagePath = $w->setExtension($watch['id'], "main");

?>

<div class="chat-container">
    <!-- Watch details header -->
    <header class="chat-header">
        <div class="watch-info">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Watch Image">
            <div class="watch-details">
                <h3><?php echo htmlspecialchars($watch['name']); ?></h3>
                <p class="price">$<?php echo htmlspecialchars($watch['price']); ?></p>
            </div>
        </div>
    </header>

    <!-- Chat messages area -->
    <section class="chat-window">
        <div class="chat-messages" id="chatMessages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo ($message['sender_id'] == $sender_id) ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($message['message']); ?></p>
                    <span class="time"><?php echo date("H:i", strtotime($message['created_at'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chat input area -->
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Type a message...">
            <button onclick="sendMessage(<?php echo $sender_id; ?>, <?php echo $receiver_id; ?>, <?php echo $chat_id; ?>)">Send</button>
        </div>
    </section>
</div>

<script src="../assets/js/chat.js"></script>

</body>
</html>
