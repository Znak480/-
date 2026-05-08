<?php
namespace Sprint\Migration;

use Sprint\Migration\Helpers\IblockHelper;

class AddGalleryPropertyInCatalogsIBlock20260506142600 extends Version
{

    protected $description = 'Добавить новое "Свойство" -> "Галлерея" в каталоги Барнаула и Горный Алтай';
    
    private const SYMBOLE_CODE = ["catalog_brn",  "catalog_gr"];
    
    private $property = [
        'NAME' => 'Галерея',
        'CODE' => 'GALLERY',
        'PROPERTY_TYPE' => 'F',
        'MULTIPLE' => 'Y',
        'FILE_TYPE' => 'jpg, png, gif, webp',
        'ACTIVE' => 'Y',
        'SORT' => 1,
    ];

    public function up(){
        $helper = new IblockHelper();

        $success = true;

        foreach(self::SYMBOLE_CODE as $code){
            
            $iblockId = $helper->getIblockId($code);

            if (!$iblockId) {
                $this->outError("Инфоблок с кодом '{$code}' не найден!");
                $success = false;
                continue;
            }

            $fields = $this->property;
            $fields['IBLOCK_ID'] = $iblockId;
            
            $propertyId = $helper->addPropertyIfNotExists($iblockId, $fields);

            if ($propertyId) {
                $this->outSuccess("Добавлено свойство {$fields['CODE']}");
            } else {
                $this->outError("Ошибка добавления свойства {$fields['CODE']}: " . $helper->getLastError());
                $success = false;
            }
        }
           
        return $success;
    }

    public function down(){}
}

?>