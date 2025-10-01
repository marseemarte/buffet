# Dashboard - Buffet Escolar

## Descripción
Dashboard moderno y dinámico para la gestión del buffet escolar, desarrollado con PHP, MySQL, Bootstrap y JavaScript. Incluye funcionalidades de autenticación, gestión de productos, métricas en tiempo real y diseño responsivo.

## Características Principales

### 🎨 Diseño Moderno
- Interfaz inspirada en aplicaciones de delivery modernas
- Sidebar de navegación con iconos intuitivos
- Colores naranjas y blancos para mantener la identidad visual
- Diseño completamente responsivo

### 📊 Dashboard Principal
- **Métricas en tiempo real**: Visitantes, productos vistos, pedidos, cancelaciones
- **Banner promocional**: Para destacar ofertas especiales
- **Categorías dinámicas**: Navegación por categorías de productos
- **Historial de pedidos**: Lista de pedidos recientes con opción de "Pedir de nuevo"
- **Carrito de compras**: Vista previa de productos en el carrito

### 🛍️ Gestión de Productos
- **Vista de productos**: Grid responsivo con información detallada
- **Filtros avanzados**: Por categoría y búsqueda de texto
- **Estadísticas**: Contadores de productos, categorías, stock, etc.
- **Información nutricional**: Indicadores de productos vegetarianos y sin TACC
- **Acciones**: Botones para editar y eliminar productos

### 🔐 Sistema de Autenticación
- **Login seguro**: Formulario de acceso con validación
- **Sesiones**: Manejo seguro de sesiones de usuario
- **Logout**: Cierre seguro de sesión
- **Credenciales demo**: Usuario de prueba incluido

## Estructura de Archivos

```
admin/
├── dashboard.php          # Página principal del dashboard
├── login.php             # Sistema de autenticación
├── logout.php            # Cierre de sesión
├── productos.php         # Gestión de productos
├── README.md            # Este archivo
└── ...

css/
├── dashboard.css         # Estilos específicos del dashboard
└── ...

js/
├── dashboard.js          # Funcionalidad JavaScript del dashboard
└── ...
```

## Instalación y Configuración

### Requisitos Previos
- Servidor web (Apache/Nginx)
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Navegador web moderno

### Pasos de Instalación

1. **Configurar la base de datos**:
   ```sql
   -- Importar el archivo buffet.sql en tu base de datos MySQL
   mysql -u root -p buffet < buffet.sql
   ```

2. **Configurar la conexión**:
   - Editar `config.php` con tus credenciales de base de datos
   - Verificar que la base de datos esté accesible

3. **Configurar el servidor web**:
   - Asegurar que el directorio `admin/` sea accesible
   - Configurar permisos de escritura si es necesario

4. **Acceder al dashboard**:
   - Navegar a `tu-dominio.com/admin/login.php`
   - Usar las credenciales demo o crear un nuevo usuario

## Uso del Dashboard

### Acceso Inicial
1. Ir a la página de login: `admin/login.php`
2. Usar las credenciales demo:
   - **Email**: buffet@gmail.com
   - **Contraseña**: 1234
3. O crear un nuevo usuario en la base de datos

### Navegación
- **Sidebar izquierdo**: Navegación principal con iconos
- **Header superior**: Búsqueda y acciones principales
- **Contenido central**: Información principal según la sección
- **Sidebar derecho**: Métricas y carrito de compras

### Gestión de Productos
1. Hacer clic en el icono de productos en el sidebar
2. Usar los filtros para encontrar productos específicos
3. Ver estadísticas en la parte superior
4. Usar los botones de acción para editar/eliminar

### Personalización
- **Colores**: Modificar las variables CSS en `dashboard.css`
- **Funcionalidad**: Extender el JavaScript en `dashboard.js`
- **Datos**: Agregar nuevas consultas en los archivos PHP

## Características Técnicas

### Frontend
- **Bootstrap 5.3**: Framework CSS responsivo
- **Font Awesome 6**: Iconografía moderna
- **JavaScript ES6**: Funcionalidad interactiva
- **CSS Grid/Flexbox**: Layouts modernos

### Backend
- **PHP 8+**: Lenguaje de programación
- **MySQL**: Base de datos relacional
- **Sesiones**: Manejo seguro de autenticación
- **Prepared Statements**: Consultas seguras

### Seguridad
- **Validación de entrada**: Sanitización de datos
- **Protección SQL**: Prepared statements
- **Sesiones seguras**: Configuración de cookies
- **Autenticación**: Verificación de usuarios

## Funcionalidades Futuras

### Próximas Mejoras
- [ ] Sistema de roles de usuario
- [ ] Gestión de inventario en tiempo real
- [ ] Reportes y analytics avanzados
- [ ] Notificaciones push
- [ ] API REST para integraciones
- [ ] Panel de administración completo
- [ ] Sistema de reservas
- [ ] Gestión de pedidos online

### Integraciones Posibles
- [ ] Sistemas de pago
- [ ] Servicios de delivery
- [ ] Aplicaciones móviles
- [ ] Sistemas de inventario
- [ ] Plataformas de marketing

## Solución de Problemas

### Problemas Comunes

1. **Error de conexión a la base de datos**:
   - Verificar credenciales en `config.php`
   - Asegurar que MySQL esté ejecutándose
   - Verificar permisos de usuario

2. **Página en blanco**:
   - Revisar logs de error de PHP
   - Verificar sintaxis en archivos PHP
   - Comprobar permisos de archivos

3. **Estilos no se cargan**:
   - Verificar rutas de archivos CSS
   - Comprobar permisos de lectura
   - Limpiar caché del navegador

4. **JavaScript no funciona**:
   - Abrir consola del navegador para errores
   - Verificar que jQuery esté cargado
   - Comprobar sintaxis del código

### Logs y Debugging
- Revisar logs de error de PHP: `/var/log/apache2/error.log`
- Usar herramientas de desarrollador del navegador
- Activar `display_errors` en PHP para desarrollo

## Soporte y Contribución

### Contacto
- **Desarrollador**: [Tu nombre]
- **Email**: [tu-email@ejemplo.com]
- **Proyecto**: Buffet Escolar EEST N°1

### Contribuir
1. Fork del proyecto
2. Crear rama para nueva funcionalidad
3. Commit de cambios
4. Push a la rama
5. Crear Pull Request

## Licencia
Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

---

**Nota**: Este dashboard está diseñado específicamente para el buffet escolar y puede requerir modificaciones para otros usos. Para soporte técnico, contactar al desarrollador.
