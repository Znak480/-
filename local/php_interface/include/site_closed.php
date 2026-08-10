<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    define("B_PROLOG_INCLUDED", true);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Технические работы</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
        }
        
        .technical-break-section {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            flex-direction: column;
            gap: 1rem;
        }
        
        .technical-break-container {
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.15);
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 550px;
            width: 100%;
            background: #fff;
        }
        
        .technical-break-title {
            color: #333;
            font-size: 28px;
            margin-top: 0;
            margin-bottom: 20px;
        }
        
        .technical-break-container > a {
            display: block;
            margin-bottom: 2rem;
        }
        
        .technical-break-container img {
            max-width: 100%;
            height: auto;
        }
        
        .technical-break-container p {
            color: #555;
            margin-bottom: 8px;
        }
        
        /* Контакты */
        .technical-break-container:last-child {
            padding: 30px 40px;
            text-align: left;
        }
        
        .contact-title {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            text-align: left;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }
        
        .contact-city-container {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .contact-city {
            flex: 1;
            min-width: 200px;
            text-align: left;
        }
        
        .city-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
            padding-bottom: 4px;
            border-bottom: 1px solid #eee;
            display: inline-block;
        }
        
        .city-line {
            font-size: 13px;
            color: #888;
            margin: 8px 0;
            text-align: left;
            line-height: 1.4;
        }
        
        .city-line a {
            color: #888;
            text-decoration: none;
        }
        
        .city-line a:hover {
            color: #333;
            text-decoration: underline;
        }
        
        /* Адаптивность */
        @media (max-width: 600px) {
            .technical-break-container {
                padding: 25px;
            }
            
            .technical-break-container:last-child {
                padding: 20px 25px;
            }
            
            .contact-city-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .city-name {
                margin-bottom: 6px;
            }
        }
    </style>
</head>
<body>
    <section class="technical-break-section">
        <div class="technical-break-container">
            <a href="/">
                <img src="/i/logo.gif" alt="Логотип компании Знак">
            </a>
            <h1 class="technical-break-title">Технические работы</h1>
            <p>Сайт временно недоступен.</p>
            <p>Пожалуйста, зайдите позже.</p>
        </div>
        
        <div class="technical-break-container">
            <h3 class="contact-title">Свяжитесь с нами:</h3>
            
            <div class="contact-city-container">
                <div class="contact-city">
                    <div class="city-name">Барнаул:</div>
                    <div class="city-line">г. Барнаул, пр-кт Строителей, д. 92</div>
                    <div class="city-line">+7 (3852) 36-40-80</div>
                    <div class="city-line"><a href="mailto:znakooo@mail.ru">znakooo@mail.ru</a></div>
                </div>
                
                <div class="contact-city">
                    <div class="city-name">Горный Алтай:</div>
                    <div class="city-line">+7 (960) 950-00-70</div>
                    <div class="city-line"><a href="mailto:znakopt04@mail.ru">znakopt04@mail.ru</a></div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>