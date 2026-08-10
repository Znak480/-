<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php
// Получаем дату последней смены пароля из журнала событий
$userId = $USER->GetID();
$lastPasswordChange = 'Не менялся';

$events = CEventLog::GetList(
    ['TIMESTAMP_X' => 'DESC'],
    [
        'AUDIT_TYPE_ID' => 'USER_PASSWORD_CHANGED',
        'OBJECT_ID' => $userId
    ]
);

if ($event = $events->Fetch()) {
    $lastPasswordChange = date("d.m.Y в H:i", strtotime($event['TIMESTAMP_X']));
}
?>
<form action="<?=$arResult["FORM_TARGET"]?>" method="post" class="profile-form">
    <?ShowError($arResult["strProfileError"]);?>
    <?
    if (isset($arResult['DATA_SAVED']) && $arResult['DATA_SAVED'] == 'Y'){
        ShowNote(GetMessage('PROFILE_DATA_SAVED'));
    }
    ?>

    <?=bitrix_sessid_post()?>
    <input type="hidden" name="save" value="Y">
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

    <?if($arResult['CAN_EDIT_PASSWORD']):?>
        <div class="input-group">
            <label for="NEW_PASSWORD"><?=GetMessage('NEW_PASSWORD_REQ')?></label>
            <input type="password" id="NEW_PASSWORD" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off">
        </div>
        
        <div class="input-group">
            <label for="NEW_PASSWORD_CONFIRM"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
            <input type="password" id="NEW_PASSWORD_CONFIRM" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off">
        </div>
        
        <button type="submit" class="btn btn-sm btn-primary"><?=GetMessage('SAVE')?></button>
    <?endif?>
    <div class="security-info">
        <p>
            <?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
        </p>
    </div>
</form>
