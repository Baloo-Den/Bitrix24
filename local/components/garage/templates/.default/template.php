<?php
use Bitrix\Main\Localization\Loc;
use Otus\Garage\GarageFactory;
Loc::loadMessages(__FILE__); //
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$_SESSION['id_user_avto']=getIdUserFromUrl(); 
 $group=getGroupUser();
   
echo '<div class="row">';
if(is_array($arResult ["LISTS"]) && count($arResult ["LISTS"])>0 )
echo '<H2>'.Loc::getMessage('AVTO_IN_GARAGE').'</H2>';//
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
    echo '<a href="/avtoservice/?id_avto='.$el["data"]["id"].'" class="btn-primary">'.Loc::getMessage('SEND_AUTO_MASTER').'</a>';
    echo '</div>';
   
}
echo '</div>';
echo '<BR>';
echo '<button class="show_panel btn btn-info">'.Loc::getMessage('ADD_AVTO').'</button>'; //Добавить машину в гараж
//if ($group)
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
    //else
    { ?>
      <script>

$('.show_panel').click(function () {
    BX.SidePanel.Instance.open("/local/ajax/sidepanel.php?destination=new_avto", {
        requestMethod: "post",
        allowChangeHistory: false,
        width: 500,
        cacheable: true,
        mobileFriendly: true,
        allowChangeHistory: false,
        label: {
            text: "Закрыть панель",
            color: "#FFFFFF",
            bgColor: "#E2AE00",
            opacity: 80
        },
    });
});	    
    </script>       
    <?}