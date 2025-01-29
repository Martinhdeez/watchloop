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
    $watch = new Watch($db, null, null, null, null, null);
    $watches = $watch->getAllWatches();

    // Aquí puedes poner la llamada a tu método displayWatchesTable(), pero modificada
    // para devolver una estructura que DataTables pueda utilizar.

    // Verifica si hay relojes
    if (!empty($watches)) {
        ?>
       
            <?php $watch->displayWatchesTable($watches); 
            
        
            ?>
       
    <?php
    } else {
        echo '<div class="error-message">No watches found.</div>';
    }
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
  $(document).ready(function() {
    // Si decides mantener una tabla y aplicar DataTables, mantén esto.
    $('#watchesTable').DataTable({
        "paging": true,
        "searching": true,
        "info": true,
        "responsive": true,
        "order": [[3, 'desc']]
    });
});

</script>
</body>
</html>
