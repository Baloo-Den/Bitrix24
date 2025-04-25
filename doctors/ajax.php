<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон
if (! defined ( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die ();
use Bitrix\Iblock\Iblock;
function converter($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    );

    $value = strtr($value, $converter);
    return $value;
}

if ($_REQUEST['destination']=='all_doctor_info')
{
    $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([ // получение списка процедур у врачей
        'select' => [
            'ID',
            'NAME',
            'FIRST_NAME',
            'LAST_NAME',
            'SECOND_NAME',
           'PROC_IDS_MULTI.ELEMENT.NAME',
        ], 
        'filter' => [
            'ID' => $_REQUEST['doctor_id'],
            'ACTIVE' => 'Y',
        ],
    ])
    ->fetchCollection(); 

    foreach($doctors as $doctor)
    {
        echo 'ФИО: '.$doctor->getFirstName()->getValue().' ';
        echo $doctor->getSecondName()->getValue().' ';
        echo $doctor->getLastName()->getValue().'<BR>';

        foreach($doctor->getProcIdsMulti()->getAll() as $prItem) 
        {
            if($prItem->getElement()->getName()!== null)
                $proc[]=$prItem->getElement()->getName();
        }
        $proc = implode(", ", $proc);
        echo 'Процедуры: '.$proc;
    }    
   
}

if ($_REQUEST['destination']=='form_add_proc')
{
    ?>
    <h1 class="doctors_h">Добавление новой процедуры</h1>
    <form id="form_new_proc" method="POST" >
        <label class="doctors_label" for="name">Название процедуры</label>
        <input type="text" name="NAME" id="name">
        <input type="hidden" name="destination" value="new_proc">
        <input class="doctor_input_btn" value="Добавить" id="add">
    </form>
    <script>
    $("#add").click(function(){

        let msg=$('#form_new_proc').serialize();//Считываем поля формы
        $.ajax( {
        type: "POST",
        url: "ajax.php",
            data: msg, 
            success: function(html){  
            $("#output").html(html);
                            } 
        });   
    });	
    </script>
    <?
}

if ($_REQUEST['destination']=='form_add_doctor')
{
    $res = \Bitrix\Iblock\Elements\ElementproceduresTable::getList([
        'select' => ['ID', 'NAME'],
        'order' => ['ID' => 'ASC'],
    ]);

    $procedures = [];
    while ($ar = $res->fetch()) {
        $procedures[$ar['ID']] = $ar['NAME'];
    }    
    ?>
    <h1 class="doctors_h">Добавление нового врача</h1>
    <form id="form_new_doctor" method="POST" class="form_new_doctor">
        <input type="text" class="doctor_input" name="FIRST_NAME" placeholder="Фамилия">
        <input type="text" class="doctor_input" name="SECOND_NAME"placeholder="Имя">
        <input type="text" class="doctor_input" name="LAST_NAME" placeholder="Отчество">
        <input type="hidden" name="destination" value="new_doctor">
        <select id="procedure" name="PROC_IDS_MULTI[]" class="doctor_input_select" multiple>
            <?php foreach($procedures as $id => $name){?>
            <option value="<?php echo $id ?>"><?php echo $name ?></option>
            <?php } ?>
        </select> 
        <input class="doctor_input_btn" value="Добавить" id="add_doc">
    </form>
    <script>
    $("#add_doc").click(function(){
        let msg=$('#form_new_doctor').serialize();//Считываем поля формы
        $.ajax( {
        type: "POST",
        url: "ajax.php",
            data: msg, 
            success: function(html){  
            $("#output").html(html);
                            } 
        });   
    });	
    </script>
    <?
}

if ($_REQUEST['destination']=='new_doctor')
{
        $elementData = [
            'IBLOCK_ID' => 17,
            'NAME' => converter($_POST["FIRST_NAME"]),
            'ACTIVE' => 'Y', 
            'PROPERTY_VALUES' => [
                'FIRST_NAME' => $_POST["FIRST_NAME"],
                'SECOND_NAME' => $_POST["SECOND_NAME"],
                'LAST_NAME' => $_POST["LAST_NAME"],
                'PROC_IDS_MULTI' => $_POST["PROC_IDS_MULTI"],
            ],
        ];

        $el = new CIBlockElement;
        $result = $el->Add($elementData);
        if ($result) 
            echo "Сохранено";
        else 
            echo "Элемент не добавился из-за ошибки: ".$el->LAST_ERROR;
}

if ($_REQUEST['destination']=='new_proc')
{
    $fields = array(
        "NAME" =>$_REQUEST['NAME'],
        "ACTIVE" => "Y", //поумолчанию делаем активным или ставим N для отключении поумолчанию
    );
    
    //Результат в конце отработки
    if (\Bitrix\Iblock\Elements\ElementproceduresTable::add($fields)) 
        echo "Сохранено";
}


