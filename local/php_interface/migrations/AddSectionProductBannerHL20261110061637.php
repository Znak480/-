<?php

namespace Sprint\Migration;


class AddSectionProductBannerHL20261110061637 extends Version
{
  protected $author = "Стоцкий Никита (S1ntoz)";

  protected $description = "HighLoad-блок для отображения банеров в секциях каталога";

  protected $moduleVersion = "5.6.1";

  /**
   * @throws Exceptions\HelperException
   * @return bool|void
   */
  public function up()
  {
    $helper = $this->getHelperManager();
    $hlblockId = $helper->Hlblock()->saveHlblock(array(
      'NAME' => 'SectionsBanner',
      'TABLE_NAME' => 'sections_banner',
      'LANG' =>
      array(
        'ru' =>
        array(
          'NAME' => 'Банер в секциях',
        ),
        'en' =>
        array(
          'NAME' => 'Sections banner',
        ),
      ),
    ));
    $helper->Hlblock()->saveField($hlblockId, array(
      'FIELD_NAME' => 'UF_NAME',
      'USER_TYPE_ID' => 'string',
      'XML_ID' => '',
      'SORT' => '1',
      'MULTIPLE' => 'N',
      'MANDATORY' => 'Y',
      'SHOW_FILTER' => 'N',
      'SHOW_IN_LIST' => 'Y',
      'EDIT_IN_LIST' => 'Y',
      'IS_SEARCHABLE' => 'N',
      'SETTINGS' =>
      array(
        'SIZE' => 20,
        'ROWS' => 1,
        'REGEXP' => '',
        'MIN_LENGTH' => 3,
        'MAX_LENGTH' => 0,
        'DEFAULT_VALUE' => '',
      ),
      'EDIT_FORM_LABEL' =>
      array(
        'en' => '',
        'ru' => 'Название баннера',
      ),
      'LIST_COLUMN_LABEL' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'LIST_FILTER_LABEL' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'ERROR_MESSAGE' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'HELP_MESSAGE' =>
      array(
        'en' => '',
        'ru' => 'Необходим для заполнения свойства ALT у тега IMG HTML ',
      ),
    ));
    $helper->Hlblock()->saveField($hlblockId, array(
      'FIELD_NAME' => 'UF_SECTIONS',
      'USER_TYPE_ID' => 'iblock_section',
      'XML_ID' => '',
      'SORT' => '2',
      'MULTIPLE' => 'Y',
      'MANDATORY' => 'Y',
      'SHOW_FILTER' => 'N',
      'SHOW_IN_LIST' => 'Y',
      'EDIT_IN_LIST' => 'Y',
      'IS_SEARCHABLE' => 'N',
      'SETTINGS' =>
      array(
        'DISPLAY' => 'DIALOG',
        'LIST_HEIGHT' => 5,
        'IBLOCK_ID' => 'catalog:catalog_brn',
        'DEFAULT_VALUE' => '',
        'ACTIVE_FILTER' => 'N',
      ),
      'EDIT_FORM_LABEL' =>
      array(
        'en' => '',
        'ru' => 'Секции',
      ),
      'LIST_COLUMN_LABEL' =>
      array(
        'en' => '',
        'ru' => 'Список секций',
      ),
      'LIST_FILTER_LABEL' =>
      array(
        'en' => '',
        'ru' => 'Список секций',
      ),
      'ERROR_MESSAGE' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'HELP_MESSAGE' =>
      array(
        'en' => '',
        'ru' => '',
      ),
    ));
    $helper->Hlblock()->saveField($hlblockId, array(
      'FIELD_NAME' => 'UF_PHOTO',
      'USER_TYPE_ID' => 'file',
      'XML_ID' => '',
      'SORT' => '3',
      'MULTIPLE' => 'N',
      'MANDATORY' => 'Y',
      'SHOW_FILTER' => 'N',
      'SHOW_IN_LIST' => 'Y',
      'EDIT_IN_LIST' => 'Y',
      'IS_SEARCHABLE' => 'N',
      'SETTINGS' =>
      array(
        'SIZE' => 20,
        'LIST_WIDTH' => 0,
        'LIST_HEIGHT' => 0,
        'MAX_SHOW_SIZE' => 0,
        'MAX_ALLOWED_SIZE' => 0,
        'EXTENSIONS' =>
        array(
          'jpg' => true,
          'jpeg' => true,
          'png' => true,
          'gif' => true,
          'svg' => true,
          'webp' => true,
        ),
        'TARGET_BLANK' => 'N',
        'DEFAULT_VIEW' => NULL,
      ),
      'EDIT_FORM_LABEL' =>
      array(
        'en' => '',
        'ru' => 'Изображение баннера',
      ),
      'LIST_COLUMN_LABEL' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'LIST_FILTER_LABEL' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'ERROR_MESSAGE' =>
      array(
        'en' => '',
        'ru' => '',
      ),
      'HELP_MESSAGE' =>
      array(
        'en' => '',
        'ru' => '',
      ),
    ));
  }
}
