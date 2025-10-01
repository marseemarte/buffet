// Esperar a que el usuario deje de escribir 300ms (debounce)
let timer;
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('buscar');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            clearTimeout(timer);
            let query = this.value.trim();

            timer = setTimeout(() => {
                const resultadosDiv = document.getElementById('resultadosBusqueda');
                if (resultadosDiv) {
                    if (query.length > 0) {
                        fetch('buscar.php?q=' + encodeURIComponent(query))
                            .then(res => res.text())
                            .then(data => {
                                resultadosDiv.innerHTML = data;
                                resultadosDiv.classList.add('show');
                            })
                            .catch(error => {
                                console.error('Error en búsqueda:', error);
                                resultadosDiv.innerHTML = '<div class="list-group-item text-muted">Error en la búsqueda</div>';
                                resultadosDiv.classList.add('show');
                            });
                    } else {
                        resultadosDiv.innerHTML = '';
                        resultadosDiv.classList.remove('show');
                    }
                }
            }, 300);
        });
    }
});

// Escuchar clic en resultados para abrir modal
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('resultado-item')) {
        let idProducto = e.target.dataset.id;
        // Usar la función abrirModal del index.js
        if (typeof abrirModal === 'function') {
            abrirModal(idProducto);
        }
        // Ocultar resultados después de seleccionar
        const resultadosDiv = document.getElementById('resultadosBusqueda');
        if (resultadosDiv) {
            resultadosDiv.classList.remove('show');
        }
    }
});

// Cerrar resultados al hacer clic fuera
document.addEventListener('click', function (e) {
    const resultadosDiv = document.getElementById('resultadosBusqueda');
    const searchInput = document.getElementById('buscar');
    
    if (resultadosDiv && searchInput && 
        !resultadosDiv.contains(e.target) && 
        !searchInput.contains(e.target)) {
        resultadosDiv.classList.remove('show');
    }
});
