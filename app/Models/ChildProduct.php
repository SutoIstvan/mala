<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildProduct extends Model
{
    protected $fillable = [
        'sku',
        'parent_product_id',
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
    // protected $dates = [
    //     'create_time',
    //     'last_mod_time',
    // ];

    // protected $casts = [
    //     'params' => 'array',
    //     'variants' => 'array',
    //     'images' => 'array'
    // ];

    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }
    
}
