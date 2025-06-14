<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'external_id',
        'external_shop',
        'created_at_external',
        'updated_at_external',
        'body_xml',
        'status',
        'sync',
        'key',
        'main_shop_key',
    ];
}
