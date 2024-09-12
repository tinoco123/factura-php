<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
class Agente extends Model
{
    use HasFactory;

    public function facturas_emitidas(){
        return $this->hasMany(Factura::class,"emisor_id");
    }

    public function facturas_recibidas(){
        return $this->hasMany(Factura::class,"receptor_id");
    }
}
