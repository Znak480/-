(function () {
    'use strict';

    /**
     * Корзина - работа через AJAX
     */
    let Cart = {
        add: function (productId, quantity) {
            return this.request('add', productId, quantity);
        },

        remove: function (productId) {
            return this.request('remove', productId);
        },

        update: function (productId, quantity) {
            return this.request('update', productId, quantity);
        },

        get: function () {
            return this.request('get');
        },

        clear: function () {
            return this.request('clear');
        },

    
        request: function (action, id, quant) {
            let data = new FormData();
            data.append('action', action);
            if (id) data.append('id', id);
            if (quant) data.append('quant', quant);

            return fetch('/local/ajax/cart.php', {
                method: 'POST',
                body: data
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Ошибка сети: ' + response.status);
                    }
                    return response.json();
                })
                .then(function (data) {
                    if (!data.success) {
                        throw new Error(data.error || 'Неизвестная ошибка');
                    }
                    return data;
                });
        },

       
        updateUI: function () {
            let self = this;
            this.get()
                .then(function (data) {
                    self.updateBadge(data.quantity);
                    self.updateButtons(data.quantity);

                    let event = new CustomEvent('cart:updated', { detail: data });
                    document.dispatchEvent(event);
                })
                .catch(function (error) {
                    console.error('Ошибка обновления корзины:', error.message);
                });
        },


        updateButtons: function(quantity) {
            let badges = document.querySelectorAll('[data-badge="basket"]');
            if (badges.length === 0) return;

            badges.forEach(function(badge){
                const button = badge.closest('.btn-action');

                if(quantity > 0){
                    button.classList.add("active");
                
                    
                }else{
                    button.classList.remove("active");
                }

            });
        },
      
        updateBadge: function (quantity) {
            let badges = document.querySelectorAll('[data-badge="basket"]');
            if (badges.length === 0) return;

            badges.forEach(function (badge) {
                if (quantity > 0) {
                    badge.textContent = quantity;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
        },
    };

    // Глобальный доступ
    window.Cart = Cart;

    
    /**
     * Добавление в корзину
     */
    document.addEventListener('click', function (e) {
        let target = e.target.closest('.btn-product-card, .add-to-cart');
        if (!target) return;

        e.preventDefault();
        ym(269955, 'reachGoal', 'addcart');

        let productId = parseInt(target.dataset.id) || 0;
        if (!productId) {
            let card = target.closest('.product-card, [data-id]');
            if (card) productId = parseInt(card.dataset.id) || 0;
        }

        let quantity = 1;
        const product = target.closest('[data-product-id]');
        const input = product?.querySelector('.quantity');
        if (input) quantity = parseInt(input.value) || 1;

        if (!productId) {
            showNotification('Ошибка: ID товара не найден', 'error');
            return;
        }
        
        let originalHtml = target.innerHTML;
        let spinner = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path d="M0 0h24v24H0z" fill="none" />
            <g stroke="currentColor">
                <circle cx="12" cy="12" r="9.5" fill="none" stroke-linecap="round" stroke-width="3">
                    <animate attributeName="stroke-dasharray" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0 150;42 150;42 150;42 150" />
                    <animate attributeName="stroke-dashoffset" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0;-16;-59;-59" />
                </circle>
                <animateTransform attributeName="transform" dur="2s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
            </g>
        </svg>
        `;
        const currentWidth = target.offsetWidth;
        target.style.width=`${currentWidth}px`,
        target.innerHTML = spinner;
        target.disabled = true;

        Cart.add(productId, quantity)
            .then(function (data) {
                Cart.updateUI();
                target.textContent = '✓';
                target.classList.add('added');
                showNotification('Товар добавлен в корзину', 'success');

                setTimeout(function () {
                    target.innerHTML = originalHtml;
                    target.style.width = null;
                    target.disabled = false;
                    target.classList.remove('added');
                }, 2000);
            })
            .catch(function (error) {
                target.innerHTML = originalHtml;
                target.disabled = false;
                showNotification('Ошибка: ' + error.message, 'error');
            });
    });

   
    function showNotification(text, type) {
        let notification = document.getElementById('cart-notification');
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'cart-notification';
            notification.className = 'notification';
            document.body.appendChild(notification);
        }

        notification.textContent = text;
        notification.className = 'notification ' + (type || 'success');
        notification.style.display = 'block';
        notification.style.opacity = '1';

        clearTimeout(notification._timer);
        notification._timer = setTimeout(function () {
            notification.style.opacity = '0';
            setTimeout(function () {
                notification.style.display = 'none';
            }, 10000);
        }, 3000);
    }

   
    document.addEventListener('DOMContentLoaded', function () {
        Cart.updateUI();
        setInterval(function () {
            Cart.updateUI();
        }, 30000);
    });

})();