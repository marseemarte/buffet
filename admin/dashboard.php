<?php
session_start();
require_once '../config.php';

// Verificar si el usuario está logueado
// if (!isset($_SESSION['usuario_id'])) {
//     header('Location: ../index.php');
//     exit();
// }

$conn = getDBConnection();
if (!$conn) {
    die("Error de conexión a la base de datos");
}

// Obtener estadísticas del dashboard
$stats = [];

// Total de visitantes (simulado)
$stats['visitantes'] = 300000;

// Productos vistos (simulado)
$stats['vistos'] = 1000;

// Total de pedidos
$query_orders = "SELECT COUNT(*) as total FROM reservas";
$result_orders = $conn->query($query_orders);
$stats['pedidos'] = $result_orders->fetch_assoc()['total'];

// Pedidos cancelados (simulado)
$stats['cancelados'] = 20000;

// Obtener categorías
$query_categorias = "SELECT * FROM categorias ORDER BY nombre";
$result_categorias = $conn->query($query_categorias);
$categorias = [];
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[] = $row;
}

// Obtener productos más vendidos (simulado con productos con más stock como indicador)
$query_productos = "SELECT p.*, c.nombre as categoria_nombre, 
                   (SELECT COUNT(*) FROM reserva_detalle rd WHERE rd.producto_id = p.id) as ventas
                   FROM productos p 
                   LEFT JOIN categorias c ON p.categoria_id = c.id 
                   ORDER BY ventas DESC, p.stock DESC 
                   LIMIT 3";
$result_productos = $conn->query($query_productos);
$productos_mas_vendidos = [];
while ($row = $result_productos->fetch_assoc()) {
    $productos_mas_vendidos[] = $row;
}

// Obtener pedidos pendientes
$query_pendientes = "SELECT r.*, p.nombre as producto_nombre, p.precio, p.imagen, rd.cantidad
                    FROM reservas r 
                    LEFT JOIN reserva_detalle rd ON r.id = rd.reserva_id 
                    LEFT JOIN productos p ON rd.producto_id = p.id 
                    WHERE r.estado = 'pendiente'
                    ORDER BY r.creado_en DESC LIMIT 10";
$result_pendientes = $conn->query($query_pendientes);
$pedidos_pendientes = [];
while ($row = $result_pendientes->fetch_assoc()) {
    $pedidos_pendientes[] = $row;
}

// Obtener pedidos entregados
$query_entregados = "SELECT r.*, p.nombre as producto_nombre, p.precio, p.imagen, rd.cantidad
                    FROM reservas r 
                    LEFT JOIN reserva_detalle rd ON r.id = rd.reserva_id 
                    LEFT JOIN productos p ON rd.producto_id = p.id 
                    WHERE r.estado = 'aceptada'
                    ORDER BY r.creado_en DESC LIMIT 10";
$result_entregados = $conn->query($query_entregados);
$pedidos_entregados = [];
while ($row = $result_entregados->fetch_assoc()) {
    $pedidos_entregados[] = $row;
}

closeDBConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Buffet Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-food">Food</span><span class="logo-health">Health</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item active" title="Dashboard">
                    <i class="fas fa-utensils"></i>
                </a>
                <a href="../carrito.php" class="nav-item" title="Carrito">
                    <i class="fas fa-shopping-bag"></i>
                </a>
                <a href="#" class="nav-item" title="Reservas">
                    <i class="fas fa-calendar-alt"></i>
                </a>
                <a href="#" class="nav-item" title="Estadísticas">
                    <i class="fas fa-chart-bar"></i>
                </a>
                <a href="../productos.php" class="nav-item" title="Productos">
                    <i class="fas fa-th-large"></i>
                </a>
                <a href="#" class="nav-item" title="Notificaciones">
                    <i class="fas fa-bell"></i>
                </a>
                <a href="#" class="nav-item" title="Configuración">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="logout.php" class="nav-item logout-btn" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <div class="logo-text">
                        <span class="logo-food">Food</span><span class="logo-health">Health</span>
                    </div>
                    <h2 class="greeting">¿Qué querés comer hoy?</h2>
                </div>
                <div class="header-right">
                    <div class="search-container">
                        <input type="text" placeholder="Buscar" class="search-input">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="left-content">
                    <!-- Promotional Banner -->
                    <!-- <div class="promo-banner">
                        <div class="promo-content">
                            <h3>¡Descuento Nuevo Menú!</h3>
                            <p>Envío gratis en compras mayores a $30 sin mínimo de compra</p>
                        </div>
                        <div class="promo-images">
                            <div class="food-image churros"></div>
                            <div class="food-image tteokbokki"></div>
                            <div class="food-image pasta"></div>
                        </div>
                    </div> -->

                    <!-- Order History Section -->
                    <div class="order-history-section">
                        <div class="section-header">
                            <div class="tabs">
                                <button class="tab active" data-tab="pendientes">Pedidos</button>
                                <button class="tab" data-tab="entregados">Entregados</button>
                            </div>
                            <a href="#" class="see-all">Ver todo</a>
                        </div>
                        
                        <!-- Pedidos Pendientes -->
                        <div class="order-list" id="pendientes-tab">
                            <?php if (empty($pedidos_pendientes)): ?>
                                <div class="empty-orders">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>No hay pedidos pendientes</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($pedidos_pendientes as $pedido): ?>
                                <div class="order-item" data-order-id="<?php echo $pedido['id']; ?>">
                                    <div class="order-image">
                                        <img src="../img/<?php echo $pedido['imagen'] ?: 'hamburguesa.png'; ?>" alt="<?php echo htmlspecialchars($pedido['producto_nombre']); ?>">
                                    </div>
                                    <div class="order-details">
                                        <h4><?php echo htmlspecialchars($pedido['producto_nombre']); ?></h4>
                                        <p class="order-date"><?php echo date('d M, H:i', strtotime($pedido['creado_en'])); ?></p>
                                        <p class="order-quantity">Cantidad: <?php echo $pedido['cantidad'] ?: 1; ?></p>
                                    </div>
                                    <button class="order-again-btn entregar-btn" onclick="marcarEntregado(<?php echo $pedido['id']; ?>)">
                                        <i class="fas fa-check"></i> Entregar
                                    </button>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Pedidos Entregados -->
                        <div class="order-list" id="entregados-tab" style="display: none;">
                            <?php if (empty($pedidos_entregados)): ?>
                                <div class="empty-orders">
                                    <i class="fas fa-check-circle"></i>
                                    <p>No hay pedidos entregados</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($pedidos_entregados as $pedido): ?>
                                <div class="order-item entregado">
                                    <div class="order-image">
                                        <img src="../img/<?php echo $pedido['imagen'] ?: 'hamburguesa.png'; ?>" alt="<?php echo htmlspecialchars($pedido['producto_nombre']); ?>">
                                    </div>
                                    <div class="order-details">
                                        <h4><?php echo htmlspecialchars($pedido['producto_nombre']); ?></h4>
                                        <p class="order-date"><?php echo date('d M, H:i', strtotime($pedido['creado_en'])); ?></p>
                                        <p class="order-quantity">Cantidad: <?php echo $pedido['cantidad'] ?: 1; ?></p>
                                    </div>
                                    <div class="order-status">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Entregado</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="right-sidebar">
                    <!-- Dashboard Stats -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h4>Visitantes totales</h4>
                            <div class="stat-value"><?php echo number_format($stats['visitantes']); ?>k</div>
                        </div>
                        <div class="stat-card">
                            <h4>Vistos</h4>
                            <div class="stat-value"><?php echo number_format($stats['vistos']); ?>k</div>
                        </div>
                        <div class="stat-card">
                            <h4>Pedidos</h4>
                            <div class="stat-value"><?php echo number_format($stats['pedidos']); ?>k</div>
                        </div>
                        <div class="stat-card">
                            <h4>Cancelados</h4>
                            <div class="stat-value"><?php echo number_format($stats['cancelados']); ?>k</div>
                        </div>
                    </div>

                    <!-- Productos Más Vendidos -->
                    <div class="cart-section">
                        <div class="cart-header">
                            <h3>Más Vendidos</h3>
                            <p>Los productos favoritos</p>
                            <i class="fas fa-fire"></i>
                        </div>
                        <div class="cart-items">
                            <?php foreach ($productos_mas_vendidos as $index => $producto): ?>
                            <div class="cart-item">
                                <div class="producto-ranking">
                                    <span class="ranking-number"><?php echo $index + 1; ?></span>
                                </div>
                                <div class="cart-item-image">
                                    <img src="../img/<?php echo $producto['imagen'] ?: 'hamburguesa.png'; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                </div>
                                <div class="cart-item-details">
                                    <h5><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                    <div class="rating">
                                        <span>4.8/5 (1k+ reseñas)</span>
                                    </div>
                                    <div class="price">$<?php echo number_format($producto['precio']); ?></div>
                                    <div class="ventas-info">
                                        <small class="text-muted">
                                            <i class="fas fa-chart-line me-1"></i>
                                            <?php echo $producto['ventas']; ?> ventas
                                        </small>
                                    </div>
                                </div>
                                <div class="producto-actions">
                                    <button class="btn-ver-producto" onclick="verProducto(<?php echo $producto['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>
