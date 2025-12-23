<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $currentCity;
$priceId=$currentCity['PRICE_ID']['VALUE'];
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');


	$trans_ents = get_html_translation_table(HTML_ENTITIES);
	$trans_ents = array_flip($trans_ents);
	
	
	$productID = $_POST["id"];
	$size= $_POST["quant"];	
	if (!$size) $size=1;
	
		if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
		{
			 
			 $arTovar=CCatalogProduct::GetByIDEx($productID);
		$price = '';
		 if (!empty($arTovar['PROPERTIES']['AKTSIYA_']['VALUE_ENUM'])){
                 $price=$arTovar["PRICES"][$priceId]["PRICE"] - $arTovar['PROPERTIES']['AKTSIYA_']['VALUE_ENUM'] / 100 * $arTovar["PRICES"][$priceId]["PRICE"];
             } else {
                 $price=$arTovar["PRICES"][$priceId]["PRICE"];
             }

			 $name = strtr($arTovar["NAME"], $trans_ents);
			
			
			$arFields = array(
                        "MODULE" => "catalog",
						"PRODUCT_ID" => $productID,
						"PRICE" => $price,
						"CURRENCY" => "RUB",
						"LID" => "s1",
						"NAME" => $name,
						"DETAIL_PAGE_URL" => $arTovar["DETAIL_PAGE_URL"],
						"QUANTITY"=> $size,
						"DELAY"=>'N',
												
						);

			        $arProps[] = array("NAME" => $arTovar['PROPERTIES']['KOD_TOVARA']['NAME'],
                        "CODE" => "KOD_TOVARA",
                        "VALUE" => $arTovar['PROPERTIES']['KOD_TOVARA']['VALUE'],
                        "SORT" => 100);

					$arFields["PROPS"] = $arProps;
						//
						//CatalogBasketCancelCallback
            //debug($arFields);

			if ($cart_id=CSaleBasket::Add($arFields))//Add2BasketByProductID($productID)
			{ 
			
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

// Печатаем массив, содержащий актуальную на текущий момент корзину

				 $price=0;
				 $quantity=0;
				 foreach ($arBasketItems as $item) {
					$price=$price+$item["PRICE"]*$item["QUANTITY"];
					$quantity=$quantity+$item["QUANTITY"];
				 } 

			
			
			
			?>
				<div class="bg"></div>
			<div class="link-to-cart">В вашей корзине</div>
			<div class="quantity"><?=$quantity?> товаров</div>
			<div style="margin: 5px 0px -5px 0px">
			    на сумму <?= $price ?> руб
			</div>
			<?	//print_r($_REQUEST);
			}
			else
			{
				if ($ex = $GLOBALS["APPLICATION"]->GetException())
					$strError = $ex->GetString();
				else
					$strError = GetMessage("CATALOG_ERROR2BASKET").".";
				echo 'ошибка '.$strError;
			}

			//var_dump($cart_id);
		}
	
?>