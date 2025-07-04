<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Backends\StudyCase;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class StudyCaseController extends Controller
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
        $routeAjax      = 'study-case.get_data';
        $title          = 'List Study Case';

        return view('backends.study_case.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title              = 'Tambah Study Case';
        return view('backends.study_case.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'is_active'             => 'required|boolean',
            'icon'                  => 'image|mimes:jpeg,png,jpg,gif|max:6144',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'                => 'title wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
            'icon.required'                => 'Hanya gambar',
            'icon.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'icon.max'                     => 'Tidak bole lebih dari 3144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('study-case.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $studyCase                      = new StudyCase();
            $studyCase->title               = $request->title;
            $studyCase->description         = $request->description;
            $studyCase->uri                 = $request->uri;
            $studyCase->is_active           = $request->is_active;
            $studyCase->meta_title          = $request->title;
            $studyCase->meta_tag            = $request->title;
            $studyCase->meta_description    = Str::limit(strip_tags($request->description), 150);
            $studyCase->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $studyCase->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $studyCase->meta_image          = null;
            $studyCase->meta_canonical      = route('web_study_case', Str::slug($request->title));
            $studyCase->meta_robots         = 'index, follow';
            $studyCase->slug                = Str::slug($request->title);
            $studyCase->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('study-case')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'study_case_banner',['small-thumb', 'normal', 'meta']);

                $studyCase->image         = $image;
                $studyCase->meta_image    = $image ?? null;
                $studyCase->update();
            }
            if ($request->hasFile('icon')) {
                $fileIcon   = $request->file('icon');

                $icon = ImageHelper::uploadImage($fileIcon,'study_case_icon',['thumb2']);

                $studyCase->icon    = $icon;
                $studyCase->update();
            }
            return redirect()->route('study-case')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StudyCase $studyCase)
    {
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        $title          = 'Detail Study Case';
        return view('backends.study_case.show', compact('title', 'studyCase', 'confirmDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyCase $studyCase)
    {
        $title  = 'Edit Study Case';
        return view('backends.study_case.edit', compact('title', 'studyCase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudyCase $studyCase)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'is_active' => 'required|boolean',
            'image'     => 'image|mimes:jpeg,png,jpg,gif|max:6144',
            'icon'      => 'image|mimes:jpeg,png,jpg,gif|max:3144',
        ], [
            'title.required'    => 'title wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('study-case.edit', $studyCase->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $studyCase->title               = $request->title;
            $studyCase->description         = $request->description;
            $studyCase->uri                 = $request->uri;
            $studyCase->is_active           = $request->is_active;
            $studyCase->meta_title          = $request->title;
            $studyCase->meta_tag            = $request->title;
            $studyCase->meta_description    = Str::limit(strip_tags($request->description), 150);
            $studyCase->meta_keywords       = implode(',', explode(' ', Str::lower($request->title)));
            $studyCase->meta_author         = auth()->check() ? auth()->user()->name : 'Admin';
            $studyCase->meta_image          = null;
            $studyCase->meta_canonical      = route('web_study_case', Str::slug($request->title));
            $studyCase->meta_robots         = 'index, follow';
            $studyCase->slug                = Str::slug($request->title);
            $studyCase->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('study-case')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file           = $request->file('image');
                $deleteImage    = ImageHelper::deleteFileExists($studyCase->image,'study_case_banner',['small-thumb','normal', 'meta', 'ori']);
                $image          = ImageHelper::uploadImage($file,'study_case_banner',['small-thumb', 'normal', 'meta']);

                $studyCase->image       = $image;
                $studyCase->meta_image  = $image ?? null;
                $studyCase->update();
            }
            if ($request->hasFile('icon')) {

                $fileIcon   = $request->file('icon');
                $deleteIcon = ImageHelper::deleteFileExists($studyCase->icon,'study_case_icon',['thumb2', 'ori']);
                $icon       = ImageHelper::uploadImage($fileIcon,'study_case_icon',['thumb2']);

                $studyCase->icon    = $icon;
                $studyCase->update();
            }
            return redirect()->route('study-case')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyCase $studyCase)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            
            if($studyCase->image){
                $deleteImage    = ImageHelper::deleteFileExists($studyCase->image,'study_case_banner',['small-thumb','normal', 'meta', 'ori']);
            }

            if($studyCase->icon){
                $deleteIcon     = ImageHelper::uploadImage($fileIcon,'study_case_icon',['thumb2']);
            }

            $studyCase->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('study-case')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('study-case')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $studyCases     = StudyCase::where('is_active', true); // eager load roles
            $routeEdit      = 'study-case.edit';
            $routeDestroy   = 'study-case.delete';
            $routeShow      = 'study-case.show';
            $iconEdit       = '<i class="bi bi-pencil"></i>';
            $iconDestroy    = '<i class="bi bi-trash"></i>';
            $iconShow       = '<i class="bi bi-eye"></i>';

            return DataTables::of($studyCases)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('icon', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'study_case_icon/';
                    $thumbPath = $item->icon
                        ? url($path . $dir . 'ori/' . $item->icon)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->icon
                        ? url($path . $dir . 'ori/' . $item->icon)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->slug) . '" title="' . e($item->slug) . '" height="50">
                            </a>';
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'study_case_banner/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'normal/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->title) . '" title="' . e($item->title) . '" height="50">
                            </a>';
                })
                ->addColumn('action', function ($studyCases) use ($routeEdit, $routeDestroy, $routeShow, $iconEdit, $iconDestroy, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show article')){
                        $btn_action .=  '<a title="Show article data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['studyCase' => $studyCases->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit article')){
                        $btn_action .=  '<a title="Edit article data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['studyCase' => $studyCases->id]) . '">' . $iconEdit . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can delete article')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['studyCase' => $studyCases->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $studyCases->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $studyCases->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $studyCases->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $studyCases->id . '">Hapus Data</h1>
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
            ->rawColumns(['studyCases', 'image', 'icon', 'action']) // to html
            ->make(true);
        }
    }
}
