<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Str;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $routeAjax      = 'customer.get_data';
        $title          = 'List Customer';

        return view('backends.customer.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function ajaxDatatable(Request $r)
    {
        // ⬇ hanya bikin query, TANPA ->get()
        $query = Customer::select('id','title','name','email','phone', 'product_name', 'message')
                ->orderByDesc('created_at');

        return DataTables::eloquent($query)    // ← paging LIMIT/OFFSET di SQL
            ->addIndexColumn()
            ->editColumn('created_at', fn($row) =>
                Carbon::parse($row->clocked_at)
                    ->timezone('Asia/Jakarta')
                    ->format('d-m-Y H:i'))
            ->editColumn('message', function ($row) {
                    return strip_tags(Str::limit($row->message, 50)); // limit to 50 characters
                })
            ->rawColumns(['action'])
            ->toJson();
    }
}
