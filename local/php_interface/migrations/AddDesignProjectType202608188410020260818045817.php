<?php

namespace Sprint\Migration;


class AddDesignProjectType202608188410020260818045817 extends Version
{
    protected $author = "stotskiy_dev";

    protected $description = "Добавить тип инфоблока: Дизайн проект (Design Project)";

    protected $moduleVersion = "5.6.1";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Iblock()->saveIblockType(array (
  'ID' => 'design_project',
  'SECTIONS' => 'N',
  'EDIT_FILE_BEFORE' => '',
  'EDIT_FILE_AFTER' => '',
  'IN_RSS' => 'N',
  'SORT' => '500',
  'LANG' => 
  array (
    'ru' => 
    array (
      'NAME' => 'Дизайн проект',
      'SECTION_NAME' => '',
      'ELEMENT_NAME' => '',
    ),
    'en' => 
    array (
      'NAME' => 'Design project',
      'SECTION_NAME' => '',
      'ELEMENT_NAME' => '',
    ),
  ),
));
        $iblockId = $helper->Iblock()->getIblockIdIfExists('dreviews', 'design_project');

    }
}
