<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


$arComponentDescription= [
    "NAME" => GetMessage("COMP_NAME"),
    "DESCRIPTION" => GetMessage("OUTPUT_CURRENCIES"),
    "ICON" => "/images/news_list.gif",
    "SORT" => 20,
    "CASH_PATH" => 'Y',
    "PATH" => [
        'ID' => 'otus',
        "CHILD" => [
            "ID" => 'currencies',
            "NAME" => GetMessage("CURRENCIES_NAME"),
            "SORT" => 10,
        ]
    ]
];








?>