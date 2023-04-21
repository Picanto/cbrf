<?php

namespace App\cbr;

use function Monolog\toArray;

class cbr {

    private $cbr_xml = 'https://www.cbr.ru/scripts/XML_daily.asp?date_req='; // 20/04/2023

    public function __construct() {

    }

    public function getCbrXml($date) {
        $full_url = $this->cbr_xml . $date;
        $xml_string = file_get_contents($full_url);
        return $xml_string;
    }

    public function xmlToJson($xml_string) {
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json,TRUE);

        return $json['Valute'];

        // return $json['Valute'][0]['CharCode'] . $json['Valute'][0]['Name'] . $json['Valute'][0]['Value'];
    }

}
