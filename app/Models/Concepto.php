<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Iva;
use App\Models\Factura;

class Concepto extends Model
{
    use HasFactory;

    public function iva(){
        return $this->belongsTo(Iva::class);
    }

    public function factura(){
        return $this->belongsTo(Factura::class);    
    }
}
