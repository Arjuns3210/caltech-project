<?php

namespace App\Exports;

use App\Models\Enquiry;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;

class MisReportExport implements FromView, WithEvents, WithTitle
{

    function __construct($misReportData)
    {
        $this->misReportData = $misReportData;
    }
    public function view(): View
    {
        return view('backend/reports/mis_report_excel', [
            'misReportData' => $this->misReportData
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $estimator_count = count($this->misReportData['admin']);
                $columns = range('B', 'Z'); // to apply formula
                $cellWithTotal = array_splice($columns, 0, $estimator_count + 1); // to apply formula with total column


                $columnsForStyleBorder = range('A', 'Z'); // to apply style
                $cellWithTotalForBorderStyle = array_splice($columnsForStyleBorder, 0, $estimator_count + 2); // to apply style with total and heading

                if ($estimator_count > 0) {

                    foreach ($cellWithTotal as $key => $value) {
                        //estimator review total
                        $event->sheet->setCellValue($value . '32', '=MAX(0,+' . $value . '28+' . $value . '29+' . $value . '30-' . $value . '31)');

                        //Day Output to typists (new + rev) total
                        $event->sheet->setCellValue($value . '42', '=+' . $value . '34+' . $value . '39');


                        //Closing load with estimators total
                        $event->sheet->setCellValue($value . '44', '=MAX(0,+' . $value . '32-' . $value . '34-' . $value . '35-' . $value . '36)');

                        //Previous day estimates pending for typing total by RItesh
                        $event->sheet->setCellValue($value . '54', '=' . $value . '42');
                        
                        
                        //Typists Review total
                        $event->sheet->setCellValue($value . '56', '=+' . $value . '54+' . $value . '55');


                        //Closing load with typists total
                        $event->sheet->setCellValue($value . '59', '=MAX(0,+' . $value . '56-' . $value . '58)');

                        //New Allocations (previous pending + inquiries received) total
                        if ($key === array_key_last($cellWithTotal)) {
                            $event->sheet->setCellValue($value . '24', '=+' . $value . '28+' . $value . '29');
                        }
                    }
                }

                $columnBorderArray =   [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_HAIR,
                        'color' => [
                            'rgb' => 'FF000000'
                        ]
                    ]
                ];

                $columnBorderArrayright =   [
                    'right' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'FF000000'
                        ]
                    ]
                ];

                $columnBorderArrayBottom =   [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'FF000000'
                        ]
                    ]
                ];

                for ($i = 1; $i <= config('global.mis_export_report_total_rows'); $i++) {

                    foreach ($cellWithTotalForBorderStyle as $key => $value) {
                        $headerColumn = $value . $i; // Columns
                        $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArray);

                        if ($key === array_key_last($cellWithTotalForBorderStyle)) {
                            $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArrayright);
                        }

                        if ($i == config('global.mis_export_report_total_rows')) {
                            $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArrayBottom);
                        }
                    }
                }
            }
        ];
    }

    public function title(): string
    {
        $sheetName = date('d-m', strtotime($this->misReportData['mis_date']));
        return $sheetName;
    }


    // public function registerEvents(): array
    // {

    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             /** @var Sheet $sheet */
    //             $sheet = $event->sheet;
    //             $start_date = Carbon::parse(now())->format('Y-m-d');
    //             $end_date = Carbon::parse(now())->format('Y-m-d');
    //             if (isset($this->request->daterange) && !empty($this->request->daterange)) {
    //                 $string = explode('-', $this->request->daterange);
    //                 $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->format('d/m/Y');
    //                 $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->format('d/m/Y');
    //             }

    //             $sheet->mergeCells('A1:Y1');
    //             $sheet->setCellValue('A1', "Enquiry Report (" . $start_date . " - " . $end_date . ")");


    //             $styleArray = [
    //                 'alignment' => [
    //                     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                 ],
    //             ];



    //             $headerFontArray = [
    //                 'name' => 'Calibri',
    //                 'bold' => TRUE,
    //                 'italic' => FALSE,
    //                 'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
    //                 'strikethrough' => FALSE,
    //                 'size' => 16,
    //                 'color' => [
    //                     'rgb' => 'FF000000'
    //                 ]
    //             ];
    //             $heading = 'A1:Y1'; // Main Heading
    //             $event->sheet->getDelegate()->getStyle($heading)->applyFromArray($styleArray);
    //             $event->sheet->getDelegate()->getStyle($heading)->getFont()->applyFromArray($headerFontArray);


    //             //column style
    //             $columnFontArray = [
    //                 'name' => 'Calibri',
    //                 'bold' => TRUE,
    //                 'italic' => FALSE,
    //                 'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
    //                 'strikethrough' => FALSE,
    //                 'size' => 11,
    //                 'color' => [
    //                     'rgb' => 'FF000000'
    //                 ]
    //             ];

    //             $columnBorderArray =   [
    //                 'allBorders' => [
    //                     'borderStyle' => Border::BORDER_THIN,
    //                     'color' => [
    //                         'rgb' => 'FF000000'
    //                     ]
    //                 ]
    //             ];

    //             $columnColorArray = [
    //                 'fillType' => Fill::FILL_GRADIENT_LINEAR,
    //                 'rotation' => 0.0,
    //                 'startColor' => [
    //                     'rgb' => 'FFFFFF00'
    //                 ],
    //                 'endColor' => [
    //                     'argb' => 'FFFFFF00'
    //                 ]
    //             ];

    //             $headerColumn = 'A2:Y2'; // Columns
    //             $columns = range('A', 'Y');
    //             foreach ($columns as $elements) {
    //                 $event->sheet->getDelegate()->getColumnDimension($elements)->setWidth(20);
    //             }

    //             $event->sheet->getDelegate()->getStyle($headerColumn)->getFill()->applyFromArray($columnColorArray);
    //             $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArray);
    //             $event->sheet->getDelegate()->getStyle($headerColumn)->getFont()->applyFromArray($columnFontArray);
    //         },
    //     ];
    // }
}
