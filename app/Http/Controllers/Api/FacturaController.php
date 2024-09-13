<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use Codedge\Fpdf\Fpdf\Fpdf;
use Exception;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::with(["conceptos", "emisor", "receptor", "pago"])->get();
        return response()->json($facturas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function generateFacturaPdf(int $id)
    {
        try {
            $factura = Factura::with(["emisor", "receptor", "pago", "conceptos"])->findOrFail($id);

            $pdf = new Fpdf();
            $pdf->AddPage();
            $pdf->SetFont("Arial","B",12);
            $pdf->MultiCell(0, 10, "Reporte de factura:" , 1, "C");
            $pdf->MultiCell(0, 10, "Folio: $factura->folio ", 1,);
            $pdf->Cell(35, 10, "Moneda: $factura->moneda", 1);
            $pdf->Cell(60, 10, "Tipo de cambio: $factura->tipo_cambio", 1);            
            $pdf->Cell(95, 10, "Fecha de creacion: $factura->fecha_creacion", 1, 1);
            $pdf->Cell(95, 10, "Emisor: " . $factura->emisor->nombre_empresa, 1);
            $pdf->Cell(95, 10, "Emisor RFC: " . $factura->emisor->rfc, 1, 1);
            $pdf->Cell(95, 10, "Receptor: " . $factura->receptor->nombre_empresa, 1);
            $pdf->Cell(95, 10, "Receptor RFC: " . $factura->receptor->rfc, 1, 1);
            $pdf->Cell(95, 10, "Monto de Pago: " . $factura->pago->monto, 1);
            $pdf->Cell(95, 10, "Fecha de pago: " . $factura->pago->created_at, 1, 1);
            $pdf->Cell(0, 10, "CONCEPTOS:", 1, 1, "C");
            $pdf->Cell(47.5, 10, "PRODUCTO/SERVICIO", 1, align:"C");
            $pdf->Cell(47.5, 10, "CANTIDAD", 1, align:"C");
            $pdf->Cell(47.5, 10, "PRECIO UNITARIO", 1, align:"C");
            $pdf->Cell(47.5, 10, "TIPO", 1, 1, "C");
            foreach ($factura->conceptos as $concepto){
                $pdf->Cell(47.5, 10, $concepto->nombre_producto, 1, align:"C");
                $pdf->Cell(47.5, 10, $concepto->cantidad, 1, align:"C");
                $pdf->Cell(47.5, 10, $concepto->precio_unitario, 1, align:"C");
                $pdf->Cell(47.5, 10, $concepto->tipo, 1, 1, "C");                
            }
            $pdf->Cell(0, 10, "COMENTARIOS:", 1, 1, "C");
            $pdf->MultiCell(0, 30, $factura->comentario, 1,);
            
            
            $pdfBuffer = $pdf->Output("S");

            return response($pdfBuffer)->header("Content-Type","application/pdf")->header("Content-Disposition","inline; filename='factura.pdf'");
        } catch(ModelNotFoundException $exception){
            return response()->json(["error" => "La factura no fue encontrada"], 404);
        } catch(Exception $exception){
            return response()->json(["error" => "Error desconocido"], 500);
        }

    }
}
