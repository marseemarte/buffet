<?php
session_start();
require_once '../config.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$conn = getDBConnection();
if (!$conn) {
    die("Error de conexión a la base de datos");
}

// Obtener categorías
$query_categorias = "SELECT * FROM categorias ORDER BY nombre";
$result_categorias = $conn->query($query_categorias);
$categorias = [];
while ($row = $result_categorias->fetch_assoc()) {
    $categorias[] = $row;
}

// Obtener productos con filtros
$categoria_filtro = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$query_productos = "SELECT p.*, c.nombre as categoria_nombre FROM productos p 
                   LEFT JOIN categorias c ON p.categoria_id = c.id 
                   WHERE 1=1";

$params = [];
$types = "";

if ($categoria_filtro > 0) {
    $query_productos .= " AND p.categoria_id = ?";
    $params[] = $categoria_filtro;
    $types .= "i";
}

if (!empty($busqueda)) {
    $query_productos .= " AND (p.nombre LIKE ? OR p.descripcion LIKE ?)";
    $search_term = "%$busqueda%";
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "ss";
}

$query_productos .= " ORDER BY p.nombre";

$stmt = $conn->prepare($query_productos);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_productos = $stmt->get_result();
$productos = [];
while ($row = $result_productos->fetch_assoc()) {
    $productos[] = $row;
}

$stmt->close();
closeDBConnection($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Buffet Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <style>
        .productos-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .producto-card-dashboard {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .producto-card-dashboard:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .producto-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .producto-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .producto-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .producto-content {
            padding: 1.5rem;
        }
        
        .producto-categoria {
            color: #ff6b35;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .producto-nombre {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .producto-descripcion {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .producto-precio {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 1rem;
        }
        
        .producto-info {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .info-badge {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-weight: 500;
        }
        
        .info-vegetariano {
            background: #d4edda;
            color: #155724;
        }
        
        .info-tacc {
            background: #fff3cd;
            color: #856404;
        }
        
        .info-stock {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .producto-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-edit {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-edit:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            flex: 1;
        }
        
        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .filters-section {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }
        
        .filter-item {
            flex: 1;
            min-width: 200px;
        }
        
        .btn-add-product {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
        
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card-small {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .stat-card-small h4 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .stat-card-small p {
            color: #6c757d;
            margin: 0;
        }
    </style>
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
                <a href="dashboard.php" class="nav-item" title="Dashboard">
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
                <a href="productos.php" class="nav-item active" title="Productos">
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
                    <h2 class="greeting">Gestión de Productos</h2>
                </div>
                <div class="header-right">
                    <a href="productos.php?action=add" class="btn-add-product">
                        <i class="fas fa-plus"></i>Agregar Producto
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="left-content" style="flex: 1;">
                    <!-- Stats Row -->
                    <!-- Categories Section -->
                    <div class="categories-section">
                        <h3>Categorías</h3>
                        <div class="categories-scroll">
                            <?php foreach ($categorias as $categoria): ?>
                            <div class="category-card">
                                <div class="category-image">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <span class="category-name"><?php echo htmlspecialchars($categoria['nombre']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="filters-section">
                        <form method="GET" action="">
                            <div class="filter-group">
                                <div class="filter-item">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select name="categoria" id="categoria" class="form-select">
                                        <option value="0">Todas las categorías</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['id']; ?>" 
                                                <?php echo $categoria_filtro == $categoria['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($categoria['nombre']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="filter-item">
                                    <label for="busqueda" class="form-label">Buscar</label>
                                    <input type="text" name="busqueda" id="busqueda" class="form-control" 
                                           placeholder="Nombre o descripción..." value="<?php echo htmlspecialchars($busqueda); ?>">
                                </div>
                                <div class="filter-item">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Filtrar
                                    </button>
                                    <a href="productos.php" class="btn btn-outline-secondary ms-2">
                                        <i class="fas fa-times me-2"></i>Limpiar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    <?php if (empty($productos)): ?>
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h3>No se encontraron productos</h3>
                            <p>Intenta ajustar los filtros o agregar nuevos productos.</p>
                        </div>
                    <?php else: ?>
                        <div class="productos-container">
                            <?php foreach ($productos as $producto): ?>
                            <div class="producto-card-dashboard">
                                <div class="producto-image">
                                    <?php if ($producto['imagen']): ?>
                                        <img src="../img/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    <?php else: ?>
                                        <i class="fas fa-utensils"></i>
                                    <?php endif; ?>
                                    <div class="producto-badge">
                                        <?php echo $producto['stock'] > 0 ? 'En Stock' : 'Sin Stock'; ?>
                                    </div>
                                </div>
                                
                                <div class="producto-content">
                                    <div class="producto-categoria">
                                        <?php echo htmlspecialchars($producto['categoria_nombre'] ?: 'Sin categoría'); ?>
                                    </div>
                                    
                                    <h3 class="producto-nombre">
                                        <?php echo htmlspecialchars($producto['nombre']); ?>
                                    </h3>
                                    
                                    <p class="producto-descripcion">
                                        <?php echo htmlspecialchars($producto['descripcion'] ?: 'Sin descripción'); ?>
                                    </p>
                                    
                                    <div class="producto-precio">
                                        $<?php echo number_format($producto['precio'], 2); ?>
                                    </div>
                                    
                                    <div class="producto-info">
                                        <?php if ($producto['vegetariano']): ?>
                                        <div class="info-badge info-vegetariano">
                                            <i class="fas fa-leaf"></i>
                                            <span>Vegetariano</span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($producto['tacc']): ?>
                                        <div class="info-badge info-tacc">
                                            <i class="fas fa-wheat-awn"></i>
                                            <span>Sin TACC</span>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <div class="info-badge info-stock">
                                            <i class="fas fa-box"></i>
                                            <span>Stock: <?php echo $producto['stock']; ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="producto-actions">
                                        <button class="btn-edit" onclick="editProduct(<?php echo $producto['id']; ?>)">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                        <button class="btn-delete" onclick="deleteProduct(<?php echo $producto['id']; ?>)">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editProduct(id) {
            // Aquí implementarías la funcionalidad de edición
            alert('Editar producto ID: ' + id);
        }
        
        function deleteProduct(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                // Aquí implementarías la funcionalidad de eliminación
                alert('Eliminar producto ID: ' + id);
            }
        }
        
        // Animación de entrada para las tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.producto-card-dashboard');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
