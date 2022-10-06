<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $guarded = array('id');

    public static $rules = array(
        'bank' => 'required',
    );
}
