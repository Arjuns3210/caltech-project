<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Exports\ReportExport;
use App\Exports\ClientExport;
use App\Models\Client;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $data['clients'] = Client::all();
        return view('backend/reports/index',["data" => $data]);
    }

    public function export ( Request $request){
        return Excel::download(new ReportExport($request) , 'Certificate - '.Carbon::parse(now())->format('d-m-Y H:i:s').'.xlsx');
    }

    public function client_report(){
        $data['clients'] = Client::all();
        return view('backend/reports/client_report',["data" => $data]);
    }
    public function client( Request $request){
        return Excel::download(new ClientExport($request) , 'Client - '.Carbon::parse(now())->format('d-m-Y H:i:s').'.xlsx');
    }
}
 