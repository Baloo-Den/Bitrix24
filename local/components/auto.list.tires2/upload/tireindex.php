<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;

$RIGHT = $APPLICATION->GetGroupRight("aspro.tires2");
if ($RIGHT >="R")
{
	header("Content-Type: text/json");
	header('Cache-Control: no-cache');
	header('Cache-Control: no-store' , false);
	header('Access-Control-Allow-Methods: POST, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type');
	header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
	header('Access-Control-Allow-Credentials: true');

	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') exit;
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			if (CModule::IncludeModule("aspro.tires2"))
			{
				$arResult = array();
				foreach ($_FILES as $key=>$file)
				{
					if (is_uploaded_file($file["tmp_name"]))
					{
						$res = array(
							"NAME" => $file["name"],
							"TYPE" => $file["type"],
							"TMP_NAME" => $file["tmp_name"],
							"ERROR" => $file["error"],
							"SIZE" => $file["size"],
						);

						if (!intval($res["ERROR"]) && $res["NAME"] && $res["TMP_NAME"])
						{
							$res["PROCESSED"] = Aspro\Functions\CAsproTireIndex::explodeSQLRequest($file["tmp_name"]);
							$arResult[] = $res;
						}
					}
				}
				echo $res["PROCESSED"];
				/*echo '<?xml version="1.0"?>';
				echo "\n";
				echo "<response>\n";
				foreach($arResult as $key=>$value)
				{
					echo "\t<element_".$key.">\n";
					echo "\t\t<NAME>".$value["NAME"]."</NAME>\n";
					echo "\t\t<TYPE>".$value["TYPE"]."</TYPE>\n";
					echo "\t\t<TMP_NAME>".$value["TMP_NAME"]."</TMP_NAME>\n";
					echo "\t\t<ERROR>".$value["ERROR"]."</ERROR>\n";
					echo "\t\t<SIZE>".$value["SIZE"]."</SIZE>\n";
					echo "\t\t<PROCESSED>".$value["PROCESSED"]."</PROCESSED>\n";
					echo "\t</element_".$key.">\n";
				}
				echo "</response>";*/
			}
		}
	}
}
?>
