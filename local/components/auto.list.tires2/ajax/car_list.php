<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();
//\Bitrix\Main\Diag\Debug::dumpToFile($request,'Var','/test.log');
?>

<?$APPLICATION->IncludeComponent("auto.list.tires2",
	'',
	array(
		"AUTO_MARK" => $request["car"],
		"AUTO_MODEL" => $request["model"],
		"AUTO_YEAR" => $request["year"],
		"AUTO_COMPLECT" => $request["modification"],
		"TYPE_FILTER" => $request["type_filter"],
		"INSTANT_RELOAD" => $request["instant_reload"],
		"VYLET_DISKA_TYPE" => $request["VYLET_DISKA_TYPE"],
		"VYLET_DISKA_RANGE_MIN" => $request["VYLET_DISKA_RANGE_MIN"],
		"VYLET_DISKA_RANGE_MAX" => $request["VYLET_DISKA_RANGE_MAX"],
		"DIAMETR_STUPITSY_TYPE" => $request["DIAMETR_STUPITSY_TYPE"],
		"DIAMETR_STUPITSY_RANGE_MIN" => $request["DIAMETR_STUPITSY_RANGE_MIN"],
		"DIAMETR_STUPITSY_RANGE_MAX" => $request["DIAMETR_STUPITSY_RANGE_MAX"],
	)
);?>
