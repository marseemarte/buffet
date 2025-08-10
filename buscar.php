<?php

$sql = "SELECT p.id, p.nombre, c.nombre AS categoria 
        FROM productos p
        INNER JOIN categorias c ON p.id_categoria = c.id
        WHERE p.nombre LIKE '%$q%' OR c.nombre LIKE '%$q%'
        LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<a href='#' class='list-group-item list-group-item-action resultado-item' data-id='{$row['id']}'>
                <strong>{$row['nombre']}</strong> <small class='text-muted'>({$row['categoria']})</small>
              </a>";
    }
} else {
    echo "<div class='list-group-item text-muted'>No se encontraron resultados</div>";
}
?>
