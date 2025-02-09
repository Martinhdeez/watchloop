<?php 
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once "../auth/auth.php";
    require_once "../config/Db.php";
    require_once "../models/Watch.php";
    require_once "../includes/header.php";
    
    $db = new Db();

    $watch = new Watch($db, $_SESSION['user_id'], null, null, null, null, null);
   
    
    $stmt = $db->conn->prepare("SELECT * FROM favorites WHERE user_id = ?");
    $res = $stmt->execute([$_SESSION['user_id']]);
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $userId = $_SESSION['user_id'];

 ?>   
 <link rel="stylesheet" href="../assets/css/mywatches.css">
 </head> 
<body>
<?php
    require_once "../includes/functions.php"; 
    require_once "../includes/layout.php";
    sessionStatus();
    ?>
    <h1 id="title">FAVORITES</h1>
    <div id = "container" >
        <?php 
            echo '<div class="watches-container">'; 
            foreach($favorites as $favorite){
                $w = $watch->getWatchById($favorite['watch_id']);
                // Recorre cada reloj y muestra su información en un div
                    $watchId = $w['id']; // El ID del reloj
                    $watchName = htmlspecialchars($w['name']); // Nombre del reloj
                    $watchCondition = $watch->getConditionLabel($w['wcondition']); // Condición del reloj
                    $watchPrice = htmlspecialchars($w['price']); // Precio del reloj
                    $user_id = $w['user_id']; // El ID del usuario
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

                    $stmt = $db->conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ? AND watch_id = ?");
                    $stmt->execute([$userId, $watchId]);
                    $isFavorited = $stmt->fetchColumn() > 0;
                
                    // Obtiene la cantidad total de favoritos
                    $stmt = $db->conn->prepare("SELECT COUNT(*) FROM favorites WHERE watch_id = ?");
                    $stmt->execute([$watchId]);
                    $favoritesCount = $stmt->fetchColumn();
                
            
                    // Convertir precio a euros (asumido 1 dólar = 1 euro, ajusta si es necesario)
                    $priceInEuros = number_format($watchPrice, 2); // Aquí podrías integrar una API de cambio de divisas
            
                    // Muestra el div con la información del reloj
                    echo '<div  class="watch-card">';
                    echo '<img src="' . $imageSrc . '" alt="' . $watchName . '" class="watch-image">';
                    echo '<p class="watch-name"><a class="watch-a" href = "../views/watchprofile.php?id='. $w['id'].'">' . $watchName . '</a></p>';
                    echo '<p class="watch-condition">Condition: ' . $watchCondition . '</p>';
                    echo '    <div>
                                    <span class="favorite" data-id="'.$watchId .'">'.$isFavorited ? "&#9733;" : "&#9734".'</span>
                                    <span class="count" id="count-'.$watchId.'">'.$favoritesCount.'</span>

                              </div>';
                    echo '<p class="watch-price">' . $priceInEuros . '€</p>';
                    echo '</div>';
             
            }
            echo '</div>'; ?>
    </div>

    <script>
        $(document).ready(function() {
            $('.favorite').click(function() {
                let favElement = $(this);
                let id = favElement.data('id');
                console.log("Funcion evento click\n");
                $.post('../controllers/favoriteController.php', { item_id: id }, function(response) {
                    let data = JSON.parse(response);
                    if (data.status === 'success') {
                        favElement.toggleClass('favorited', data.favorited);
                        favElement.html(data.favorited ? '&#9733;' : '&#9734;');
                        $('#count-' + id).text(data.count);
                    }
                });
            });
        });
    </script>
</body>