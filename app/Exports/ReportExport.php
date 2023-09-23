<?php

namespace App\Exports;

use App\Models\Certificate;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Admin;

class ReportExport implements FromCollection , WithHeadings, WithCustomStartCell, WithEvents, WithTitle
{
    function __construct($request)
    {
        $this->request = $request;
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;
                $start_date = $end_date = Carbon::parse(now())->format('d-m-Y');

                if (isset($this->request->daterange) && !empty($this->request->daterange)) {
                    $string = explode('-', $this->request->daterange);
                    $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->startOfDay()->toDateString();
                    $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->endOfDay()->toDateString();
                }
                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', "Certificate Report (" . $start_date . " - " . $end_date . ")");

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];

                $headerFontArray = [
                    'name' => 'Calibri',
                    'bold' => TRUE,
                    'italic' => FALSE,
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
                    'strikethrough' => FALSE,
                    'size' => 16,
                    'color' => [
                        'rgb' => 'FF000000'
                    ]
                ];
                $heading = 'A1:K1'; // Main Heading
                $event->sheet->getDelegate()->getStyle($heading)->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle($heading)->getFont()->applyFromArray($headerFontArray);

                //column style
                $columnFontArray = [
                    'name' => 'Calibri',
                    'bold' => TRUE,
                    'italic' => FALSE,
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE,
                    'strikethrough' => FALSE,
                    'size' => 11,
                    'color' => [
                        'rgb' => 'FF000000'
                    ]
                ];

                $columnBorderArray =   [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'FF000000'
                        ]
                    ]
                ];

                $columnColorArray = [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 0.0,
                    'startColor' => [
                        'rgb' => 'FFFFFF00'
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFF00'
                    ]
                ];
                $headerColumn = 'A2:M2'; // Columns
                $columns = range('A', 'M');

                foreach ($columns as $elements) {
                    $event->sheet->getDelegate()->getColumnDimension($elements)->setWidth(20);
                }
                $event->sheet->getDelegate()->getStyle($headerColumn)->getFill()->applyFromArray($columnColorArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getBorders()->applyFromArray($columnBorderArray);
                $event->sheet->getDelegate()->getStyle($headerColumn)->getFont()->applyFromArray($columnFontArray);
            },
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Certificate No',
            'Client Name',
            'Company Name',
            
            'Product Name',
            'Product Sr.No',
            'Product Range',
            'Calibration Date',
            'Next Calibration Date',
            'Reference',
            'Remark',
            'Created By',
            'Created On'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $start_date = Carbon::parse(now())->format('d-m-Y');
        $end_date = Carbon::parse(now())->format('d-m-Y');

        if (isset($this->request->daterange) && !empty($this->request->daterange)) {
            $string = explode('-', $this->request->daterange);
            $start_date = Carbon::createFromFormat('d/m/Y', trim($string[0]))->startOfDay()->toDateTimeString();
            $end_date = Carbon::createFromFormat('d/m/Y', trim($string[1]))->endOfDay()->toDateTimeString();
        }
        $report_data = Certificate::select('id','certificate_no','client_id','digital_signature','product_id','client_details','product_details','calibration_date','next_calibration_date','reference','remark','created_by',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_on'))->whereBetween('calibration_date',[$start_date,$end_date]);

        if($this->request->search_client_id && $this->request->search_client_id[0]!="select"){
            $report_data->whereIn('client_id',$this->request->search_client_id);
        }
        $report_data = $report_data->get();

        foreach($report_data as $key => $report){
            $client_details = json_decode($report->client_details) ; 
            $report->id = $key + 1;
            $report->client_id = $client_details->client_name ?? 'NA';
            $report->digital_signature = $client_details->company_name ?? 'NA';
            $product_details = json_decode($report->product_details) ; 
            $report->product_id = $product_details->product_make ?? 'NA';
            $creator_name = Admin::find($report->created_by);
            $report->client_details = json_decode($report->product_details)->product_sr_no ?? 'NA';
            $report->product_details = json_decode($report->product_details)->product_range ?? 'NA';
            $report->created_by = $creator_name->admin_name;
            $report->calibration_date = Carbon::parse($report->calibration_date)->format('d-m-Y');
            $report->next_calibration_date = Carbon::parse($report->next_calibration_date)->format('d-m-Y');
        }

        return $report_data;
    }

    public function title(): string
    {
        return 'Certificate Data ' . Carbon::now()->format('d-m-Y');
    }
}