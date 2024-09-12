<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use Codedge\Fpdf\Fpdf\Fpdf;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::with(["conceptos", "emisor", "receptor"])->get();
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
            $pdf->SetFont("Arial","B",0);
            $pdf->Cell(0, 0, "Reporte de factura:", 1, ln:2);
            $pdf->MultiCell(63, 10, "Folio: $factura->folio", 1);
            $pdf->Cell(0, 0, "Moneda: $factura->moneda", 1);
            $pdf->Cell(0, 0, "Tipo cambio: $factura->tipo_cambio", 1);
            $pdf->Cell(0, 0, "Tipo cambio: $factura->comentario", 1);
            $pdf->Cell(0, 0, "Fecha creacion: $factura->created_at", 1);
            $pdf->Cell(0, 0, "Emisor: " . $factura->emisor->nombre_empresa, 1);
            $pdf->Cell(0, 0, "Emisor RFC: " . $factura->emisor->rfc, 1);
            $pdf->Cell(0, 0, "Receptor: " . $factura->receptor->nombre_empresa, 1);
            $pdf->Cell(0, 0, "Receptor RFC: " . $factura->receptor->rfc, 1);
            $pdf->Cell(0, 0, "Pago: " . $factura->pago->monto, 1);
            $pdf->Cell(0, 0, "Fecha pago: " . $factura->pago->created_at, 1);
            $pdf->Cell(0, 0, "<- " . $factura->conceptos->count() . " Conceptos ->" , 1);
            foreach ($factura->conceptos as $concepto) {

                $pdf->Cell(0, 0, "|Concepto|:" . $concepto->nombre_producto, 1);
                $pdf->Cell(0, 0, "|Tipo: |" . $concepto->tipo, 1);
                $pdf->Cell(0, 0, "|Cantidad: |" . $concepto->cantidad, 1);
                $pdf->Cell(0, 0, "|Precio: |" . $concepto->precio_unitario, 1);

            }
            
            $pdfBuffer = $pdf->Output("S");

            return response($pdfBuffer)->header("Content-Type","application/pdf")->header("Content-Disposition","inline; filename='factura.pdf'");
        } catch(ModelNotFoundException $exception){
            return response()->json(["error" => "La factura no fue encontrada"], 404);
        }

    }
}
