<?php

/* ORMENTITYANNOTATION:Craft\Area\Entity\AreaTable */
namespace Craft\Area\Entity {
	/**
	 * Area
	 * @see \Craft\Area\Entity\AreaTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getId()
	 * @method \Craft\Area\Entity\Area setId(\int|\Bitrix\Main\DB\SqlExpression $id)
	 * @method bool hasId()
	 * @method bool isIdFilled()
	 * @method bool isIdChanged()
	 * @method \string getName()
	 * @method \Craft\Area\Entity\Area setName(\string|\Bitrix\Main\DB\SqlExpression $name)
	 * @method bool hasName()
	 * @method bool isNameFilled()
	 * @method bool isNameChanged()
	 * @method \string remindActualName()
	 * @method \string requireName()
	 * @method \Craft\Area\Entity\Area resetName()
	 * @method \Craft\Area\Entity\Area unsetName()
	 * @method \string fillName()
	 * @method \string getCode()
	 * @method \Craft\Area\Entity\Area setCode(\string|\Bitrix\Main\DB\SqlExpression $code)
	 * @method bool hasCode()
	 * @method bool isCodeFilled()
	 * @method bool isCodeChanged()
	 * @method \string remindActualCode()
	 * @method \string requireCode()
	 * @method \Craft\Area\Entity\Area resetCode()
	 * @method \Craft\Area\Entity\Area unsetCode()
	 * @method \string fillCode()
	 * @method \boolean getActive()
	 * @method \Craft\Area\Entity\Area setActive(\boolean|\Bitrix\Main\DB\SqlExpression $active)
	 * @method bool hasActive()
	 * @method bool isActiveFilled()
	 * @method bool isActiveChanged()
	 * @method \boolean remindActualActive()
	 * @method \boolean requireActive()
	 * @method \Craft\Area\Entity\Area resetActive()
	 * @method \Craft\Area\Entity\Area unsetActive()
	 * @method \boolean fillActive()
	 * @method \int getSort()
	 * @method \Craft\Area\Entity\Area setSort(\int|\Bitrix\Main\DB\SqlExpression $sort)
	 * @method bool hasSort()
	 * @method bool isSortFilled()
	 * @method bool isSortChanged()
	 * @method \int remindActualSort()
	 * @method \int requireSort()
	 * @method \Craft\Area\Entity\Area resetSort()
	 * @method \Craft\Area\Entity\Area unsetSort()
	 * @method \int fillSort()
	 * @method \Bitrix\Main\Type\DateTime getCreatedAt()
	 * @method \Craft\Area\Entity\Area setCreatedAt(\Bitrix\Main\Type\DateTime|\Bitrix\Main\DB\SqlExpression $createdAt)
	 * @method bool hasCreatedAt()
	 * @method bool isCreatedAtFilled()
	 * @method bool isCreatedAtChanged()
	 * @method \Bitrix\Main\Type\DateTime remindActualCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime requireCreatedAt()
	 * @method \Craft\Area\Entity\Area resetCreatedAt()
	 * @method \Craft\Area\Entity\Area unsetCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime fillCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime getUpdatedAt()
	 * @method \Craft\Area\Entity\Area setUpdatedAt(\Bitrix\Main\Type\DateTime|\Bitrix\Main\DB\SqlExpression $updatedAt)
	 * @method bool hasUpdatedAt()
	 * @method bool isUpdatedAtFilled()
	 * @method bool isUpdatedAtChanged()
	 * @method \Bitrix\Main\Type\DateTime remindActualUpdatedAt()
	 * @method \Bitrix\Main\Type\DateTime requireUpdatedAt()
	 * @method \Craft\Area\Entity\Area resetUpdatedAt()
	 * @method \Craft\Area\Entity\Area unsetUpdatedAt()
	 * @method \Bitrix\Main\Type\DateTime fillUpdatedAt()
	 * @method \Craft\Area\Entity\AreaFieldCollection getFields()
	 * @method \Craft\Area\Entity\AreaFieldCollection requireFields()
	 * @method \Craft\Area\Entity\AreaFieldCollection fillFields()
	 * @method bool hasFields()
	 * @method bool isFieldsFilled()
	 * @method bool isFieldsChanged()
	 * @method void addToFields(\Craft\Area\Entity\AreaField $areaField)
	 * @method void removeFromFields(\Craft\Area\Entity\AreaField $areaField)
	 * @method void removeAllFields()
	 * @method \Craft\Area\Entity\Area resetFields()
	 * @method \Craft\Area\Entity\Area unsetFields()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection getContent()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection requireContent()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection fillContent()
	 * @method bool hasContent()
	 * @method bool isContentFilled()
	 * @method bool isContentChanged()
	 * @method void addToContent(\Craft\Area\Entity\AreaContent $areaContent)
	 * @method void removeFromContent(\Craft\Area\Entity\AreaContent $areaContent)
	 * @method void removeAllContent()
	 * @method \Craft\Area\Entity\Area resetContent()
	 * @method \Craft\Area\Entity\Area unsetContent()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @property-read array $primary
	 * @property-read int $state @see \Bitrix\Main\ORM\Objectify\State
	 * @property-read \Bitrix\Main\Type\Dictionary $customData
	 * @property \Bitrix\Main\Authentication\Context $authContext
	 * @method mixed get($fieldName)
	 * @method mixed remindActual($fieldName)
	 * @method mixed require($fieldName)
	 * @method bool has($fieldName)
	 * @method bool isFilled($fieldName)
	 * @method bool isChanged($fieldName)
	 * @method \Craft\Area\Entity\Area set($fieldName, $value)
	 * @method \Craft\Area\Entity\Area reset($fieldName)
	 * @method \Craft\Area\Entity\Area unset($fieldName)
	 * @method void addTo($fieldName, $value)
	 * @method void removeFrom($fieldName, $value)
	 * @method void removeAll($fieldName)
	 * @method \Bitrix\Main\ORM\Data\Result delete()
	 * @method mixed fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method mixed[] collectValues($valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL)
	 * @method \Bitrix\Main\ORM\Data\AddResult|\Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\Result save()
	 * @method static \Craft\Area\Entity\Area wakeUp($data)
	 */
	class EO_Area {
		/* @var \Craft\Area\Entity\AreaTable */
		static public $dataClass = '\Craft\Area\Entity\AreaTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Craft\Area\Entity {
	/**
	 * AreaCollection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getIdList()
	 * @method \string[] getNameList()
	 * @method \string[] fillName()
	 * @method \string[] getCodeList()
	 * @method \string[] fillCode()
	 * @method \boolean[] getActiveList()
	 * @method \boolean[] fillActive()
	 * @method \int[] getSortList()
	 * @method \int[] fillSort()
	 * @method \Bitrix\Main\Type\DateTime[] getCreatedAtList()
	 * @method \Bitrix\Main\Type\DateTime[] fillCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime[] getUpdatedAtList()
	 * @method \Bitrix\Main\Type\DateTime[] fillUpdatedAt()
	 * @method \Craft\Area\Entity\AreaFieldCollection[] getFieldsList()
	 * @method \Craft\Area\Entity\AreaFieldCollection getFieldsCollection()
	 * @method \Craft\Area\Entity\AreaFieldCollection fillFields()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection[] getContentList()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection getContentCollection()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection fillContent()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @method void add(\Craft\Area\Entity\Area $object)
	 * @method bool has(\Craft\Area\Entity\Area $object)
	 * @method bool hasByPrimary($primary)
	 * @method \Craft\Area\Entity\Area getByPrimary($primary)
	 * @method \Craft\Area\Entity\Area[] getAll()
	 * @method bool remove(\Craft\Area\Entity\Area $object)
	 * @method void removeByPrimary($primary)
	 * @method array|\Bitrix\Main\ORM\Objectify\Collection|null fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method static \Craft\Area\Entity\AreaCollection wakeUp($data)
	 * @method \Bitrix\Main\ORM\Data\Result save($ignoreEvents = false)
	 * @method void offsetSet() ArrayAccess
	 * @method void offsetExists() ArrayAccess
	 * @method void offsetUnset() ArrayAccess
	 * @method void offsetGet() ArrayAccess
	 * @method void rewind() Iterator
	 * @method \Craft\Area\Entity\Area current() Iterator
	 * @method mixed key() Iterator
	 * @method void next() Iterator
	 * @method bool valid() Iterator
	 * @method int count() Countable
	 * @method \Craft\Area\Entity\AreaCollection merge(?\Craft\Area\Entity\AreaCollection $collection)
	 * @method bool isEmpty()
	 * @method array collectValues(int $valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, int $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL, bool $recursive = false)
	 */
	class EO_Area_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Craft\Area\Entity\AreaTable */
		static public $dataClass = '\Craft\Area\Entity\AreaTable';
	}
}
namespace Craft\Area\Entity {
	/**
	 * @method static EO_Area_Query query()
	 * @method static EO_Area_Result getByPrimary($primary, array $parameters = [])
	 * @method static EO_Area_Result getById($id)
	 * @method static EO_Area_Result getList(array $parameters = [])
	 * @method static EO_Area_Entity getEntity()
	 * @method static \Craft\Area\Entity\Area createObject($setDefaultValues = true)
	 * @method static \Craft\Area\Entity\AreaCollection createCollection()
	 * @method static \Craft\Area\Entity\Area wakeUpObject($row)
	 * @method static \Craft\Area\Entity\AreaCollection wakeUpCollection($rows)
	 */
	class AreaTable extends \Bitrix\Main\ORM\Data\DataManager {}
	/**
	 * Common methods:
	 * ---------------
	 *
	 * @method EO_Area_Result exec()
	 * @method \Craft\Area\Entity\Area fetchObject()
	 * @method \Craft\Area\Entity\AreaCollection fetchCollection()
	 */
	class EO_Area_Query extends \Bitrix\Main\ORM\Query\Query {}
	/**
	 * @method \Craft\Area\Entity\Area fetchObject()
	 * @method \Craft\Area\Entity\AreaCollection fetchCollection()
	 */
	class EO_Area_Result extends \Bitrix\Main\ORM\Query\Result {}
	/**
	 * @method \Craft\Area\Entity\Area createObject($setDefaultValues = true)
	 * @method \Craft\Area\Entity\AreaCollection createCollection()
	 * @method \Craft\Area\Entity\Area wakeUpObject($row)
	 * @method \Craft\Area\Entity\AreaCollection wakeUpCollection($rows)
	 */
	class EO_Area_Entity extends \Bitrix\Main\ORM\Entity {}
}
/* ORMENTITYANNOTATION:Craft\Area\Entity\AreaContentTable */
namespace Craft\Area\Entity {
	/**
	 * AreaContent
	 * @see \Craft\Area\Entity\AreaContentTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getAreaId()
	 * @method \Craft\Area\Entity\AreaContent setAreaId(\int|\Bitrix\Main\DB\SqlExpression $areaId)
	 * @method bool hasAreaId()
	 * @method bool isAreaIdFilled()
	 * @method bool isAreaIdChanged()
	 * @method \int getAreaBlockId()
	 * @method \Craft\Area\Entity\AreaContent setAreaBlockId(\int|\Bitrix\Main\DB\SqlExpression $areaBlockId)
	 * @method bool hasAreaBlockId()
	 * @method bool isAreaBlockIdFilled()
	 * @method bool isAreaBlockIdChanged()
	 * @method \string getValue()
	 * @method \Craft\Area\Entity\AreaContent setValue(\string|\Bitrix\Main\DB\SqlExpression $value)
	 * @method bool hasValue()
	 * @method bool isValueFilled()
	 * @method bool isValueChanged()
	 * @method \string remindActualValue()
	 * @method \string requireValue()
	 * @method \Craft\Area\Entity\AreaContent resetValue()
	 * @method \Craft\Area\Entity\AreaContent unsetValue()
	 * @method \string fillValue()
	 * @method \Craft\Area\Entity\Area getArea()
	 * @method \Craft\Area\Entity\Area remindActualArea()
	 * @method \Craft\Area\Entity\Area requireArea()
	 * @method \Craft\Area\Entity\AreaContent setArea(\Craft\Area\Entity\Area $object)
	 * @method \Craft\Area\Entity\AreaContent resetArea()
	 * @method \Craft\Area\Entity\AreaContent unsetArea()
	 * @method bool hasArea()
	 * @method bool isAreaFilled()
	 * @method bool isAreaChanged()
	 * @method \Craft\Area\Entity\Area fillArea()
	 * @method \Craft\Area\Entity\AreaField getField()
	 * @method \Craft\Area\Entity\AreaField remindActualField()
	 * @method \Craft\Area\Entity\AreaField requireField()
	 * @method \Craft\Area\Entity\AreaContent setField(\Craft\Area\Entity\AreaField $object)
	 * @method \Craft\Area\Entity\AreaContent resetField()
	 * @method \Craft\Area\Entity\AreaContent unsetField()
	 * @method bool hasField()
	 * @method bool isFieldFilled()
	 * @method bool isFieldChanged()
	 * @method \Craft\Area\Entity\AreaField fillField()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @property-read array $primary
	 * @property-read int $state @see \Bitrix\Main\ORM\Objectify\State
	 * @property-read \Bitrix\Main\Type\Dictionary $customData
	 * @property \Bitrix\Main\Authentication\Context $authContext
	 * @method mixed get($fieldName)
	 * @method mixed remindActual($fieldName)
	 * @method mixed require($fieldName)
	 * @method bool has($fieldName)
	 * @method bool isFilled($fieldName)
	 * @method bool isChanged($fieldName)
	 * @method \Craft\Area\Entity\AreaContent set($fieldName, $value)
	 * @method \Craft\Area\Entity\AreaContent reset($fieldName)
	 * @method \Craft\Area\Entity\AreaContent unset($fieldName)
	 * @method void addTo($fieldName, $value)
	 * @method void removeFrom($fieldName, $value)
	 * @method void removeAll($fieldName)
	 * @method \Bitrix\Main\ORM\Data\Result delete()
	 * @method mixed fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method mixed[] collectValues($valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL)
	 * @method \Bitrix\Main\ORM\Data\AddResult|\Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\Result save()
	 * @method static \Craft\Area\Entity\AreaContent wakeUp($data)
	 */
	class EO_AreaContent {
		/* @var \Craft\Area\Entity\AreaContentTable */
		static public $dataClass = '\Craft\Area\Entity\AreaContentTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Craft\Area\Entity {
	/**
	 * EO_AreaContent_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getAreaIdList()
	 * @method \int[] getAreaBlockIdList()
	 * @method \string[] getValueList()
	 * @method \string[] fillValue()
	 * @method \Craft\Area\Entity\Area[] getAreaList()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection getAreaCollection()
	 * @method \Craft\Area\Entity\AreaCollection fillArea()
	 * @method \Craft\Area\Entity\AreaField[] getFieldList()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection getFieldCollection()
	 * @method \Craft\Area\Entity\AreaFieldCollection fillField()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @method void add(\Craft\Area\Entity\AreaContent $object)
	 * @method bool has(\Craft\Area\Entity\AreaContent $object)
	 * @method bool hasByPrimary($primary)
	 * @method \Craft\Area\Entity\AreaContent getByPrimary($primary)
	 * @method \Craft\Area\Entity\AreaContent[] getAll()
	 * @method bool remove(\Craft\Area\Entity\AreaContent $object)
	 * @method void removeByPrimary($primary)
	 * @method array|\Bitrix\Main\ORM\Objectify\Collection|null fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method static \Craft\Area\Entity\EO_AreaContent_Collection wakeUp($data)
	 * @method \Bitrix\Main\ORM\Data\Result save($ignoreEvents = false)
	 * @method void offsetSet() ArrayAccess
	 * @method void offsetExists() ArrayAccess
	 * @method void offsetUnset() ArrayAccess
	 * @method void offsetGet() ArrayAccess
	 * @method void rewind() Iterator
	 * @method \Craft\Area\Entity\AreaContent current() Iterator
	 * @method mixed key() Iterator
	 * @method void next() Iterator
	 * @method bool valid() Iterator
	 * @method int count() Countable
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection merge(?\Craft\Area\Entity\EO_AreaContent_Collection $collection)
	 * @method bool isEmpty()
	 * @method array collectValues(int $valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, int $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL, bool $recursive = false)
	 */
	class EO_AreaContent_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Craft\Area\Entity\AreaContentTable */
		static public $dataClass = '\Craft\Area\Entity\AreaContentTable';
	}
}
namespace Craft\Area\Entity {
	/**
	 * @method static EO_AreaContent_Query query()
	 * @method static EO_AreaContent_Result getByPrimary($primary, array $parameters = [])
	 * @method static EO_AreaContent_Result getById($id)
	 * @method static EO_AreaContent_Result getList(array $parameters = [])
	 * @method static EO_AreaContent_Entity getEntity()
	 * @method static \Craft\Area\Entity\AreaContent createObject($setDefaultValues = true)
	 * @method static \Craft\Area\Entity\EO_AreaContent_Collection createCollection()
	 * @method static \Craft\Area\Entity\AreaContent wakeUpObject($row)
	 * @method static \Craft\Area\Entity\EO_AreaContent_Collection wakeUpCollection($rows)
	 */
	class AreaContentTable extends \Bitrix\Main\ORM\Data\DataManager {}
	/**
	 * Common methods:
	 * ---------------
	 *
	 * @method EO_AreaContent_Result exec()
	 * @method \Craft\Area\Entity\AreaContent fetchObject()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection fetchCollection()
	 */
	class EO_AreaContent_Query extends \Bitrix\Main\ORM\Query\Query {}
	/**
	 * @method \Craft\Area\Entity\AreaContent fetchObject()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection fetchCollection()
	 */
	class EO_AreaContent_Result extends \Bitrix\Main\ORM\Query\Result {}
	/**
	 * @method \Craft\Area\Entity\AreaContent createObject($setDefaultValues = true)
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection createCollection()
	 * @method \Craft\Area\Entity\AreaContent wakeUpObject($row)
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection wakeUpCollection($rows)
	 */
	class EO_AreaContent_Entity extends \Bitrix\Main\ORM\Entity {}
}
/* ORMENTITYANNOTATION:Craft\Area\Entity\AreaFieldTable */
namespace Craft\Area\Entity {
	/**
	 * AreaField
	 * @see \Craft\Area\Entity\AreaFieldTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getId()
	 * @method \Craft\Area\Entity\AreaField setId(\int|\Bitrix\Main\DB\SqlExpression $id)
	 * @method bool hasId()
	 * @method bool isIdFilled()
	 * @method bool isIdChanged()
	 * @method \int getAreaId()
	 * @method \Craft\Area\Entity\AreaField setAreaId(\int|\Bitrix\Main\DB\SqlExpression $areaId)
	 * @method bool hasAreaId()
	 * @method bool isAreaIdFilled()
	 * @method bool isAreaIdChanged()
	 * @method \int remindActualAreaId()
	 * @method \int requireAreaId()
	 * @method \Craft\Area\Entity\AreaField resetAreaId()
	 * @method \Craft\Area\Entity\AreaField unsetAreaId()
	 * @method \int fillAreaId()
	 * @method \string getType()
	 * @method \Craft\Area\Entity\AreaField setType(\string|\Bitrix\Main\DB\SqlExpression $type)
	 * @method bool hasType()
	 * @method bool isTypeFilled()
	 * @method bool isTypeChanged()
	 * @method \string remindActualType()
	 * @method \string requireType()
	 * @method \Craft\Area\Entity\AreaField resetType()
	 * @method \Craft\Area\Entity\AreaField unsetType()
	 * @method \string fillType()
	 * @method \string getName()
	 * @method \Craft\Area\Entity\AreaField setName(\string|\Bitrix\Main\DB\SqlExpression $name)
	 * @method bool hasName()
	 * @method bool isNameFilled()
	 * @method bool isNameChanged()
	 * @method \string remindActualName()
	 * @method \string requireName()
	 * @method \Craft\Area\Entity\AreaField resetName()
	 * @method \Craft\Area\Entity\AreaField unsetName()
	 * @method \string fillName()
	 * @method \int getSort()
	 * @method \Craft\Area\Entity\AreaField setSort(\int|\Bitrix\Main\DB\SqlExpression $sort)
	 * @method bool hasSort()
	 * @method bool isSortFilled()
	 * @method bool isSortChanged()
	 * @method \int remindActualSort()
	 * @method \int requireSort()
	 * @method \Craft\Area\Entity\AreaField resetSort()
	 * @method \Craft\Area\Entity\AreaField unsetSort()
	 * @method \int fillSort()
	 * @method \string getCode()
	 * @method \Craft\Area\Entity\AreaField setCode(\string|\Bitrix\Main\DB\SqlExpression $code)
	 * @method bool hasCode()
	 * @method bool isCodeFilled()
	 * @method bool isCodeChanged()
	 * @method \string remindActualCode()
	 * @method \string requireCode()
	 * @method \Craft\Area\Entity\AreaField resetCode()
	 * @method \Craft\Area\Entity\AreaField unsetCode()
	 * @method \string fillCode()
	 * @method \boolean getActive()
	 * @method \Craft\Area\Entity\AreaField setActive(\boolean|\Bitrix\Main\DB\SqlExpression $active)
	 * @method bool hasActive()
	 * @method bool isActiveFilled()
	 * @method bool isActiveChanged()
	 * @method \boolean remindActualActive()
	 * @method \boolean requireActive()
	 * @method \Craft\Area\Entity\AreaField resetActive()
	 * @method \Craft\Area\Entity\AreaField unsetActive()
	 * @method \boolean fillActive()
	 * @method \boolean getMultiple()
	 * @method \Craft\Area\Entity\AreaField setMultiple(\boolean|\Bitrix\Main\DB\SqlExpression $multiple)
	 * @method bool hasMultiple()
	 * @method bool isMultipleFilled()
	 * @method bool isMultipleChanged()
	 * @method \boolean remindActualMultiple()
	 * @method \boolean requireMultiple()
	 * @method \Craft\Area\Entity\AreaField resetMultiple()
	 * @method \Craft\Area\Entity\AreaField unsetMultiple()
	 * @method \boolean fillMultiple()
	 * @method \string getSettings()
	 * @method \Craft\Area\Entity\AreaField setSettings(\string|\Bitrix\Main\DB\SqlExpression $settings)
	 * @method bool hasSettings()
	 * @method bool isSettingsFilled()
	 * @method bool isSettingsChanged()
	 * @method \string remindActualSettings()
	 * @method \string requireSettings()
	 * @method \Craft\Area\Entity\AreaField resetSettings()
	 * @method \Craft\Area\Entity\AreaField unsetSettings()
	 * @method \string fillSettings()
	 * @method \Craft\Area\Entity\Area getArea()
	 * @method \Craft\Area\Entity\Area remindActualArea()
	 * @method \Craft\Area\Entity\Area requireArea()
	 * @method \Craft\Area\Entity\AreaField setArea(\Craft\Area\Entity\Area $object)
	 * @method \Craft\Area\Entity\AreaField resetArea()
	 * @method \Craft\Area\Entity\AreaField unsetArea()
	 * @method bool hasArea()
	 * @method bool isAreaFilled()
	 * @method bool isAreaChanged()
	 * @method \Craft\Area\Entity\Area fillArea()
	 * @method \Craft\Area\Entity\AreaContent getContent()
	 * @method \Craft\Area\Entity\AreaContent remindActualContent()
	 * @method \Craft\Area\Entity\AreaContent requireContent()
	 * @method \Craft\Area\Entity\AreaField setContent(\Craft\Area\Entity\AreaContent $object)
	 * @method \Craft\Area\Entity\AreaField resetContent()
	 * @method \Craft\Area\Entity\AreaField unsetContent()
	 * @method bool hasContent()
	 * @method bool isContentFilled()
	 * @method bool isContentChanged()
	 * @method \Craft\Area\Entity\AreaContent fillContent()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @property-read array $primary
	 * @property-read int $state @see \Bitrix\Main\ORM\Objectify\State
	 * @property-read \Bitrix\Main\Type\Dictionary $customData
	 * @property \Bitrix\Main\Authentication\Context $authContext
	 * @method mixed get($fieldName)
	 * @method mixed remindActual($fieldName)
	 * @method mixed require($fieldName)
	 * @method bool has($fieldName)
	 * @method bool isFilled($fieldName)
	 * @method bool isChanged($fieldName)
	 * @method \Craft\Area\Entity\AreaField set($fieldName, $value)
	 * @method \Craft\Area\Entity\AreaField reset($fieldName)
	 * @method \Craft\Area\Entity\AreaField unset($fieldName)
	 * @method void addTo($fieldName, $value)
	 * @method void removeFrom($fieldName, $value)
	 * @method void removeAll($fieldName)
	 * @method \Bitrix\Main\ORM\Data\Result delete()
	 * @method mixed fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method mixed[] collectValues($valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL)
	 * @method \Bitrix\Main\ORM\Data\AddResult|\Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\Result save()
	 * @method static \Craft\Area\Entity\AreaField wakeUp($data)
	 */
	class EO_AreaField {
		/* @var \Craft\Area\Entity\AreaFieldTable */
		static public $dataClass = '\Craft\Area\Entity\AreaFieldTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Craft\Area\Entity {
	/**
	 * AreaFieldCollection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getIdList()
	 * @method \int[] getAreaIdList()
	 * @method \int[] fillAreaId()
	 * @method \string[] getTypeList()
	 * @method \string[] fillType()
	 * @method \string[] getNameList()
	 * @method \string[] fillName()
	 * @method \int[] getSortList()
	 * @method \int[] fillSort()
	 * @method \string[] getCodeList()
	 * @method \string[] fillCode()
	 * @method \boolean[] getActiveList()
	 * @method \boolean[] fillActive()
	 * @method \boolean[] getMultipleList()
	 * @method \boolean[] fillMultiple()
	 * @method \string[] getSettingsList()
	 * @method \string[] fillSettings()
	 * @method \Craft\Area\Entity\Area[] getAreaList()
	 * @method \Craft\Area\Entity\AreaFieldCollection getAreaCollection()
	 * @method \Craft\Area\Entity\AreaCollection fillArea()
	 * @method \Craft\Area\Entity\AreaContent[] getContentList()
	 * @method \Craft\Area\Entity\AreaFieldCollection getContentCollection()
	 * @method \Craft\Area\Entity\EO_AreaContent_Collection fillContent()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @method void add(\Craft\Area\Entity\AreaField $object)
	 * @method bool has(\Craft\Area\Entity\AreaField $object)
	 * @method bool hasByPrimary($primary)
	 * @method \Craft\Area\Entity\AreaField getByPrimary($primary)
	 * @method \Craft\Area\Entity\AreaField[] getAll()
	 * @method bool remove(\Craft\Area\Entity\AreaField $object)
	 * @method void removeByPrimary($primary)
	 * @method array|\Bitrix\Main\ORM\Objectify\Collection|null fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method static \Craft\Area\Entity\AreaFieldCollection wakeUp($data)
	 * @method \Bitrix\Main\ORM\Data\Result save($ignoreEvents = false)
	 * @method void offsetSet() ArrayAccess
	 * @method void offsetExists() ArrayAccess
	 * @method void offsetUnset() ArrayAccess
	 * @method void offsetGet() ArrayAccess
	 * @method void rewind() Iterator
	 * @method \Craft\Area\Entity\AreaField current() Iterator
	 * @method mixed key() Iterator
	 * @method void next() Iterator
	 * @method bool valid() Iterator
	 * @method int count() Countable
	 * @method \Craft\Area\Entity\AreaFieldCollection merge(?\Craft\Area\Entity\AreaFieldCollection $collection)
	 * @method bool isEmpty()
	 * @method array collectValues(int $valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, int $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL, bool $recursive = false)
	 */
	class EO_AreaField_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Craft\Area\Entity\AreaFieldTable */
		static public $dataClass = '\Craft\Area\Entity\AreaFieldTable';
	}
}
namespace Craft\Area\Entity {
	/**
	 * @method static EO_AreaField_Query query()
	 * @method static EO_AreaField_Result getByPrimary($primary, array $parameters = [])
	 * @method static EO_AreaField_Result getById($id)
	 * @method static EO_AreaField_Result getList(array $parameters = [])
	 * @method static EO_AreaField_Entity getEntity()
	 * @method static \Craft\Area\Entity\AreaField createObject($setDefaultValues = true)
	 * @method static \Craft\Area\Entity\AreaFieldCollection createCollection()
	 * @method static \Craft\Area\Entity\AreaField wakeUpObject($row)
	 * @method static \Craft\Area\Entity\AreaFieldCollection wakeUpCollection($rows)
	 */
	class AreaFieldTable extends \Bitrix\Main\ORM\Data\DataManager {}
	/**
	 * Common methods:
	 * ---------------
	 *
	 * @method EO_AreaField_Result exec()
	 * @method \Craft\Area\Entity\AreaField fetchObject()
	 * @method \Craft\Area\Entity\AreaFieldCollection fetchCollection()
	 */
	class EO_AreaField_Query extends \Bitrix\Main\ORM\Query\Query {}
	/**
	 * @method \Craft\Area\Entity\AreaField fetchObject()
	 * @method \Craft\Area\Entity\AreaFieldCollection fetchCollection()
	 */
	class EO_AreaField_Result extends \Bitrix\Main\ORM\Query\Result {}
	/**
	 * @method \Craft\Area\Entity\AreaField createObject($setDefaultValues = true)
	 * @method \Craft\Area\Entity\AreaFieldCollection createCollection()
	 * @method \Craft\Area\Entity\AreaField wakeUpObject($row)
	 * @method \Craft\Area\Entity\AreaFieldCollection wakeUpCollection($rows)
	 */
	class EO_AreaField_Entity extends \Bitrix\Main\ORM\Entity {}
}
/* ORMENTITYANNOTATION:Craft\Orm\SearchSynonymTable */
namespace Craft\Orm {
	/**
	 * SearchSynonym
	 * @see \Craft\Orm\SearchSynonymTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getId()
	 * @method \Craft\Orm\SearchSynonym setId(\int|\Bitrix\Main\DB\SqlExpression $id)
	 * @method bool hasId()
	 * @method bool isIdFilled()
	 * @method bool isIdChanged()
	 * @method \string getSearchItems()
	 * @method \Craft\Orm\SearchSynonym setSearchItems(\string|\Bitrix\Main\DB\SqlExpression $searchItems)
	 * @method bool hasSearchItems()
	 * @method bool isSearchItemsFilled()
	 * @method bool isSearchItemsChanged()
	 * @method \string remindActualSearchItems()
	 * @method \string requireSearchItems()
	 * @method \Craft\Orm\SearchSynonym resetSearchItems()
	 * @method \Craft\Orm\SearchSynonym unsetSearchItems()
	 * @method \string fillSearchItems()
	 * @method \Bitrix\Main\Type\DateTime getCreatedAt()
	 * @method \Craft\Orm\SearchSynonym setCreatedAt(\Bitrix\Main\Type\DateTime|\Bitrix\Main\DB\SqlExpression $createdAt)
	 * @method bool hasCreatedAt()
	 * @method bool isCreatedAtFilled()
	 * @method bool isCreatedAtChanged()
	 * @method \Bitrix\Main\Type\DateTime remindActualCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime requireCreatedAt()
	 * @method \Craft\Orm\SearchSynonym resetCreatedAt()
	 * @method \Craft\Orm\SearchSynonym unsetCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime fillCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime getUpdatedAt()
	 * @method \Craft\Orm\SearchSynonym setUpdatedAt(\Bitrix\Main\Type\DateTime|\Bitrix\Main\DB\SqlExpression $updatedAt)
	 * @method bool hasUpdatedAt()
	 * @method bool isUpdatedAtFilled()
	 * @method bool isUpdatedAtChanged()
	 * @method \Bitrix\Main\Type\DateTime remindActualUpdatedAt()
	 * @method \Bitrix\Main\Type\DateTime requireUpdatedAt()
	 * @method \Craft\Orm\SearchSynonym resetUpdatedAt()
	 * @method \Craft\Orm\SearchSynonym unsetUpdatedAt()
	 * @method \Bitrix\Main\Type\DateTime fillUpdatedAt()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @property-read array $primary
	 * @property-read int $state @see \Bitrix\Main\ORM\Objectify\State
	 * @property-read \Bitrix\Main\Type\Dictionary $customData
	 * @property \Bitrix\Main\Authentication\Context $authContext
	 * @method mixed get($fieldName)
	 * @method mixed remindActual($fieldName)
	 * @method mixed require($fieldName)
	 * @method bool has($fieldName)
	 * @method bool isFilled($fieldName)
	 * @method bool isChanged($fieldName)
	 * @method \Craft\Orm\SearchSynonym set($fieldName, $value)
	 * @method \Craft\Orm\SearchSynonym reset($fieldName)
	 * @method \Craft\Orm\SearchSynonym unset($fieldName)
	 * @method void addTo($fieldName, $value)
	 * @method void removeFrom($fieldName, $value)
	 * @method void removeAll($fieldName)
	 * @method \Bitrix\Main\ORM\Data\Result delete()
	 * @method mixed fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method mixed[] collectValues($valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL)
	 * @method \Bitrix\Main\ORM\Data\AddResult|\Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\Result save()
	 * @method static \Craft\Orm\SearchSynonym wakeUp($data)
	 */
	class EO_SearchSynonym {
		/* @var \Craft\Orm\SearchSynonymTable */
		static public $dataClass = '\Craft\Orm\SearchSynonymTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Craft\Orm {
	/**
	 * EO_SearchSynonym_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getIdList()
	 * @method \string[] getSearchItemsList()
	 * @method \string[] fillSearchItems()
	 * @method \Bitrix\Main\Type\DateTime[] getCreatedAtList()
	 * @method \Bitrix\Main\Type\DateTime[] fillCreatedAt()
	 * @method \Bitrix\Main\Type\DateTime[] getUpdatedAtList()
	 * @method \Bitrix\Main\Type\DateTime[] fillUpdatedAt()
	 *
	 * Common methods:
	 * ---------------
	 *
	 * @property-read \Bitrix\Main\ORM\Entity $entity
	 * @method void add(\Craft\Orm\SearchSynonym $object)
	 * @method bool has(\Craft\Orm\SearchSynonym $object)
	 * @method bool hasByPrimary($primary)
	 * @method \Craft\Orm\SearchSynonym getByPrimary($primary)
	 * @method \Craft\Orm\SearchSynonym[] getAll()
	 * @method bool remove(\Craft\Orm\SearchSynonym $object)
	 * @method void removeByPrimary($primary)
	 * @method array|\Bitrix\Main\ORM\Objectify\Collection|null fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL) flag or array of field names
	 * @method static \Craft\Orm\EO_SearchSynonym_Collection wakeUp($data)
	 * @method \Bitrix\Main\ORM\Data\Result save($ignoreEvents = false)
	 * @method void offsetSet() ArrayAccess
	 * @method void offsetExists() ArrayAccess
	 * @method void offsetUnset() ArrayAccess
	 * @method void offsetGet() ArrayAccess
	 * @method void rewind() Iterator
	 * @method \Craft\Orm\SearchSynonym current() Iterator
	 * @method mixed key() Iterator
	 * @method void next() Iterator
	 * @method bool valid() Iterator
	 * @method int count() Countable
	 * @method \Craft\Orm\EO_SearchSynonym_Collection merge(?\Craft\Orm\EO_SearchSynonym_Collection $collection)
	 * @method bool isEmpty()
	 * @method array collectValues(int $valuesType = \Bitrix\Main\ORM\Objectify\Values::ALL, int $fieldsMask = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL, bool $recursive = false)
	 */
	class EO_SearchSynonym_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Craft\Orm\SearchSynonymTable */
		static public $dataClass = '\Craft\Orm\SearchSynonymTable';
	}
}
namespace Craft\Orm {
	/**
	 * @method static EO_SearchSynonym_Query query()
	 * @method static EO_SearchSynonym_Result getByPrimary($primary, array $parameters = [])
	 * @method static EO_SearchSynonym_Result getById($id)
	 * @method static EO_SearchSynonym_Result getList(array $parameters = [])
	 * @method static EO_SearchSynonym_Entity getEntity()
	 * @method static \Craft\Orm\SearchSynonym createObject($setDefaultValues = true)
	 * @method static \Craft\Orm\EO_SearchSynonym_Collection createCollection()
	 * @method static \Craft\Orm\SearchSynonym wakeUpObject($row)
	 * @method static \Craft\Orm\EO_SearchSynonym_Collection wakeUpCollection($rows)
	 */
	class SearchSynonymTable extends \Bitrix\Main\ORM\Data\DataManager {}
	/**
	 * Common methods:
	 * ---------------
	 *
	 * @method EO_SearchSynonym_Result exec()
	 * @method \Craft\Orm\SearchSynonym fetchObject()
	 * @method \Craft\Orm\EO_SearchSynonym_Collection fetchCollection()
	 */
	class EO_SearchSynonym_Query extends \Bitrix\Main\ORM\Query\Query {}
	/**
	 * @method \Craft\Orm\SearchSynonym fetchObject()
	 * @method \Craft\Orm\EO_SearchSynonym_Collection fetchCollection()
	 */
	class EO_SearchSynonym_Result extends \Bitrix\Main\ORM\Query\Result {}
	/**
	 * @method \Craft\Orm\SearchSynonym createObject($setDefaultValues = true)
	 * @method \Craft\Orm\EO_SearchSynonym_Collection createCollection()
	 * @method \Craft\Orm\SearchSynonym wakeUpObject($row)
	 * @method \Craft\Orm\EO_SearchSynonym_Collection wakeUpCollection($rows)
	 */
	class EO_SearchSynonym_Entity extends \Bitrix\Main\ORM\Entity {}
}
/* ORMENTITYANNOTATION:Bitrix\Blog\CommentTable */
namespace Bitrix\Blog {
	/**
	 * EO_Comment
	 * @see \Bitrix\Blog\CommentTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string getUfBlogCommentDoc()
	 * @method \string remindActualUfBlogCommentDoc()
	 * @method \string requireUfBlogCommentDoc()
	 * @method bool hasUfBlogCommentDoc()
	 * @method bool isUfBlogCommentDocFilled()
	 * @method \Bitrix\Blog\EO_Comment unsetUfBlogCommentDoc()
	 * @method \string fillUfBlogCommentDoc()
	 * @method \Bitrix\Blog\EO_Comment setUfBlogCommentDoc(\string[] $ufBlogCommentDoc)
	 * @method bool isUfBlogCommentDocChanged()
	 * @method \int getUfBlogCommUrlPrv()
	 * @method \int remindActualUfBlogCommUrlPrv()
	 * @method \int requireUfBlogCommUrlPrv()
	 * @method bool hasUfBlogCommUrlPrv()
	 * @method bool isUfBlogCommUrlPrvFilled()
	 * @method \Bitrix\Blog\EO_Comment unsetUfBlogCommUrlPrv()
	 * @method \int fillUfBlogCommUrlPrv()
	 * @method \Bitrix\Blog\EO_Comment setUfBlogCommUrlPrv(\int $ufBlogCommUrlPrv)
	 * @method bool isUfBlogCommUrlPrvChanged()
	 */
	class EO_Comment {
		/* @var \Bitrix\Blog\CommentTable */
		static public $dataClass = '\Bitrix\Blog\CommentTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Bitrix\Blog {
	/**
	 * EO_Comment_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string[] getUfBlogCommentDocList()
	 * @method \string[] fillUfBlogCommentDoc()
	 * @method \int[] getUfBlogCommUrlPrvList()
	 * @method \int[] fillUfBlogCommUrlPrv()
	 */
	class EO_Comment_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Bitrix\Blog\CommentTable */
		static public $dataClass = '\Bitrix\Blog\CommentTable';
	}
}
/* ORMENTITYANNOTATION:Bitrix\Blog\PostTable */
namespace Bitrix\Blog {
	/**
	 * EO_Post
	 * @see \Bitrix\Blog\PostTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string getUfBlogPostDoc()
	 * @method \string remindActualUfBlogPostDoc()
	 * @method \string requireUfBlogPostDoc()
	 * @method bool hasUfBlogPostDoc()
	 * @method bool isUfBlogPostDocFilled()
	 * @method \Bitrix\Blog\EO_Post unsetUfBlogPostDoc()
	 * @method \string fillUfBlogPostDoc()
	 * @method \Bitrix\Blog\EO_Post setUfBlogPostDoc(\string[] $ufBlogPostDoc)
	 * @method bool isUfBlogPostDocChanged()
	 * @method \int getUfGratitude()
	 * @method \int remindActualUfGratitude()
	 * @method \int requireUfGratitude()
	 * @method bool hasUfGratitude()
	 * @method bool isUfGratitudeFilled()
	 * @method \Bitrix\Blog\EO_Post unsetUfGratitude()
	 * @method \int fillUfGratitude()
	 * @method \Bitrix\Blog\EO_Post setUfGratitude(\int $ufGratitude)
	 * @method bool isUfGratitudeChanged()
	 * @method \int getUfBlogPostUrlPrv()
	 * @method \int remindActualUfBlogPostUrlPrv()
	 * @method \int requireUfBlogPostUrlPrv()
	 * @method bool hasUfBlogPostUrlPrv()
	 * @method bool isUfBlogPostUrlPrvFilled()
	 * @method \Bitrix\Blog\EO_Post unsetUfBlogPostUrlPrv()
	 * @method \int fillUfBlogPostUrlPrv()
	 * @method \Bitrix\Blog\EO_Post setUfBlogPostUrlPrv(\int $ufBlogPostUrlPrv)
	 * @method bool isUfBlogPostUrlPrvChanged()
	 * @method \Bitrix\Main\Type\DateTime getUfImprtantDateEnd()
	 * @method \Bitrix\Main\Type\DateTime remindActualUfImprtantDateEnd()
	 * @method \Bitrix\Main\Type\DateTime requireUfImprtantDateEnd()
	 * @method bool hasUfImprtantDateEnd()
	 * @method bool isUfImprtantDateEndFilled()
	 * @method \Bitrix\Blog\EO_Post unsetUfImprtantDateEnd()
	 * @method \Bitrix\Main\Type\DateTime fillUfImprtantDateEnd()
	 * @method \Bitrix\Blog\EO_Post setUfImprtantDateEnd(\Bitrix\Main\Type\DateTime $ufImprtantDateEnd)
	 * @method bool isUfImprtantDateEndChanged()
	 * @method \int getUfMailMessage()
	 * @method \int remindActualUfMailMessage()
	 * @method \int requireUfMailMessage()
	 * @method bool hasUfMailMessage()
	 * @method bool isUfMailMessageFilled()
	 * @method \Bitrix\Blog\EO_Post unsetUfMailMessage()
	 * @method \int fillUfMailMessage()
	 * @method \Bitrix\Blog\EO_Post setUfMailMessage(\int $ufMailMessage)
	 * @method bool isUfMailMessageChanged()
	 */
	class EO_Post {
		/* @var \Bitrix\Blog\PostTable */
		static public $dataClass = '\Bitrix\Blog\PostTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Bitrix\Blog {
	/**
	 * EO_Post_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string[] getUfBlogPostDocList()
	 * @method \string[] fillUfBlogPostDoc()
	 * @method \int[] getUfGratitudeList()
	 * @method \int[] fillUfGratitude()
	 * @method \int[] getUfBlogPostUrlPrvList()
	 * @method \int[] fillUfBlogPostUrlPrv()
	 * @method \Bitrix\Main\Type\DateTime[] getUfImprtantDateEndList()
	 * @method \Bitrix\Main\Type\DateTime[] fillUfImprtantDateEnd()
	 * @method \int[] getUfMailMessageList()
	 * @method \int[] fillUfMailMessage()
	 */
	class EO_Post_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Bitrix\Blog\PostTable */
		static public $dataClass = '\Bitrix\Blog\PostTable';
	}
}
/* ORMENTITYANNOTATION:Bitrix\Catalog\ProductTable */
namespace Bitrix\Catalog {
	/**
	 * EO_Product
	 * @see \Bitrix\Catalog\ProductTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getUfProductGroup()
	 * @method \int remindActualUfProductGroup()
	 * @method \int requireUfProductGroup()
	 * @method bool hasUfProductGroup()
	 * @method bool isUfProductGroupFilled()
	 * @method \Bitrix\Catalog\EO_Product unsetUfProductGroup()
	 * @method \int fillUfProductGroup()
	 * @method \Bitrix\Catalog\EO_Product setUfProductGroup(\int $ufProductGroup)
	 * @method bool isUfProductGroupChanged()
	 */
	class EO_Product {
		/* @var \Bitrix\Catalog\ProductTable */
		static public $dataClass = '\Bitrix\Catalog\ProductTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Bitrix\Catalog {
	/**
	 * EO_Product_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getUfProductGroupList()
	 * @method \int[] fillUfProductGroup()
	 */
	class EO_Product_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Bitrix\Catalog\ProductTable */
		static public $dataClass = '\Bitrix\Catalog\ProductTable';
	}
}
/* ORMENTITYANNOTATION:Bitrix\Main\UserTable */
namespace Bitrix\Main {
	/**
	 * EO_User
	 * @see \Bitrix\Main\UserTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string getUfImSearch()
	 * @method \string remindActualUfImSearch()
	 * @method \string requireUfImSearch()
	 * @method bool hasUfImSearch()
	 * @method bool isUfImSearchFilled()
	 * @method \Bitrix\Main\EO_User unsetUfImSearch()
	 * @method \string fillUfImSearch()
	 * @method \Bitrix\Main\EO_User setUfImSearch(\string $ufImSearch)
	 * @method bool isUfImSearchChanged()
	 */
	class EO_User {
		/* @var \Bitrix\Main\UserTable */
		static public $dataClass = '\Bitrix\Main\UserTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Bitrix\Main {
	/**
	 * EO_User_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \string[] getUfImSearchList()
	 * @method \string[] fillUfImSearch()
	 */
	class EO_User_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Bitrix\Main\UserTable */
		static public $dataClass = '\Bitrix\Main\UserTable';
	}
}
/* ORMENTITYANNOTATION:Bitrix\Forum\MessageTable */
namespace Bitrix\Forum {
	/**
	 * EO_Message
	 * @see \Bitrix\Forum\MessageTable
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int getUfForumMesUrlPrv()
	 * @method \int remindActualUfForumMesUrlPrv()
	 * @method \int requireUfForumMesUrlPrv()
	 * @method bool hasUfForumMesUrlPrv()
	 * @method bool isUfForumMesUrlPrvFilled()
	 * @method \Bitrix\Forum\EO_Message unsetUfForumMesUrlPrv()
	 * @method \int fillUfForumMesUrlPrv()
	 * @method \Bitrix\Forum\EO_Message setUfForumMesUrlPrv(\int $ufForumMesUrlPrv)
	 * @method bool isUfForumMesUrlPrvChanged()
	 * @method \int getUfTaskCommentType()
	 * @method \int remindActualUfTaskCommentType()
	 * @method \int requireUfTaskCommentType()
	 * @method bool hasUfTaskCommentType()
	 * @method bool isUfTaskCommentTypeFilled()
	 * @method \Bitrix\Forum\EO_Message unsetUfTaskCommentType()
	 * @method \int fillUfTaskCommentType()
	 * @method \Bitrix\Forum\EO_Message setUfTaskCommentType(\int $ufTaskCommentType)
	 * @method bool isUfTaskCommentTypeChanged()
	 */
	class EO_Message {
		/* @var \Bitrix\Forum\MessageTable */
		static public $dataClass = '\Bitrix\Forum\MessageTable';
		/**
		 * @param bool|array $setDefaultValues
		 */
		public function __construct($setDefaultValues = true) {}
	}
}
namespace Bitrix\Forum {
	/**
	 * EO_Message_Collection
	 *
	 * Custom methods:
	 * ---------------
	 *
	 * @method \int[] getUfForumMesUrlPrvList()
	 * @method \int[] fillUfForumMesUrlPrv()
	 * @method \int[] getUfTaskCommentTypeList()
	 * @method \int[] fillUfTaskCommentType()
	 */
	class EO_Message_Collection implements \ArrayAccess, \Iterator, \Countable {
		/* @var \Bitrix\Forum\MessageTable */
		static public $dataClass = '\Bitrix\Forum\MessageTable';
	}
}