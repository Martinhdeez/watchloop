<?php
require_once "../config/Db.php";
require_once "../models/Watch.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $db = new Db();

    $user_id = $_SESSION['user_id'];
    $name = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $condition = $_POST['condition'];


    $watch = new Watch($db, $user_id, $name , $description,  $condition, $price);

    $res = $watch->upload();

    if ($res) {
        $_SESSION['success'] = "Watch uploaded successfully";
    } else {
        $_SESSION["error"] = $res;
        header("Location: ../views/index.php");
        exit();
    }


    // Verificamos si se enviaron archivos
    if (isset($_FILES['photos']) && count($_FILES['photos']['name']) > 0) {
        // Arreglo para almacenar las rutas de las fotos subidas
        $photos = [];

        // Iteramos sobre cada archivo en el arreglo 'photos'
        for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
            // Obtenemos el nombre y la ruta temporal de la foto
            $file_name = $_FILES['photos']['name'][$i];  // Nombre original del archivo
            $tmp_name = $_FILES['photos']['tmp_name'][$i]; // Ruta temporal del archivo

            // Comprobamos si no hubo error al subir el archivo
            if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                // Extraemos la extensión del archivo usando pathinfo
                $file_info = pathinfo($file_name);
                $ext = $file_info['extension'];  // Obtiene la extensión del archivo (ej. 'jpg', 'png')

                // Crear una carpeta con la ID del producto (por ejemplo, 'watch_1234')
                $folder_name = "../publicIMG/watch_" . $last_inserted_id;
                if (!file_exists($folder_name)) {
                    mkdir($folder_name, 0777, true);  // Crear la carpeta si no existe
                }

                // Generamos un nuevo nombre para la foto con un número secuencial
                $new_file_name = $folder_name . "/" . ($i + 1) . "." . $ext;

                // Movemos el archivo a la carpeta recién creada
                if (move_uploaded_file($tmp_name, $new_file_name)) {
                    // Si se movió correctamente, lo agregamos al arreglo
                    $photos[] = $new_file_name;
                } else {
                    echo "Error al mover el archivo: $file_name";
                }
            }
        }

        
    } 
    $main_photo = $_FILES['mainPhoto'];
    $file_info = pathinfo($main_photo);
    $ext = $file_info['extension'];
    $folder_name = "../publicIMG/watch_" . $last_inserted_id;
    if (!file_exists($folder_name)) {
        mkdir($folder_name, 0777, true);  // Crear la carpeta si no existe
    }
    $new_file_name = $folder_name . "/main" . $ext;
    if (move_uploaded_file($main_photo, $new_file_name)) {
        // Si se movió correctamente, lo agregamos al arreglo
        $main_photo = $new_file_name;
    } else {
        echo "Error al mover el archivo: $main_photo";
    }

}

header("Location: ../views/index.php");
exit();
?>
