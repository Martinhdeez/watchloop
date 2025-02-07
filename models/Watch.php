<?php
require_once "../config/Db.php";
class Watch{

    private $conn;
    private $table = 'watches';
    public $id;
    public $user_id;
    public $name;
    public $description;
    public $location;
    public $condition;
    public $price;

    public function __construct($db, $user_id, $name, $description, $condition, $price){  
        $this->user_id = $user_id;  
        $this->name = $name;    
        $this->description = $description;  
        $this->condition = $condition;
        $this->price = $price;
        $this->conn = $db->connect();
    }

    public function upload(){
        if (strlen($this->name) || strlen($this->name) > 50) {
            return "Name must be between 3 and 50 characters.";
        }
        $sql = "INSERT INTO ". $this->table ."( user_id, name, description, wcondition, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $res = $stmt->execute([$this->user_id, $this->name, $this->description, $this->condition, $this->price]); 
        if($res){
            $this->id = $this->conn->lastInsertId();
            return $res;
        }else{
            return "Error: " . $stmt->errorInfo()[2];
        }
    }

    public function upgrade($watchId, $name, $description, $condition, $price){
        try {
            $stmt = $this->conn->prepare("UPDATE ".$this->table." SET name = ?, description = ?, price = ?, wcondition = ?  WHERE id = ?");
            return $stmt->execute([$name, $description, $price, $condition, $watchId]); 
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete($watchId){
        try{
            $stmt = $this->conn->prepare("DELETE FROM ". $this->table." WHERE id = ?");
            return $stmt->execute([$watchId]);
        } catch(PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }


    public function getWatchesByUser($user_id){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM ". $this->table." WHERE user_id = ?");
            $success = $stmt->execute([$user_id]); 
            $watches = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            
            // Verifica si se obtuvo una nota
            if ($success) {
                return $watches; 
            } else {
                return ['error' => 'Usuario no encontrada.']; 
            }
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function getAllWatches(){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM ". $this->table);
            $success = $stmt->execute();
            $watches = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($success) {
                return $watches;
            } else {
                return ['error' => 'No se encontraron relojes.'];
            }
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getWatchById($id){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM ". $this->table." WHERE id = ?");
            $success = $stmt->execute([$id]); 
            $watch = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            // Verifica si se obtuvo una nota
            if ($success) {
                return $watch; 
            } else {
                return ['error' => 'Usuario no encontrada.']; 
            }
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
    // Función para obtener el estado (condition) de una manera legible
public function getConditionLabel($condition) {
    $conditions = [
        'BRANDNEW' => 'Brand New',
        'NEW' => 'New',
        'LIKENEW' => 'Like New',
        'USED' => 'Used',
        'WORNOUT' => 'Worn Out',
        'NOTOPERATIONAL' => 'Not Operational'
    ];

    return isset($conditions[$condition]) ? $conditions[$condition] : 'Unknown';
}


public function getWatchesArray() {
    $watchArray = []; // Array que almacenará todos los relojes
    $watches = $this->getAllWatches(); // Obtener todos los relojes
    // Recorre cada reloj y agrega sus datos al array
    foreach ($watches as $watch) {
        $watchId = $watch['id']; // El ID del reloj
        $user_id = $watch['user_id']; // El ID del usuario
        $watchName = htmlspecialchars($watch['name']); // Nombre del reloj
        $watchCondition = $watch['wcondition']; // Condición del reloj
        $watchPrice = htmlspecialchars($watch['price']); // Precio del reloj
        $imagePathBase = "../publicIMG/$user_id/watch_$watchId/main"; // Ruta base de la imagen

        // Posibles extensiones de la imagen
        $possibleExtensions = ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg', '.ico', '.jp2', 'j2k'];
        $imageSrc = null;

        // Busca la primera imagen válida en las posibles extensiones
        foreach ($possibleExtensions as $ext) {
            $imagePath = $imagePathBase . $ext;
            if (file_exists($imagePath)) {
                $imageSrc = $imagePath;
                break;
            }
        }
        if (!$imageSrc) {
            $imageSrc = 'default.jpg'; // Ruta de imagen predeterminada si no se encuentra una válida
        }

        // Convertir precio a euros
        $priceInEuros = number_format($watchPrice, 2);

        // Crear un array asociativo para el reloj
        $watchData = [
            'id' => $watchId,
            'user_id' => $user_id,
            'name' => $watchName,
            'condition' => $watchCondition,
            'price' => $priceInEuros,
            'image' => $imageSrc
        ];

        // Agregar el reloj al array principal
        $watchArray[] = $watchData;
    }

    // Devolver el array con todos los relojes
    return $watchArray;
}




public function displayWatches() {
    $user_id = $this->user_id;
    $watches = $this->getWatchesByUser($user_id); // Obtener los relojes del usuario

    // Verifica si se obtuvieron relojes
    if (isset($watches['error'])) {
        echo '<div class="error-message">' . $watches['error'] . '</div>';
        return;
    }
    echo '<div class="watches-container">'; // Cambié 'container' a 'watches-container'
    // Recorre cada reloj y muestra su información en un div
    foreach ($watches as $watch) {
        $watchId = $watch['id']; // El ID del reloj
        $watchName = htmlspecialchars($watch['name']); // Nombre del reloj
        $watchCondition = $this->getConditionLabel($watch['wcondition']); // Condición del reloj
        $watchPrice = htmlspecialchars($watch['price']); // Precio del reloj
        $imagePathBase = "../publicIMG/$user_id/watch_$watchId/main"; // Ruta base de la imagen

        // Posibles extensiones de la imagen
        $possibleExtensions = ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg', '.ico', '.jp2', 'j2k'];
        $imageSrc = null;

        // Busca la primera imagen válida en las posibles extensiones
        foreach ($possibleExtensions as $ext) {
            $imagePath = $imagePathBase . $ext;
            if (file_exists($imagePath)) {
                $imageSrc = $imagePath;
                break;
            }
        }
        if (!$imageSrc) {
            $_SESSION['error'] = "Not found an image for the watch $watchName";
        }

        // Convertir precio a euros (asumido 1 dólar = 1 euro, ajusta si es necesario)
        $priceInEuros = number_format($watchPrice, 2); // Aquí podrías integrar una API de cambio de divisas

        // Muestra el div con la información del reloj
        echo '<a href="../views/watch.php?id='. $watchId .'" class="watch-card">'; // Ahora el enlace envuelve todo el div del reloj
        echo '<img src="' . $imageSrc . '" alt="' . $watchName . '" class="watch-image">';
        echo '<p class="watch-name">' . $watchName . '</p>';
        echo '<p class="watch-condition">Condition: ' . $watchCondition . '</p>';
        echo '<p class="watch-price">' . $priceInEuros . '€</p>';
        echo '</a>'; // Cierra el enlace aquí
    }
    echo '</div>';
}



    public function setExtension($watchId, $img){
        $imagePathBase = "../publicIMG/$this->user_id/watch_$watchId/$img"; // Ruta base de la imagen
        // Posibles extensiones de la imagen
        $possibleExtensions = ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg', '.ico', '.jp2', 'j2k'];
        $imageSrc = null;
        // Busca la primera imagen válida en las posibles extensiones
        foreach ($possibleExtensions as $ext) {
            $imagePath = $imagePathBase . $ext;
            if (file_exists($imagePath)) {
                $imageSrc = $imagePath;
                break;
            }
        }
        return $imageSrc;
    }
    
    public function setAllExtensions($watchId) {
        $imagePath = []; // Inicializa el arreglo vacío para almacenar las rutas
        $images = ["main", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20"];
        
        foreach ($images as $img) {
            $path = $this->setExtension($watchId, $img); // Llama a la función setExtension
            
            if (!$path) { // Si no se obtiene una ruta válida, rompe el bucle
                break;
            }
            
            $imagePath[] = $path; // Almacena la ruta en el arreglo
        }
        
        return $imagePath; // Devuelve el arreglo con las rutas generadas
    }
    
}