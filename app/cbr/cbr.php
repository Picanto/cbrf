<?php

namespace App\cbr;

class cbr {

    private $cbr_xml = 'https://www.cbr.ru/scripts/XML_daily.asp?date_req=';
    private $date;

    public function __construct($date) {
        $this->date = $date;
    }

    private function getDate() {
        return $this->date;
    }

    public function getCbrXml() {
        $full_url = $this->cbr_xml . $this->getDate();
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

    public function getValute($name, $array) {

        if(is_null($name) || $name === 'all') {

            $all_valutes = [];

            foreach($array as $item) {
                $all_valutes[] = ['CharCode' => $item['CharCode'],
                    'Name'  => $item['Name'],
                    'Value' => $item['Value'],
                    'Date'  => $this->date
                ];
            }

            return $all_valutes;

        }

        foreach($array as $item) {

            if($item['CharCode'] === $name) {
                return ['CharCode' => $item['CharCode'],
                        'Name'  => $item['Name'],
                        'Value' => $item['Value'],
                        'Date'  => $this->date
                ];
            }

        }

    }

}
