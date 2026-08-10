<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<section class="section section--ups">
    <div class="container">
        <div class="ups-wrapper">
            <div class="ups-content">
                <div class="ups-icon">
                    <svg width="80" height="80" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="60" cy="60" r="58" stroke="var(--color-primary)" stroke-width="4"/>
                        <path d="M60 35V65M60 75V77" stroke="var(--color-primary)" stroke-width="6" stroke-linecap="round"/>
                        <circle cx="60" cy="60" r="2" fill="var(--color-primary)"/>
                    </svg>
                </div>

                <h1 class="ups-title">Упс! Страница в разработке</h1>
                
                <div class="ups-divider"></div>
                
                <p class="ups-text">
                    Мы уже работаем над этим разделом, чтобы сделать его удобным и полезным для вас.
                </p>
                <p class="ups-text ups-text--small">
                    Приносим извинения за временные неудобства. Совсем скоро здесь появится что-то интересное!
                </p>

                <div class="ups-actions">
                    <a href="/" class="btn btn-primary">Вернуться на главную</a>
                    <a href="mailto:info@site.ru" class="btn btn-outline">Связаться с нами</a>
                </div>

                <div class="ups-status">
                    <span class="status-dot"></span>
                    <span class="status-text">Статус: <strong>В активной разработке</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ===== ROOT VARIABLES ===== */
    :root {
        --text-dark: #1a1a2e;
        --text-gray: #4a4a6a;
        --text-light: #6b6b8a;
        --border-light: #d0d0e0;
        --bg-light: #f8f9fa;
    }

    /* ===== SECTION ===== */
    .section--ups {
        min-height: calc(100vh - 160px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 0;
        background: #ffffff;
        position: relative;
    }
    /* ===== WRAPPER ===== */
    .ups-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    /* ===== CONTENT ===== */
    .ups-content {
        max-width: 600px;
        text-align: center;
    }

    .ups-icon {
        margin-bottom: 24px;
        animation: float 3s ease-in-out infinite;
    }

    .ups-icon svg {
        display: block;
        margin: 0 auto;
        width: 90px;
        height: 90px;
    }

    .ups-title {
        font-size: 42px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 16px 0;
        line-height: 1.2;
    }

    .ups-divider {
        width: 80px;
        height: 4px;
        background: var(--color-primary);
        border-radius: 4px;
        margin: 16px auto 24px;
    }

    .ups-text {
        font-size: 20px;
        line-height: 1.6;
        color: var(--text-gray);
        margin: 0 0 12px 0;
    }

    .ups-text--small {
        font-size: 16px;
        color: var(--text-light);
        margin-bottom: 32px;
    }

    /* ===== BUTTONS ===== */
    .ups-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        margin-bottom: 36px;
    }


    /* ===== STATUS ===== */
    .ups-status {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 8px 20px;
        background: rgba(255, 184, 0, 0.08);
        border-radius: 50px;
        font-size: 14px;
        color: var(--text-gray);
    }

    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--color-primary);
        animation: pulse-dot 1.8s ease-in-out infinite;
    }

    .status-text strong {
        color: var(--text-dark);
    }

    /* ===== ANIMATIONS ===== */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 576px) {
        .section--ups {
            min-height: calc(100vh - 120px);
            padding: 40px 0;
        }

        .ups-title {
            font-size: 28px;
        }

        .ups-text {
            font-size: 17px;
        }

        .ups-icon svg {
            width: 80px;
            height: 80px;
        }

        .ups-actions {
            flex-direction: column;
            width: 100%;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        .ups-status {
            font-size: 13px;
            padding: 6px 16px;
        }
    }

    @media (max-width: 400px) {
        .ups-title {
            font-size: 24px;
        }
        .ups-text {
            font-size: 15px;
        }
    }
</style>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>