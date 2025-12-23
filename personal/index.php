<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>
    <div class="common-content-full news-page regular-block">
        <div class="title-block-full">
            <!-- <div class="path">
                <a href="/">Главная</a> &rarr;
            </div> -->
            <h1 class="big-din">Кабинет</h1>
        </div>
        <div class="content-block-full">
            <div class="bx_page">
                <p>
                    В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов,
                    просмотреть или изменить личную информацию, а также подписаться на новости и другие информационные
                    рассылки.<br>
                    <br>
                </p>
                <!-- <h2 class="">Личная информация</h2>
                <p><a href="profile/">Изменить регистрационные данные</a></p> -->

                <!-- <div>
                    <h2 class="">Заказы</h2>
                    <p><a href="order/">Ознакомиться с состоянием заказов</a></p>
                    <p><a href="/cart/">Посмотреть содержимое корзины</a></p>
<!--                    <p><a href="order/">Посмотреть историю заказов</a></p>
                </div> -->
            </div>
            <div class="lk-row">
              <div class="lk-col">
                <a href="order/" class="lk-card">
                   <h3>Заказы</h3> 
                </a>
              </div>
              <div class="lk-col">
                <a href="/cart/" class="lk-card">
                   <h3>Корзина</h3> 
                </a>
              </div>
              <div class="lk-col">
                <a href="profile/" class="lk-card">
                   <h3>Профиль</h3> 
                </a>
              </div>
              <div class="lk-col">
                <a href="/personal/logout.php" class="lk-card">
                   <h3>Выход</h3> 
                </a>
              </div>
            </div>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>