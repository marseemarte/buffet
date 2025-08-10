<?php
$conn = new mysqli("localhost", "root", "", "buffet");
$id = intval($_GET['id']);

$sql = "SELECT p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = $id";
$result = $conn->query($sql);
$producto = $result->fetch_assoc();
?>

<div class="modal-header">
    <h5 class="modal-title"><?= $producto['nombre'] ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body text-center">
    <img src="img/productos/<?= $producto['imagen'] ?>" class="img-fluid mb-3" style="max-height:200px;">
    <p><?= $producto['descripcion'] ?></p>
    <p><strong>Precio:</strong> S/ <?= number_format($producto['precio'], 2) ?></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger">Agregar al carrito</button>
</div>
