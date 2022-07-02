<?php
// https://github.com/andrey-tech/bitrix24-api-php#%D0%9C%D0%B5%D1%82%D0%BE%D0%B4%D1%8B-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%8B-%D1%81%D0%BE-%D1%81%D0%B4%D0%B5%D0%BB%D0%BA%D0%B0%D0%BC%D0%B8

require __DIR__ . '/vendor/autoload.php';

use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;

try {
    // https://zelinskygroup.bitrix24.ru/devops/edit/in-hook/417/
    $file_Name = __DIR__ . '/webHookURL.txt';
    $webHookURL = file_get_contents($file_Name);

    print_r($file_Name);

    $bx24 = new Bitrix24API($webHookURL);

    $filter = ['%TITLE' => 'Мих'];
    $select = ['ID', 'TITLE'];
    $order_ = ['ID' => 'ASC'];

    // Загружаем все сделки используя быстрый метод при работе с большими объемами данных
    $generator = $bx24->fetchDealList($filter, $select, $order_);

//    учуся
    $deal = $bx24->getDeal(22843);
    print_r($deal['ID']);

//    foreach ($generator as $deals) {
//        foreach ($deals as $deal) {
//            // print_r($deal);
//            $dealId = '';
//            // Загружаем сделку по ID вместе со связанными товарами и контактами одним запросом
//            $deal = $bx24->getDeal($dealId);
//            print_r($deal);
//
//            //    // Обновляем существующую сделку
////    $bx24->updateDeal($dealId, [
////        'TITLE' => 'Новая сделка №12'
////    ]);
//
//        }
//    }


} catch (Bitrix24APIException $e) {
    printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (Exception $e) {
    printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}