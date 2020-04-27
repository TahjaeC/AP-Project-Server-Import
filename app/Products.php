<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //protected $table = "products";
    protected $fillable=[
        'name',
        'cost',
        'category',
        'stock',
        'item_image',
        'image',
        'audio',
        'created_by'
    ];
}
