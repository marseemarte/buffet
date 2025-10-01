// Dashboard JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // === NAVIGATION FUNCTIONALITY ===
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // === SEARCH FUNCTIONALITY ===
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            // Search in categories
            const categoryCards = document.querySelectorAll('.category-card');
            categoryCards.forEach(card => {
                const categoryName = card.querySelector('.category-name').textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Search in order history
            const orderItems = document.querySelectorAll('.order-item');
            orderItems.forEach(item => {
                const orderName = item.querySelector('h4').textContent.toLowerCase();
                if (orderName.includes(searchTerm)) {
                    item.style.display = 'flex';
                    item.style.animation = 'fadeIn 0.3s ease';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // === TAB FUNCTIONALITY ===
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Show/hide corresponding content
            const tabName = this.getAttribute('data-tab');
            const tabContent = document.getElementById(tabName + '-tab');
            
            // Hide all tab contents
            document.querySelectorAll('.order-list').forEach(content => {
                content.style.display = 'none';
            });
            
            // Show selected tab content
            if (tabContent) {
                tabContent.style.display = 'block';
            }
            
            console.log('Tab clicked:', tabName);
        });
    });

    // === QUANTITY CONTROLS ===
    const quantityControls = document.querySelectorAll('.quantity-controls');
    quantityControls.forEach(control => {
        const minusBtn = control.querySelector('.minus');
        const plusBtn = control.querySelector('.plus');
        const quantitySpan = control.querySelector('.quantity');
        
        if (minusBtn && plusBtn && quantitySpan) {
            let quantity = parseInt(quantitySpan.textContent);
            
            minusBtn.addEventListener('click', function() {
                if (quantity > 1) {
                    quantity--;
                    quantitySpan.textContent = quantity;
                    updateCartTotal();
                }
            });
            
            plusBtn.addEventListener('click', function() {
                if (quantity < 10) {
                    quantity++;
                    quantitySpan.textContent = quantity;
                    updateCartTotal();
                }
            });
        }
    });

    // === ORDER AGAIN FUNCTIONALITY ===
    const orderAgainBtns = document.querySelectorAll('.order-again-btn');
    orderAgainBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Add to cart animation
            this.style.transform = 'scale(0.95)';
            this.textContent = 'Agregado!';
            this.style.background = '#28a745';
            
            setTimeout(() => {
                this.style.transform = '';
                this.textContent = 'Pedir de nuevo';
                this.style.background = '#ff6b35';
            }, 1500);
            
            // Here you would typically add the item to cart
            console.log('Order again clicked');
        });
    });

    // === CATEGORY CARDS INTERACTION ===
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Here you would typically filter products by category
            const categoryName = this.querySelector('.category-name').textContent;
            console.log('Category selected:', categoryName);
        });
    });

    // === CART ITEM INTERACTIONS ===
    const cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });

    // === STATS CARDS ANIMATION ===
    const statCards = document.querySelectorAll('.stat-card');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInUp 0.6s ease forwards';
            }
        });
    }, observerOptions);

    statCards.forEach(card => {
        observer.observe(card);
    });

    // === PROMO BANNER INTERACTION ===
    const promoBanner = document.querySelector('.promo-banner');
    if (promoBanner) {
        promoBanner.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Here you would typically navigate to a special offers page
            console.log('Promo banner clicked');
        });
    }

    // === UTILITY FUNCTIONS ===
    function updateCartTotal() {
        // This function would calculate and update the cart total
        // For now, it's just a placeholder
        console.log('Cart total updated');
    }

    // === ANIMATION KEYFRAMES ===
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 0.6s ease;
        }
    `;
    document.head.appendChild(style);

    // === LOADING ANIMATION ===
    window.addEventListener('load', function() {
        // Add loading animation to main elements
        const mainElements = document.querySelectorAll('.promo-banner, .categories-section, .order-history-section, .cart-section');
        mainElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });

    // === RESPONSIVE BEHAVIOR ===
    function handleResize() {
        const width = window.innerWidth;
        
        if (width <= 768) {
            // Mobile adjustments
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.width = '60px';
            }
        } else {
            // Desktop adjustments
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.width = '80px';
            }
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Call once on load

    // === NOTIFICATION SYSTEM ===
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ff6b35'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Add notification styles
    const notificationStyle = document.createElement('style');
    notificationStyle.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(notificationStyle);

    // === PRODUCTO FUNCTIONS ===
    window.verProducto = function(id) {
        // Aquí implementarías la funcionalidad para ver el producto
        showNotification('Ver producto ID: ' + id, 'info');
        console.log('Ver producto:', id);
    };

    // === PEDIDO FUNCTIONS ===
    window.marcarEntregado = function(pedidoId) {
        if (confirm('¿Estás seguro de que quieres marcar este pedido como entregado?')) {
            // Mostrar loading en el botón
            const button = event.target.closest('.entregar-btn');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            button.disabled = true;
            
            // Enviar petición AJAX
            fetch('marcar_entregado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'pedido_id=' + pedidoId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mover el pedido a la pestaña de entregados
                    const orderItem = document.querySelector(`[data-order-id="${pedidoId}"]`);
                    if (orderItem) {
                        // Cambiar el botón por el estado de entregado
                        const buttonContainer = orderItem.querySelector('.order-again-btn').parentNode;
                        buttonContainer.innerHTML = `
                            <div class="order-status">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Entregado</span>
                            </div>
                        `;
                        
                        // Agregar clase de entregado
                        orderItem.classList.add('entregado');
                        
                        // Mover a la pestaña de entregados
                        const entregadosTab = document.getElementById('entregados-tab');
                        if (entregadosTab) {
                            // Remover de pendientes
                            orderItem.remove();
                            
                            // Agregar a entregados
                            const emptyState = entregadosTab.querySelector('.empty-orders');
                            if (emptyState) {
                                emptyState.remove();
                            }
                            entregadosTab.appendChild(orderItem);
                        }
                        
                        showNotification('Pedido marcado como entregado', 'success');
                    }
                } else {
                    showNotification(data.message || 'Error al marcar como entregado', 'error');
                    // Restaurar botón
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error de conexión', 'error');
                // Restaurar botón
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    };

    // === DEMO NOTIFICATIONS ===
    // Uncomment these lines to see demo notifications
    // setTimeout(() => showNotification('¡Bienvenido al dashboard!', 'success'), 1000);
    // setTimeout(() => showNotification('Nuevos productos disponibles', 'info'), 3000);

    console.log('Dashboard JavaScript loaded successfully!');
});
