<?php
require_once 'config.php';

$q = $_GET['q'] ?? '';
$conn = getDBConnection();

if (empty($q)) {
    echo "<div class='list-group-item text-muted'>Ingrese un término de búsqueda</div>";
    exit;
}

$sql = "SELECT p.id, p.nombre, c.nombre AS categoria 
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.nombre LIKE ? OR c.nombre LIKE ?
        LIMIT 10";

$stmt = $conn->prepare($sql);
$searchTerm = '%' . $q . '%';
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href='#' class='list-group-item list-group-item-action resultado-item' data-id='{$row['id']}'>
                <strong>{$row['nombre']}</strong> <small class='text-muted'>({$row['categoria']})</small>
              </a>";
    }
} else {
    echo "<div class='list-group-item text-muted'>No se encontraron resultados</div>";
}

$stmt->close();
closeDBConnection($conn);
?>
