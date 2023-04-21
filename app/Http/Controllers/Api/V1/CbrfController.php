<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cbrf;
use Illuminate\Http\Request;

class CbrfController extends Controller
{
    //
    public function index() {

        $xml_string = file_get_contents('https://www.cbr.ru/scripts/XML_daily.asp?date_req=20/04/2023');

        $xml = simplexml_load_string($xml_string);

        $json = json_encode($xml);

        $array = json_decode($json,TRUE);

        $count = count($array['Valute']);

        return $array['Valute'];

        // return $array['Valute'][$count-1];

        // return 1; // Cbrf::all();
    }
}
