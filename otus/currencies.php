<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Список валют");
$rsCurrency = \Bitrix\Currency\CurrencyTable::getList();

?><?$APPLICATION->IncludeComponent(
	"otus:currencies",
	"",
	Array(
		"CURRENCY" => "978"
	)
);?><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>