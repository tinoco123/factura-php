<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concepto;

class Iva extends Model
{
    use HasFactory;

    public function conceptos(){
        return $this->hasMany(Concepto::class);
    }
}
