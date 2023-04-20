<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cbrf;
use Illuminate\Http\Request;

class CbrfController extends Controller
{
    //
    public function index() {
        return Cbrf::all();
    }
}
