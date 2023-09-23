<?php

namespace App\Http\Controllers\Backend;

class Mypdf extends \TCPDF
{

    var $htmlHeader;

    public function setHtmlHeader($htmlHeader)
    {
        $this->htmlHeader = $htmlHeader;
    }
     /**
     * Created By :karan suryavanshi
     * Created On : 03 Jan 2023
     * Uses : Create Pdf Header.
     * @param Request $request 
     * @return Response
     */
    //Page header
    public function Header()
    {
        // Get the current page break margin
        // $bMargin = $this->getBreakMargin();

        // // Get current auto-page-break mode
        // $auto_page_break = $this->AutoPageBreak;

        // // Disable auto-page-break
        // $this->SetAutoPageBreak(false, 0);

        // // Define the path to the image that you want to use as watermark.
        // $img_file = 'public\backend\img\Watermark-Caltech.png';

        // // Render the image
        // $this->Image($img_file,15, 40, 180, 190,'','',70);

        // // Restore the auto-page-break status   
        // $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // // Set the starting point for the page content
        // $this->setPageMark();


        $this->writeHTMLCell(
            $w = 0,
            $h = 0,
            $x = '',
            $y = '',
            $this->htmlHeader,
            $border = 0,
            $ln = 1,
            $fill = 0,
            $reseth = true,
            $align = 'top',
            $autopadding = true
        );
    }
    /**
     * Created By :karan suryavanshi
     * Created On : 03 Jan 2023
     * Uses : Create Pdf Footer.
     * @param Request $request 
     * @return Response
     */
    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
