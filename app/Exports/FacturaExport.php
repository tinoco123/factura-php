<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;

class FacturaExport implements FromCollection
{
    protected $fechaInicio;
    protected $fechaFin;
    public function __construct(string $fechaInicio = null, string $fechaFin = null){
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query =  Factura::with(["emisor:id,nombre_empresa,rfc", "receptor:id,nombre_empresa,rfc", "pago:id,monto,created_at", "conceptos:id,factura_id,nombre_producto,cantidad,precio_unitario,tipo"])->getQuery();
        return $query->whereBetween("created_at", [$this->fechaInicio, $this->fechaFin])->get();
    }
}
