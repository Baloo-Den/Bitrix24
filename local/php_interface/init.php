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
include_once __DIR__ . '/js/scripts.php';
if(file_exists(__DIR__.'/classes/autoload.php')){
    require_once __DIR__. '/classes/autoload.php';
}
\Bitrix\Main\UI\Extension::load('jquery3');
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

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

//Обработка событий
require dirname(__FILE__) . '/event_handler.php';

function addFileLog($text, $path)
{
    file_put_contents($path, $text . PHP_EOL, FILE_APPEND);
}
function getGroupUser()
{
    $id_groups= \Bitrix\Main\Engine\CurrentUser::get()->getUserGroups();//Получаем все группы пользователя
    if (in_array(10, $id_groups))//10 - Идешкa руководства    
        return true;
    else
        return false;
}
function getIdUserFromUrl()
{
    $url_begin = explode("/", $_SERVER['HTTP_REFERER']);
    return $url_begin[6];
}