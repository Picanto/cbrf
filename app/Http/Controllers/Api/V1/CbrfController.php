<?php

namespace App\Http\Controllers\Api\V1;

use App\cbr\cbr;
use App\cbr\cbrDto;
use App\Http\Controllers\Controller;
use App\Models\Cbrf;
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

//        var_dump($date);
//        var_dump($valute);
//        exit();

//        $valute = $get_params['valute'];
//        $date = $get_params['date'];
//
        $cbr = new cbr($date);
//
        $xml = $cbr->getCbrXml();

//        var_dump($xml);
//        exit();
//
        $all_valute_array = $cbr->xmlToJson($xml);

//        return $all_valute_array;
//
        return $cbr->getValute($valute, $all_valute_array);

    }
}
