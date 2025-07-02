<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Faq;
use App\Models\Backends\FaqCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use Str;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $routeAjax      = 'faq.get_data';
        $title          = 'List Faq';

        return view('backends.faq.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title          = 'Tambah Faq';
        $faqCategories  = FaqCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Faq')->sortKeys();
        return view('backends.faq.create', compact('title', 'faqCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faq_category_id'   => 'required',
            'question'          => 'required',
            'answer'            => 'required',
            'position'          => 'required',
        ], [
            'faq_category_id.required'  => 'title wajib diisi',
            'question.required'         => 'description wajib diisi',
            'answer.required'           => 'is active wajib diisi',
            'position.required'         => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faq.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $faq                    = new Faq();
            $faq->faq_category_id   = $request->faq_category_id;
            $faq->question          = $request->question;
            $faq->answer            = $request->answer;
            $faq->position          = $request->position;
            $faq->is_active         = $request->is_active;
            $faq->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('faq')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        $title          = 'Detail Faq';
        return view('backends.faq.show', compact('title', 'faq'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $title          = 'Edit Faq';
        $faqCategories  = FaqCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Faq')->sortKeys();
        return view('backends.faq.edit', compact('title', 'faq', 'faqCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'faq_category_id'   => 'required',
            'question'          => 'required',
            'answer'            => 'required',
            'position'          => 'required',
        ], [
            'faq_category_id.required'  => 'title wajib diisi',
            'question.required'         => 'description wajib diisi',
            'answer.required'           => 'is active wajib diisi',
            'position.required'         => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faq.edit', $faq->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $faq->faq_category_id   = $request->faq_category_id;
            $faq->question          = $request->question;
            $faq->answer            = $request->answer;
            $faq->position          = $request->position;
            $faq->is_active         = $request->is_active;
            $faq->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('faq')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $faq->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('faq')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $faqs           = Faq::with('category'); // eager load roles
            $routeEdit          = 'faq.edit';
            $routeDestroy       = 'faq.delete';
            $routePermission    = 'faq.permission';
            $routeShow          = 'faq.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($faqs)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('question', function ($row) {
                    return strip_tags(Str::limit($row->question, 50)); // limit to 50 characters
                })
                ->editColumn('answer', function ($row) {
                    return strip_tags(Str::limit($row->answer, 50)); // limit to 50 characters
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->orderColumn('category_name', function ($query, $order) {
                    $query->join('faq_categories', 'faqs.faq_category_id', '=', 'faq_categories.id')
                        ->orderBy('faq_categories.name', $order);
                })
                ->addColumn('action', function ($faqs) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show faq')){
                        $btn_action .=  '<a title="Show faq data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['faq' => $faqs->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit faq')){
                        $btn_action .=  '<a title="Edit faq data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['faq' => $faqs->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $faqs->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $faqs->id;
                        $valueActive = $faqs->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('faq.active', ['faq' => $faqs->id]) . '" method="POST">
                                            <input type="hidden" name="_method" value="patch">
                                            <input type="hidden" name="is_active" value="' . $valueActive . '">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <a title="Change Status" class="btn btn-info btn-sm btn-icon" href="#" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">' . $statusIcon . '</a>
                                            <div class="modal fade" id="' . $modalId . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="' . $modalId . 'Label">Ubah Status</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($faqs->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Ya, Ubah</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete faq')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['faq' => $faqs->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $faqs->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $faqs->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $faqs->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $faqs->id . '">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 row">
                                                                <p>Anda yakin ingin menghapus data ini</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    $btn_action .=  '</div>';

                    return $btn_action;
                })
            ->rawColumns(['faqs', 'image', 'action']) // to html
            ->make(true);
        }
    }
}
