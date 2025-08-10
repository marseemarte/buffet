# Buffet Escolar EEST Nº1

Sitio web responsive para el buffet escolar con sistema de productos dinámico y carrito de compras.

## Características

- ✅ **Diseño Responsive** con Bootstrap 5
- ✅ **Header con Menú Hamburguesa** 
- ✅ **Productos Dinámicos** desde base de datos MySQL
- ✅ **Modal de Productos** con información nutricional
- ✅ **Sistema de Carrito** funcional
- ✅ **Búsqueda de Productos** en tiempo real
- ✅ **Gestión de Stock** en tiempo real

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- WAMP/XAMPP/LAMP

## Instalación

### 1. Clonar/Descargar el proyecto
```bash
git clone [url-del-repositorio]
cd buffet_pruebas
```

### 2. Configurar la base de datos
1. Abrir phpMyAdmin o tu gestor de MySQL
2. Crear una nueva base de datos llamada `buffet`
3. Importar el archivo `database.sql` o ejecutar el siguiente SQL:

```sql
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS buffet;
USE buffet;

-- Crear tabla categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    comentarios TEXT,
    stock INT DEFAULT 0,
    vegetariano BOOLEAN DEFAULT FALSE,
    tacc BOOLEAN DEFAULT TRUE,
    precio DECIMAL(10,2) NOT NULL,
    id_categoria INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);
```

### 3. Configurar la conexión a la base de datos
Editar el archivo `config.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');     // Host de la base de datos
define('DB_USER', 'root');          // Usuario de MySQL
define('DB_PASS', '');              // Contraseña de MySQL
define('DB_NAME', 'buffet');        // Nombre de la base de datos
```

### 4. Insertar datos de ejemplo
Ejecutar el siguiente SQL para insertar categorías y productos de ejemplo:

```sql
-- Insertar categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Hamburguesas', 'Hamburguesas caseras con diferentes ingredientes'),
('Milanesas', 'Milanesas de carne y pollo'),
('Pollo', 'Platos a base de pollo'),
('Pescado', 'Platos a base de pescado'),
('Ensaladas', 'Ensaladas frescas y saludables'),
('Bebidas', 'Bebidas y jugos naturales');

-- Insertar productos
INSERT INTO productos (nombre, comentarios, stock, vegetariano, tacc, precio, id_categoria) VALUES
('Hamburguesa Clásica', 'Hamburguesa con carne, lechuga, tomate y cebolla', 50, FALSE, TRUE, 2800, 1),
('Hamburguesa con Queso', 'Hamburguesa con queso cheddar derretido', 45, FALSE, TRUE, 3200, 1),
('Milanesa de Ternera', 'Milanesa de ternera con pan rallado', 40, FALSE, TRUE, 3500, 2);
```

### 5. Configurar imágenes
Colocar las imágenes de los productos en la carpeta `img/` con el siguiente formato:
- `hamburguesa_clasica.png`
- `hamburguesa_con_queso.png`
- `milanesa_de_ternera.png`

**Nota:** Si no existe la imagen específica, se mostrará `hamburguesa.png` como imagen por defecto.

## Estructura de Archivos

```
buffet_pruebas/
├── css/
│   ├── index.css          # Estilos principales
│   ├── header_footer.css  # Estilos del header y footer
│   └── carrito.css        # Estilos del carrito
├── js/
│   ├── index.js           # Funcionalidad principal
│   └── buscador.js        # Sistema de búsqueda
├── img/                   # Imágenes de productos
├── config.php             # Configuración de base de datos
├── productos.php          # Lista de productos
├── obtener_producto.php   # API para obtener producto
├── database.sql           # Estructura de la base de datos
├── index.php              # Página principal
├── header.php             # Header del sitio
├── footer.php             # Footer del sitio
└── carrito.php            # Página del carrito
```

## Funcionalidades

### Modal de Productos
- **Información Completa**: Nombre, precio, stock, categoría
- **Información Nutricional**: TACC, vegetariano, ingredientes
- **Selector de Cantidad**: Botones + y - con límite de 10
- **Estado de Stock**: Badge visual (Disponible/Sin stock)
- **Botón de Compra**: Se deshabilita si no hay stock

### Sistema de Carrito
- **Agregar Productos**: Con cantidad personalizable
- **Contador en Header**: Badge que se actualiza en tiempo real
- **Notificaciones**: Toast de éxito/error
- **Persistencia**: Los productos se mantienen en la sesión

### Búsqueda
- **Búsqueda en Tiempo Real**: Con debounce de 300ms
- **Resultados Dinámicos**: Se actualizan automáticamente
- **Búsqueda por Nombre**: Filtra productos en tiempo real

## Personalización

### Agregar Nuevos Productos
1. Insertar en la tabla `productos` con los campos requeridos
2. Agregar imagen correspondiente en `img/`
3. El sistema automáticamente detectará y mostrará el nuevo producto

### Modificar Categorías
1. Editar la tabla `categorias`
2. Los productos se agruparán automáticamente por categoría

### Cambiar Estilos
- **Colores**: Editar variables CSS en `css/index.css`
- **Layout**: Modificar clases Bootstrap en los archivos PHP
- **Responsive**: Ajustar breakpoints en `css/index.css`

## Solución de Problemas

### Error de Conexión a la Base de Datos
- Verificar credenciales en `config.php`
- Asegurar que MySQL esté ejecutándose
- Verificar que la base de datos `buffet` exista

### Productos No Se Muestran
- Verificar que las tablas tengan datos
- Revisar permisos de MySQL
- Verificar errores en la consola del navegador

### Imágenes No Se Cargan
- Verificar que existan en la carpeta `img/`
- Comprobar permisos de archivos
- Verificar nombres de archivos (deben coincidir con `nombre_producto.png`)

## Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS**: Bootstrap 5.3.6
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Carousel**: Swiper.js
- **Iconos**: FontAwesome 6
- **Fuentes**: Google Fonts (Nunito, Raleway)

## Licencia

Este proyecto es de uso educativo para el Buffet Escolar EEST Nº1.

## Soporte

Para soporte técnico o consultas, contactar al equipo de desarrollo.
