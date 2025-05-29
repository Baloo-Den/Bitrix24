<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Otus\Integrations\DaData;
use Otus\Helper\Company;
use Bitrix\Bizproc\Activity\BaseActivity;
use Bitrix\Bizproc\FieldType;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Localization\Loc;
use Bitrix\Bizproc\Activity\PropertiesDialog;
class CBPSearchByInnActivity extends BaseActivity
{
    // protected static $requiredModules = ["crm"];
    
    /**
     * @see parent::_construct()
     * @param $name string Activity name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->arProperties = [
            'Inn' => '',
            'ID' => '', // потенциально можно было использовать только rootActivity, без нового параметра
        ];

        $this->SetPropertiesTypes([
            'Text' => ['Type' => FieldType::STRING],
        ]);
    }

    /**
     * Return activity file path
     * @return string
     */
    protected static function getFileName(): string
    {
        return __FILE__;
    }

    /**
     * @return ErrorCollection
     */
    protected function internalExecute(): ErrorCollection 
    {
        $errors = parent::internalExecute();
        global $USER;

            $dadata = new Dadata();
            $dadata->init();
    
            $fields = array("query" => $this->Inn, "count" => 5);
            $response = $dadata->suggest("party", $fields);
            //var_dump($response); exit;
            if(!empty($response['suggestions'])){
                $dataCompany = [
                    "KPP" => $response['suggestions'][0]['data']['kpp'],
                    "FULL_TITLE" => $response['suggestions'][0]['data']['name']['full_with_opf'],
                    "SHORT_TITLE" => $response['suggestions'][0]['data']['name']['short_with_opf'],
                    "INN" => $response['suggestions'][0]['data']['inn'],
                    "OGRN" => $response['suggestions'][0]['data']['ogrn'],
                    "OKPO" => $response['suggestions'][0]['data']['okpo'],
                    "OKTMO" => $response['suggestions'][0]['data']['oktmo'],
                    "ADRESS" => $response['suggestions'][0]['data']['address']['unrestricted_value'],
                ];
                $idCompany = Company::createCompany($dataCompany);
                if($idCompany){
                    $titleCompany = $dataCompany["FULL_TITLE"];
                    $textStatus = 'Компания с ИНН '.$this->Inn.' усппешно добавлена. #'.$idCompany.' '.$titleCompany;
                }else{
                    $textStatus = 'Упс! Что-то пошло не так. Вероятно, компания или реквизиты не были добавлены :(';
                }
            }else{
                $textStatus = 'По ИНН '.$this->Inn.' компания в DaData не найдена, соответственно, привязывать к элементу нечего.';
            }


        if($idCompany){
            CIBlockElement::SetPropertyValueCode($this->ID, "COMPANY", $idCompany);
        }

        $this->preparedProperties['Text'] = $textStatus;
        $this->log($this->preparedProperties['Text']);
    
        return $errors;
    }

    /**
     * @param PropertiesDialog|null $dialog
     * @return array[]
     */
    public static function getPropertiesDialogMap(?PropertiesDialog $dialog = null): array
    {
        $map = [
            'Inn' => [
                'Name' => Loc::getMessage('SEARCHBYINN_ACTIVITY_FIELD_SUBJECT'),
                'FieldName' => 'inn',
                'Type' => FieldType::STRING,
                'Required' => true,
                'Options' => [],
            ],
            'ID' => [
                'Name' => Loc::getMessage('SEARCHBYINN_ACTIVITY_FIELD_ID'),
                'FieldName' => 'ID',
                'Type' => FieldType::STRING,
                'Required' => true,
                'Options' => [],
            ],
        ];
        return $map;
    }
}