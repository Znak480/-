<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>

<?
	//include($_SERVER['DOCUMENT_ROOT']."/include/cabmenu.php");
?>
<div class="data">

			<?if($_REQUEST['filter_history'] == 'Y' && !$_REQUEST['show_canceled']){
                //$APPLICATION->SetPageProperty("h1", "История заказов");?>
				<a href="/personal/order/" class="hover link fw-700 mb-3 me-5">Текущие заказы</a>
                <!-- <a href="/personal/order/?filter_history=Y&show_canceled=Y" class="hover link fw-700 mb-3">Отмененные заказы</a> -->
                <?
            }elseif($_REQUEST['show_canceled'] == 'Y'){?>
                <a href="/personal/order/" class="hover link fw-700 mb-3 me-5">Текущие заказы</a>
                <a href="/personal/order/?filter_history=Y" class="hover link fw-700 mb-3 ">История заказов</a>

            <?}else{?>
				<a href="/personal/order/?filter_history=Y" class="hover link fw-700 mb-3 me-5">История заказов</a>
                <!-- <a href="/personal/order/?filter_history=Y&show_canceled=Y" class="hover link fw-700 mb-3">Отмененные заказы</a> -->
                <?
            }?>

<!--h1>Мои заказы </h1 -->
<?
	$arStatus = CSaleStatus::GetByID($_REQUEST['status']);
//	print_r($arStatus);
//	print_r($arResult);
?>

<?
if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}
}
?>

			<?

                //ov_dump(count($arResult["ORDERS"]));


				$bNoOrder = true;
				foreach($arResult["ORDERS"]  as $key => $vval)
				{
                   // echo $vval["ORDER"]["ACCOUNT_NUMBER"]. '   ';
					if(
                        ($_REQUEST['status']==$vval['ORDER']['STATUS_ID']&&$vval["ORDER"]['CANCELED']=='N') ||
                        (!$_REQUEST['status']) ||
                        ($vval["ORDER"]['CANCELED']=='Y'&&$_REQUEST['status']=='O')
                    ){
						$bNoOrder = false;



					?>
					


					<section class="order-list">
						<div class="personal-order">
							<div class="personal-order__heading js-order-details noSelect">
								<a class="personal-order__name " href="javascript:void(0)">
									<b class="fs-22">Заказ № 
										<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>
									</b>
									&nbsp;от&nbsp;
									<?echo GetMessage("STPOL_FROM")?>
										<?= $vval["ORDER"]["DATE_INSERT"]; ?>
									<span class="personal-order__status"><?echo $arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"];?></span>
									&nbsp;&nbsp;
									<i class="fa fa-caret-down" aria-hidden="true"></i>
								</a>
								<span class="personal-order__total fs-18 fw-700"><?=$vval["ORDER"]["FORMATED_PRICE"]?></span>
							</div>

							<div class="personal-order__detail" style="display:none">

								<div class="overflow-auto">
								<div class="personal-order__wrapper">

								<table>
									<tr>
										<td width=50%><b>Сумма:</b></td>
										<td width=50%><b><?=$vval["ORDER"]["FORMATED_PRICE"]?></b></td>
									</tr>
                                    <?//debug($vval)?>
									<tr>
										<td>Статус заказа:</td>
										<td>
											<?
                                            if($vval["ORDER"]["CANCELED"] == 'Y'){
                                                echo 'Заказ отменен';
                                            }else{
	                                            if ($vval["ORDER"]['STATUS_ID']=="N" && $vval['ORDER']['PAY_SYSTEM_ID']==2) {
		                                            echo "Заказ принят, оплата при получении товара";
	                                            }
	                                            else{
		                                            echo $arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"];
	                                            }
                                            }


											?>
									</td>
									</tr>
									<!-- tr>
										<td><b>Стоимость доставки:</b></td>
										<td><?=CurrencyFormat($vval['ORDER']['PRICE_DELIVERY'], 'RUB');?></td>
									</tr -->
									<tr>
										<td>Способ оплаты:</td>
										<td>
											<?
												$pay = CSalePaySystemAction::GetByID($vval['ORDER']['PAY_SYSTEM_ID']);
												if ($pay)
												{
												  echo $pay["NAME"];
												}
											?>
										</td>
									</tr>
									<tr>
										<td>Способ доставки:</td>
										<td>
											<?
												$arDeliv = CSaleDelivery::GetByID($vval['ORDER']['DELIVERY_ID']);
												if ($arDeliv)
												{
												  echo $arDeliv["NAME"];
												}
											?>
										</td>
									</tr>
									<?
									$order_props = CSaleOrderPropsValue::GetOrderProps($vval["ORDER"]['ID']);
									while ($arProps = $order_props->Fetch()) {
										//Qov_dump($arProps);
                                        if($arProps['ORDER_PROPS_ID'] == 5){ // адрес доставки
                                            $adr_deliv = $arProps['VALUE'];
                                        }
										if($arProps['ORDER_PROPS_ID'] == 6){ // адрес магазина
											$adr_store = $arProps['VALUE'];
										}
									}

									?>
                                    <?if($vval['ORDER']['DELIVERY_ID'] == 2): // самовыоз?>


                                        <tr>
                                            <td>Адрес самовывоза:</td>
                                            <td>
			                                    <?=$adr_store?>
                                            </td>
                                        </tr>
                                    <?endif;?>
									<?if($vval['ORDER']['DELIVERY_ID'] == 3): // доставка?>
                                        <tr>
                                            <td>Адрес доставки:</td>
                                            <td>
												<?=$adr_deliv?>
                                            </td>
                                        </tr>
									<?endif;?>
									<tr>
										<td>Количество товаров:</td>
										<td><?=count($vval["BASKET_ITEMS"])?></td>
									</tr>
								</table>

								<div class="personal-order__list" style="display: block;" id=vv<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>>
									<div class="table-resp">
<!--										<p class="table-resp__arrows"><i class="fa fa-caret-left" aria-hidden="true"></i>&nbsp;&nbsp;Смахните просмотра&nbsp;&nbsp;<i class="fa fa-caret-right" aria-hidden="true"></i></p>-->
										<table style="width: 100%;">
											<tr>
												<td><b>Наименование товара:</b></td>
												<td><b>Количество:</b></td>
												<td><b>Цена:</b></td>
												<td><b>Итого:</b></td>
											</tr>
											<?
											$allsum=0;
											foreach ($vval["BASKET_ITEMS"] as $vvval)
											{

												?>

												<tr>
													<td >
														<div class="d-flex align-items-center">
															
                                                       

                                                        <?=$vvval['NAME']?>
														<?
														if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
															//echo "<a href=\"".$vvval["DETAIL_PAGE_URL"]."\">";
														echo $vvval["NAME"];
														if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
															//echo "</a>";
														?>
														</div>
													</td>
													<?

													$count_prise=$vvval['PRICE']*$vvval["QUANTITY"];
													$allsum=$count_prise+$allsum;
													?>
													<td nowrap><?=$vvval["QUANTITY"]?> <!-- ?=$vvval['MEASURE_TEXT'];? --> </td>
													<td nowrap><?=CurrencyFormat($vvval["PRICE"], 'RUB');?> <!-- за < ?=$vvval['MEASURE_TEXT'];? --></td>											
													<td  nowrap><?=CurrencyFormat($count_prise, 'RUB');?></td>
													
												</tr>
												<?
											}?>
										</table>
									</div>
								</div>

								</div>
								</div>

								<div class="personal-order__controls">
									<div>
										<?/*
										//if ($vval["PAYMENT"][0]['PAID']=="N"&&$vval["PAYMENT"][0]['IS_CASH']=="N"
                                        if(($vval['ORDER']['STATUS_ID']=='N'||$vval['ORDER']['STATUS_ID']=='SN')&&($vval["ORDER"]["CANCELED"] == "N")) {
											?>
												<a class="btn btn--md btn--blue" target=_blank href="<?=$vval["PAYMENT"][0]['PSA_ACTION_FILE']?>">Оплатить заказ</a>
											<?
										}*/
										?>
										  <?
									?>
									</div>

									<?//var_dump($vval["ORDER"]["CANCELED"])?>

									<div>

                                        <?/*if($vval["ORDER"]["STATUS_ID"] == 'N' && (empty($vval["ORDER"]["CANCELED"]) || $vval["ORDER"]["CANCELED"] == 'N')):?>
	                                        <a href="<?=htmlspecialcharsbx($vval["ORDER"]["URL_TO_CANCEL"])?>" class="mb-1 mb-sm-0 btn btn--sm btn--border personal-order__btn-repeat">
                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                Отмена заказа
	                                        </a>
										<?endif;*/?>

                                        <a href="<?=htmlspecialcharsbx($vval["ORDER"]["URL_TO_COPY"])?>" class="mb-1 mb-sm-0 btn btn--sm btn--blue personal-order__btn-repeat">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                            Повторить заказ
                                        </a>

                                        <?//debug($vval)?>

										<?if($vval["ORDER"]["STATUS_ID"] == 'OP' && (empty($vval["ORDER"]["CANCELED"]) || $vval["ORDER"]["CANCELED"] == 'N')):?>
                                            <?if($vval['ORDER']['PAY_SYSTEM_ID'] != 1):?>
                                                <a href="<?=$vval['PAYMENT'][0]['PSA_ACTION_FILE']?>" class="mb-1 mb-sm-0 btn btn--sm btn--red personal-order__btn-repeat">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                    Оплатить
                                                </a>
                                            <?endif;?>
                                        <?endif;?>


									</div>

								</div>
							</div>

						</div>
					</section>










					<!-- <table class="sale_personal_order_list" style="border-bottom:2px solid #eee"></table> -->
				<?
				}
				?>
				<?
				}

			if ($bNoOrder)
			{
				?><center><b><?echo GetMessage("STPOL_NO_ORDERS")?></b></center><?
			}
			?>

			</div>


			<br><br>




<script>
	$('.js-order-details').click(function() {
		var parent = $(this).parent().parent().find('.personal-order__detail');

		if( !$(parent).hasClass('visible') ) {
			// $(parent).show(100);
			$(parent).slideDown(300);
			$(parent).addClass('visible');
		} else {
			// $(parent).hide(100);
			$(parent).slideUp(300);
			$(parent).removeClass('visible');
		}
	});


	
</script>
