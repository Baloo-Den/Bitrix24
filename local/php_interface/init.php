<?php
if (file_exists(__DIR__."/../../vendor/autoload.php")) 
{
    require_once(__DIR__."/../../vendor/autoload.php");
}
if (file_exists(__DIR__."/src/autoloader.php")) 
{
    require_once(__DIR__."/src/autoloader.php");
}

include_once __DIR__ . '/../app/autoload.php';
if ($APPLICATION->GetCurDir()=='/stream/')//Если это лента, выводим температуру
{
    ob_start();

    $APPLICATION->IncludeComponent(
        "weather",
        "",
    );
    $customHtml = ob_get_clean();
    
    $APPLICATION->AddViewContent('sidebar', $customHtml, 100);//sidebar - расположение, 100- Сортировка, она же расположение
}
