<?php
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;

try {

    $webhookURL = 'https://www.example.com/rest/1/u7ngxagzrhpuj31a/';
    $bx24 = new Bitrix24API($webhookURL);

    // Добавляем новую сделку
    $dealId = $bx24->addDeal([
        'TITLE'      => 'Новая сделка №1',
        'COMPANY_ID' => 6,
        'CONTACT_ID' => 312
    ]);
    print_r($dealId);

    // Устанавливаем набор связанных контактов
    $bx24->setDealContactItems($dealId, [
        [ 'CONTACT_ID' => 313 ],
        [ 'CONTACT_ID' => 454 ]
    ]);

    // Устанавливаем набор связанных товарных позиций
    $bx24->setDealProductRows($dealId, [
        [ 'PRODUCT_ID' => 1689, 'PRICE' => 1500.00, 'QUANTITY' => 2 ],
        [ 'PRODUCT_ID' => 1860, 'PRICE' => 500.00, 'QUANTITY' => 15 ]
    ]);

    // Обновляем существующую сделку
    $bx24->updateDeal($dealId, [
        'TITLE' => 'Новая сделка №12'
    ]);


    // При необходимости, изменяем значение по умолчанию 'PRODUCTS' на '_PRODUCTS' для имени поля
    // со списком товарных позиций, возвращаемых вместе со сделкой
    Bitrix24API::$WITH_PRODUCTS = '_PRODUCTS';

    // Загружаем сделку по ID вместе со связанными товарами и контактами одним запросом
    $deal = $bx24->getDeal($dealId, [ Bitrix24API::$WITH_PRODUCTS, Bitrix24API::$WITH_CONTACTS ]);
    print_r($deal);

    // Удаляем существующую сделку
    $bx24->deleteDeal($dealId);

    // Загружаем все сделки используя быстрый метод при работе с большими объемами данных
    $generator = $bx24->fetchDealList();
    foreach ($generator as $deals) {
        foreach($deals as $deal) {
            print_r($deal);
        }
    }

    // Пакетно добавляем сделки вместе с товарными позициями
    $dealIds = $bx24->addDeals([
        [
            'TITLE' => 'Новая сделка №1121',
            'COMPANY_ID' => 6,
            'CONTACT_ID' => 312,
            'PRODUCTS' => [
                [ "PRODUCT_ID" => 27, "PRICE" => 100.00, "QUANTITY" => 11 ],
            ]

        ],
        [
            'TITLE' => 'Новая сделка №1122',
            'COMPANY_ID' => 6,
            'PRODUCTS' => [
                [ "PRODUCT_ID" => 28, "PRICE" => 200.00, "QUANTITY" => 22 ],
                [ "PRODUCT_ID" => 27, "PRICE" => 200.00, "QUANTITY" => 11 ],
            ]
        ]
    ]);
    print_r($dealIds);

    // Пакетно удаляем сделки
    $bx24->deleteDeals($dealIds);

} catch (Bitrix24APIException $e) {
    printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (Exception $e) {
    printf('Ошибка (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}