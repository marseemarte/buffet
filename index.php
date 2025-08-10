  <!-- Encabezado -->
  <?php include 'header.php' ?>

  <!-- Modal -->
<div class="modal fade" id="productoModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" id="modalContenido">
      <!-- Contenido dinámico -->
    </div>
  </div>
</div>


  <!-- Hero -->
  <section class="hero d-flex align-items-center justify-content-center text-center" style="background-image: url('img/fondo-buffet.png');">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7">
          <h6 class="display-6 mb-1 mb-md-3">BIENVENIDOS</h6>
          <h1 class="display-4 fw-bold mb-2 mb-md-3">BUFFET ESCOLAR EEST N°1</h1>
          <p class="lead mb-3 mb-md-4">Calidad, variedad y calidez todos los días.</p>
          <a href="#productos" class="btn btn-danger btn-lg px-3 px-md-4 py-2 py-md-3">Ver Productos</a>
        </div>
      </div>
    </div>
  </section>


  <!-- Redes Sociales -->
  <section class="redes py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
          <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
            <div class="text-center text-md-start">
              <h3 class="h2 fw-bold mb-3">VISITÁ NUESTRAS REDES</h3>
              <p class="lead mb-4"><strong>¡Enterate de todas las novedades del día!</strong></p>
              <a href="https://instagram.com/buffet.eest1" class="btn btn-danger btn-lg px-4" target="_blank">
                @buffet.eest1
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Productos -->
  <section id="productos" class="py-5">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-12">
          <h2 class="display-5 fw-bold">Nuestros Productos</h2>
        </div>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php include 'productos.php'; ?>
        </div>

        <!-- Controles Swiper -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

  <?php include 'footer.php' ?>

  <!-- Modal Producto -->
  <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Columna izquierda - Imagen del producto -->
            <div class="col-md-6 text-center">
              <img id="modal-img" src="" class="img-fluid mb-2" style="max-height: 300px; border-radius: 8px;" onerror="this.src='img/hamburguesa.png'">
              <p class="text-muted small">(imagen ilustrativa)</p>
            </div>
            
            <!-- Columna derecha - Detalles del producto -->
            <div class="col-md-6">
              <div class="ps-md-3">
                <p class="text-muted small mb-1" id="modal-categoria"></p>
                <h3 id="modal-nombre" class="fw-bold mb-2"></h3>
                <h4 id="modal-precio" class="fw-bold text-danger mb-3"></h4>
                
                <!-- Estado del stock -->
                <div class="mb-3">
                  <span id="modal-stock" class="badge"></span>
                </div>
                
                <!-- Selector de cantidad -->
                <div class="d-flex align-items-center mb-3">
                  <button id="menos" class="btn btn-outline-secondary btn-sm">-</button>
                  <input type="text" id="cantidad" value="1" max="10" readonly class="form-control text-center mx-2" style="width: 80px;">
                  <button id="mas" class="btn btn-outline-secondary btn-sm">+</button>
                </div>
                
                <!-- Información nutricional -->
                <div class="mb-4">
                  <p class="small text-muted mb-2" id="modal-info-nutricional"></p>
                  <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-wheat-awn text-warning me-2"></i>
                    <span class="small" id="modal-tacc"></span>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="fas fa-leaf text-success me-2"></i>
                    <span class="small" id="modal-vegetariano"></span>
                  </div>
                </div>
                
                <!-- Botón agregar al carrito -->
                <button id="agregarCarrito" class="btn btn-danger w-100 py-2">
                  + Agregar al carrito
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Scripts -->

  <script src="https://static.elfsight.com/platform/platform.js" async></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/index.js"></script>
  <script src="js/buscador.js"></script>



</body>

</html>