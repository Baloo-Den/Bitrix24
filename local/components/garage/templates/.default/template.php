<?php
use Bitrix\Main\Localization\Loc;
use Otus\Garage\GarageFactory;
Loc::loadMessages(__FILE__); //
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
 $group=getGroupUser();
   
echo '<div class="row">';
if(is_array($arResult ["LISTS"]) && count($arResult ["LISTS"])>0 )
echo '<H2>Ваши машины в гараже</H2>';
foreach ($arResult ["LISTS"] as $el)
{
    echo '<div id="'.$el["data"]["id"].'" class="full_info col-md-4">'; 
    echo '<img width="50%"  src="'. $el["data"]["MODELS_LISTS_GARAGE_AUTO_image"].'">'.'<BR>';
    echo Loc::getMessage('VENDOR').$el["data"]["MODELS_LISTS_GARAGE_AUTO_vendor"].' '.$el["data"]["MODELS_LISTS_GARAGE_AUTO_model"].' '.$el["data"]["MODELS_LISTS_GARAGE_AUTO_modification"].'<BR>';
    echo Loc::getMessage('YEAR').$el["data"]["year"].'<BR>';
    echo Loc::getMessage('PROBEG').$el["data"]["probeg"].' км.<BR>';
    echo Loc::getMessage('COLOR').$el["data"]["color"].'<BR>';
    echo Loc::getMessage('GOS_NUMBER').$el["data"]["gos_number"].'<BR>';
    echo '<div id="result'.$el["data"]["id"].'"></div>';
    if (!$group)
    echo '<button class="btn-primary add_new_deal" id="'.$el["data"]["id"].'"><span>'.Loc::getMessage('SEND_AUTO_MASTER').'</span></button>';
    echo '</div>';
   
}
echo '</div>';
if ($group)
{
 ?>
     <script>
    $(".full_info").click(function(){

        let id = $(this).attr('id');
        $.ajax( {
        type: "POST",
        url: "/local/ajax/history.php",
            data: {"id":id},
            success: function(html){  
            $("#result"+id).html(html); 
                            } 
        });   
    });	
    </script>
    <? }
    else
    { ?>
      <script>
    $(".add_new_deal").click(function(){

        let id = $(this).attr('id');
        $.ajax( {
        type: "POST",
        url: "/local/components/auto.list.tires2/ajax/new_auto.php",
            data: {"id":id,"dest":'service'},
            success: function(html){  
            $("#result"+id).html(html); 
                            } 
        });   
    });	
    </script>       
    <?}