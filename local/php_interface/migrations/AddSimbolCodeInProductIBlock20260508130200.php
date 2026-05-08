<?php     
namespace Sprint\Migration;

use Sprint\Migration\Helpers\IblockHelper;

class AddSimbolCodeInProductIBlock20260508130200 extends Version
{
   
    protected $description = "Добавить символьный код для инфоблоков каталога";

    private const SYMBOLE_CODE = [
        19 => "catalog_brn",
        21 => "catalog_gr"
    ];    

    public function up(){
        $helper = new IblockHelper();

        $allSuccess = true;
        foreach(self:: SYMBOLE_CODE as $iblockId => $symbolCode){
            $success = $helper->updateIblock($iblockId, ['CODE' => $symbolCode]);

            if ($success) {
                $this->out("Символьный код '{$symbolCode}' успешно добавлен инфоблоку ID: {$idBlock}");
            } else {
                $this->outError("Ошибка при добавлении символьного кода инфоблоку ID: {$idBlock}");
                $allSuccess = false;
            }
        }

        return $allSuccess;
    }


     public function down()
    {
        $helper = new IblockHelper();
        $allSuccess = true;

        foreach (self::SYMBOLE_CODE as $idBlock => $symbolCode) {
            $success = $helper->updateIblock($idBlock, ['CODE' => '']);

            if ($success) {
                $this->out("Символьный код удален у инфоблока ID: {$idBlock}");
            } else {
                $this->outError("Ошибка при удалении символьного кода у инфоблока ID: {$idBlock}");
                $allSuccess = false;
            }
        }

        return $allSuccess;
    }
}

?>