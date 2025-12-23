<?php


$inputName = $fieldSettings->getCode() . '[' . $field->getId() . '][' . $fieldSettings->getCode() . '][n#IND#]';
if($field->getMultiple())
{
    $inputName = $fieldSettings->getCode() . '[' . $field->getId() . '][' . $inputIndex . '][' . $fieldSettings->getCode() . ']';
}

