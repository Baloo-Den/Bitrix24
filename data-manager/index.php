<?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle('Пациенты');

    use Bitrix\Main\Type;
    use Bitrix\Main\Entity\Query;
    use Models\Lists\HospitalClientsTable as Clients;
    \Bitrix\Main\UI\Extension::load("ui.bootstrap4");

    $q = new Query(Clients::getEntity());// регистрируем новое временное поле для исходной сущности
        $q->registerRuntimeField(
            'USER',
        array(
            'data_type' => 'Bitrix\Main\UserTable', // тип — сущность ElementTable
            'reference' => array('=this.contact_id' => 'ref.id'),// this.ID относится к таблице, относительно которой строится запрос 
            'join_type' => 'INNER'// тип соединения INNER JOIN
        )
    );
    $q->registerRuntimeField(
        'PROCEDURA',
        array(
            'data_type' => 'Models\Lists\HospitalProceduresTable', // тип — сущность ElementTable
            'reference' => array('=this.procedure_id' => 'ref.id'),
            'join_type' => 'INNER'
        )
    );
       
    $q->setSelect(array('contact_id', 'USER.name', 'USER.last_name','DOCTORS', 'PROCEDURA'));//Выбираем имя и фамилию из пользователей, данные о врачах и процедурах
    $q->setCacheTtl(3600); // Включаем кеш
    $q->cacheJoins(mode:true); //Запрос с джойном для кэширования обязателен
    $result = $q->exec(); // выполняем запрос

    ?>
<div class="container">     
<table class="table table-hover">
  <thead class="thead-hover ">
    <tr>
      <th scope="col">Имя пациента</th>
      <th scope="col">Фамилия пациента</th>
      <th scope="col">Фамилия лечащего врача</th>
      <th scope="col">Процедура</th>
    </tr>
  </thead>
  <tbody>
      <?php
        while ($row = $result->fetch()) 
        {
            echo '<tr>';
            echo '<td>'.$row["MODELS_LISTS_HOSPITAL_CLIENTS_USER_NAME"].'</td>';
            echo '<td>'.$row["MODELS_LISTS_HOSPITAL_CLIENTS_USER_LAST_NAME"].'</td>';
            echo '<td>'.$row["MODELS_LISTS_HOSPITAL_CLIENTS_DOCTORS_FIRST_NAME"].'</td>';
            echo '<td>'.$row["MODELS_LISTS_HOSPITAL_CLIENTS_PROCEDURA_name"].'</td>';
            echo '</tr>';
        }
?>
  </tbody>
</table>
  </tbody>
</table>
</div> 
    <?php
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>