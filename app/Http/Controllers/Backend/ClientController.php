<?php

namespace App\Http\Controllers\backend;
use App\Models\Client;

use App\Models\Country;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\backend\Role;
class ClientController extends Controller
{
    /**
     * @author Arjun Singh <chhotelal.s@mypcot.com>
     * Created On : 15 dec 2022
     * Uses : This will load Client view.
     * @return mixed
     */
    public function index()
    {
        // $data['country'] = Country::all();
        $data['client_add'] = checkPermission('client_add');
        $data['client_edit'] = checkPermission('client_edit');
        $data['client_view'] = checkPermission('client_view');
        $data['client_delete'] = checkPermission('client_delete');
        $data['client_status'] = checkPermission('client_status');
        return view('backend/client/index', ["data" => $data]);
    }

    /**
     *   Created by : Arjun Singh
     *   Created On : 15 dec-2022
     *   Uses :  to load Client view
     *   @param int $id
     *   @return Response
     */
    public function view($id)
    {
        $data['data'] = Client::find($id);
        // $data['country'] = Country::all();
        return view('backend/client/client_view', $data);
    }

    /**
     * @author Mohammed Taqi Syed <mohammed.s@mypcot.com>
     * @param int $id
     * @return Response
     */
    public function singleClient($id)
    {
        return Client::find($id);
    }

    /**
     * Created By :Arjun Singh
     * Created On : 15 dec 2022
     * Uses : This will load add Client view.
     */
   public function addClient(Request $request)
    {
       
        // $data['country'] = Country::all(); , ["data" => $data]
        \Log::info('inside add client');
        return view('backend/client/client_add');

    }
    private function validateNewRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'company_name' => 'required|string',
           'contact_person_name' => 'required|string|unique:clients,contact_person_name,'. $request->id,
           'GSTIN' => 'required|unique:clients,GSTIN,'. $request->id,
            'company_number' => 'required',
            'email' => 'required|email|unique:clients',
            
            
        ])->errors();
    }


    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'company_name' => 'required|string',
            'contact_person_name' => 'required|string',
            'company_number' => 'required',
           'GSTIN' => 'required|unique:clients,GSTIN,'. $request->id,
            'email' => 'required|email|unique:clients,email,'. $request->id,
            
        ])->errors();
    }

    /**
     * Created By :Arjun Singh
     * Created On : 15 dec 2022
     * Uses : This will add a new  Client.
     * @param Request $request
     * @return Response
     */

    public function saveClient(Request $request)
    {
        \Log::info('inside saveClient');
        $msg_data = array();
        if (isset($_GET['id'])) {
            $validationErrors = $this->validateRequest($request);

        } else {
            \Log::info('before validate');
            $validationErrors = $this->validateNewRequest($request);
            // $validationErrors = 0;
            
            \Log::info('after validate');

        }
        if (count($validationErrors)) {
            \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        $msg_data = array();
        $isEditFlow = false;
      

        $email = trim(strtolower($request->email));
        if (isset($_GET['id'])) {
            $isEditFlow = true;
            $response = Client::where([['email', $email], ['id', '<>', $_GET['id']]])->get()->toArray();
            if (isset($response[0])) {
                errorMessage('Email Already Exist', $msg_data);
            }
            $response = Client::where([['company_number', $request->company_number], ['id', '<>', $_GET['id']]])->get()->toArray();
            if (isset($response[0])) {
                errorMessage('Phone Number Already Exist', $msg_data);
            }
            $clients = Client::find($_GET['id']);
        } else {
            $clients = new Client;
            $response = Client::where([['company_number', $request->company_number]])->get()->toArray();
            if (isset($response[0])) {
                errorMessage('Phone Number Already Exist', $msg_data);
            }
          
            $response = Client::where([['email', $email]])->get();
        }

      
        \Log::info('down name');
        $clients->company_name = $request->company_name;
        $clients->contact_person_name = $request->contact_person_name;
        $clients->country =$request->country;
        $clients->email = $email;
        $clients->pin_code = $request->pin_code;
        $clients->city = $request->city;
        $clients->state = $request->state;
        $clients->GSTIN = $request->GSTIN;
        $clients->country_code = $request->country_code;
        $clients->company_number = $request->company_number;
        $clients->address = $request->address;
        if ($isEditFlow) {
            $clients->updated_by = session('data')['id'];
        } else {
            $clients->created_by = session('data')['id'];
        }
        \Log::info('before save');
        \Log::info($request->contact_person_name);
        $clients->save();
        \Log::info('after save');
        successMessage('Data saved successfully', $msg_data);
    }


    /**
     * Created By :Arjun Singh
     * Created On : 15 dec 2022
     * Uses : This will fetch  Client data.
     * @param Request $request 
     * @return mixed array | object
     */
    public function clientData(Request $request)
    {
        \Log::info('before save');
        if ($request->ajax()) {
            try {
                \Log::info('after save');
                $query = Client::orderBy('updated_at', 'desc');
                
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request['search']['search_email'] && !is_null($request['search']['search_email'])) {
                            $query->where('email', 'like', "%" . $request['search']['search_email'] . "%");
                        }

                        if ($request['search']['search_company_name'] && !is_null($request['search']['search_company_name'])) {
                            $query->where('company_name', 'like', "%" . $request['search']['search_company_name'] . "%");
                        }
                        if ($request['search']['search_city'] && !is_null($request['search']['search_city'])) {
                            $query->where('city', 'like', "%" . $request['search']['search_city'] . "%");
                        }

                        if ($request['search']['search_GSTIN'] && !is_null($request['search']['search_GSTIN'])) {
                            $query->where('GSTIN', 'like', "%" . $request['search']['search_GSTIN'] . "%");
                        }

                        if ($request['search']['search_contact_person_name'] && !is_null($request['search']['search_contact_person_name'])) {
                            $query->where('contact_person_name', 'like', "%" . $request['search']['search_contact_person_name'] . "%");
                        }

                        if ($request['search']['search_company_number'] && !is_null($request['search']['search_company_number'])) {
                            $query->where('company_number', 'like', "%" . $request['search']['search_company_number'] . "%");
                        }

                        $query->get();
                    })
                    ->editColumn('company_name', function ($event) {
                        return '<div style="width: 150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->company_name .'</div>' ;
                    })->editColumn('company_number', function ($event) {
                        return '<div style="width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->company_number .'</div>' ;
                    })
                    ->editColumn('email', function ($event) {
                        return '<div style="width: 150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->email .'</div>' ;
                    })
                    ->editColumn('contact_person_name', function ($event) {
                        return '<div style="width: 130px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" >'.$event->contact_person_name .'</div>' ;
                    })
                    ->editColumn('action', function ($event) {
                        $client_view = checkPermission('client_view');
                        $client_edit = checkPermission('client_edit');
                        $client_status = checkPermission('client_status');
                        $client_delete = checkPermission('client_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($client_view) {
                            $actions .= '<a href="client_view/' . $event->id . '" class="btn  btn-sm src_data  btn-primary"  data-title="View Client Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($client_edit) {
                            $actions .= ' <a href="client_edit/' . $event->id . '" class="btn  btn-sm src_data btn-success" title="Update"><i class="fa fa-edit"></i></a>';
                        }

                        if ($client_delete) {
                            $actions .= ' <a data-url="client_delete/' . $event->id . '" class="btn  btn-sm delete-data btn-danger"  title="Delete"><i class="fa fa-trash"></i></a>';
                        }
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['company_name', 'email', 'company_number', 'contact_person_name','action'])->setRowId('id')->make(true);
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
    /**
     * Created By :Arjun Singh
     * Created On : 15 dec 2022
     * Uses : This will load edit Client view.
     * @param int $id 
     * @return Response
     */
    public function editClient($id)
    {
        $data['data'] = Client::find($id);
        // $data['country'] = Country::all();
        return view('backend/client/client_edit', ["data" => $data]);
    }

    /**
     * Created By :Arjun Singh
     * Created On : 15 dec 2022
     * Uses : This will delete  Client.
     * @param Request $request
     * @return Response
     */
    public function deleteClient($id)
    {
        $msg_data = array();
        $data= Client::find($id);
        $data->delete();
        successMessage('Data delete successfully', $msg_data);

        return view('backend/client/client_index');
    }    
}
