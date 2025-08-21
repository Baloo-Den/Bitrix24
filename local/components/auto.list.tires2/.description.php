<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("AUTO_LIST_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("AUTO_LIST_COMPONENT_DESCRIPTION"),
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "aspro",
		"NAME" => GetMessage("ASPRO"),
		"SORT" => 30,
	),
);

?>