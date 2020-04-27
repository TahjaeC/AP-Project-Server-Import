<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        
        'name',
        'sale'
    ];

    public function getImage(){
        return "images/$this->image";
    }
}
