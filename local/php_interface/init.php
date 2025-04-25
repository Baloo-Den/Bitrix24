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