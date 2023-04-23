<?php

namespace App\cbr;

use App\Models\Valutes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class cbr {

    private $cbr_xml = 'https://www.cbr.ru/scripts/XML_daily.asp?date_req=';
    private $date;

    public function __construct($date) {
        $this->date = $date;
    }

    /**
     * @return string[]
     */
    public function getAllCodes(): array {
        $array = ['AUD','AZN','GBP','AMD','BYN','BGN','BRL','HUF','VND','HKD','GEL','DKK','AED','USD','EUR','EGP',
            'INR','IDR','KZT','CAD','QAR','KGS','CNY','MDL','NZD','NOK','PLN','RON','XDR','SGD','TJS','THB','TRY',
            'TMT','UZS','UAH','CZK','SEK','CHF','RSD','ZAR','KRW','JPY'];
        return $array;
    }

    /**
     * @return mixed
     */
    private function getDate() {
        return $this->date;
    }

    /**
     * @return false|string
     */
    public function getCbrXml() {

        $full_url = $this->cbr_xml . $this->getDate();
        $xml_string = file_get_contents($full_url);
        return $xml_string;

    }

    /**
     * @param $xml_string
     * @return mixed
     */
    public function xmlToJson($xml_string) {

        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json,TRUE);

        return $json['Valute'];

    }

    /**
     * @param $name
     * @param $array
     * @return array
     */
    public function getValute($name, $array, $comment) {

        $all_valutes = [];

        if(is_null($name)) {

            foreach($array as $item) {
                $all_valutes[] = ['CharCode' => $item['CharCode'],
                                  'Name'  => $item['Name'],
                                  'Value' => $item['Value'],
                                  'Date'  => $this->date,
                                  'Comment' => $comment
                ];
            }

        }

        foreach($array as $item) {

            if($item['CharCode'] === $name) {
                $all_valutes[] = ['CharCode' => $item['CharCode'],
                                  'Name'  => $item['Name'],
                                  'Value' => $item['Value'],
                                  'Date'  => $this->date,
                                  'Comment' => $comment
                ];
            }

        }

        return $all_valutes;

    }

    /**
     * @param $array
     * @return array
     */
    private function getDataFromDataBase($array): array {

        $records = DB::table('valutes')
                    ->whereIn('uid', $array)
                    ->get();

        $resultArray = [];

        foreach($records as $item) {

            $resultArray[] = ['charcode' => $item->charcode,
                            'value' => $item->value,
                            'date' => $item->date,
                            'uid' => $item->uid,
                            'comment' => $item->comment
            ];

        }

        return $resultArray;

    }

    /**
     * @param $date
     * @param $valute
     * @return array
     */
    public function checkInDataBase($date, $valute): array {

        if(is_null($valute)) {
            $allCodesArray = $this->getAllCodes();

            $valutesFromDataBase = [];

            for($i = 0; $i < count($allCodesArray); $i++) {
                $uid = md5($date.$allCodesArray[$i]);

                $dataFromDataBase = $this->getDataFromDataBase([$uid]);

                if(!empty($dataFromDataBase)) {
                    $valutesFromDataBase[] = $dataFromDataBase;
                }

            }

            return $valutesFromDataBase;

        }

        $uid = md5($date.$valute);
        return $this->getDataFromDataBase([$uid]);

    }

    /**
     * @param $valuteArray
     */

    public function saveToDataBase($valuteArray): void {

        $tempArray = [];

        foreach($valuteArray as $item) {

            if(!empty($item)) {
                $tempArray[] = $item;
            }

        }

        $valuteArray = $tempArray;

        foreach($valuteArray as $item) {

            $valutes = new Valutes();
            $valutes->charcode = $item['CharCode'];
            $valutes->value = $item['Value'];
            $valutes->date = Carbon::createFromFormat('d/m/Y', $item['Date']);
            $valutes->uid = md5($item['Date'].$item['CharCode']);
            $valutes->comment = $item['Comment'];
            $valutes->save();

        }

    }

}
