<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kakeibo extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'bank' => 'required',
        'total' => 'required',
        'date' => 'required',
        'category' => 'required',
        'amount' => 'required',
    );
}
