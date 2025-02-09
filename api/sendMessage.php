<?php
require_once "../config/Db.php";
require_once "../models/Chat.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["chat_id"], $data["sender_id"], $data["receiver_id"], $data["message"])) {
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

$chat = new Chat();
$chat->sendMessage($data["chat_id"], $data["sender_id"], $data["receiver_id"], $data["message"]);

echo json_encode(["success" => true]);
?>
