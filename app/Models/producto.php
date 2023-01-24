<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $primaryKey='producto_id';
    public $timestamps = false;

    protected $guarded =[];

    public function imagen(){
        return $this->hasMany('\App\Models\imagen');
    }
}
