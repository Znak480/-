<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");

// Если пользователь не авторизован — редирект на логин
if (!$USER->IsAuthorized()) {
    LocalRedirect("/auth/");
}
?>

<section class="account">
    <div class="container">
        <div class="account-layout">
            <aside class="account-sidebar">
                <nav class="account-nav">
                    <a href="#" class="nav-item" data-page="profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 2a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2m0 7c2.67 0 8 1.33 8 4v3H4v-3c0-2.67 5.33-4 8-4m0 1.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1" />
                        </svg>
                        <span>Личные данные</span>
                    </a>
                    <a href="#" class="nav-item disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M3 21V5.8L5.3 3h13.4L21 5.8V21zM5.4 6h13.2l-.85-1H6.25zM8 16l4-2l4 2V8H8z" />
                        </svg>
                        <span>Мои покупки</span>
                        <div class="badge badge--wip"><span class="badge-label" style="font-size: 0.5rem">Cкоро</span></div> 
                    </a>
                    <a href="#" class="nav-item" data-page="password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="currentColor" d="M11.088 5.588Q11.675 5 12.5 5t1.413.588T14.5 7t-.587 1.413T12.5 9t-1.412-.587T10.5 7t.588-1.412M12.5 24L8 19.5l1.5-2l-1.5-2l1.5-2.125V12.2q-1.35-.8-2.175-2.162T6.5 7q0-2.5 1.75-4.25T12.5 1t4.25 1.75T18.5 7q0 1.675-.825 3.038T15.5 12.2V21zm-4-17q0 1.4.85 2.463t2.15 1.412V14l-1.025 1.45L12 17.5l-1.375 1.775L12.5 21.15l1-1v-9.275q1.3-.35 2.15-1.412T16.5 7q0-1.65-1.175-2.825T12.5 3T9.675 4.175T8.5 7" />
                        </svg>
                        <span>Сменить пароль</span>
                    </a>
                    <a href="/personal/logout.php" class="btn btn-sm btn-outline-error">
                      <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256">
                        <path d="M0 0h256v256H0z" fill="none" />
                        <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M112 168a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm48 0a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0Zm0-120H96v-8a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8Z" />
                      </svg>
                      <span>Выйти</span>
                    </a>
                </nav>
            </aside>

            <div class="account-content">
                <!-- СТРАНИЦА ПРОФИЛЯ -->
                <div class="account-page active" data-account="page-profile">
                    <h2 class="account-title">Личные данные</h2>
                    <?php
                   
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.profile",
                        "personal_data", 
                        Array(
                            "SET_TITLE" => "N",
                            "AJAX_MODE" => "N",
                            "SET_AUTH_INFO" => "N"
                        )
                    );
                    ?>
                </div>

                <!-- СТРАНИЦА ЗАКАЗОВ -->
                <div class="account-page" data-account="page-orders">
                    <h2 class="account-title">Мои покупки</h2>
                </div>

                <!-- СТРАНИЦА СМЕНЫ ПАРОЛЯ -->
                <div class="account-page" data-account="page-password">
                    <h2 class="account-title">Сменить пароль</h2>
                    
                    <?php
                    // КОМПОНЕНТ СМЕНЫ ПАРОЛЯ
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.profile",
                        "change_password", 
                        Array(
                            "SET_TITLE" => "N",
                            "AJAX_MODE" => "N"
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    const $navItem = $(".nav-item");
    
    $navItem.each(function() {
        const $this = $(this);

        $this.on("click", function(e) {
            e.stopPropagation();
            e.preventDefault();

            if ($(this).hasClass('active')) return;
            
            if($(this).hasClass("disabled")) return;

            $navItem.removeClass('active');
            $(this).addClass('active');

            const attr = $(this).attr("data-page");
            toggleMenu(attr);
            localStorage.setItem('activeTab', attr);
        });
    });

    function toggleMenu(pageName) {
        const $pages = $(".account-page");

        $pages.removeClass("active");

        const $target = $(`.account-page[data-account="page-${pageName}"]`);

        if ($target.length) {
            $target.addClass('active');
        } else {
            console.warn(`Не найдена: data-account="page-${pageName}"`);
            $pages.each(function() {
                console.log(`   - ${$(this).attr('data-account')}`);
            });
        }
    }

    const savedTab = localStorage.getItem('activeTab');
    let $targetTab;

    if (savedTab) {
        $targetTab = $(`.nav-item[data-page="${savedTab}"]`);
    }

    if (!$targetTab || !$targetTab.length) {
        $targetTab = $(".nav-item").first();
    }

    $targetTab.addClass('active');
    toggleMenu($targetTab.data('page'));

    $(document).on('submit', '.profile-form', function(e) {
        const currentTab = $(".nav-item.active").data('page');
        localStorage.setItem('activeTab', currentTab);
    });

    BX.addCustomEvent('onProfileSave', function() {
        const currentTab = $(".nav-item.active").data('page');
        localStorage.setItem('activeTab', currentTab);
    });
});
</script>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>