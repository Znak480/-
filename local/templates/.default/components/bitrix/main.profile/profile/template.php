<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
global $USER;
?>
<?//$APPLICATION->SetPageProperty("title", "Персональная информация");?>

    <div class="caption mb-3">
        <h4 class="fs-22 color-black">Ваши данные</h4>
    </div>
<!-- <div class="lead"> -->
	<div class="signup__form">

	    <div class="signup__form">



			<div class="mb-4">
				<p><?ShowError($arResult["strProfileError"]);?></p>
			</div>




	                <form class="signup-form form" method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">


	                	<?=$arResult["BX_SESSION_CHECK"]?>
						<input type="hidden" name="lang" value="<?=LANG?>" />
						<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
						<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
	                	<div class="mb-20">



						<!-- Какой-то выбор языка. Он нужен? -->
				       	<?
						if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
						{
							?>
							<div class="form-group">
								<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
								<div class="col-sm-12">
									<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
								</div>
							</div>
							<?
						}
						?>

                            <div class="bx-authform-formgroup-container">
                                <div class="bx-authform-label-container"><?=Loc::getMessage('NAME')?></div>
                                <div class="bx-authform-input-container">
                                    <input type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>">
                                </div>
                            </div>

                            <div class="bx-authform-formgroup-container">
                                <div class="bx-authform-label-container"><?=Loc::getMessage('LAST_NAME')?></div>
                                <div class="bx-authform-input-container">
                                    <input type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>">
                                </div>
                            </div>

                            <div class="bx-authform-formgroup-container">
                                <div class="bx-authform-label-container"><?=Loc::getMessage('EMAIL')?></div>
                                <div class="bx-authform-input-container">
                                    <input type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" readonly>
                                </div>
                            </div>



<!--					<div class="row mb-20">-->
<!--						<div class="col-sm-6">-->
<!--                            <div class="bx-authform-formgroup-container">-->
<!--                                <div class="bx-authform-label-container">Имя</div>-->
<!--                                <div class="bx-authform-input-container">-->
<!--                                    <input type="text" name="USER_NAME" maxlength="255" value="Ольга">-->
<!--                                </div>-->
<!--                            </div>-->
<!--							<div class="text-field text-field_floating-2 mb-3 mb-sm-4">-->
<!--								<input class="input text-field__input" type="text" name="NAME" maxlength="50" id="main-profile-name" value="--><?//=$arResult["arUser"]["NAME"]?><!--">-->
<!--								<label class="text-field__label" for="name">--><?//=Loc::getMessage('NAME')?><!--</label>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="col-sm-6">-->
<!--							<div class="text-field text-field_floating-2 mb-3 mb-sm-4">-->
<!--								<input class="input text-field__input" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="--><?//=$arResult["arUser"]["LAST_NAME"]?><!--">-->
<!--								<label class="text-field__label" for="name">--><?//=Loc::getMessage('LAST_NAME')?><!--</label>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="col-sm-6">-->
<!--							<div class="text-field text-field_floating-2 mb-3 mb-sm-4">-->
<!--								<input class="input text-field__input" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="--><?//=$arResult["arUser"]["EMAIL"]?><!--" readonly>-->
<!--								<label class="text-field__label" for="name">--><?//=Loc::getMessage('EMAIL')?><!--</label>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->




							<?
								if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '')
								{
								?>

			                    <div class="caption mb-3">
				                    <h4 class="fs-22 color-black">Смена пароля</h4>
				                </div>


                                <div class="bx-authform-formgroup-container">
                                    <div class="bx-authform-label-container"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></div>
                                    <div class="bx-authform-input-container">
                                        <input type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off">
                                    </div>
                                </div>

                                <div class="bx-authform-formgroup-container">
                                    <div class="bx-authform-label-container"><?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?></div>
                                    <div class="bx-authform-input-container">
                                        <input  type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off">
                                    </div>
                                </div>

                                    <p class="text-small" style="padding-bottom: 15px;"><i><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></i></p>

		                    	<?
								}
							?>

	                	</div>


	                    <div class="d-sm-flex align-items-center mb-4 mt-4">
	                        <input type="submit" name="save" class="border-0 btn btn--blue btn--lg color-white me-sm-4 mb-3 mb-sm-0" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
							<!-- &nbsp; -->
							<a class="hover d-block text-center" href="/personal/"><?echo GetMessage("MAIN_RESET")?></a>
							<!-- <input type="submit" class="btn btn_outline btn_size-l"  name="reset" value="<?echo GetMessage("MAIN_RESET")?>"> -->
	                    </div>
	                </form>

	            </div>


	</div>
<!-- </div> -->


<div class="mt-4">
	<p class="text-small">
		<?
		if($arResult["ID"]>0)
		{
			if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
			{
				?>

					<b><?=Loc::getMessage('LAST_UPDATE')?></b>
					<?=$arResult["arUser"]["TIMESTAMP_X"]?>

				<?
			}

			if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
			{
				?>

					<b><br/><?=Loc::getMessage('LAST_LOGIN')?></b>
					<?=$arResult["arUser"]["LAST_LOGIN"]?>

				<?
			}
		}
		?>
	</p>
</div>




<?php
/*
 <div class="bx_profile">
	<?
	ShowError($arResult["strProfileError"]);

	if ($arResult['DATA_SAVED'] == 'Y')
	{
		ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
	}

	?>
	<form method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
		<div class="main-profile-block-shown" id="user_div_reg">
			<div class="main-profile-block-date-info">
				<?
				if($arResult["ID"]>0)
				{
					if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
					{
						?>
						<div class="col-sm-9 col-md-offset-3 small">
							<strong><?=Loc::getMessage('LAST_UPDATE')?></strong>
							<strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong>
						</div>
						<?
					}

					if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
					{
						?>
						<div class="col-sm-9 col-md-offset-3 small">
							<strong><?=Loc::getMessage('LAST_LOGIN')?></strong>
							<strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong>
						</div>
						<?
					}
				}
				?>
			</div>
			<?
			if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
			{
				?>
				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
					<div class="col-sm-12">
						<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
					</div>
				</div>
				<?
			}
			?>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
				</div>
			</div>
			<?
			if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '')
			{
				?>
				<div class="form-group">
					<p class="main-profile-form-password-annotation col-sm-9 col-sm-offset-3 small">
						<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
					</p>
				</div>
				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
					<div class="col-sm-12">
						<input class=" form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
					</div>
				</div>
				<div class="form-group">
					<label class="main-profile-form-label main-profile-password col-sm-12 col-md-3 text-md-right" for="main-profile-password-confirm">
						<?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>
					</label>
					<div class="col-sm-12">
						<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
					</div>
				</div>
				<?
			}
			?>
		</div>
		<p class="main-profile-form-buttons-block col-sm-9 col-md-offset-3">
			<input type="submit" name="save" class="btn btn-themes btn-default btn-md main-profile-submit" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
			&nbsp;
			<input type="submit" class="btn btn-themes btn-default btn-md"  name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
		</p>
	</form>


	<div class="col-sm-12 main-profile-social-block">
		<?
		if ($arResult["SOCSERV_ENABLED"])
		{
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
				"SHOW_PROFILES" => "Y",
				"ALLOW_DELETE" => "Y"
			),
				false
			);
		}
		?>
	</div>

</div>
 * */
?>