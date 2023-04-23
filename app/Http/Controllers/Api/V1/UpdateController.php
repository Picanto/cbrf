<?php

namespace App\Http\Controllers\Api\V1;

use App\cbr\cbr;
use App\cbr\cbrDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends Controller
{

    public function index(Request $request) {

        $get_params = $request->query();

        $cbrDto = new cbrDto($get_params);

        $uid = $cbrDto->getUid();
        $comment = $cbrDto->getComment();

        $cbr = new cbr('');
        $cbr->updateComment($uid, $comment);

    }

}
