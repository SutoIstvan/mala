<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'unas_id',
        'state',
        'name',
        'price',
        'unit',
        'url',
        'qty',
        'category',
        'description',
        'images',
        'params',
        'variants',
        'statuses',
        'history',
        'types',
        'datas',
        'create_time',
        'last_mod_time',
    ];

    // Если вы хотите автоматически преобразовывать поля create_time и last_mod_time в Carbon
    protected $dates = [
        'create_time',
        'last_mod_time',
    ];
}
