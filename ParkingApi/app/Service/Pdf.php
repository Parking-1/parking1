<?php
namespace App\Service;

use App\Interface\IPdf;
use Illuminate\Http\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf implements IPdf{
    private function options() : Options{
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        return $options;
    }
    public function Body($data, $tipo) : Response{
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdf.body', ["data" => $data, "tipo" => $tipo]));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->setOptions($this->options());
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        return $dompdf->stream('document.pdf');
    }
}
