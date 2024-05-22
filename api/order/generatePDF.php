<?php

function generateOrderPdf($id)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/tecnickcom/tcpdf/tcpdf.php';
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Kantine system');
    $pdf->SetTitle('Bestilling' . $id);
    $pdf->SetSubject('Bestilling' . $id);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setHeaderData("$",0, "Kuben kantine system");
    $pdf->addPage();

    $html = generateHTML($id);
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output($_SERVER["DOCUMENT_ROOT"] . '/order_pdfs/bestilling' . $id . '.pdf', 'F');

    return $_SERVER["DOCUMENT_ROOT"] . '/order_pdfs/bestilling' . $id . '.pdf';
}

function generateHTML($id)
{
    require "../DB.php";
    // this is a bit unoptimal :(
    $order = $conn->query("SELECT * FROM bestillinger WHERE id = '$id'")->fetch_assoc();
    $html = "<h4>Bestilling #" . $id . "</h4>";

    // henter avdeling
    $avdelingID = $order['avdeling'];
    $avdeling = $conn->query("SELECT * FROM avdelinger WHERE id = '$avdelingID' ")->fetch_assoc();
    $html .= "<h4>Avdeling: " . $avdeling["nanv"] . "</h4>";

    // henter avsender
    $userid = $order['bruker_id'];
    $user = $conn->query("SELECT * FROM users WHERE id = '$userid'")->fetch_assoc();
    $html .= "<h4>Kunde: " . $user['email'] . "</h4>";

    // totalpris
    $html .= "<h4>Total pris: " . $order['total_pris'] . " Kr</h4>";

    $allProducts = $conn->query("SELECT * FROM vare_bestilling WHERE bestilling_id = '$id'")->fetch_all(1);
    $allCat = $conn->query("SELECT * FROM kategorier")->fetch_all(1);

    foreach ($allCat as $cat) {
        $printedCat = false;
        foreach ($allProducts as $product) {
            $productID = $product['vare_id'];
            $productDetail = $conn->query("SELECT * FROM varer WHERE id = '$productID' ")->fetch_assoc();
            if ($cat['id'] == $productDetail['kategori']) {
                if (!$printedCat) {
                    $html .= "<table border='1' cellspacing='0' cellpadding='5'>";
                   $html .= "<tr style='background-color: black'><th>" . $cat["name"] . "</th><td>.</td><td>.</td><td>.</td></tr>";
                    $html .= "<tr><th>Navn</th><th>Beskrivelse</th><th>Pris</th><th>Antall</th></tr>";

                    $printedCat = true;
                }
                $html .= "<tr><td>" . $productDetail["navn"] . "</td><td>" . $productDetail["beskrivelse"] . "</td>"
                    . "<td>" . $productDetail["pris"] ."</td><td>" . $product["antall"] . "</td></tr>";

            }

        }
        if ($printedCat) {
            $html .= "</table>";
        }
    }

    return $html;

}

//generateOrderPdf(19);