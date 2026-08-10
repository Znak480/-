<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<form action="<?=$arResult["FORM_TARGET"]?>" method="post" class="profile-form">
    <?ShowError($arResult["strProfileError"]);?>
    <?
    if (isset($arResult['DATA_SAVED']) && $arResult['DATA_SAVED'] == 'Y'){
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    }
    ?>
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="save" value="Y">
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
    
    <div class="input-group">
        <label for="NAME"><?=GetMessage('NAME')?></label>
        <input type="text" id="NAME" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>">
    </div>
    
    <div class="input-group">
        <label for="LAST_NAME"><?=GetMessage('LAST_NAME')?></label>
        <input type="text" id="LAST_NAME" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>">
    </div>
    
    <div class="input-group" data-required="<?= !empty($arResult["EMAIL_REQUIRED"])? "true" : "false" ?>">
        <label for="EMAIL"><?=GetMessage('EMAIL')?></label>
        <input type="text" id="EMAIL" name="EMAIL" maxlength="50" value="<?= $arResult["arUser"]["EMAIL"]?>">
    </div>
    
    <?if($arResult["PHONE_REGISTRATION"]):?>
        <div class="input-group" data-required="<?= !empty($arResult["PHONE_REQUIRED"])? "true" : "false" ?>">
            <label for="PHONE_NUMBER"><?=GetMessage("main_profile_phone_number")?></label>
            <input type="tel" id="PHONE_NUMBER" name="PHONE_NUMBER" maxlength="50" value="<?= $arResult["arUser"]["PHONE_NUMBER"]?>">
        </div>
    <?endif?>
    
    <button type="submit" class="btn btn-sm btn-primary">Сохранить</button>
    <?if($USER->IsAdmin()):?>
    <div class="security-info">
        <div class="info-item">
            <span class="info-label"><?=GetMessage('LAST_UPDATE')?></span>
            <span class="info-value"><?=$arResult["arUser"]["TIMESTAMP_X"]?></span>
        </div>
        <div class="info-item">
            <span class="info-label"><?=GetMessage('LAST_LOGIN')?></span>
            <span class="info-value"><?=$arResult["arUser"]["LAST_LOGIN"]?></span>
        </div>
    </div>
    <? endif; ?>
</form>