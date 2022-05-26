<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;



class PDFController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generatePDF()
    {

        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
        
        $pdf = PDF::loadView('pdf.test', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
