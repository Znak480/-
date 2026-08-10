<?php 
namespace Sprint\Migration;

use Sprint\Migration\Helpers\IblockHelper;

class AddAdditionalImageFields20260803093100 extends Version{
    protected $author = "s1ntoz";

    protected $description = "Добавление полей для изображений (Мобилка, Планшет) в слайдеры и акции для БРН и ГА";

    private const IBLOCK_TYPES = [
        "barnaul" => "Региональные данные БРН", 
        "galtaysk" => "Региональные данные ГА"
    ];

    private const IBLOCK_CODES = ["slider", "stocks"];

    private const PROPERTIES = [
          [
                'NAME' => 'Банер для мобильных устройств',
                'CODE' => 'IMAGE_MOBILE',
                'PROPERTY_TYPE' => 'F',
                'MULTIPLE' => 'N',
                'FILE_TYPE' => 'jpg, png, gif, webp, jpeg, svg',
                'WITH_DESCRIPTION' => 'N',
                'SORT' => 100,
            ],
            [
                'NAME' => 'Банер для планшетов',
                'CODE' => 'IMAGE_TABLET',
                'PROPERTY_TYPE' => 'F',
                'MULTIPLE' => 'N',
                'FILE_TYPE' => 'jpg, png, gif, webp, jpeg, svg',
                'WITH_DESCRIPTION' => 'N',
                'SORT' => 300,
            ],
    ];

    public function up(){
        $helper = new IblockHelper();
        $success = true;

        foreach(self::IBLOCK_TYPES as $iblockType => $description){
            $this->out("Обработка: [ {$description} ] (тип: {$iblockType})");

            foreach(self::IBLOCK_CODES as $iblockCode){
                $iblockId = $helper->getIblockId($iblockCode, $iblockType);

                if (!$iblockId) {
                    $this->outError("  Инфоблок с кодом '{$iblockCode}' не найден в типе '{$iblockType}'!");
                    $success = false;
                    continue;
                }

                $this->out("  Инфоблок: {$iblockCode} (ID: {$iblockId})");
                foreach (self::PROPERTIES as $property) {
                    if ($helper->getPropertyId($iblockId, $property['CODE'])) {
                        $this->outWarning("    Свойство {$property['CODE']} уже существует");
                        continue;
                    }

                    $fields = $property;
                    $fields['IBLOCK_ID'] = $iblockId;
                    $fields['ACTIVE'] = 'Y';
                    $fields['SEARCHABLE'] = 'N';
                    $fields['FILTRABLE'] = 'N';
                    $fields['USER_TYPE'] = null;

                    $propertyId = $helper->addProperty($iblockId, $fields);

                    if ($propertyId) {
                        $this->outSuccess("    + Добавлено свойство {$property['CODE']} (ID: {$propertyId})");
                    } else {
                        $this->outError("    Ошибка добавления свойства {$property['CODE']}: " . $helper->getLastError());
                        $success = false;
                    }
                }
            
            }
        
        }
        return $success;
    }

    public function down(){
        $helper = new IblockHelper();
        $success = true;

        $propertyCodes = ['IMAGE_MOBILE', 'IMAGE_TABLET'];

        foreach (self::IBLOCK_TYPES as $iblockType => $description) {
            $this->out("Откат: [ {$description} ] (тип: {$iblockType})");

            foreach (self::IBLOCK_CODES as $iblockCode) {
                $iblockId = $helper->getIblockId($iblockCode, $iblockType);

                if (!$iblockId) {
                    $this->outError("  Инфоблок с кодом '{$iblockCode}' не найден в типе '{$iblockType}'!");
                    $success = false;
                    continue;
                }

                $this->out("  Инфоблок: {$iblockCode} (ID: {$iblockId})");

                foreach ($propertyCodes as $propertyCode) {
                    $propertyId = $helper->getPropertyId($iblockId, $propertyCode);

                    if (!$propertyId) {
                        $this->outWarning("    Свойство {$propertyCode} не найдено");
                        continue;
                    }
                    
                    $result = \CIBlockProperty::Delete($propertyId);

                    if ($result) {
                        $this->outSuccess("    - Удалено свойство {$propertyCode} (ID: {$propertyId})");
                    } else {
                        $this->outError("    Ошибка удаления свойства {$propertyCode}");
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }
}
?>