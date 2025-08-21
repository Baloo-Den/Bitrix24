<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);?>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if($request['type_filter'])
	$typeFilter = $request['type_filter'];
elseif($arParams['TYPE_FILTER'])
	$typeFilter = $arParams['TYPE_FILTER'];

use \Bitrix\Main\Localization\Loc;
global $APPLICATION;
$arResult = array();

$cache = new CPHPCache();
$cache_time = 3600000;
$cache_path = 'custom1.auto_list.tires2/'.$typeFilter;


$baseName = 'auto_carmodels';
$cache_id = 'auto_list';

if($cache->InitCache($cache_time, $cache_id, $cache_path))
{
	$res = $cache->GetVars();
	$arResult = $res["arResult"];
}
else
{
	global $DB;

	$strsql = "show tables like '".$baseName."'";
	$res = $DB->Query($strsql, false, $err_mess.__LINE__);
	if($res->SelectedRowsCount())
	{
		$strsql = 'SELECT vendor FROM '.$baseName.' GROUP BY vendor ORDER BY vendor ASC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["CARS"][] = array( "NAME" => $car["vendor"], "FORMAT_NAME" => crc32($car["vendor"]) );

		if ($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
	else
	{
		echo Loc::getMessage("ERROR_TABLES_TYREINDEX");
		return;
	}
}

if(!empty($arParams["AUTO_MARK"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_car';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"];

	foreach($arResult["CARS"] as $key => $arValue)
	{
		if($arValue["FORMAT_NAME"] == $arParams["AUTO_MARK"])
			$arParams["AUTO_MARK"] = $arValue["NAME"];
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT model FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" GROUP BY model ORDER BY model ASC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["MODEL"][] = array( "NAME" => $car["model"], "FORMAT_NAME" => crc32($car["model"]) );

		if ($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_MARK"]) && !empty( $arParams["AUTO_MODEL"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_model';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"];

	foreach($arResult["MODEL"] as $key => $arValue)
	{
		if($arValue["FORMAT_NAME"] == $arParams["AUTO_MODEL"])
			$arParams["AUTO_MODEL"] = $arValue["NAME"];
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT min(beginyear) AS "start", max(endyear) AS "end" FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" AND model = "'.$arParams["AUTO_MODEL"].'"';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		if ($yearsRange = $res->fetch()) {
			$arResult['YEAR'] = array_map(static function ($year) {
				return ['NAME' => $year, 'FORMAT_NAME' => crc32($year)];
			}, range($yearsRange['start'], $yearsRange['end']));
		}

		if($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_MARK"]) && !empty($arParams["AUTO_MODEL"]) && !empty($arParams["AUTO_YEAR"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_year';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"].'_year_'.$arParams["AUTO_YEAR"];

	if(is_array($arResult["YEAR"])){
		foreach($arResult["YEAR"] as $key => $arValue)
		{
			if($arValue["FORMAT_NAME"] == $arParams["AUTO_YEAR"])
				$arParams["AUTO_YEAR"] = $arValue["NAME"];
		}
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT modification FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" AND model = "'.$arParams["AUTO_MODEL"].'" AND "'.$arParams["AUTO_YEAR"].'" BETWEEN beginyear AND endyear GROUP BY modification ORDER BY modification ASC';

		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["MODIFICATION"][] = array( "NAME" => $car["modification"], "FORMAT_NAME" => crc32($car["modification"]),"ID"=>$car["id"] );

		if($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_COMPLECT"]) && $typeFilter)
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_modification';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"].'_year_'.$arParams["AUTO_YEAR"].'_mod_'.$arParams["AUTO_COMPLECT"].'_type_'.$typeFilter;


	$modification = $arParams["AUTO_COMPLECT"];

	if(is_array($arResult["MODIFICATION"])){
		foreach($arResult["MODIFICATION"] as $key => $arValue)
		{
			if($arValue["FORMAT_NAME"] == $arParams["AUTO_COMPLECT"])
				$modification = $arValue["NAME"];
		}
	}

	$modification = str_replace('\\', '\\\\', $modification);

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{

			$strsql = 'select  car.id, tyre.spectype, tyre.front_width, tyre.front_profile, tyre.front_diameter, tyre.back_width, tyre.back_profile, tyre.back_diameter
				from auto_tyrespecifications as tyre, auto_carmodels as car 
				where tyre.carmodel = car.id and car.id = ( select id from auto_carmodels where vendor = "'.$arParams["AUTO_MARK"].'" and model = "'.$arParams["AUTO_MODEL"].'" and "'.$arParams["AUTO_YEAR"].'" BETWEEN beginyear AND endyear and modification = "'.$modification.'" )';
			$res = $DB->Query($strsql, false, $err_mess.__LINE__);

			$arResult["TYPE"]["DEFAULT"] = array();
			$arResult["TYPE"]["ALTERNATIVE"] = array();
			$arResult["TYPE"]["TUNING"] = array();

			while($car = $res->fetch())
			{
				
			}
			if(!$arResult["TYPE"]["DEFAULT"] && !$arResult["TYPE"]["ALTERNATIVE"] && !$arResult["TYPE"]["TUNING"])
			{
				// unset($arResult["TYPE"]);
				$arResult["TYPE"] = array();
			}

		if($cache_time > 0)
		{
			$cache->StartDataCache( $cache_time, $cache_id, $cache_path );
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

$arResult["TYPE_T"] = $typeFilter;

$this->IncludeComponentTemplate();?>
