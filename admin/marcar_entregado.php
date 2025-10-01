<?php
session_start();
require_once '../config.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Obtener el ID del pedido
$pedido_id = isset($_POST['pedido_id']) ? (int)$_POST['pedido_id'] : 0;

if ($pedido_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de pedido inválido']);
    exit();
}

$conn = getDBConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit();
}

try {
    // Actualizar el estado del pedido a 'aceptada' (entregado)
    $stmt = $conn->prepare("UPDATE reservas SET estado = 'aceptada' WHERE id = ?");
    $stmt->bind_param("i", $pedido_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Pedido marcado como entregado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el pedido']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el pedido']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
} finally {
    closeDBConnection($conn);
}
?>
