<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/include/libmail.php");
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule("sale"); 

$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');
				 
				$m  = new Mail;//отправка продавцу
				$m2 = new Mail;//отправка покупателю
				$arBasketItems = array();
				$dbBasketItems = CSaleBasket::GetList(
						array(
								"NAME" => "ASC",
								"ID" => "ASC"
							),
						array(
								"FUSER_ID" => CSaleBasket::GetBasketUserID(),
								"LID" => SITE_ID,
								"ORDER_ID" => "NULL"
							),
						false,
						false,
						array("ID", "CALLBACK_FUNC", "MODULE", 
							  "PRODUCT_ID", "QUANTITY", "DELAY", 
							  "CAN_BUY", "PRICE", "WEIGHT")
					);
					while ($arItems = $dbBasketItems->Fetch())
					{
						if (strlen($arItems["CALLBACK_FUNC"]) > 0)
						{
							CSaleBasket::UpdatePrice($arItems["ID"], 
													 $arItems["CALLBACK_FUNC"], 
													 $arItems["MODULE"], 
													 $arItems["PRODUCT_ID"], 
													 $arItems["QUANTITY"]);
							$arItems = CSaleBasket::GetByID($arItems["ID"]);
						}

						$arBasketItems[] = $arItems;
					}

					//отправка заказа продавцу
					$message = ('Вам поступила заявка с сайта Знак ');	
					$message .= ('<br>От : '.$_POST["fio"]);
					$message .= ('<br>Телефон : '.$_POST["phone"]);
					$message .= ('<br>Email : '.$_POST["email"]);
					$message .= ('<br>Товары : ');
					foreach ($arBasketItems as $item) {
						$res = CIBlockElement::GetByID($item["PRODUCT_ID"]);
						if($ar_res = $res->GetNext())
					    $message .= ('<br>'.$ar_res['NAME'].' : '.$item["QUANTITY"]);
					}




					$m->From("noreply@znakooo.ru"); // от кого отправляется почта
					$m->To( $adminEmail  ); // кому адресованно
		

					$m->Subject("Заказ из корзины");
					$m->Body( $message , "html");    
					$m->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "8RdG5eY1wC", 25) ; // если указана эта команда, отправка пойдет через SMTP
				    $m->log_on(true);
					$m->Send();    // а теперь пошла отправка


					
					$msg = $m->Get(); // получение в переменную
					echo($msg);
//$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
//$order = Bitrix\Sale\Order::create('s1', 1);
//$order->setPersonTypeId(1);
//$order->setBasket($basket);
//$result = $order->save();
//if (!$result->isSuccess())
//{
//    //$result->getErrors();
//}

//отправка письма покупателю
$message2 = "Заказ оформлен, с вами в скором времени свяжется менеджер магазина";
$m2->From("noreply@znakooo.ru"); // от кого отправляется почта
$m2->To(trim($_POST["email"])); // кому адресованно

$m2->Subject("Заказ на сайте");
$m2->Body( $message2 , "html");
//$m2->smtp_on( "mail.nic.ru", "noreply@znakooo.ru", "97kw2fKjvz6ZQ", 25) ; // если указана эта команда, отправка пойдет через SMTP
$m2->log_on(true);
$m2->Send();    // а теперь пошла отправка

					CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
					


?>
