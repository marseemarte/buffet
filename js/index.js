const swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30
      },
      992: {
        slidesPerView: 4,
        spaceBetween: 30
      },
      1200: {
        slidesPerView: 5,
        spaceBetween: 30
      }
    }
  });

let carrito = [];
let productoActual = {};

// Función para abrir el modal del producto
function abrirModal(idProducto) {
  console.log('Intentando abrir modal para producto ID:', idProducto);
  
  fetch('obtener_producto.php?id=' + idProducto)
    .then(response => {
      console.log('Respuesta del servidor:', response);
      return response.json();
    })
    .then(data => {
      console.log('Datos del producto:', data);
      if (data.error) {
        console.error('Error:', data.error);
        return;
      }
      
      productoActual = data;
      
      // Actualizar modal con datos de la base de datos
      document.getElementById("modal-img").src = data.imagen;
      document.getElementById("modal-categoria").innerText = data.categoria;
      document.getElementById("modal-nombre").innerText = data.nombre;
      document.getElementById("modal-precio").innerText = "$" + data.precio;
      document.getElementById("modal-info-nutricional").innerText = data.infoNutricional;
      document.getElementById("modal-tacc").innerText = data.tacc ? 'Contiene TACC' : 'Sin TACC';
      document.getElementById("modal-vegetariano").innerText = data.vegetariano ? 'Vegetariano' : 'No vegetariano';
      document.getElementById("cantidad").value = 1;
      
      // Actualizar estado del stock
      const stockBadge = document.getElementById("modal-stock");
      if (data.stock > 0) {
        stockBadge.className = "badge bg-success";
        stockBadge.innerText = "Disponible";
        document.getElementById("agregarCarrito").disabled = false;
        document.getElementById("agregarCarrito").innerText = "+ Agregar al carrito";
      } else {
        stockBadge.className = "badge bg-danger";
        stockBadge.innerText = "Sin stock";
        document.getElementById("agregarCarrito").disabled = true;
        document.getElementById("agregarCarrito").innerText = "Sin stock";
      }
      
      // Mostrar modal
      console.log('Mostrando modal...');
      const modalElement = document.getElementById("productoModal");
      console.log('Elemento modal encontrado:', modalElement);
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
      console.log('Modal mostrado');
    })
    .catch(error => {
      console.error('Error al obtener producto:', error);
      mostrarNotificacion("Error al cargar el producto", "danger");
    });
}

document.getElementById("mas").addEventListener("click", () => {
  const cantidadInput = document.getElementById("cantidad");
  const nuevaCantidad = parseInt(cantidadInput.value) + 1;
  if (nuevaCantidad <= 10) {
    cantidadInput.value = nuevaCantidad;
  }
});

document.getElementById("menos").addEventListener("click", () => {
  const cantidadInput = document.getElementById("cantidad");
  const nuevaCantidad = parseInt(cantidadInput.value) - 1;
  if (nuevaCantidad >= 1) {
    cantidadInput.value = nuevaCantidad;
  }
});

document.getElementById("agregarCarrito").addEventListener("click", () => {
  if (!productoActual.id) {
    mostrarNotificacion("Error: Producto no válido", "danger");
    return;
  }
  
  const cant = parseInt(document.getElementById("cantidad").value);
  const existe = carrito.find(p => p.id === productoActual.id);
  
  if (existe) {
    existe.cantidad += cant;
  } else {
    carrito.push({...productoActual, cantidad: cant});
  }
  
  console.log("Carrito:", carrito);
  bootstrap.Modal.getInstance(document.getElementById("productoModal")).hide();
  
  // Mostrar notificación de éxito
  mostrarNotificacion("Producto agregado al carrito", "success");
  
  // Actualizar contador del carrito en el header
  actualizarContadorCarrito();
});

function actualizarContadorCarrito() {
  const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
  const badge = document.querySelector('.navbar .badge');
  if (badge) {
    badge.innerText = totalItems;
  }
}

function mostrarNotificacion(mensaje, tipo) {
  // Crear notificación toast
  const toast = document.createElement("div");
  toast.className = `toast align-items-center text-white bg-${tipo === 'success' ? 'success' : 'danger'} border-0 position-fixed`;
  toast.style.cssText = "top: 20px; right: 20px; z-index: 9999;";
  toast.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">
        ${mensaje}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  `;
  
  document.body.appendChild(toast);
  const bsToast = new bootstrap.Toast(toast);
  bsToast.show();
  
  // Remover después de que se oculte
  toast.addEventListener('hidden.bs.toast', () => {
    document.body.removeChild(toast);
  });
}