<?php
require_once "../config/Db.php";
require_once "../models/Chat.php";

header('Content-Type: application/json');

$chat_id = $_GET['chat_id'] ?? null;
if (!$chat_id) {
    echo json_encode(["error" => "Chat ID not provided"]);
    exit();
}

$chat = new Chat();
$messages = $chat->getMessages($chat_id);

echo json_encode($messages);
?>
