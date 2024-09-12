<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;

class Pago extends Model
{
    use HasFactory;

    public function factura(){
        return $this->hasOne(Factura::class);
    }
}
