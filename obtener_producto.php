<?php
header('Content-Type: application/json');
require_once 'config.php';

$conn = getDBConnection();

$id = intval($_GET['id']);

$sql = "SELECT p.id, p.nombre, p.comentarios, p.stock, p.vegetariano, p.tacc, p.precio, p.id_categoria, c.nombre AS categoria_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    
    // Determinar información nutricional según la categoría
    $infoNutricional = "";
    switch(strtolower($producto['categoria_nombre'])) {
        case 'hamburguesas':
            $infoNutricional = "Contiene: pan de hamburguesa, medallón de carne, lechuga, tomate, cebolla";
            break;
        case 'milanesas':
            $infoNutricional = "Contiene: pan rallado, carne de ternera, huevo, especias";
            break;
        case 'pollo':
            $infoNutricional = "Contiene: pechuga de pollo, especias, aceite de oliva";
            break;
        case 'pescado':
            $infoNutricional = "Contiene: filete de pescado, limón, hierbas aromáticas";
            break;
        case 'ensaladas':
            $infoNutricional = "Contiene: vegetales frescos, aceite de oliva, vinagre";
            break;
        default:
            $infoNutricional = "Contiene: ingredientes frescos y naturales";
    }
    
    $response = [
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'categoria' => $producto['categoria_nombre'],
        'comentarios' => $producto['comentarios'],
        'precio' => $producto['precio'],
        'stock' => $producto['stock'],
        'vegetariano' => $producto['vegetariano'],
        'tacc' => $producto['tacc'],
        'infoNutricional' => $infoNutricional,
        'imagen' => 'img/' . strtolower(str_replace(' ', '_', $producto['nombre'])) . '.png'
    ];
    
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Producto no encontrado']);
}

$stmt->close();
closeDBConnection($conn);
?>
