// Esperar a que el usuario deje de escribir 300ms (debounce)
let timer;
document.getElementById('*/obtener_producto').addEventListener('keyup', function () {
    clearTimeout(timer);
    let query = this.value.trim();

    timer = setTimeout(() => {
        if (query.length > 0) {
            fetch('*/obtener_producto.php?q=' + encodeURIComponent(query))
                .then(res => res.text())
                .then(data => {
                    document.getElementById('resultadosBusqueda').innerHTML = data;
                });
        } else {
            document.getElementById('resultadosBusqueda').innerHTML = '';
        }
    }, 300);
});

// Escuchar clic en resultados para abrir modal
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('resultado-item')) {
        let idProducto = e.target.dataset.id;
        fetch('modal_producto.php?id=' + idProducto)
            .then(res => res.text())
            .then(html => {
                document.getElementById('modalContenido').innerHTML = html;
                new bootstrap.Modal(document.getElementById('productoModal')).show();
            });
    }
});
