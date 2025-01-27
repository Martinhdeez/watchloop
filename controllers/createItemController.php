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

    // Crear una instancia de Watch y llamar al método upload para insertar el reloj
    $watch = new Watch($db, $user_id, $name , $description, $condition, $price);
    $res = $watch->upload();

    // Si la inserción fue exitosa, obtenemos la última ID insertada
    if ($res) {
        $last_id = $watch->id;
        echo "Archivo con id: $last_id\n";
        $_SESSION['success'] = "Watch uploaded successfully";

    } else {
        $_SESSION["error"] = $res;
        echo "error no ha conseguido subir bien el archivo\n";
        header("Location: ../views/index.php");
        exit();
    }

    //foto principal

    $main_photo = $_FILES['mainPhoto'];
    echo "entra en main photo";
    $file_info = pathinfo($main_photo['name']);
    $ext = $file_info['extension'];
    $folder_name = "../publicIMG/" . $_SESSION['user_id'];


    if (!file_exists($folder_name)) {
        echo "crea el directorio";
        mkdir($folder_name, 0777, true);
    }

    $folder_name = $folder_name . "/watch_" . $last_id;


    if (!file_exists($folder_name)) {
        echo "crea el directorio";
        mkdir($folder_name, 0777, true);
    }

    // Generamos un nuevo nombre para la foto principal
    $new_file_name = $folder_name . "/main." . $ext;

    if (move_uploaded_file($main_photo['tmp_name'], $new_file_name)) {
        echo "ha movido la carpeta exitosamente\n";
        $main_photo = $new_file_name;
    } else {
        echo "Error al mover el archivo: " . $main_photo['name'];
    }

    // Verificamos si se enviaron archivos
    if (isset($_FILES['photos']) && count($_FILES['photos']['name']) > 0) {
        // Arreglo para almacenar las rutas de las fotos subidas
        $photos = [];

        // Iteramos sobre cada archivo en el arreglo 'photos'
        for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
            $file_name = $_FILES['photos']['name'][$i];
            $tmp_name = $_FILES['photos']['tmp_name'][$i];

            if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                $file_info = pathinfo($file_name);
                $ext = $file_info['extension'];

                // Crear una carpeta con la ID del producto
                $folder_name = "../publicIMG/".$_SESSION['user_id']."/watch_" . $last_id;
                if (!file_exists($folder_name)) {
                    mkdir($folder_name, 0777, true);
                }

                // Generamos un nuevo nombre para la foto
                $new_file_name = $folder_name . "/" . ($i + 1) . "." . $ext;

                if (move_uploaded_file($tmp_name, $new_file_name)) {
                    $photos[] = $new_file_name;
                } else {
                    echo "Error al mover el archivo: $file_name";
                }
            }
        }
    }

}

header("Location: ../views/index.php");
exit();
?>
