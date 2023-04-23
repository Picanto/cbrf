<?php

namespace App\Http\Controllers\Api\V1;

use App\cbr\cbr;
use App\cbr\cbrDto;
use App\Http\Controllers\Controller;
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

            // Список валют, которые есть в базе
            for($i = 0; $i < count($valuteFromDataBase); $i++) {
                $charCodesFromDataBase[] = $valuteFromDataBase[$i][0]['charcode'];
            }

            // получить коды всех валют
            $allCharCodes = $cbr->getAllCodes();

            // найти разницу в кодах валют и валют в базе данных
            $arrayDiff = array_values(array_diff($allCharCodes, $charCodesFromDataBase));

            for($i = 0; $i < count($arrayDiff); $i++) {
                // Если не найдено в таблице, то загрузить с сайта
                $xml = $cbr->getCbrXml();
                $all_valute_array = $cbr->xmlToJson($xml);

                if($save === 'true') {
                    $cbr->saveToDataBase($cbr->getValute($arrayDiff[$i], $all_valute_array, $comment));
                }
            }

            // если в базе данных ничего не найдено, то загрузить с сайта
            if(empty($valuteFromDataBase)) {
                $xml = $cbr->getCbrXml();
                $all_valute_array = $cbr->xmlToJson($xml);
                $valuteArray = $cbr->getValute($valute, $all_valute_array, $comment);
                return $valuteArray;
            }

            return $valuteFromDataBase;
        }

    }

}
