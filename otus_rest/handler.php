<?php
require_once(__DIR__ . '/CRest/crest.php');

//CRest::setLog($_REQUEST);
if (isset($_REQUEST['event']) && $_REQUEST['event'] === 'ONCRMACTIVITYADD')//Проверяем подписку на событие 
{
    $activityId = $_REQUEST['data']['FIELDS']['ID'];//Выцепляем айдишник активити
    $activity = CRest::call('crm.activity.get', ['id' => $activityId]);
    if ($activity && isset($activity['result']['OWNER_ID']))
     {
        $contactId = $activity['result']['OWNER_ID'];//Выцепляем айдишник контакта
        $ownerType = $activity['result']['OWNER_TYPE_ID'];//Выцепляем айдишник сущности

        if ($ownerType == 3) //Если соответствует контактам
        {
            $currentDate = date('Y-m-d H:i:s');
            $updateResult = CRest::call('crm.contact.update', [
                'id' => $contactId,
                'fields' => ['UF_CRM_1751258998202' => $currentDate]
            ]);//Обновляем поле «Дата последней коммуникации»
        }
    }
}
