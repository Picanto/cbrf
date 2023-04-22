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
        $xml = $cbr->getCbrXml();

        $all_valute_array = $cbr->xmlToJson($xml);

        if($save === 'true') {

            foreach($cbr->getValute($valute, $all_valute_array) as $item) {


                $valutes = new Valutes();
                // echo $item['CharCode'] . ' ' . $item['Value'];
                $valutes->charcode = $item['CharCode'];
                $valutes->value = $item['Value'];
                $valutes->date = Carbon::createFromFormat('d/m/Y', $date);
                $valutes->uid = md5($date.$item['CharCode']);
                $valutes->comment = $comment;
                // return $valutes->getTable();
                $valutes->save();
            }

        }

    }
}
