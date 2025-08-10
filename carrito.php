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
  <link rel="stylesheet" href="css/carrito.css">
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
    <?php include 'header.php' ?>

    <nav class="breadcrumb-iconic">
        <a href="index.php"> Inicio</a>
        <i class="fa fa-angle-right"></i>
        <a href="carito.php"> Carito</a>
    </nav>
    <div>
        <h1>Mi Carrito de Compras</h1>    
        <i></i>
    </div>
    

    <div class="container">
    <!-- Productos -->
    <div class="productos">
        <div class="producto">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4b/Hamburger_%28black_bg%29.jpg" alt="Hamburguesa">
            <div class="info">
                <div class="titulo">
                    <a href="producto.php"><i class="fa-solid fa-pen"></i></a>  
                    Hamburguesa Clásica      
                </div> 
                <div class="precio">$ <span class="precio-unitario">15.00</span></div>
            </div>
            <input type="number" min="0" value="0" class="cantidad">
        </div>

        <div class="producto">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Hot_dog_with_mustard.png" alt="Pancho">
            <div class="info">
                <div class="titulo">
                    <a href="producto.php"><i class="fa-solid fa-pen"></i></a>  
                    Pancho con Mostaza
                </div> 
                <div class="precio">$ <span class="precio-unitario">8.00</span></div>
            </div>
            <input type="number" min="0" value="0" class="cantidad">
        </div>

        <div class="producto">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/02/Papas_fritas.jpg" alt="Papas Fritas">
            <div class="info">
                <div class="titulo">
                    <a href="producto.php"><i class="fa-solid fa-pen"></i></a>  
                    Papas Fritas
                </div> 
                <div class="precio">$ <span class="precio-unitario">6.50</span></div>
            </div>
            <input type="number" min="0" value="0" class="cantidad">
        </div>
    </div>

    <!-- Resumen -->
    <div class="resumen">
        <button class="btn-amarillo">Continuar Comprando</button>
        <h3>Detalle total</h3>
        <div class="linea"><span>Total</span> <span>$ <span id="total">0.00</span></span></div>
        <div class="linea"><span>Descuento</span> <span>0</span></div>
        <div class="linea"><span>Cargos por Entrega</span> <span>0</span></div>
        <div class="total">TOTAL: $ <span id="total-final">0.00</span></div>
        <button class="btn-negro">Hacer Pedido</button>
    </div>
</div>
    <?php include 'footer.php' ?>
    <script>
    const cantidades = document.querySelectorAll(".cantidad");
    const precios = document.querySelectorAll(".precio-unitario");
    const totalElement = document.getElementById("total");
    const totalFinalElement = document.getElementById("total-final");

    function actualizarTotal() {
        let total = 0;
        cantidades.forEach((input, i) => {
            let precio = parseFloat(precios[i].textContent);
            let cantidad = parseInt(input.value) || 0;
            total += precio * cantidad;
        });
        totalElement.textContent = total.toFixed(2);
        totalFinalElement.textContent = total.toFixed(2);
    }

    cantidades.forEach(input => {
        input.addEventListener("input", actualizarTotal);
    });
</script>
  

</body>

</html>