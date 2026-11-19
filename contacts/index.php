<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;
global $currentCity;

$APPLICATION->SetPageProperty("title", "Контакты | Торговый центр «Знак» – товары для ремонта и строительства");
$APPLICATION->SetPageProperty("keywords", "Контакты, торговый, центр, знак, товар, ремонт, строительство, отделочный, строительный, материал");
$APPLICATION->SetPageProperty("description", "Контакты торгового центра «Знак». Отделочные и строительные материалы, а также инструменты, текстиль, предметы интерьера, хозтовары, товары для дома.");
$APPLICATION->SetTitle("Контакты");
?>

<div data-page="contacts">
	<?$APPLICATION->IncludeComponent(
        "bitrix:breadcrumb", 
        "znak", 
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "-",
        ),
        false
    );?>

	<section class="section">
		<div class="container">
			<div class="contacts-wrapper">
				<div class="contact-card">
					<div class="contact-info">
						<h2 class="contact-info-title">Торговый центр «Синий ЗНАК»</h2>
						<div class="contact-info-description">
							<address>
								<p>Пр. Строителей, 92</p>
								<p>Тел. <a href="tel:+73852364080">(3852) 36-40-80</a></p>
								<p>E-mail: <a href="mailto:znakooo@mail.ru">znakooo@mail.ru</a></p>
							</address>
							<div class="contact-schedule">
								<p>Режим работы:<br>
								понедельник — суббота с 09:00 до 20:00,<br>
								воскресенье 09:00 — 19:00, без обеда</p>
							</div>
						</div>
					</div>
					<div class="contact-image">
						<img src="<?= SITE_TEMPLATE_PATH .'/assets/image/znak-blue.jpg' ?>" alt="Торговый центр «Синий ЗНАК»">
					</div>
				</div>

				<div class="contact-card">
					<div class="contact-info">
						<h2 class="contact-info-title">Торговый центр «Красный ЗНАК»</h2>
						<div class="contact-info-description">
							<address>
								<p>Пр. Строителей, 94</p>
								<p>Тел. <a href="tel:+73852364080">(3852) 36-40-80</a></p>
								<p>E-mail: <a href="mailto:znakooo@mail.ru">znakooo@mail.ru</a></p>
							</address>
							<div class="contact-schedule">
								<p>Режим работы:<br>
								понедельник — суббота с 09:00 до 20:00,<br>
								воскресенье 09:00 — 19:00, без обеда</p>
							</div>
						</div>
					</div>
					<div class="contact-image">
						<img src="<?= SITE_TEMPLATE_PATH .'/assets/image/znak-red.jpg' ?>" alt="Торговый центр «Красный ЗНАК»">
					</div>
				</div>

				<div class="contact-card" data-entity="warehouses">
					<div class="contact-info">
						<h2 class="contact-info-title">Склады</h2>
						<div class="contact-info-description">
							<p>Режим работы складов:</p> 
							<p>понедельник — воскресенье с 09:00 до 19:00</p>
						</div>
					</div>
				</div>

				<div class="contact-card" data-entity="company-details">
					 <div class="company-detail">
						<h3 class="company-detail-title">Контакты ООО «Знак»:</h3>
						
						<div class="company-detail-info">
							<p><strong>Фактический адрес:</strong> 656031, Алтайский край, Барнаул г, Строителей пр-кт, дом № 94.</p>
							<p><strong>Электронная почта: </strong> <a href="mailto:znakooo@mail.ru">znakooo@mail.ru</a>.</p>
							<p><strong>Телефоны: </strong> <a href="tel:+73852624006">(3852) 62 40 06</a>.</p>
						</div>

						<div class="company-requisites">
							<p class="requisites-label">Реквизиты:</p>
							<p>ООО «Знак».</p>
							<p><strong>ИНН: </strong> 2225025537 / <strong>ОГРН:</strong> 1022201761317.</p>
							<p><strong>Юридический адрес:</strong> 656031, Алтайский край, Барнаул г, Строителей пр-кт, дом № 94.</p>
							<p><strong>Тел./факс: </strong> <a href="tel:+73852624006">(3852) 62 40 06</a>.</p>
						</div>
					</div>

					<div class="company-detail">
						<h3 class="company-detail-title">Контакты ООО «Энтер»:</h3>
						
						<div class="company-detail-info">
							<p><strong>Фактический адрес:</strong> 656031, Алтайский край, Барнаул г, Строителей пр-кт, дом № 94.</p>
							<p><strong>Телефоны:</strong> <a href="tel:+73852624049">(3852) 62-40-49</a>.</p>
						</div>

						<div class="company-requisites">
							<p class="requisites-label">Реквизиты:</p>
							<p>ООО "Энтер".</p>
							<p><strong>ИНН: </strong>2225073379 / <strong>ОГРН:</strong>1052202343160.</p>
							<p><strong>Юридический адрес:</strong> 656031, Алтайский край, Барнаул г, Строителей пр-кт, дом № 94.</p>
							<p><strong>Тел./факс: </strong>  <a href="tel:+73852624049">(3852) 62-40-49</a>.</p>
						</div>
					</div>
				</div>

				<div class="contact-card" data-entity="wholesale-goods">
					<div class="contact-info">
						<h2 class="contact-info-title">Отдел оптовых продаж</h2>
						<div class="contact-info-description">
							<p>Электронная почта:</p> 
							<p><a href="mailto:znakooo@mail.ru">znakopt@mail.ru</a></p>
						</div>
					</div>
				</div>

				<div class="contact-map">
					<div class="map">
						<a href="http://2gis.ru/barnaul/firm/563478234743280/center/83.74541044235231,53.341302606877335/zoom/16?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap" class="dg-widget-link">Посмотреть на карте Барнаула</a>
							<div class="dg-widget-link">
						<a href="http://2gis.ru/barnaul/center/83.745417,53.341146/zoom/16/routeTab/rsType/bus/to/83.745417,53.341146╎Знак, гипермаркет товаров для стройки и ремонта?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Знак, гипермаркет товаров для стройки и ремонта</a>
							</div>
							<script charset="utf-8" src="https://widgets.2gis.com/js/DGWidgetLoader.js"></script><script charset="utf-8">new DGWidgetLoader({"width":"100%", "height": 320,"borderColor":"#a3a3a3","pos":{"lat":53.341302606877335,"lon":83.74541044235231,"zoom":16},"opt":{"city":"barnaul"},"org":[{"id":"563478234743280"}]});</script>
					</div>
				</div>

			</div>
		</div>
	</section>

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>