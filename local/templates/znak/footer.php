<div class="clear"></div>
</div>

<?
echo "<br><br><br><br><br>";
if(!empty($_GET['ORDER_ID']))
{
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
}
?>


<div class="footer">
	<div class="wrapper">

		<!-- модалка on -->

		<div class="contact-form-modal orderCall">
			<a class="close">X</a>
			<div class="form-table" id="feedbackwrap">
				<h2 class="common-sans">Заказать звонок</h2>
				<div class="line">
					<div class="label">Как вас зовут? *</div>
					<div class="input">
						<input type="text" value="" name="fio">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<div class="label">Телефон *</div>
					<div class="input">
						<input type="text" value="" name="phone">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<div class="label">E-mail</div>
					<div class="input">
						<input type="text" value="" name="email">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line extended-line">
					<div class="label">Примечание</div>
					<div class="input">
						<textarea name="comment"></textarea>
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<div class="label">двa плюc тpи рaвно (чиcлoм)</div>
					<div class="input">
						<input type="text" value="" name="fix" size="3">
					</div>
					<div class="clear"></div>
				</div>
				<br>
				<br>
				<div class="line">
					<div class="label"></div>

					<div class="input">
						<div style="max-width:100%;">
							<input type="checkbox" value="Y" name="agree" data-agree-checkbox>
							Принимаю условия
							<a href="/agreement/" target="_blank">Пользовательского соглашения</a>
							, и соглашаюсь с
							<a href="/personal-data/" target="_blank">Политикой
								обработки и
								использования
								персональных
								данных
							</a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<br>
				<br>
				<div class="line">
					<div class="label"></div>
					<div class="input">
						<input type="submit" value="Отправить">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<p>* - обязательно для заполнения</p>
					<div class="clear"></div>
				</div>
			</div>
		</div>


		<div class="contact-form-modal buy-one-click">
			<a class="close">X</a>
			<div class="form-table" id="feedbackwrap">
				<h2 class="common-sans">Покупка в 1 клик</h2>
				<div class="line">
					<div class="label">Как вас зовут? *</div>
					<div class="input">
						<input type="text" value="" name="fio">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<div class="label">Телефон *</div>
					<div class="input">
						<input type="text" value="" name="phone">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<div class="label">E-mail</div>
					<div class="input">
						<input type="text" value="" name="email">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line extended-line">
					<div class="label">Примечание</div>
					<div class="input">
						<textarea name="comment"></textarea>
					</div>
					<div class="clear"></div>
				</div>

				<div class="line">
					<div class="label"></div>

					<div class="input">
						<div style="max-width:100%;">
							<input type="checkbox" value="Y" name="agree" data-agree-checkbox>
							Принимаю условия
							<a href="/agreement/" target="_blank">Пользовательского соглашения</a>
							, и соглашаюсь с
							<a href="/personal-data/" target="_blank">Политикой
								обработки и
								использования
								персональных
								данных
							</a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<br>
				<br>
				<div class="line">
					<div class="label"></div>
					<div class="input">
						<input type="submit" value="Отправить">
					</div>
					<div class="clear"></div>
				</div>
				<div class="line">
					<p>* - обязательно для заполнения</p>
					<div class="clear"></div>
				</div>
				<input type="hidden" value="" name="product">
			</div>
		</div>

		<div class="contact-form-modal isNovosib" style="display: <? echo($_SESSION['city'] == 'novosibirsk' ? 'block' : 'none') ?>;">

			<form action="" method="post" style="display: none">
				<input type="text" name="city" value="barnaul" hidden>
			</form>
			<a class="close">X</a>
			<div class="form-table" id="feedbackwrap">
				<h2 class="common-sans"></h2>
				<div class="line">
					<p>
						Мы определили, что вы, возможно, находитесь в Новосибирске.
					</p>
				</div>
				<div class="line">
					<p>
						Для Новосибирска у нас есть отдельный сайт:
						<a href="http://nsk.znakooo.ru"> http://nsk.znakooo.ru</a>
					</p>
					<div class="clear"></div>
				</div>
				<div class="line">
					<p>
						Вы можете либо остаться на этом сайте, либо перейти на версию для Новосибирска
					</p>
					<div class="clear"></div>
				</div>
				<div class="line">
				</div>
				<div class="line buttons">
					<div class="input">
						<input type="submit" onclick="$(this).parents('.isNovosib').find('form').submit()" value="Остаться">
					</div>
					<div class="input">
						<input type="submit" onclick="document.location.href = 'http://nsk.znakooo.ru/'"
							   value="Перейти">
					</div>
				</div>
			</div>
		</div>

		<div class="contact-success-modal">
			<div class="form-table">
				<h2 class="common-sans">Ваша заявка отправлена</h2>

			</div>
		</div>

		<!-- модалка off -->

		<? $APPLICATION->IncludeComponent("bitrix:main.include", "", [
			"AREA_FILE_SHOW" => "file",
			"PATH"           => "/include/footer_menu.php",
			"EDIT_TEMPLATE"  => "",
		],
			false
		); ?>

		<div class="consultation">Заказать звонок</div>

		<ul class="pay-cards">
			<li>
				<img src="/images/visa.png"/>
			</li>
			<li>
				<img src="/images/ms.png"/>
			</li>
			<li>
				<img src="/images/mir.png"/>
			</li>
		</ul>

		<div class="subscribe">
			<? /*$APPLICATION->IncludeComponent(
	"bitrix:sender.subscribe",
	"subscribe",
	array(
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => "subscribe",
		"USE_PERSONALIZATION" => "Y",
		"CONFIRMATION" => "N",
		"SHOW_HIDDEN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
);*/ ?>
		</div>
		<div class="social">
			<ul class="">
				<li>
					<a href="https://vk.com/znakooo" target="_blank">
						<img src="/images/vk-icon.png"/>
					</a>
				</li>
				<li>
					<a href="https://ok.ru/znakooo" target="_blank">
						<img src="/images/ok-icon.png"/>
					</a>
				</li>
			</ul>
			<!--            <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,odnoklassniki,moimir"></div>-->
		</div>
	</div>
</div>
<div class="post-footer">
	<div class="wrapper">
		<p>При полном или частичном использовании материалов с сайта, ссылка на источник обязательна. Вся представленная на сайте информация, касающаяся технических
			характеристик, наличия на складе, стоимости товаров и услуг, носит информационный характер и ни при каких условиях не является публичной офертой.
		</p>
	</div>
</div>

<div class="modal-add">
	<div class="modal-add__title">
		<span>Товар добавлен в корзину</span>
	</div>
	<div class="modal-add__content">
		<a href="#" target="_blank">
			<span class="modal-add__name"></span>
			<div class="modal-add__image">

			</div>
		</a>
	</div>
</div>

<div class="black-bg" style="display: <? echo($_SESSION['city'] == 'novosibirsk' ? 'block' : 'none') ?>;"></div>


<?php
$APPLICATION->IncludeComponent(
	'craft:cookie.agree',
	'.default',
	[
		'TEXT' => 'Мы&nbsp;используем файлы cookie, Яндекс.Метрику и&nbsp;Google Analytics для&nbsp;обеспечения работы сервисов, анализа и&nbsp;улучшения работы сайта. Продолжая пользоваться сайтом, вы&nbsp;соглашаетесь с&nbsp;условиями использования.',
	],
	false,
	['HIDE_ICONS' => 'Y']
);
?>

</body>
</html>
