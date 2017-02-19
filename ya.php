<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 19.02.2017
 * Time: 16:48
 * Реализовать сервис по определению широты и долготы по адресу.
 * Внешний вид на ваше усмотрение. Опубликовать сервис на своем учебном хостинге.
 * Предоставить ссылку на рабочий пример и ссылку на исходный код проекта (github, bitbucket, cloud9).

DONE - Установить Composer.
 * composer.org/download скачать
 * указать php.ini при установке
 * в этом файле раскомментить
 * --- extension_dir = "ext"
 * --- extension=php_curl.dll
 * --- extension=php_mbstring.dll
 * --- extension=php_openssl.dll
 *
DONE - Установить библиотеку yandex/geo.
 * cmd
 * cd neto-5.1
 * composer init
 * composer require
 *
DONE - Создать форму с полем: “Адрес” и кнопкой “Найти”.
- Используя API yandex, вывести все варианты ширОТы и долготы

 */
require "vendor/autoload.php";

if (!empty($_GET["getaddr"])) {
    $addr = (string) $_GET["getaddr"];
    $yandexgeoapi = new Yandex\Geo\Api();
// https://packagist.org/packages/yandex/geo
    $yandexgeoapi->setQuery($addr);

    // Настройка фильтров
    $yandexgeoapi
        ->setLimit(100) // кол-во результатов
        ->setLang(\Yandex\Geo\Api::LANG_RU) // локаль ответа
        ->load();

    $response = $yandexgeoapi->getResponse();
    $response->getFoundCount(); // кол-во найденных адресов
    $response->getQuery(); // исходный запрос
    $response->getLatitude(); // широта для исходного запроса
    $response->getLongitude(); // долгота для исходного запроса

// Список найденных точек
    $collection = $response->getList();
    //var_dump($collection);
    foreach ($collection as $item) {
        echo "Адрес: ".$item->getAddress()."<br>"; // вернет адрес

        echo "Широта: ".$item->getLatitude()."<br>"; // широта
        echo "Долгота: ".$item->getLongitude()."<br>"; // долгота
        //echo $item->getData()."<br>"; // необработанные данные
    }
}

$html = <<<FORM_FIND
<form name="yandexGeoSearching" method="get">
    <label for="getaddr">Введите адрес:</label>
    <input type="text" size="40" name="getaddr" autofocus>
    <input type="submit" value="Найти">
</form>
FORM_FIND;
echo $html;
