<?php

namespace Craft\Bitrix\Events;

use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use CCatalogProduct;
use CIBlockElement;
use CModule;

class OnBasketUpdateHandler
{
	public static function OnBasketHandler($ID, $arItem)
	{
		global $fileRoute;
		global $USER, $DB;
		$strGroups = $USER->GetUserGroupString();
		$arUserGroups = explode(',', $strGroups);


		//if(!in_array(7, $arUserGroups) && !in_array(8, $arUserGroups) && !in_array(9, $arUserGroups) && !in_array(10, $arUserGroups) ) {
		if($USER->IsAdmin() or 1)
		{
			$productID = $arItem['PRODUCT_ID'];
			$quantity = $arItem['QUANTITY'];
			$tovarId = $productID;
			if(CModule::IncludeModule('iblock'))
			{
				$tovar = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_PRODUCTS_ID, 'ID' => $productID], false, false, ['PROPERTY_CML2_LINK']);
				if($t = $tovar->GetNext())
				{
					$tovarId = $t['PROPERTY_CML2_LINK_VALUE'];
				}
			}
			if($productID > 0)
				$strsql = "SELECT ACTIONS cc, APPLICATION aa FROM  b_sale_discount as i2
          where i2.active='Y' and (i2.active_from<=CURDATE() or i2.active_from is NULL)  and (i2.active_to>=CURDATE() or  i2.active_to is NULL)
          and i2.APPLICATION like concat('%', 'applyToBasket', '%')
          and i2.UNPACK like '%CSaleBasketFilter::ProductFilter%'
          and 
            PRESET_ID is NULL
          and  (
              i2.APPLICATION like concat('%', '] == " . $productID . ")', '%')
              or
              i2.APPLICATION like concat('%', '] == " . $productID . " |', '%')
              or
              i2.APPLICATION like concat('%', '] == " . $tovarId . ")', '%')
              or
              i2.APPLICATION like concat('%', '] == " . $tovarId . " |', '%')
          )
        order by id desc";
			if($strsql)
			{

				$ids = [];
				$sales = [];
				$resZ = $DB->Query($strsql, false, "Error" . __LINE__);
				while($tovar = $resZ->GetNext())
				{

					$skidka = [];
					$s = unserialize($tovar['~cc'])['CHILDREN'];

					foreach($s as $key => $val)
					{
						//
						foreach($val['CHILDREN'] as $tov)
						{
							$ids[] = $tov['DATA']['value'];

							$skidka[$tov['DATA']['value']] = [
								"value" => $val['DATA']['Value'],
								"type"  => $val['DATA']['Unit'],
							];
						}
					}
					$sales[] = $skidka;
				}

				$ids = array_unique($ids);
				$basket = Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());
				$mincount = [];
				$tovars = [];
				foreach($basket as $basketItem)
				{
					$tovarId = 0;
					$tovar = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_PRODUCTS_ID, 'ID' => $basketItem->getField('PRODUCT_ID')], false, false, ['PROPERTY_CML2_LINK']);
					if($t = $tovar->GetNext())
					{
						$tovarId = $t['PROPERTY_CML2_LINK_VALUE'];
					}

					if((in_array($basketItem->getField('PRODUCT_ID'), $ids) || in_array($tovarId, $ids)) && !$basketItem->isDelay())
					{
						$mincount[$tovarId != 0 ? $tovarId : $basketItem->getField('PRODUCT_ID')] = $basketItem->getQuantity();
						$tovars[$basketItem->getField('PRODUCT_ID')] = $tovarId != 0 ? $tovarId : $basketItem->getField('PRODUCT_ID');
					}
				}

				if($mincount && count($mincount) > 1)
				{
					$min = min($mincount);
				} else
				{
					$min = 1;
				}

				foreach($sales as $key => $value)
				{
					if(empty(array_diff(array_keys($value), array_keys($mincount))))
					{
						$thisSale = $value;
						break;
					}
				}
				if(CModule::IncludeModule('catalog'))
				{
					foreach($basket as $basketItem)
					{
						if(in_array($basketItem->getField('PRODUCT_ID'), array_keys($tovars)) && !$basketItem->isDelay())
						{
							$arPrice = CCatalogProduct::GetOptimalPrice($basketItem->getField('PRODUCT_ID'), $basketItem->getQuantity(), $arUserGroups, 'N');
							if($mincount[$ID] == $min)
							{
								$basketItem->setFields([
									'CUSTOM_PRICE' => 'N',
									'PRICE'        => $arPrice['PRICE']['PRICE'],
								]);
							} else
							{

								if($thisSale[$tovars[$basketItem->getField('PRODUCT_ID')]]['type'] == "Perc")
								{
									$salePart = ($arPrice['PRICE']['PRICE'] * $thisSale[$tovars[$basketItem->getField('PRODUCT_ID')]]['value'] / 100) * ($min);
								} else
								{
									$salePart = $thisSale[$tovars[$basketItem->getField('PRODUCT_ID')]]['value'] * ($min);
								}

								$full = $arPrice['PRICE']['PRICE'] * ($basketItem->getQuantity());
								$basketItem->setFields([
									'CUSTOM_PRICE' => 'Y',
									'PRICE'        => ($full - $salePart) / $basketItem->getQuantity(),
								]);
								$arItem['BASE_PRICE'] = ($full - $salePart) / $basketItem->getQuantity();
							}
							$basketItem->save();
						}
					}//foreach(basket)
				}//if (IncludeModule('catalog'))
			}//if (strsql)
		}//if(isAdmin)
	}
}