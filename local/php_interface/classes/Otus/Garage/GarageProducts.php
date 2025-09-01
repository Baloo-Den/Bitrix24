<?php
namespace Otus\Garage;
\Bitrix\Main\Loader::includeModule('sale');
use Bitrix\Catalog\ProductTable;
use Bitrix\Catalog\PriceTable;

/**
 * GarageProducts
 */
class GarageProducts
{    
    
    /**
     * getAllProducts
     *
     * @return void
     */

    public static function getAllProducts()//Метод получения всех товаров
    {
        $arrAllProducts = \Bitrix\Catalog\ProductTable::getList([
            'select' => [
                'ID'
            ],
        ]);

        $catalog = [];
        while($elem = $arrAllProducts->fetch())
        {
            $catalog[] = $elem['ID'];
        }
        return $catalog;
    }    
    
    /**
     * getAllPrices
     *
     * @param  mixed $arrId
     * @return void
     */

    public static function getAllPrices($arrId)//
    {
        $prices = PriceTable::getList([
            'filter'=> ['PRODUCT_ID' => $arrId],
            'select' => [
                'PRODUCT_ID',
                'PRICE',
            ],
            'order' => [
                'PRODUCT_ID' => 'ASC'
            ]
        ]); 
        $catalog = [];
        while($elem = $prices->fetch())
        {
            $catalog[$elem['PRODUCT_ID']] = $elem['PRICE'];
        }
        return $catalog;               
    }    

    /**
     * getOstatki
     *
     * @param  mixed $productId
     * @return void
     */

    public static function getOstatki($productId)//
    {
        $result = \Bitrix\Catalog\ProductTable::getList(array(

            'filter' => array('=ID'=>$productId),

        ));



        if($product=$result->fetch())

        {

            $amount = $product['[QUANTITY]'];

        }        

        return $amount;               
    }   

    /**
     * getRnd
     *
     * @return void
     */

    public static function getRnd()//Генератор случайных чисел
    {
        $httpClient = new \Bitrix\Main\Web\HttpClient();
        $url = 'https://www.random.org/integers/?num=1&min=0&max=10&col=1&base=10&format=plain&rnd=new';
        $response = $httpClient->get($url);
        if ($response !== false) {
            return trim($response); 
        } else {
            $error = $httpClient->getError();
            throw new \Exception('Ошибка при выполнении запроса: ' . implode(', ', $error));
        }
    }    

    /**
     * updateProduct
     *
     * @param  mixed $id_product
     * @param  mixed $quantity
     * @return void
     */

    public static function updateProduct($id_product, $quantity)//Обновление остатков  
    {
        
    $result=\Bitrix\Catalog\ProductTable::update($id_product,array(
            'QUANTITY'=>$quantity,
        )); 
    if ($result->isSuccess())
        return true;
    else
        return false;        
    }   

    /**
     * logProducts
     *
     * @param  mixed $idProducts
     * @param  mixed $int
     * @return void
     */
    
    public static function logProducts($idProducts, $int)//
    {
        $text='Товару с id-'.$idProducts.' установлено количество '.$int;
        \Bitrix\Main\Diag\Debug::writeToFile($text,'Var','/local/cron/log.log');
    }
}