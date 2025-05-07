<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
    echo "Температура: ".$arResult['WEATHER']->temp."°C (ощущается как ".$arResult['WEATHER']->feels_like."°C)";    
 ?>