<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../config/Db.php";
require_once "../models/Watch.php";
require_once "../includes/header.php";
?>   
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="../assets/css/index.css">
</head> 
<body>
<?php
require_once "../includes/functions.php"; 
require_once "../includes/layout.php";
sessionStatus();
$db = new Db();
$watch = new Watch($db, null, null, null, null, null, null);

// Obtener los datos de los relojes usando el método getWatchesArray()
$watches = $watch->getWatchesArray();

// Verifica si hay relojes
if (!empty($watches)) {
    // Contenedor principal de la tabla
    echo '<div class="table-container">';
    echo '<table id="watchesTable" class="display responsive nowrap">';
    echo '<thead><tr>';
    echo '<th id="column-name">Name</th>';
    echo '<th id="column-name">Brand</th>';
    echo '<th id="column-condition">Condition</th>';
    echo '<th id="column-price">Price</th>';
    echo '<th id="column-image">Image</th>';
    echo '</tr></thead><tbody>';

    // Recorrer los relojes y agregar cada uno a la tabla
    foreach ($watches as $watch) {
        echo '<tr class="watch-row">';
        echo '<td class="watch-name"><a class="watch-a" href = "../views/watchprofile.php?id='. $watch['id'].'">' . $watch['name'] . '</a></td>';
        echo '<td class="watch-brand">'.$watch['brand'].'</td>';
        echo '<td class="watch-condition">' . $watch['condition'] . '</td>';
        echo '<td class="watch-price">' . $watch['price'] . '€</td>';
        echo '<td class="watch-image"><img src="' . $watch['image'] . '" alt="' . $watch['name'] . '" class="watch-image" style="width: 50px; height: 50px;"></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
} else {
    echo '<div class="error-message">No watches found.</div>';
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    // Inicializar el DataTable
    $('#watchesTable').DataTable({
        "paging": true,
        "searching": true,
        "info": true,
        "responsive": true,
        "order": [[2, 'desc']] // Ordenar por precio, por ejemplo
    });
});

</script>

</body>
</html>
