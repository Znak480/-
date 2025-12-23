CModule::IncludeModule("iblock");
ini_set ("max_execution_time" , "6000");
?>
<div class="content-block regular-block">
<?
$results = $DB->Query("SELECT * FROM `categories` WHERE `Owner`=1 order by `ID` ASC");
//выполняем произвольный запрос

$name_array=array();
//создаем пустой массив, но можно эту строчку исключить

while ($row = $results->Fetch()) // перебираем все которые в корне лежат
{ 
	
	$bs = new CIBlockSection;
	$arFields = Array(
	  "ACTIVE" => 'Y',
	  "IBLOCK_SECTION_ID" => 0,
	  "IBLOCK_ID" => 2,
	  "NAME" => $row["Title"],
	  "CODE" => translit($row["Title"]).$row["ID"],
	  "DESCRIPTION" => $row["Info"]
	  );
	 
	 $ID = $bs->Add($arFields); // Добавляем первый уровень категорий
	 
	 $results_element = $DB->Query("SELECT * FROM `products` WHERE `Owner`=".$row["ID"]." order by `ID` ASC");  // достаем элеемнты если вдруг они лежат в корне
	  
	  while ($elem = $results_element->Fetch())
	  {
		$el = new CIBlockElement; 
		$arRequestArray = Array(
		"MODIFIED_BY"    => 1,
		"IBLOCK_SECTION_ID" => $ID,       
		"IBLOCK_ID"      => 2,
		"NAME"           => $elem["Title"],
		"CODE"			 => translit($elem["Title"]).$elem["ID"],
		"ACTIVE"         => "Y",
		"PREVIEW_TEXT"	 => $elem["Info"],
		"PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images1/products/".$elem['ID'].".".$elem["Ext"])// активен
		);
		$PRODUCT_ID = $el->Add($arRequestArray); // добавляем эелемнты н первый уровень категорий, если они конечно есть 
		echo $el->LAST_ERROR;
	  }	
	  
	  /* *****************************************************   */
	  $results2lvl = $DB->Query("SELECT * FROM `categories` WHERE `Owner`=".$row["ID"]." order by `ID` ASC"); 
      while ($row2 = $results2lvl->Fetch())
		{
			
		$bs2 = new CIBlockSection;
		$arFields2 = Array(
		  "ACTIVE" => 'Y',
		  "IBLOCK_SECTION_ID" => $ID,
		  "IBLOCK_ID" => 2,
		  "NAME" => $row2["Title"],
		  "CODE" => translit($row2["Title"]).$row2["ID"],
		  "DESCRIPTION" => $row2["Info"]
		  
		);
		
		$ID2 = $bs2->Add($arFields2); // Добавляем второй уровень категорий
		echo $bs2->LAST_ERROR;
		$results_element = $DB->Query("SELECT * FROM `products` WHERE `Owner`=".$row2["ID"]." order by `ID` ASC"); 
	  
		  while ($elem = $results_element->Fetch())
		  {
			$el = new CIBlockElement; 
			$arRequestArray = Array(
			"MODIFIED_BY"    => 1, // элемент изменен текущим пользователем 
			"IBLOCK_SECTION_ID" => $ID2,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => 2,
			"NAME"           => $elem["Title"],
			"CODE"			 => translit($elem["Title"]).$elem["ID"],
			"ACTIVE"         => "Y",
			"PREVIEW_TEXT"	 => $elem["Info"],
			"PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images1/products/".$elem['ID'].".".$elem["Ext"])// активен
			);
			$PRODUCT_ID = $el->Add($arRequestArray); // добавляем эелемнты н второй уровень категорий, если они конечно есть 
			echo $el->LAST_ERROR;
		  }		
		  
		  
		/// третий уровень вложености
		$results3lvl = $DB->Query("SELECT * FROM `categories` WHERE `Owner`=".$row2["ID"]." order by `ID` ASC"); 
		  while ($row3 = $results3lvl->Fetch())
			{
			
		
		$bs3 = new CIBlockSection;
			$arFields3 = Array(
			  "ACTIVE" => 'Y',
			  "IBLOCK_SECTION_ID" => $ID2,
			  "IBLOCK_ID" => 2,
			  "NAME" => $row3["Title"],
			  "CODE" => translit($row3["Title"]).$row3["ID"],
			  "DESCRIPTION" => $row3["Info"]
			  
			);
		
		$ID3 = $bs3->Add($arFields3); // Добавляем второй уровень категорий
		echo $bs3->LAST_ERROR;
		$results_element = $DB->Query("SELECT * FROM `products` WHERE `Owner`=".$row3["ID"]." order by `ID` ASC"); 
	  
		  while ($elem = $results_element->Fetch())
		  {
			$el = new CIBlockElement; 
			$arRequestArray = Array(
			"MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => $ID3,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => 2,
			"NAME"           => $elem["Title"],
			"CODE"			 => translit($elem["Title"]).$elem["ID"],	
			"ACTIVE"         => "Y",
			"PREVIEW_TEXT"	 => $elem["Info"],
			"PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/images1/products/".$elem['ID'].".".$elem["Ext"])// активен
			);
			$PRODUCT_ID = $el->Add($arRequestArray); // добавляем эелемнты н второй уровень категорий, если они конечно есть 
			
		  }		
			
			
		  
		}
			
}
}
?>
</div>