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

if(!$chat_id){
    die("Error: Chat not found");
}

if($_SESSION['user_id'] != $receiver_id && $_SESSION['user_id'] != $sender_id){
    die("This chat are not yours.");
}

if (!$receiver_id || !$sender_id) {
    die("Error: Invalid user ID.");
}
// Fetch messages
$chat = new Chat();

if(isset($_POST['send'])){
    $message = $_POST['message'];
    $chat->sendMessage( $chat_id, $sender_id, $receiver_id, $message);

    // Redirige para evitar el reenvío del formulario
    header("Location: chat.php?watch_id=$watch_id&receiver_id=$receiver_id&chat_id=$chat_id");
    exit();
}
$messages = $chat->getMessages($chat_id);

$db = new Db();
// Fetch watch details
$w = new Watch($db, $receiver_id, null, null, null, null, null);
$watch = $w->getWatchById($watch_id);

$user = $db->getUser($receiver_id);
$w->user_id = $watch['user_id'];
$imagePath = $w->setExtension($watch['id'], "main");

?>

<div class="chat-container">
    <!-- Watch details header -->
    <header class="chat-header">
        <div class="watch-info">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Watch Image">
            <div class="watch-details">
                <h3><?php echo htmlspecialchars($watch['name']); ?></h3>
                <p class="price"><?php echo htmlspecialchars($watch['price']); ?>€</p>
                <p class="name"><?= htmlspecialchars($user['name']." ".$user['surname']); ?></p>
            </div>
        </div>
    </header>

    <!-- Chat messages area -->
    <section class="chat-window">
        <div class="chat-messages" id="chatMessages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo ($message['sender_id'] == $sender_id) ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($message['message']); ?></p>
                    <span class="time"><?php echo date("H:i", strtotime($message['timestamp'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chat input area -->
        <form class="chat-input" method="post" action="chat.php?watch_id=<?=$watch_id?>&receiver_id=<?=$receiver_id?>&chat_id=<?=$chat_id?>">
            <input type="text" id="messageInput" name="message" placeholder="Type a message...">
            <button type="submit" name="send">Send</button>
        </form>
    </section>
</div>

<script>
    const chatMessages = document.getElementById("chatMessages");
    const chatId = "<?= $chat_id ?>"; // Chat ID actual

    const options = { hour: "2-digit", minute: "2-digit", hour12: false }; // 24h sin segundos

    function actualizarChat() {
        fetch(`../api/getMessages.php?chat_id=${chatId}`)
            .then(response => response.json())
            .then(messages => {
                chatMessages.innerHTML = ""; // Limpiar mensajes antiguos
                messages.forEach(message => {
                    const div = document.createElement("div");
                    div.classList.add("message", message.sender_id == "<?= $sender_id ?>" ? "sent" : "received");
                    div.innerHTML = `
                        <p>${message.message}</p>
                        <span class="time">${new Date(message.timestamp).toLocaleTimeString("es-ES", options)}</span>
                    `;
                    chatMessages.appendChild(div);
                });

                chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll hacia abajo
            });
    }

    // Actualiza el chat cada 2 segundos
    setInterval(actualizarChat, 2000);
    actualizarChat(); // Cargar mensajes al inicio

    // Enviar mensaje sin recargar la página
    document.querySelector(".chat-input").addEventListener("submit", function(event) {
        event.preventDefault();
        const mensajeInput = document.getElementById("messageInput");
        const mensaje = mensajeInput.value.trim();
        if (mensaje === "") return;

        fetch("../api/sendMessage.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                chat_id: chatId,
                sender_id: "<?= $sender_id ?>",
                receiver_id: "<?= $receiver_id ?>",
                message: mensaje
            })
        }).then(() => {
            mensajeInput.value = "";
            actualizarChat();
        });
    });

    // Auto-scroll al último mensaje
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Llamar la función al cargar la página
    document.addEventListener("DOMContentLoaded", scrollToBottom);
</script>

</body>
</html>
