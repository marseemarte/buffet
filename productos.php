<?php
require_once 'config.php';

$conn = getDBConnection();

$sql = "SELECT p.id, p.nombre, p.comentarios, p.stock, p.vegetariano, p.tacc, p.precio, p.id_categoria, c.nombre AS categoria_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id
        ORDER BY p.id_categoria, p.nombre";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $vegetariano = $row['vegetariano'] ? 'Vegetariano' : 'No vegetariano';
        $tacc = $row['tacc'] ? 'Contiene TACC' : 'Sin TACC';
        $stockClass = $row['stock'] > 0 ? 'text-success' : 'text-danger';
        $stockText = $row['stock'] > 0 ? 'Disponible' : 'Sin stock';
        
        echo '<div class="swiper-slide">';
        echo '<div class="producto-card text-center mx-auto">';
        echo '<img src="img/' . strtolower(str_replace(' ', '_', $row['nombre'])) . '.png" alt="' . $row['nombre'] . '" class="img-fluid mb-3" onerror="this.src=\'img/hamburguesa.png\'">';
        echo '<h5 class="fw-bold mb-2">' . $row['nombre'] . '</h5>';
        echo '<span class="badge bg-danger mb-2">Sale</span>';
        echo '<p class="mb-3">' . $row['comentarios'] . '<br>$' . number_format($row['precio'], 0) . '</p>';
        echo '<button class="btn btn-red w-100" onclick="abrirModal(' . $row['id'] . ')">Comprar</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="col-12 text-center"><p>No hay productos disponibles</p></div>';
}

closeDBConnection($conn);
?>
