<?php
// models/Chat.php

class Chat {
    /**
     * Instancia de la clase Db.
     *
     * @var Db
     */
    private $db;

    /**
     * Conexión PDO.
     *
     * @var PDO
     */
    private $conn;

    public function __construct() {
        $this->db = new Db();
        $this->conn = $this->db->conn;
    }

    /**
     * Obtiene el chat existente entre dos usuarios para un anuncio (watch) o lo crea si no existe.
     *
     * @param int $user1_id ID del primer usuario.
     * @param int $user2_id ID del segundo usuario.
     * @param int $watch_id ID del anuncio (watch) asociado al chat.
     * @return int El ID del chat.
     */
    public function getOrCreateChat($user1_id, $user2_id, $watch_id) {
        // Se busca un chat existente. Se consideran ambas combinaciones (user1, user2) o (user2, user1)
        $sql = "SELECT chat_id 
                FROM chat_users 
                WHERE ((user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?))
                  AND watch_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user1_id, $user2_id, $user2_id, $user1_id, $watch_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return (int)$result['chat_id'];
        } else {
            // Crear un nuevo chat en la tabla `chats`
            // Se asume que la tabla `chats` tiene una columna auto-incremental y acepta inserciones sin especificar campos
            $stmtChat = $this->conn->prepare("INSERT INTO chats () VALUES ()");
            $stmtChat->execute();
            $chat_id = $this->conn->lastInsertId();

            // Registrar la relación en la tabla `chat_users`
            $stmtCU = $this->conn->prepare("INSERT INTO chat_users (chat_id, user1_id, user2_id, watch_id) VALUES (?, ?, ?, ?)");
            $stmtCU->execute([$chat_id, $user1_id, $user2_id, $watch_id]);

            return (int)$chat_id;
        }
    }

    /**
     * Recupera todos los mensajes de un chat ordenados cronológicamente.
     *
     * @param int $chat_id ID del chat.
     * @return array Lista de mensajes.
     */
    public function getMessages($chat_id) {
        $sql = "SELECT * FROM messages WHERE chat_id = ? ORDER BY timestamp ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$chat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Envía (inserta) un nuevo mensaje en un chat.
     *
     * @param int    $chat_id     ID del chat.
     * @param int    $sender_id   ID del usuario que envía el mensaje.
     * @param int    $receiver_id ID del usuario que recibe el mensaje.
     * @param string $message     Contenido del mensaje.
     * @return bool Resultado de la operación (true si se insertó correctamente).
     */
    public function sendMessage($chat_id, $sender_id, $receiver_id, $message) {
        $chat_id = (int) $chat_id;
        $receiver_id = (int) $receiver_id;  
        $sql = "INSERT INTO messages (chat_id, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$chat_id, $sender_id, $receiver_id, $message]);
    }

    /**
     * Lista los chats en los que participa un usuario, incluyendo el último mensaje y la fecha del mismo.
     *
     * @param int $user_id ID del usuario.
     * @return array Lista de chats con información adicional.
     */


    public function listChatsForUser($user_id) {
        $sql = "
            SELECT 
                cu.id AS chat_id,  
                cu.user1_id,
                cu.user2_id,
                cu.watch_id,
                MAX(m.timestamp) AS last_message_time
            FROM chat_users cu
            LEFT JOIN messages m ON cu.id = m.chat_id
            WHERE cu.user1_id = ? OR cu.user2_id = ?
            GROUP BY cu.id
            ORDER BY last_message_time DESC
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id, $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}

