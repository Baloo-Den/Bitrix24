<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Page\Asset;
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
CJSCore::Init(array("jquery")); 
$APPLICATION->SetTitle('Врачи');
Asset::getInstance()->addCss("/doctors/style.css");

    //Получаем список врачей
    $doctors = \Bitrix\Iblock\Elements\ElementdoctorsTable::getList([
        'select' => [
            'ID',
            //'NAME',
            'FIRST_NAME',
            'LAST_NAME',
            'SECOND_NAME',
           //'PROC_IDS_MULTI.ELEMENT.NAME',
        ]
    ])->fetchCollection();
?>
<div class="container">   
    <div class="content row">  
        <div class="col-md-2"><button type="button" class="btn btn-primary form_add_proc">Добавить процедуру</button></div>
        <div class="col-md-2"><button type="button" class="btn btn-primary form_add_doctor">Добавить врача</button></div>
    </div> 
    <h1 class="">Врачи</h1>
    <div class="content row">  
        <?php foreach($doctors as $doctor)
        {
            echo '<div class="doctors_btn_main_page col-md-2" data-doctor_id="'.$doctor->getId().'" data-destination="all_doctor_info">';
            echo $doctor->getFirstName()->getValue().'<BR>';
            echo $doctor->getSecondName()->getValue().'<BR>';
            echo $doctor->getLastName()->getValue();
            echo '</div>';

        }
?>
    </div>  
    <div class="content row" id="output">
    
    </div> 
</div>           
<script>
    
$( ".doctors_btn_main_page" ).on( "click", function() {
   var doctor_id = $(this).data('doctor_id');
   var destination = $( ".doctors_btn_main_page" ).data( "destination" );
   $.ajax( {
      type: "POST",
      url: "ajax.php",
        data: {"destination":destination,"doctor_id":doctor_id},
      	success: function(html){  
        $("#output").html(html);
						} 
    }); 
});
$( ".form_add_proc" ).on( "click", function() {
   var destination = 'form_add_proc';
   $.ajax( {
      type: "POST",
      url: "ajax.php",
        data: {"destination":destination},
      	success: function(html){  
        $("#output").html(html);
						} 
    }); 
});
$( ".form_add_doctor" ).on( "click", function() {
   var destination = 'form_add_doctor';
   $.ajax( {
      type: "POST",
      url: "ajax.php",
        data: {"destination":destination},
      	success: function(html){  
        $("#output").html(html);
						} 
    }); 
});
</script>

    