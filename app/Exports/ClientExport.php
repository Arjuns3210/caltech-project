<?php

namespace App\Exports;

use App\Models\Client;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Admin;


class ClientExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents,WithTitle
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
                $start_date = Carbon::parse(now())->format('d-m-Y');
                $end_date = Carbon::parse(now())->format('d-m-Y');
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', "Client Report (" . $start_date . " - " . $end_date . ")");

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
                $heading = 'A1:M1'; // Main Heading
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
            'Name',
            'Company Name',
            'Company Number',
            'Email',
            'GSTIN',
            'Country',
            'State',
            'City',
            'Address',
            'Pin Code',
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

      
        $client_data= Client::select('id','contact_person_name','company_name','company_number','email','GSTIN','country','state','city','address','pin_code','created_by',\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y %H:%i:%s") as created_on'));
        if($this->request->client_id && $this->request->client_id[0]!="select"){
            $client_data->whereIn('id',$this->request->client_id);
        }
        $client_data = $client_data->get();


        foreach($client_data as  $key =>$client){
            // \Log::info($user)
            $client->id = $key + 1;
            $creator_name = Admin::find($client->created_by);
            $client->created_by = $creator_name->admin_name;
               }      
            return $client_data;
    } 
    public function title(): string
    {
        return 'Client Data ' . Carbon::now()->format('d-m-Y');
    }
}
