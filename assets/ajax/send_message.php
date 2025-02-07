<?php
require_once "../config/Db.php";
require_once "../models/Chat.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sender_id = $_POST["sender_id"];
    $receiver_id = $_POST["receiver_id"];
    $chat_id = $_POST["chat_id"];
    $message = trim($_POST["message"]);

    if ($sender_id && $receiver_id && $chat_id && $message) {
        $chat = new Chat();
        $result = $chat->sendMessage($sender_id, $receiver_id, $chat_id, $message);

        echo json_encode(["success" => $result]);
    } else {
        echo json_encode(["error" => "Invalid input"]);
    }
}
?>
