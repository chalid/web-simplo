<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\FaqCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use Str;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $routeAjax      = 'faq-category.get_data';
        $title          = 'List Faq Category';

        return view('backends.faq_category.index', compact(['confirmDelete','routeAjax','title']));
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
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'description'   => 'required',
        ], [
            'name.required'         => 'name wajib diisi',
            'description.required'  => 'description wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faq-category')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $faqCategory                    = new FaqCategory();
            $faqCategory->name              = $request->name;
            $faqCategory->description       = $request->description;
            $faqCategory->meta_title        = $request->name;
            $faqCategory->meta_tag          = $request->name;
            $faqCategory->meta_description  = Str::limit(strip_tags($request->description), 150);
            $faqCategory->meta_keywords     = implode(',', explode(' ', Str::lower($request->name)));
            $faqCategory->meta_author       = auth()->check() ? auth()->user()->name : 'Admin';
            $faqCategory->meta_image        = $request->image ?? null;
            $faqCategory->meta_canonical    = route('web_faq', Str::slug($request->name));
            $faqCategory->meta_robots       = 'index, follow';
            $faqCategory->slug              = Str::slug($request->name);
            $faqCategory->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('faq-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqCategory $faqCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaqCategory $faqCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaqCategory $faqCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $faqCategory->name              = $request->name;
            $faqCategory->description       = $request->description;
            $faqCategory->meta_title        = $request->name;
            $faqCategory->meta_tag          = $request->name;
            $faqCategory->meta_description  = Str::limit(strip_tags($request->description), 150);
            $faqCategory->meta_keywords     = implode(',', explode(' ', Str::lower($request->name)));
            $faqCategory->meta_author       = auth()->check() ? auth()->user()->name : 'Admin';
            $faqCategory->meta_image        = $request->image ?? null;
            $faqCategory->meta_canonical    = route('web_faq', Str::slug($request->name));
            $faqCategory->meta_robots       = 'index, follow';
            $faqCategory->slug              = Str::slug($request->name);
            $faqCategory->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('faq-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq-category')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqCategory $faqCategory)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $faqCategory->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('faq-category')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('faq-category')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $faqCategories  = FaqCategory::get();

            $routeEdit          = 'faq-category.update';
            $routeDestroy       = 'faq-category.delete';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';

            return DataTables::of($faqCategories)
                ->addIndexColumn()
                ->addColumn('action', function ($faqCategories) use ($routeEdit,$routeDestroy,$iconEdit,$iconDestroy) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can edit faq category')){
                        $btn_action .=  '<form action="' . route($routeEdit, ['faqCategory' => $faqCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="PATCH">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-warning btn-sm" title="Edit Data" href="" data-bs-target="#staticBackdrop' . $faqCategories->id . '">' . $iconEdit . '</a>' .
                                            '<div class="modal fade" id="staticBackdrop' . $faqCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $faqCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $faqCategories->id . '">Edit Data</h1>
                                                            <button type="button" class="btn-close clear-form" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="name" class="form-control" id="name" value="' . $faqCategories->name . '" required>
                                                                    <div class="invalid-feedback">Harap isi sgroup</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="description" class="col-sm-4 col-form-label">description</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="description" class="form-control" id="description" value="' . $faqCategories->description . '" required>
                                                                    <div class="invalid-feedback">Harap isi description</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger clear-form" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete faq category')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['faqCategory' => $faqCategories->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="DELETE">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $faqCategories->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $faqCategories->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $faqCategories->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $faqCategories->id . '">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 row">
                                                                <p>Anda yakin ingin menghapus data ini</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-success">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>&nbsp;';
                    }
                    $btn_action .=  '</div>';

                    return $btn_action;
                })
            ->rawColumns(['action']) // to html
            ->make(true);
        }
    }
}
