<?php

/**
 * @var $version
 * @var $description
 * @var $param1
 * @var $param2
 * @var $param3
 * @var $extendUse
 * @var $extendClass
 * @var $extend
 * @var $use
 * @var $moduleVersion
 * @formatter:off
 */

?><?php echo "<?php\n" ?>

namespace Sprint\Migration;

use <?php echo $use ?>;
use Craft\Area\Entity\AreaContentTable;
use Craft\Area\Entity\AreaFieldTable;
use Craft\Area\Entity\AreaTable;

class <?php echo $version ?> extends <?php echo $extend ?>
{
    protected $description = "<?php echo $description ?>";

    protected $moduleVersion = "<?php echo $moduleVersion ?>";

    /**
    * @throws Exceptions\HelperException
    * @return bool|void
    */
    public function up()
    {


$this->import()->execute(function($areaFullData) {

$areaList = $areaFullData['areaList'];
$fieldList = $areaFullData['fieldList'];
$contentList = $areaFullData['contentList'];


foreach($areaList as $area)
{

$areaId = $area[AreaTable::FIELD_ID];
unset($area[AreaTable::FIELD_ID]);

$areaModel = AreaTable::createObject();
$areaModel->fillFromArray($area);
$areaModel->save();

$newAreaId = $areaModel->getId();

$fields = array_filter($fieldList, function($field) use ($areaId) {
return $field[AreaFieldTable::FIELD_AREA_ID] == $areaId;
});

if($fields)
{
foreach($fields as $field)
{
$areaFieldId = $field[AreaFieldTable::FIELD_ID];
unset($field[AreaFieldTable::FIELD_ID]);
unset($field[AreaFieldTable::FIELD_AREA_ID]);

$field[AreaFieldTable::FIELD_AREA_ID] = $newAreaId;

$fieldModel = AreaFieldTable::createObject();
$fieldModel->fillFromArray($field);
$fieldModel->save();

$newFieldId = $fieldModel->getId();

if(is_array($contentList))
{
$content = array_filter($contentList, function($content) use ($areaFieldId, $areaId) {
return $content['VALUE'][AreaContentTable::FIELD_AREA_FIELD_ID] == $areaFieldId && $content['VALUE'][AreaContentTable::FIELD_AREA_ID] == $areaId;
});

if($content)
{
$contentModel = AreaContentTable::createObject();
$contentModel->setAreaId($newAreaId);
$contentModel->setAreaBlockId($newFieldId);

if(count($content) == 1) # simple value
{
$el = array_shift($content);
$el = $el['VALUE']['val'];

if(is_array($el) && $el['tmp_name'])
{
$fileId = \CFile::SaveFile($el, 'craft.area/' . $fieldModel->getType());
if($fileId)
{
$contentModel->setValueSerialized($fileId);
}
} else
{
$contentModel->setValue($el);
}


$contentModel->save();

} elseif(count($content) > 1) # multiple images
{
$imgColl = [];
foreach($content as $contentItem)
{
if($contentItem['VALUE']['val']['tmp_name'])
{
$imgColl[] = $contentItem['VALUE']['val'];
}
}


if($imgColl)
{
$imgIdList = [];
foreach($imgColl as $imgData)
{
$imgIdList[] = \CFile::SaveFile($imgData, 'craft.area/' . $fieldModel->getType());;
}

if($imgIdList)
{
$contentModel->setValueSerialized($imgIdList);
}
}

$contentModel->save();
}

}
}
}
}
}
});


	}

    public function down()
    {
        //your code ...
    }
}