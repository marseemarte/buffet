<?php
header('Content-Type: application/json');
require_once 'config.php';

try {
    $conn = getDBConnection();
    
    if (!$conn) {
        throw new Exception('Error de conexión a la base de datos');
    }

    $id = intval($_GET['id']);
    
    if ($id <= 0) {
        throw new Exception('ID de producto inválido');
    }

    $sql = "SELECT p.id, p.nombre, p.descripcion, p.stock, p.vegetariano, p.tacc, p.precio, p.categoria_id, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta');
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        
        // Determinar información nutricional según la categoría
        $infoNutricional = "";
        $categoriaNombre = $producto['categoria_nombre'] ?? '';
        switch(strtolower($categoriaNombre)) {
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
            'categoria' => $categoriaNombre ?: 'Sin categoría',
            'descripcion' => $producto['descripcion'],
            'precio' => $producto['precio'],
            'stock' => $producto['stock'],
            'vegetariano' => (bool)$producto['vegetariano'],
            'tacc' => (bool)$producto['tacc'],
            'infoNutricional' => $infoNutricional,
            'imagen' => 'img/' . strtolower(str_replace(' ', '_', $producto['nombre'])) . '.png'
        ];
        
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Producto no encontrado']);
    }

    $stmt->close();
    closeDBConnection($conn);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
