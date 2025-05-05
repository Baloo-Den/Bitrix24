<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 

$APPLICATION->IncludeComponent(
	'bitrix:main.ui.grid',
	'',
	[
		'GRID_ID'             => 'MY_GRID_ID',
		'COLUMNS'             => $arResult["COLUMNS"],
		'ROWS'                => $arResult["LISTS"],
		'AJAX_MODE'           => 'Y',
		'AJAX_OPTION_JUMP'    => 'N',
		'AJAX_OPTION_HISTORY' => 'N',
        'TOTAL_ROWS_COUNT'    => $arResult["COUNT"],
	]
);

?>


