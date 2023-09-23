<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Mypdf;
use App\Models\Certificate;
use App\Models\Client;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\CertificateTestResult;
use App\Models\EmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class CertificateController extends Controller
{
    public function index()
    {
        $data['certificate_add'] = checkPermission('certificate_add');
        $data['clients'] = Client::all();
        $data['products']=Product::all();
        return view('backend/certificate/index', ["data" => $data]);
    }

    public function editCertificate($id)
    {
        $data = Certificate::find($id);
        $data['clients'] = Client::all();
        $data['products'] = Product::all();

        $data['test_results'] = CertificateTestResult::where('certificate_id',$id)->get();
        return view('backend/certificate/certificate_edit', ["data" => $data]);
    }

    public function deleteCertificate($id)
    {
        $msg_data = array();
        $data = Certificate::find($id);
        $data->delete();
        successMessage('Data delete successfully', $msg_data);
        return view('backend/certificate/certificate_index');
    }

    public function addCertificate(Request $request)
    {
        $data['client'] =  Client::all();
        $data['product'] = Product::all();
        $data['certificate'] = Certificate::all();

        return view('backend/certificate/certificate_add', ["data" => $data]);
    }

    public function view($id)
    {
        $data['data'] = Certificate::find($id);
        $data['test_results'] = CertificateTestResult::where('certificate_id', $id)->get();

        return view('backend/certificate/certificate_view', $data);
    }

    public function saveCertificate(Request $request)
    {
        $msg_data = array();
        $validationErrors = $this->validateRequest($request);

        if (count($validationErrors)) {
            \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        if (isset($_GET['id'])) {
            $certificates = Certificate::find($request->id);
            $certificate_results = CertificateTestResult::where('certificate_id', $request->id)->pluck('id');
            CertificateTestResult::destroy($certificate_results);
        } else {
            $certificates = new Certificate;
            $certificates->certificate_no = Helper::IDGenerator($request->calibration_date);
        }
        $certificates->calibration_date = $request->calibration_date;
        $certificates->next_calibration_date = $request->next_calibration_date;
        $certificates->client_id = $request->client_id;
        $certificates->reference = $request->reference;
        $certificates->product_id = $request->product_id;
        $certificates->remark = $request->remark;
        $certificates->product_details = json_encode($this->getProductDetails($request->product_id));
        $certificates->client_details = json_encode($this->getClientDetails($request->client_id));
        //added by arjun TO FETCH PRODUCT CKEDDITOR :START
        $certificates->product_ckeditor =$this->getCkDetails($request->product_id);
        //added by arjun TO FETCH PRODUCT CKEDDITOR :END

        if (isset($_GET['id'])) {
            $certificates->updated_by = $this->getUpdatedByDetails(session('data')['id']);
        } else {
            $certificates->created_by = session('data')['id'];
        }
        $certificates->save();

        if (!empty($request->setting)) {
            foreach ($request->setting as $key => $value) {
                $query = new CertificateTestResult;
                $query->certificate_id = !empty($request->id) ? $request->id : $certificates->id;
                $query->setting = $value;
                $query->instrument = $request->instrument[$key];
                $query->error = $request->error[$key];

                $query->save();
            }
        }
        successMessage('Data saved successfully', $msg_data);
    }

    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'calibration_date' => 'required|date|',
            'client_id' => 'required|integer|',
            'reference' => 'required|string',
            'product_id' => 'required|integer|',

        ])->errors();
    }
    /**
     * Created By :karan suryavanshi
     * Created On : 03 Jan 2023
     * Uses : Create Pdf.
     * @param Request $request 
     * @return Response
     */
    public function certificatePdf($enc_id)
    {
        try {
            $main_table = 'certificates';
            $id = Crypt::decrypt($enc_id);
            $data = DB::table('certificates')->select(
                'certificates.id',
                'certificates.certificate_no',
                'certificates.calibration_date',
                'certificates.next_calibration_date',
                'certificates.reference',
                'certificates.remark',
                'certificates.product_details',
                'certificates.product_ckeditor',
                'certificates.client_details',
                'certificates.created_at AS creation_date',
            )
                ->where([[$main_table . '' . '.id', $id], [$main_table . '' . '.deleted_at', NULL]])->first();

            $result = [
                'data' => $data,
                'test_results' => DB::table('certificate_test_results')->where('certificate_id', $id)->get()->toArray(),
                'no_image' => URL::to('/') . '/public/backend/img/dark_sign.png',
            ];
            $pdf = new Mypdf('p', 'mm', 'A4', true, 'UTF-8', false);
            $html = view('backend/certificate/certificate_pdf', $result);

            $pdf_header = '
            <table style="width: 100% !important;">
            <tr><td style="line-height:5mm"></td></tr>
                <tr>
                    <th ><img style="width:650mm" src="' . URL::to('/') . '/public/backend/img/header2.jpg"/></th>
                </tr>
             <hr>
            </table>';


            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Caltech');
            $pdf->SetTitle('Certificate Invoice');
            $pdf->SetSubject('Caltech');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            $pdf->setHtmlHeader($pdf_header);
            $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

            // set header and footer fonts
            $pdf->setHeaderFont(array('helvetica', '', 10));
            $pdf->setFooterFont(array('helvetica', '', 8));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');

            // set margins
            $pdf->SetMargins(15, 50, 15);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(27);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 20);

            // set image scale factor
            $pdf->setImageScale(1.25);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            // add a page
            $pdf->AddPage();

            // Print text using writeHTMLCell()
            $pdf->writeHTMLCell(0, 0, '', '44', $html, 0, 1, 0, true, '', true);

            //Close and output PDF document
            $pdf->Output('certificate Invoice.pdf', 'I');
        } catch (\Exception $e) {
            \Log::error("certificate Invoice Generation Failed " . $e->getMessage());
            return redirect()->back()->withErrors(array("msg" => "Something went wrong"));
        }
    }

    public function certificateData(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Certificate::with('client','product')->orderBy('updated_at', 'desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request['search']['search_certificate_no'] && !is_null($request['search']['search_certificate_no'])) {
                            $query->where('certificate_no', 'like', "%" . $request['search']['search_certificate_no'] . "%");
                        }
                        if ($request['search']['search_product_id'] && !is_null($request['search']['search_product_id'])) {
                            $query->where('product_id', 'like', "%" . $request['search']['search_product_id'] . "%");
                        }
                        if ($request['search']['search_client_id'] && !is_null($request['search']['search_client_id'])) {
                            $query->where('client_id', 'like', "%" . $request['search']['search_client_id'] . "%");
                        }
                        if ($request['search']['search_calibration_date'] && !is_null($request['search']['search_calibration_date'])) {
                            $calibration_date = Carbon::parse($request['search']['search_calibration_date'])->format('Y-m-d');
                            $query->where('calibration_date', $calibration_date);
                        }
                        if ($request['search']['search_next_calibration_date'] && !is_null($request['search']['search_next_calibration_date'])) {
                            $next_calibration_date = Carbon::parse($request['search']['search_next_calibration_date'])->format('Y-m-d');
                            $query->where('next_calibration_date', '>=', $next_calibration_date);
                        }
                        $query->get();
                    })
                    ->editColumn('certificate_no', function ($event) {
                        return $event->certificate_no . ' ';
                    })
                    ->editColumn('calibration_date', function ($event) {
                        return $event->calibration_date;
                    })
                    ->editColumn('client', function ($event) {
                        return '<div style="width: 200px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->client->company_name .'</div>' ;
                    })
                    ->editColumn('reference', function ($event) {
                        return $event->reference;
                    })
                    ->editColumn('product', function ($event) {
                        return $event->product->product_sr_no;
                    })
                    ->editColumn('remark', function ($event) {
                        return $event->remark;
                    })
                    ->editColumn('action', function ($event) {
                        $certificateID = Crypt::encrypt($event->id);

                        $url = URL::temporarySignedRoute(
                            'invoice_pdf',
                            now()->addDays(config('global.TEMP_URL_EXP_DAYS_FOR_INVOICE')),
                            [$certificateID]
                        );
                        $certificates_view = checkPermission('certificate_view');
                        $certificates_edit = checkPermission('certificate_edit');
                        $certificates_delete = checkPermission('certificate_delete');
                        $certificates_pdf = checkPermission('certificate_pdf');
                        $share_certificate = checkPermission('share_certificate');
                        $actions = '<span style="white-space:nowrap;">';

                        if ($certificates_view) {
                            $actions .= '<a href="certificate_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Certificate Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($certificates_edit) {
                            $actions .= ' <a href="certificate_edit/' . $event->id . '" class="btn btn-success btn-sm src_data " title="Update"><i class="fa fa-edit"></i></a>';

                            if ($certificates_delete) {
                                $actions .= ' <a  data-url="certificate_delete/'  . $event->id . '"   class="btn btn-danger btn-sm delete-data" title="Delete"><i class="fa fa-trash"></i></a>';
                            }
                            if ($certificates_pdf) {
                                $actions .= ' <a href="' . $url . '" class="btn btn-info btn-sm" title="Pdf" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                            }
                            if ($share_certificate) {
                                $actions .= ' <a href="share_certificate/' . $event->id . '" class="btn btn-warning btn-sm certificate-share" title="Send Email"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
                            }
                        }

                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['calibration_date', 'next_calibration_date', 'client', 'reference', 'product', 'remark', 'action'])->setRowId('id')->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                return response([
                    'draw'            => 0,
                    'recordsTotal'    => 0,
                    'recordsFiltered' => 0,
                    'data'            => [],
                    'error'           => 'Something went wrong',
                ]);
            }
        }
    }

    private function getProductDetails($product_id)
    {
        return DB::table('products')->select(
            'id as product_id',
            'name as product_name',
            'make as product_make',
            'range as product_range',
            'product_sr_no',
            'standard_sr_no',
            'description AS equipment_description',
            'certificate_no AS equipment_certificate_no',
            'valid_till',
            'count',
            'remarks',
            'standard_make AS equipment_make',
            'standard_range',
            'ckeditor',
        )->where('id', $product_id)->first();
    }

    //added by arjun TO FETCH PRODUCT CKEDDITOR :START
    private function getCkDetails($product_id)
    {
        $ckdata= DB::table('products')->select(
            'ckeditor',
        )->where('id', $product_id)->first();

     return $ckdata->ckeditor;
     }
     //added by arjun TO FETCH PRODUCT CKEDDITOR :END


    private function getClientDetails($client_id)
    {
        return DB::table('clients AS c')->select(
            'c.id as client_id',
            'contact_person_name as client_name',
            'company_name',
            'email as client_email',
            'company_number as phone',
            'address',
            'city',
            'pin_code',
            'state',
            'country',
            'GSTIN',
        )
            ->where('c.id', $client_id)->first();
    }

    private function getUpdatedByDetails($admin_id)
    {
        $admins_arr = array();
        $current_admin = DB::table('admins AS a')->selectRaw(
            'a.id as admin_id, admin_name, nick_name, email, phone,
            r.role_name as admin_role'
        )
            ->where('a.id', $admin_id)->leftJoin('roles AS r', 'r.id', '=', 'role_id')
            ->first();

        $current_admin->updated_on = date("Y-m-d H:i:s");
        $admins_updated = Certificate::find($_GET['id'])['updated_by'];

        if (!empty($admins_updated)) {
            $admins_arr = json_decode($admins_updated, true);

            if (!empty($admins_arr) && count($admins_arr) >= 5) {
                unset($admins_arr[0]);
            }
        }
        array_push($admins_arr, $current_admin);

        return json_encode(array_values($admins_arr));
    }

    public function share_certificate($certificate_id)
    {
        $result = Certificate::find($certificate_id);
        $result['client_email'] = Client::find($result->client_id)['email'];

        if (!empty($result)) {
            $result = $result->toArray();
        }

        return view('backend/certificate/certificate_share', ["data" => $result]);
    }

    public function viewCertificate($encrypted_certificate_id)
    {
        $certificate_id = Crypt::decrypt($encrypted_certificate_id);
        $dataExists = Certificate::find($certificate_id)->toArray();

        if (!empty($dataExists)) {
            $main_table = 'certificates';
            $data = DB::table('certificates')->select(
                'certificates.id',
                'certificates.certificate_no',
                'certificates.calibration_date',
                'certificates.next_calibration_date',
                'certificates.reference',
                'certificates.remark',
                'certificates.product_details',
                'certificates.product_ckeditor',
                'certificates.client_details',
                'certificates.created_at AS creation_date',
            )
            ->where([[$main_table . '' . '.id', $certificate_id], [$main_table . '' . '.deleted_at', NULL]])->first();
            $result = array(
                'data' => $data,
                'test_results' => DB::table('certificate_test_results')->where('certificate_id', $certificate_id)->get()->toArray(),
                'no_image' => URL::to('/') . '/public/backend/img/dark_sign.png',
            );
            $pdf = new Mypdf('p', 'mm', 'A4', true, 'UTF-8', false);
            $html = view('backend/certificate/certificate_pdf', $result);

            $pdf_header = '
            <table style="width: 100% !important;">
            <tr><td style="line-height:5mm"></td></tr>
                <tr>
                    <th ><img style="width:650mm" src="' . URL::to('/') . '/public/backend/img/header2.jpg"/></th>
                </tr>
             <hr>
            </table>';

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Caltech');
            $pdf->SetTitle('Certificate Invoice');
            $pdf->SetSubject('Caltech');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
            $pdf->setHtmlHeader($pdf_header);
            $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

            // set header and footer fonts
            $pdf->setHeaderFont(array('helvetica', '', 10));
            $pdf->setFooterFont(array('helvetica', '', 8));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont('courier');

            // set margins
            $pdf->SetMargins(15, 50, 15);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(27);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 20);

            // set image scale factor
            $pdf->setImageScale(1.25);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            // add a page
            $pdf->AddPage();

            // Print text using writeHTMLCell()
            $pdf->writeHTMLCell(0, 0, '', '44', $html, 0, 1, 0, true, '', true);

            //Close and output PDF document
            $pdf->Output('certificate Invoice.pdf', 'I');
        } else {
            return "Url Expired";
        }
    }

    public function sendEmail(Request $request)
    {
        if (config('global.TRIGGER_CUSTOM_EMAIL')) {
            $result = Certificate::find($request->certificate_id)->toArray();
            $encrypted_id = Crypt::encrypt($result['id']);
            $client_name = Client::find($result['client_id'])->toArray();
            $email_to = array_unique(array_filter($request->email));
            array_push($email_to, Client::find($result['client_id'])['email']);

            $emailData = EmailNotification::where([['mail_key', 'SHARE_CERTIFICATE'], ['status', 1]])->first();

            if (!empty($emailData)) {
                $emailData = $emailData->toArray();
                $email_cc = !empty($emailData['cc_email']) ? (is_array($emailData['cc_email']) ? $emailData['cc_email'] : array($emailData['cc_email'])) : array();
                $email = array_diff($email_to, $email_cc);
                // $url = URL::to(Request::route()->getPrefix()).'/certificates/' . $encrypted_id;
                $url = URL::to('/');
                $url =  URL::to('/webadmin/certificates/' . Crypt::encrypt($result['id']));
                $url = URL::temporarySignedRoute('shared_certificate_view', now()->addDays(config('global.MAX_DAYS.CERTIFICATE_SHARE_URL_EXP_DAYS')), [$encrypted_id]);

                $subject = str_replace('$$certificate_id$$', $result['certificate_no'], $emailData['subject'] ?? '');
                $emailData['content'] = str_replace('$$company_name$$', $client_name['company_name'], $emailData['content']);
                $emailData['content'] = str_replace('$$url$$', $url, $emailData['content']);
                $emailData['content'] = str_replace('$$from_name$$', $emailData['from_name'], $emailData['content']);
                $emailData['content'] =  htmlspecialchars_decode(stripslashes($emailData['content']));

                Mail::send('backend/auth/email-forgot', ['body' => $emailData['content']], function ($message) use ($email, $subject, $email_cc) {
                    $message->from('crm2@mypcot.com', 'Caltech Team');
                    $message->cc($email_cc);
                    $message->to($email, 'Caltech Team')->subject($subject);
                });
            }
        }
        successMessage('Email Send Successfully');
    }
}
