<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="wishlist">
    <div class="container">
        <div class="wishlist-layout">
            
            <div class="wishlist-items">
                <?if(!empty($arResult["ITEMS"])):?>
                    <?foreach ($arResult['ITEMS'] as $arItem){
                        $APPLICATION->IncludeFile(
                            SITE_TEMPLATE_PATH . '/include/card-favorite.php',
                            ['arItem' => $arItem],
                            [
                                'SHOW_BORDER' => false,
                                "MODE" => "PHP"
                            ]
                        );
                    }
                    ?>
                <? endif;?>
            </div>
                <div id="empty-page" class="empty-page hidden">
                    <h2 class="empty-title">Список избранного пуст</h2>
                        <p class="empty-description">
                            Добавьте товары в избранное, <br> чтобы не потерять их!
                        </p>
                    <a href="/catalog/" class="btn btn-primary">Перейти в каталог</a>
                </div>
        </div>
    </div>
</section>

<script>
    BX.ready(function () {
        const container = document.querySelector('.wishlist-layout');
        const cards = container.querySelectorAll('[data-card="favorite"]');

        function updateEmptyState(){
           
            const cardContainer = container.querySelector('.wishlist-items');
            const empty = container.querySelector("#empty-page");
            if (!cardContainer || !empty) {
                console.warn('Не найдены элементы .wishlist-items или #empty-page');
                return;
            }

            cardContainer.classList.toggle('hidden', cards.length === 0);
            empty.classList.toggle('hidden', cards.length > 0);
        }
        
        function updatePrice(card){
            const quantityInput = card.querySelector(".quantity");
            const quantity = parseInt(quantityInput.value) || 0;
            

           function calculatePrice(priceElement){
                const costPerUnit = priceElement.dataset.price;
                
                return (costPerUnit * quantity).toFixed(2);
           }

            card.querySelectorAll(".price").forEach(function(priceElement){
                const priceBox = priceElement.querySelector(".price-integer");

                if(!priceBox){
                    return;
                }

                const totalPriceValue = calculatePrice(priceElement);
                
                if(totalPriceValue < 0){
                    totalPriceValue = 0;
                } 

                priceBox.textContent = totalPriceValue;
            });

        }
        
        
        cards.forEach(function(card){
            card.querySelector(".quantity").addEventListener("change", function(){
                    updatePrice(card);
            }) 
        })

        document.addEventListener('click', async function(e){
            const button = e.target.closest('.js-favorite-delete');

            if(!button){
                return;
            }

            const elementId = button.dataset.id;

            if (!elementId) {
                return;
            }

            BX.ajax({
                url: '/local/ajax/favorite_delete.php',
                method: 'POST',
                data: {
                    elementId: elementId,
                    sessid: BX.bitrix_sessid(),
                },
                dataType: 'json',

                onsuccess: function (data) {
                    BX.onCustomEvent('onIntensaFavoriteChange', [data]);
                    
                    BX.onCustomEvent('onIntensaFavoriteUpdate', []);

                    if(data.success){
                       const card =  document.querySelector(`[data-product-id="${elementId}"]`);

                       if(card) {
                          card.classList.add('deleting');
                          setTimeout(() => {card.remove();
                            updateEmptyState();
                          },300);
                       }
                    }
                },
                onfailure:function(data){
                    console.error(data.error);
                }
            })
        });
        
        updateEmptyState();

    });
</script>