<?php

namespace App\Http\Controllers\Api\V1;

use App\cbr\cbr;
use App\cbr\cbrDto;
use App\Http\Controllers\Controller;
use App\Models\Cbrf;
use App\Models\Valutes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CbrfController extends Controller
{

    public function index(Request $request) {

        $get_params = $request->query();

        $cbrDto = new cbrDto($get_params);

        $date = $cbrDto->getDate();
        $valute = $cbrDto->getValute();
        $save = $cbrDto->getSave();
        $comment = $cbrDto->getComment();

        $cbr = new cbr($date);

        // Если валюта указана (запрос для одной валюты)
        if(!is_null($valute)) {

            $valuteFromDataBase = $cbr->checkInDataBase($date, $valute);

//            var_dump($valuteFromDataBase);
//            exit();

            // Проверить наличие валют в таблице для минимизации запросов ко внешнему сервису
            if ($valuteFromDataBase) {
                return $valuteFromDataBase;
            } else {
                // Если не найдено в таблице, то загрузить с сайта
                $xml = $cbr->getCbrXml();
                $all_valute_array = $cbr->xmlToJson($xml);

                $valuteArray = $cbr->getValute($valute, $all_valute_array, $comment);

                if($save === 'true') {
                    $cbr->saveToDataBase($valuteArray);
                }

                return $valuteArray;
            }

        } else {
            // Иначе, если валюта не указана, то запрос ко всем валютам

            $valuteFromDataBase = $cbr->checkInDataBase($date, $valute);

            $charCodesFromDataBase = [];

//            var_dump($valuteFromDataBase);
//            exit();

            // Список валют, которые есть в базе
            for($i = 0; $i < count($valuteFromDataBase); $i++) {
                // if(array_key_exists('charcode', $valuteFromDataBase)) {
                    // var_dump($valuteFromDataBase[$i][0]['charcode']);
                $charCodesFromDataBase[] = $valuteFromDataBase[$i][0]['charcode'];
                // }

            }

            //--------------------------------------------
//            // Если не найдено в таблице, то загрузить с сайта
//            $xml = $cbr->getCbrXml();
//            $all_valute_array = $cbr->xmlToJson($xml);
//
//            $valuteArray = $cbr->getValute($valute, $all_valute_array, $comment);
//
//            var_dump($valuteArray);
//            exit();
//
//            if($save === 'true') {
//                // $cbr->saveToDataBase($valuteArray);
//            }
//
//            return $valuteArray;
            //--------------------------------------------

            // получить коды всех валют
            $allCharCodes = $cbr->getAllCodes();

            // var_dump($charCodesFromDataBase);

            // найти разницу в кодах валют и валют в базе данных
            $arrayDiff = array_values(array_diff($allCharCodes, $charCodesFromDataBase));

//            var_dump('arrayDiff');
//            var_dump($arrayDiff);
//            exit();

            $valuteArray = [];

            for($i = 0; $i < count($arrayDiff); $i++) {
                // Если не найдено в таблице, то загрузить с сайта
                $xml = $cbr->getCbrXml();
                $all_valute_array = $cbr->xmlToJson($xml);
                // $valuteArray[] = $cbr->getValute($arrayDiff[$i], $all_valute_array, $comment);

                if($save === 'true') {
                    $cbr->saveToDataBase($cbr->getValute($arrayDiff[$i], $all_valute_array, $comment));
                }
            }

//            var_dump(count($valuteArray));
////            var_dump($valuteArray);
//            exit();

            // for($i = 0; $i < count($valuteArray); $i++) {
//                if($save === 'true') {
//                    // сохранить в базу данных, если стоит флаг 'save'
//                    $cbr->saveToDataBase($valuteArray);
//                    // var_dump($valuteArray[$i][0]);
//                }
            // }

//            var_dump($valuteArray[0][0]);
//            exit();

            // если в базе данных ничего не найдено, то загрузить с сайта
            if(empty($valuteFromDataBase)) {
                $xml = $cbr->getCbrXml();
                $all_valute_array = $cbr->xmlToJson($xml);
                $valuteArray = $cbr->getValute($valute, $all_valute_array, $comment);
                return $valuteArray;
            }
//            var_dump($valuteFromDataBase);
//            exit();

            // if(empty($valuteArray)) {
                return $valuteFromDataBase;
                // return $cbr->checkInDataBase_2($date, $valute);
            // }

            // return $valuteArray;

//            exit();

//            var_dump($valuteFromDataBase);
//            exit();

        }

    }

}
