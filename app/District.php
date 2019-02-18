<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 * @package App
 */
class District extends Model
{
    protected $fillable = [
        'name',
        'population',
        'city',
        'area',
    ];
}
