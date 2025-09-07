<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"AUTO_MARK" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_MANUFACTURER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"AUTO_MODEL" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_MODEL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"AUTO_YEAR" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_YEAR"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"AUTO_COMPLECT" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_EQUIPMENT"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"TYPE_FILTER" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"tires" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_TIRES"),
				"wheels" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_WHEELS"),
				"akb" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_AKB")
			),
			"DEFAULT" => "tires",
			"REFRESH" => "Y",
		),
	),
);
?>
