<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'charcode',
        'value',
        'date',
        'uid',
        'comment',
        'created_at',
        'updated_at'
    ];

}
