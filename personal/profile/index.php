<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?>
	<div class="common-content-full news-page regular-block">
		<div class="title-block-full">
			<div class="path">
				<a href="/" title="Главная страница" itemprop="url">
					<span itemprop="title">Главная страница</span>
				</a> &rarr;
				<a href="/personal/" title="Каталог" itemprop="url">
					<span itemprop="title">Кабинет</span>
				</a> &rarr;
				<a href="/personal/profile/">Профиль</a>
			</div>
			<h1 class="big-din">Профиль</h1>
		</div>
		<div class="content-block-full">

			<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile", Array(
				"CHECK_RIGHTS" => "N",	// Проверять права доступа
				"SEND_INFO" => "N",	// Генерировать почтовое событие
				"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
				"USER_PROPERTY" => "",	// Показывать доп. свойства
				"USER_PROPERTY_NAME" => "UF_PHONE",	// Название закладки с доп. свойствами
			),
				false
			);?>
		</div>
	</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>