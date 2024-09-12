<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;
use App\Models\Agente;
use App\Models\Concepto;

class Factura extends Model
{
    use HasFactory;

    public function pago(){
        return $this->belongsTo(Pago::class);
    }

    public function emisor(){
        return $this->belongsTo(Agente::class, "emisor_id");
    }

    public function receptor(){
        return $this->belongsTo(Agente::class, "receptor_id");
    }

    public function conceptos(){
        return $this->hasMany(Concepto::class);
    }
}
