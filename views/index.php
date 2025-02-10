<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../config/Db.php";
require_once "../models/Watch.php";
require_once "../includes/header.php";
?>   
<!-- Cargamos los estilos de DataTables y el CSS propio -->
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

// Obtener los datos de los relojes
$watches = $watch->getWatchesArray();
?>

<!-- Panel de filtros (oculto por defecto) -->
<div id="filtersPanel" class="filters-panel">
  <div class="filters-inner">
    <label for="minPrice">Min price:</label>
    <input type="number" id="minPrice" placeholder="Min">
    
    <label for="maxPrice">Max price:</label>
    <input type="number" id="maxPrice" placeholder="Max">
    
    <label for="brandFilter">Brand:</label>
    <select id="brandFilter">
      <option value="">All</option>
      <option value="rolex">ROLEX</option>
      <option value="omega">OMEGA</option>
      <option value="casio">CASIO</option>
      <option value="tissot">TISSOT</option>
      <option value="swatch">SWATCH</option>
      <option value="patek">PATEK</option>
      <option value="lotus">LOTUS</option>
      <option value="armani">ARMANI</option>
    </select>
    
    <label for="conditionFilter">Condition:</label>
    <select id="conditionFilter">
      <option value="">All</option>
      <option value="brandnew">Brand new</option>
      <option value="new">New</option>
      <option value="likenew">Like new</option>
      <option value="used">Used</option>
      <option value="wornout">Worn out</option>
      <option value="notoperational">Not operational</option>
    </select>
    
    <!-- Botón de Reset filters -->
    <button id="applyFilters" class="filter-apply-btn">Reset filters</button>
  </div>
</div>

<!-- La tabla con los relojes -->
<?php
if (!empty($watches)) {
    // La tabla tendrá UNA columna, cuyo contenido será la tarjeta de cada reloj
    echo '<table id="watchesTable" class="display">';
    echo '<thead><tr><th>Watch</th></tr></thead>';
    echo '<tbody>';
    foreach ($watches as $watch) {
         echo '<tr>';
         echo '<td>';
         // Se agregan los atributos data-price, data-brand y data-condition  
         echo '<a href="../views/watchprofile.php?id=' . $watch['id'] . '" class="watch-card" ' .
              'data-price="' . $watch['price'] . '" ' .
              'data-brand="' . strtolower($watch['brand']) . '" ' .
              'data-condition="' . strtolower($watch['condition']) . '">';
         echo '<img src="' . $watch['image'] . '" class="watch-img" alt="' . $watch['name'] . '">';
         echo '<div class="content">';
         echo '<div class="watch-name">' . $watch['name'] . '</div>';
         echo '<div class="watch-brand">' . $watch['brand'] . '</div>';
         echo '<div class="watch-condition">' . $watch['condition'] . '</div>';
         echo '<div class="watch-price">' . $watch['price'] . '€</div>';
         echo '</div>';
         echo '</a>';
         echo '</td>';
         echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<div class="error-message">No watches found.</div>';
}
?>

<!-- Scripts (sin duplicados) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
// Inicialización de DataTable y filtros personalizados
$(document).ready(function() {
    // Inicializamos la DataTable
    var table = $('#watchesTable').DataTable({
        "paging": true,
        "searching": true,
        "info": true,
        "responsive": false,
        "ordering": false,  
        "dom": '<"top"f>rt<"bottom"ip><"clear">',  
        "autoWidth": false 
    });

    // Configuración del buscador: se envuelve el input en un contenedor personalizado y se añade un icono.
    let searchBox = $('.dataTables_filter input');
    searchBox.attr('placeholder', 'Search watch...');
    searchBox.wrap('<div class="custom-search"></div>');
    $('.custom-search').prepend('<i class="fas fa-search"></i>'); // Requiere Font Awesome para el icono

    // Agregar el botón de filtros (toggle) a la derecha del buscador
    $('.custom-search').append('<button id="toggleFilters" class="filter-toggle-btn">Filters</button>');

    // Mover el panel de filtros debajo del buscador
    $('.dataTables_filter').after($('#filtersPanel'));

    // Toggle para mostrar/ocultar el panel de filtros
    $('#toggleFilters').on('click', function() {
        $('#filtersPanel').slideToggle();
        $(this).toggleClass('active');
    });

    // Función de filtrado personalizada
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var rowNode = table.row(dataIndex).node();
        // Se utiliza .attr para obtener el precio (valor numérico esperado)
        var price = parseInt($(rowNode).find('.watch-card').attr('data-price'), 10) || 0;
        var brand = ($(rowNode).find('.watch-card').attr('data-brand') || "").toLowerCase();
        var condition = ($(rowNode).find('.watch-card').attr('data-condition') || "").toLowerCase();

        // Obtención de los valores de los filtros, verificando si los campos están vacíos
        var minPriceVal = $('#minPrice').val();
        var maxPriceVal = $('#maxPrice').val();
        var minPrice = (minPriceVal !== "" ? parseInt(minPriceVal, 10) : 0);
        var maxPrice = (maxPriceVal !== "" ? parseInt(maxPriceVal, 10) : Infinity);

        var filterBrand = ($('#brandFilter').val() || "").toLowerCase();
        var filterCondition = ($('#conditionFilter').val() || "").toLowerCase();

        // Filtrado por precio: se muestran relojes cuyo precio sea >= minPrice y <= maxPrice
        if (price < minPrice || price > maxPrice) {
            return false;
        }
        // Filtrado por marca (si se seleccionó alguna)
        if (filterBrand && brand !== filterBrand) {
            return false;
        }
        // Filtrado por condición (si se seleccionó alguna)
        if (filterCondition && condition !== filterCondition) {
            return false;
        }
        return true;
    });

    // Al hacer "Reset filters": se limpian los campos y se redibuja la tabla
    $('#applyFilters').on('click', function() {
        $('#minPrice').val("");
        $('#maxPrice').val("");
        $('#brandFilter').val("");
        $('#conditionFilter').val("");
        table.draw();
    });
    
    // También se redibuja la tabla al cambiar alguno de los inputs (opcional)
    $('#minPrice, #maxPrice, #brandFilter, #conditionFilter').on('keyup change', function() {
        table.draw();
    });
});
</script>

</body>
</html>
