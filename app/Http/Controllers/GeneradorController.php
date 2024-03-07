<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class GeneradorController extends Controller
{
    public function imprimir()
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.invoice');
        return $pdf->download('ejemplo.pdf');
    }

}
