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

//    public function checkInDataBase(array $hashIdsArray) {
//
//        $uids = DB::table('valutes')->select('uid')->get();
//
//        $uidsDbArray = [];
//
//        foreach($uids as $item) {
//            $uidsDbArray[] = $item->uid;
//        }
//
////        var_dump($hashIdsArray);
////        var_dump($uidsDbArray);
////        exit();
//
//        // $arrayDiff = array_diff($hashIdsArray, $uidsDbArray);
//
//        // if(empty($arrayDiff)) {
//            // $this->getDataFromDataBase($hashIdsArray);
////            var_dump($this->getDataFromDataBase($hashIdsArray));
////            exit();
//        // }
//
//        return $this->getDataFromDataBase($hashIdsArray);
//
////        return $arrayDiff;
//
//    }

    /**
     * @param $array
     * @return array
     */
    private function getDataFromDataBase($array): array {

        // $records = DB::table('valutes')->where('uid', '038523354f2e28369d4782726da3b9b9');

        // $records = DB::table('valutes')->select('charcode', 'value', 'date', 'uid', 'comment')->get();

//        var_dump($array);
//        exit();

        $records = DB::table('valutes')
                    ->whereIn('uid', $array)
                    ->get();

//        var_dump($records);
//        exit();

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
                // var_dump($this->getDataFromDataBase([$uid]));

                $dataFromDataBase = $this->getDataFromDataBase([$uid]);

                if(!empty($dataFromDataBase)) {
                    $valutesFromDataBase[] = $dataFromDataBase;
                }

                // $valutesFromDataBase[] = $this->getDataFromDataBase([$uid]);

            }

            return $valutesFromDataBase;

//            exit();
        }

//        var_dump($date);
//        var_dump($valute);
//        var_dump(md5($date.$valute));
//        exit();

        $uid = md5($date.$valute);
        return $this->getDataFromDataBase([$uid]);

//        var_dump($this->getDataFromDataBase([$uid]));
//        exit();

    }

    public function saveToDataBase($valuteArray) {

        $tempArray = [];

//        var_dump('<pre>');

        foreach($valuteArray as $item) {

            if(!empty($item)) {
                $tempArray[] = $item;
                // var_dump($item);
            }

        }

//        var_dump($tempArray);

        $valuteArray = $tempArray;

//        exit();
//
//        var_dump('<pre>');
//        // var_dump($valuteArray);
//        var_dump(count($valuteArray));
//        exit();

        foreach($valuteArray as $item) {

//            $valutes = new Valutes();
//            $valutes->charcode = $item[0]['CharCode'] ?? null;
//            $valutes->value = $item[0]['Value'] ?? null;
//            $valutes->date = Carbon::createFromFormat('d/m/Y', $item[0]['Date'] ?? null);
//            $valutes->uid = md5($item[0]['Date'].$item[0]['CharCode']);
//            $valutes->comment = $item[0]['Comment'] ?? null;
//            $valutes->save();

//            var_dump($item['CharCode']);

            $valutes = new Valutes();
            $valutes->charcode = $item['CharCode'];
            $valutes->value = $item['Value'];
            $valutes->date = Carbon::createFromFormat('d/m/Y', $item['Date']);
            $valutes->uid = md5($item['Date'].$item['CharCode']);
            $valutes->comment = $item['Comment'];
            $valutes->save();

        }

//        exit();

    }

}
