<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buffet Escolar EEST Nº1</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Estilos propios -->
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/header_footer.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&family=Raleway:wght@100..900&display=swap"
    rel="stylesheet">

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/d41e86b587.js" crossorigin="anonymous"></script>
</head>

<body>
<!-- Encabezado -->
<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <img src="img/logo.png" alt="Logo del Buffet" height="40">
    </a>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú colapsable -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Barra de búsqueda -->
    <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 400px;" onsubmit="return false;">
      <input id="buscar" class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Buscar">
      <button class="btn btn-outline-danger" type="button">
        <i class="fa-solid fa-search"></i>
      </button>
    </form>

    <!-- Contenedor de resultados -->
    <div id="resultadosBusqueda" class="list-group position-absolute w-50" style="z-index: 1000;"></div>

      <!-- Navegación -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#productos">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contacto">Contacto</a>
        </li>
      </ul>

      <!-- Carrito -->
      <div class="d-flex align-items-center">
        <a href="carrito.php" class="btn btn-outline-danger position-relative">
          <i class="fa-solid fa-cart-shopping"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
          </span>
        </a>
      </div>
    </div>
  </div>
</header>
