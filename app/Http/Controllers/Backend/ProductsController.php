<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Str;
use App\Models\Product;

class ProductsController extends Controller
{

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will load Product listing.
     */
    public function index()
    {
        $data['product_add'] = checkPermission('product_add');
        $data['product_edit'] = checkPermission('product_edit');
        $data['product_view'] = checkPermission('product_view');
        $data['product_status'] = checkPermission('product_status');
        $data['product_delete'] = checkPermission('product_delete');
        return view('backend/products/index', ["data" => $data]);
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will load edit product.
     * @param int $id 
     * @return Response
     */
    public function editproduct($id)
    {
        $data['data'] = Product::find($id);
        return view('backend/products/products_edit', $data);
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will delete product.
     * @param int $id 
     * @return Response
     */
    public function deleteproduct($id)
    {
        $msg_data = array();
        $data = Product::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', $msg_data);
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will load  product view.
     *   @param int $id
     *   @return Response
     */
    public function view($id)
    {
        $data['data'] = Product::find($id);
        return view('backend/products/products_view', $data);
    }

    /**
     * @author Mohammed Taqi Syed <mohammed.s@mypcot.com>
     * @param int $id
     * @return Response
     */
    public function singleProduct($id)
    {
        $data = Product::find($id);
        $data->valid_till = date('d-m-Y', strtotime($data->valid_till));

        return $data;
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will load add product view.
     */
    public function addProduct(Request $request)
    {

        $data['product'] = Product::all();
        return view('backend/products/products_add', ["data" => $data]);
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will add/update product.
     * @param Request $request
     * @return Response
     */

    public function saveproducts(Request $request)
    {

        $msg_data = array();
        $isEditFlow = false;
        if (isset($_GET['id'])) {
            $validationErrors = $this->validateRequest($request);
            $isEditFlow = true;
            $products = Product::find($_GET['id']);
        } else {
            $validationErrors = $this->validateNewRequest($request);
            $products = new Product;
        }
        if (count($validationErrors)) {
            \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
            errorMessage(implode("\n", $validationErrors->all()), $msg_data);
        }
        $msg_data = array();

        $products->product_sr_no = $request->product_sr_no;
        $products->name = $request->name;
        $products->range = $request->range;
        $products->make = $request->make;
        $products->count = $request->count;
        $products->remarks = $request->remarks;
        $products->standard_sr_no = $request->standard_sr_no;
        $products->standard_range = $request->standard_range;
        $products->standard_make = $request->standard_make;
        $products->description = $request->description;
        $products->certificate_no = $request->certificate_no;
        $products->valid_till = $request->valid_till;
        $products->ckeditor = $request->editiorData;
        if ($isEditFlow) {
            $products->updated_by = session('data')['id'];
        } else {
            $products->created_by = session('data')['id'];
        }

        $products->save();
        successMessage('Data saved successfully', $msg_data);
    }

    /**
     * Created By :karan suryavanshi
     * Created On : 15 dec 2022
     * Uses : This will fetch product data.
     * @param Request $request 
     * @return Response
     */
    public function productsData(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Product::orderBy('updated_at', 'desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request['search']['search_product_sr_no'] && !is_null($request['search']['search_product_sr_no'])) {
                            $query->where('product_sr_no', 'like', "%" . $request['search']['search_product_sr_no'] . "%");
                        }

                        if ($request['search']['search_name'] && !is_null($request['search']['search_name'])) {
                            $query->where('name', 'like', "%" . $request['search']['search_name'] . "%");
                        }

                        if ($request['search']['search_range'] && !is_null($request['search']['search_range'])) {
                            $query->where('range', 'like', "%" . $request['search']['search_range'] . "%");
                        }

                        if ($request['search']['search_count'] && !is_null($request['search']['search_count'])) {
                            $query->where('count', 'like', "%" . $request['search']['search_count'] . "%");
                        }

                        if ($request['search']['search_make'] && !is_null($request['search']['search_make'])) {
                            $query->where('make', 'like', "%" . $request['search']['search_make'] . "%");
                        }


                        $query->get();
                    })
                    ->editColumn('name', function ($event) {
                        return $event->name . ' ';
                    })
                    ->editColumn('product_sr_no', function ($event) {
                        return $event->product_sr_no;
                    })
                    ->editColumn('range', function ($event) {
                        return '+' . $event->range . ' ';
                    })
                    ->editColumn('product_sr_no', function ($event) {
                        return $event->product_sr_no;
                    })
                    ->editColumn('action', function ($event) {
                        $products_view = checkPermission('product_view');
                        $products_edit = checkPermission('product_edit');
                        $products_delete = checkPermission('product_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($products_view) {
                            $actions .= '<a href="products_view/' . $event->id . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Product Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($products_edit) {
                            $actions .= ' <a href="products_edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';

                            if ($products_delete) {
                                $actions .= ' <a  data-url="products_delete/'  . $event->id . '"   class="btn btn-danger btn-sm delete-data" title="Delete"><i class="fa fa-trash"></i></a>';
                            }
                        }
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['sr_no', 'name', 'range', 'make', 'count', 'remarks','standard_sr_no', 'description', 'certificate_no', 'valid_till', 'action'])->setRowId('id')->make(true);
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

    private function validateNewRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'product_sr_no' => 'required|string',
            'name' => 'required|string|',
            'range' => 'required|string|',
            'make' => 'required|string',
            'description' => 'required|string|',
            'editiorData' => 'required',
        ])->errors();
    }

    private function validateRequest(Request $request)
    {
        return \Validator::make($request->all(), [
            'product_sr_no' => 'required|string',
            'name' => 'required|string|',
            'range' => 'required|string|',
            'make' => 'required|string',
            'description' => 'required|string|',
            'editiorData' => 'required',
        ])->errors();
    }
}
