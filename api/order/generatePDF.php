<?php

function generateOrderPdf($id)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/tecnickcom/tcpdf/tcpdf.php';
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Kantine system');
    $pdf->SetTitle('Bestilling' . $id);
    $pdf->SetSubject('Bestilling' . $id);

    $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->Output('bestilling' . $id . '.pdf', 'F');
}

generateOrderPdf(1);