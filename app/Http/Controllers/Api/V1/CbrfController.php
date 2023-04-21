<?php

namespace App\Http\Controllers\Api\V1;

use App\cbr\cbr;
use App\Http\Controllers\Controller;
use App\Models\Cbrf;
use Illuminate\Http\Request;

class CbrfController extends Controller
{
    public function index(Request $request) {

        $get_params = $request->query();

        $valute = $get_params['valute'];
        $date = $get_params['date'];

        $cbr = new cbr($date);

        $xml = $cbr->getCbrXml();

        $all_valute_array = $cbr->xmlToJson($xml);

        return $cbr->getValute($valute, $all_valute_array);

    }
}
