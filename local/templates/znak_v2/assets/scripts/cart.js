(function () {
    'use strict';

    /**
     * Корзина - работа через AJAX
     */
    let Cart = {
        add: function (productId, quantity, modificator) {
            return this.request('add', productId, quantity, modificator);
        },

        remove: function (productId) {
            return this.request('remove', productId);
        },

        update: function (productId, quantity, modificator) {
            return this.request('update', productId, quantity, modificator);
        },

        get: function () {
            return this.request('get');
        },

        clear: function () {
            return this.request('clear');
        },

        request: function (action, id, quant, modificator) {
            let data = new FormData();
            data.append('action', action);
            if (id) data.append('id', id);
            if (quant) data.append('quant', quant);
            if (modificator) data.append("modificator", modificator);

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
     * Плавное переключение между кнопкой и инпутом
     */
    function toggleCartControls(card, quantity, showAnimation = true) {
        const inputNumber = card.querySelector('.input-number');
        const button = card.querySelector('.btn-product-card');
        
        if (!inputNumber || !button) return;

        if (quantity > 0) {
            if (showAnimation) {
                inputNumber.style.display = 'inline-flex';
                inputNumber.style.opacity = '0';
                inputNumber.style.transform = 'scale(0.8)';
                
                button.style.transition = 'all 0.3s ease';
                button.style.opacity = '0';
                button.style.transform = 'scale(0.8)';
                button.style.display = 'none';
                
                setTimeout(function() {
                    requestAnimationFrame(function() {
                        inputNumber.style.transition = 'all 0.3s ease';
                        inputNumber.style.opacity = '1';
                        inputNumber.style.transform = 'scale(1)';
                    });
                },300);
            } else {
                inputNumber.style.display = 'inline-flex';
                inputNumber.style.opacity = '1';
                inputNumber.style.transform = 'scale(1)';
                button.style.display = 'none';
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
            }
          
            button.textContent = 'В корзине';
            button.classList.add('added');
        } else {
            if (showAnimation) {
                button.style.display = 'inline-flex';
                button.style.opacity = '0';
                button.style.transform = 'scale(0.8)';
                
                inputNumber.style.transition = 'all 0.3s ease';
                inputNumber.style.opacity = '0';
                inputNumber.style.transform = 'scale(0.8)';
                
                setTimeout(function() {
                    inputNumber.style.display = 'none';
                    
                    requestAnimationFrame(function() {
                        button.style.transition = 'all 0.3s ease';
                        button.style.opacity = '1';
                        button.style.transform = 'scale(1)';
                        button.classList.remove('added');
                    });
                }, 300);
            } else {
                inputNumber.style.display = 'none';
                inputNumber.style.opacity = '1';
                inputNumber.style.transform = 'scale(1)';
                button.style.display = 'inline-flex';
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
            }
            button.textContent = 'В корзину';
        }
    }

    /**
     * Обработчик изменения количества
     */
    function handleQuantityChange(input, productId, card) {
        const newInput = input.cloneNode(true);
        input.parentNode.replaceChild(newInput, input);
        input = newInput;

        input.min = 0;
        input.addEventListener('change', function(e) {
            const val = parseInt(e.target.value) || 0;
            const modificator = e.target.dataset.modificator || null;
            
            if (val <= 0) {
                Cart.remove(productId)
                    .then(function() {
                        toggleCartControls(card, 0, true);
                        Cart.updateUI();
                    })
                    .catch(function(error) {
                        console.error('Ошибка удаления:', error.message);
                        e.target.value = 1;
                    });
                input.min = 1;
                input.value = 1;
            } else {
                Cart.update(productId, val, modificator)
                    .then(function() {
                        Cart.updateUI();
                    })
                    .catch(function(error) {
                        console.error('Ошибка обновления:', error.message);
                    });
            }
        });

        input.addEventListener('input', function(e) {
            const val = parseInt(e.target.value) || 0;
            if (val < 0) {
                e.target.value = 0;
            }
        });
    }

    /**
     * Добавление в корзину с анимацией
     */
    document.addEventListener('click', function (e) {
        let target = e.target.closest('.btn-product-card, .add-to-cart');
        if (!target) return;

        e.preventDefault();
        e.stopPropagation();
        ym(269955, 'reachGoal', 'addcart');

        let productId = parseInt(target.dataset.id) || 0;
        if (!productId) {
            let card = target.closest('.product-card, [data-id]');
            if (card) productId = parseInt(card.dataset.id) || 0;
        }

        const card = target.closest('.product-card, [data-product-id]');
        if (!card) {
            console.error('Card not found');
            return;
        }

        const input = card.querySelector('.quantity');
        let quantity = 1;
        
        if (input) {
            quantity = parseInt(input.value) || 1;
        }

        if (!productId) {
            console.error(`Product with id ${productId} not found.`);
            return;
        }
        
        let originalHtml = target.innerHTML;
        let currentWidth = target.offsetWidth;
    
        let spinner = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path d="M0 0h24v24H0z" fill="none" />
            <g stroke="currentColor">
                <circle cx="12" cy="12" r="9.5" fill="none" stroke-linecap="round" stroke-width="3">
                    <animate attributeName="stroke-dasharray" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0 150;42 150;42 150;42 150" />
                    <animate attributeName="stroke-dashoffset" calcMode="spline" dur="1.5s" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" keyTimes="0;0.475;0.95;1" repeatCount="indefinite" values="0;-16;-59;-59" />
                </circle>
                <animateTransform attributeName="transform" dur="2s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12" />
            </g>
        </svg>`;
        
        target.style.transition = 'all 0.2s ease';
        target.style.transform = 'scale(0.95)';
        target.style.width = `${currentWidth}px`;
        
        setTimeout(function() {
            target.innerHTML = spinner;
            target.style.transform = 'scale(1)';
        }, 200);

        const modificator = card.dataset.modificator || null;

        Cart.add(productId, quantity, modificator)
            .then(function (data) {
                setTimeout(function() {
                    toggleCartControls(card, quantity, true);
                    
                    const inputElement = card.querySelector('.quantity');
                    if (inputElement) {
                        inputElement.value = quantity;
                        handleQuantityChange(inputElement, productId, card);
                    }
                    
                    Cart.updateUI();
                }, 500);
            })
            .catch(function (error) {
                target.innerHTML = originalHtml;
                target.style.width = 'auto';
                target.style.transform = 'scale(1)';
                console.error('Ошибка: ' + error.message);
            });
    });

    /**
     * Синхронизация с корзиной при загрузке
     */
    async function synchronizeItemsWithBasket(){
        try {
            const request = await Cart.get();
            const basketItems = request.items;
            
            if (!basketItems?.length) {
                console.debug('Cart is empty, no need to sync with the server.');
                return;
            }

            const quantityMap = Object.fromEntries(
                basketItems.map(item => [item.product_id, item.quantity])
            );

            const productsItems = document.querySelectorAll('[data-card="product"]');

            productsItems.forEach((card) => {
                const productId = parseInt(card.dataset.productId);
                const quantity = quantityMap[productId] || 0;
                
                const input = card.querySelector('.quantity');
                const button = card.querySelector('.btn-product-card');
                
                if (quantity > 0) {
                    if (input) {
                        input.value = parseInt(quantity);
                        handleQuantityChange(input, productId, card);
                    }
                    
                    toggleCartControls(card, quantity, false);
                } else {
                    toggleCartControls(card, 0, false);
                }
            });
        } catch (error) {
            console.error('Error synchronizing with basket:', error);
        }
    }
    

    window.synchronizeItemsWithBasket = synchronizeItemsWithBasket;

    document.addEventListener('DOMContentLoaded', async function () {
        const allCards = document.querySelectorAll('[data-card="product"]');
        allCards.forEach((card) => {
            const inputNumber = card.querySelector('.input-number');
            const button = card.querySelector('.btn-product-card');
            
            if (inputNumber) {
                inputNumber.style.display = 'none';
                inputNumber.style.opacity = '1';
                inputNumber.style.transform = 'scale(1)';
            }
            if (button) {
                button.style.display = 'inline-flex';
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
                button.textContent = 'В корзину';
                button.classList.remove('added');
            }
        });

        await synchronizeItemsWithBasket();
        Cart.updateUI();
        
        setInterval(function () {
            Cart.updateUI();
        }, 30000);
    });
})();
