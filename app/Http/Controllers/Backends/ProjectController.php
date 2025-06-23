<?php

namespace App\Http\Controllers\Backends;

Use App\Http\Controllers\Controller;
use App\Models\Backends\Project;
use App\Models\Backends\ProjectImage;
use App\Models\Backends\ProjectCategory;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Validator;
use ImageHelper;
use Str;

class ProjectController extends Controller
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
        $routeAjax      = 'project.get_data';
        $title          = 'List Project';

        return view('backends.project.index', compact(['confirmDelete','routeAjax','title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title              = 'Tambah Project';
        $projectCategories  = ProjectCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Project')->sortKeys();
        return view('backends.project.create', compact('title', 'projectCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'project_category_id'   => 'required',
            'is_active'             => 'required|boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'project_category_id.required'  => 'project category wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
            'image.required'                => 'Hanya gambar',
            'image.mimes'                   => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'                     => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('project.create')
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $project                        = new Project();
            $project->title                 = $request->title;
            $project->description           = $request->description;
            $project->project_category_id   = $request->project_category_id;
            $project->is_active             = $request->is_active;
            $project->meta_title            = $request->title;
            $project->meta_description      = Str::limit(strip_tags($request->description), 150);
            $project->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $project->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $project->meta_image            = null;
            $project->meta_canonical        = url()->current();
            $project->meta_robots           = 'index, follow';
            $project->slug                  = Str::slug($request->title);
            $project->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('project')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'project',['small-thumb', 'small','normal', 'meta', 'large']);

                $project->image         = $image;
                $project->meta_image    = $image ?? null;
                $project->update();

                $projectImage  = new ProjectImage();
                $projectImage->project_id = $project->id;
                $projectImage->uri        = $image;
                $projectImage->is_default = true;
                $projectImage->save();
            }
            return redirect()->route('project')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $title          = 'Detail Project';
        $confirmDelete  = 'Yakin ingin menghapus data ini?';
        return view('backends.project.show', compact('title', 'project', 'confirmDelete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $title              = 'Edit Project';
        $projectCategories  = ProjectCategory::pluck('name', 'id')->put(0, 'Pilih Kategori Project')->sortKeys();
        return view('backends.project.edit', compact('title', 'project', 'projectCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'title'                 => 'required',
            'description'           => 'required',
            'project_category_id'   => 'required',
            'is_active'             => 'required|boolean',
        ], [
            'title.required'                => 'title wajib diisi',
            'description.required'          => 'description wajib diisi',
            'project_category_id.required'  => 'project category wajib diisi',
            'is_active.required'            => 'is active wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('project.edit', $project->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $project->title                 = $request->title;
            $project->description           = $request->description;
            $project->is_active             = $request->is_active;
            $project->project_category_id   = $request->project_category_id;
            $project->meta_title            = $request->title;
            $project->meta_description      = Str::limit(strip_tags($request->description), 150);
            $project->meta_keywords         = implode(',', explode(' ', Str::lower($request->title)));
            $project->meta_author           = auth()->check() ? auth()->user()->name : 'Admin';
            $project->meta_canonical        = url()->current();
            $project->meta_robots           = 'index, follow';
            $project->slug                  = Str::slug($request->title);
            $project->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project')->with('success', 'Berhasil terkirim');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            foreach($project->images as $image){
                $deleteImage = ImageHelper::deleteFileExists($image->uri,'project',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            }
            $project->images->each->delete();

            $project->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project')->with('alert-success', 'Berhasil terkirim');
        }
    }

    public function ajaxDatatable(Request $request)
    {
        if ($request->ajax()) {
            $projects           = Project::with('category'); // eager load roles
            $routeEdit          = 'project.edit';
            $routeDestroy       = 'project.delete';
            $routePermission    = 'project.permission';
            $routeShow          = 'project.show';
            $iconEdit           = '<i class="bi bi-pencil"></i>';
            $iconDestroy        = '<i class="bi bi-trash"></i>';
            $iconPermission     = '<i class="bi bi-lock"></i>';
            $iconShow           = '<i class="bi bi-eye"></i>';

            return DataTables::of($projects)
                ->addIndexColumn()
                ->editColumn('is_active', function ($row) {
                    return $row->is_active ? 'Active' : 'Not Active';
                })
                ->editColumn('description', function ($row) {
                    return strip_tags(Str::limit($row->description, 50)); // limit to 50 characters
                })
                ->editColumn('image', function ($item) {
                    $path   = 'storage/upload_files/images/';
                    $dir    = 'project/';
                    $thumbPath = $item->image
                        ? url($path . $dir . 'small-thumb/' . $item->image)
                        : url('assets/backend/images/png/no_image.png');

                    $originalPath = $item->image
                        ? url($path . $dir . 'large/' . $item->image)
                        : '#';

                    return '<a href="' . $originalPath . '" target="_blank">
                                <img src="' . $thumbPath . '" alt="' . e($item->name) . '" title="' . e($item->name) . '" height="50">
                            </a>';
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
                    $query->join('project_categories', 'projects.project_category_id', '=', 'project_categories.id')
                        ->orderBy('project_categories.name', $order);
                })
                ->addColumn('action', function ($projects) use ($routeEdit, $routeDestroy, $routePermission, $routeShow, $iconEdit, $iconDestroy, $iconPermission, $iconShow) {
                    $btn_action = '';
                    $btn_action .=  '<div class="btn-group">';
                    if(Auth::user()->can('Can show project')){
                        $btn_action .=  '<a title="Show project data" class="btn btn-primary btn-sm btn-icon" href="' . route($routeShow, ['project' => $projects->id]) . '">' . $iconShow . '</a>&nbsp;';
                    }
                    if(Auth::user()->can('Can edit project')){
                        $btn_action .=  '<a title="Edit project data" class="btn btn-warning btn-sm btn-icon" href="' . route($routeEdit, ['project' => $projects->id]) . '">' . $iconEdit . '</a>&nbsp;';

                        $statusIcon = $projects->is_active ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>';
                        $modalId = 'modalToggleStatus' . $projects->id;
                        $valueActive = $projects->is_active ? 0 : 1;
                        $btn_action .= '
                                        <form action="' . route('project.active', ['project' => $projects->id]) . '" method="POST">
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
                                                            <p>Apakah Anda yakin ingin mengubah status menjadi <strong>' . ($projects->is_active ? 'Nonaktif' : 'Aktif') . '</strong>?</p>
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
                    if(Auth::user()->can('Can delete project')){
                        $btn_action .=  '<form action="' . route($routeDestroy, ['project' => $projects->id]) . '" method="POST">' .
                                            '<input type="hidden" name="_method" value="delete">' . // Add this line to specify the PATCH method
                                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' . // Add this line for CSRF protection
                                            '<a data-bs-toggle="modal" class="btn btn-danger btn-sm btn-icon" title="Delete Data" href="" data-bs-target="#staticDeleteBackdrop' . $projects->id . '">' . $iconDestroy . '</a>' .
                                            '<div class="modal fade" id="staticDeleteBackdrop' . $projects->id . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticDeleteBackdropLabel' . $projects->id . '" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticDeleteBackdropLabel' . $projects->id . '">Hapus Data</h1>
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
            ->rawColumns(['projects', 'image', 'action']) // to html
            ->make(true);
        }
    }

    public function active(Request $request, Project $project)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {

            $project->is_active           = $request->is_active;
            $project->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project')->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project')->with('success', 'Berhasil terkirim');
        }
    }

    public function imageAdd(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:6144',
        ], [
            'image.required'        => 'Hanya gambar',
            'image.mimes'           => 'Hanya file bertipe jpeg,png,jpg,gif',
            'image.max'             => 'Tidak bole lebih dari 6144',
        ]);

        if ($validator->fails()) {
            return redirect()->route('project.show', $project->id)
                        ->with('error',$validator->errors())
                        ->withInput();
        }
        DB::beginTransaction();
        $success_trans = false;

        try {

            if ($request->hasFile('image')) {
                $file   = $request->file('image');

                $image = ImageHelper::uploadImage($file,'project',['small-thumb', 'small','normal', 'meta', 'large']);

                $project->image         = $image;
                $project->meta_image    = $image ?? null;
                $project->update();

                $oldProjectImage           = ProjectImage::where('project_id', $project->id)->where('is_default', true)->update(['is_default' => false]);

                $projectImage              = new ProjectImage();
                $projectImage->project_id  = $project->id;
                $projectImage->uri         = $image;
                $projectImage->is_default  = true;
                $projectImage->save();
            }

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project.show', $project->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project.show', $project->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageSetDefault(Request $request, Project $project, ProjectImage $projectImage)
    {
        $projectImage = ProjectImage::find($request->image_id);

        DB::beginTransaction();
        $success_trans = false;

        try {

            $project->image             = $projectImage->uri;
            $project->meta_image        = $projectImage->uri ?? null;
            $project->update();

            $oldProjectImage            = ProjectImage::where('project_id', $project->id)->where('is_default', true)->update(['is_default' => false]);

            $projectImage->is_default   = true;
            $projectImage->update();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project.show', $project->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project.show', $project->id)->with('success', 'Berhasil terkirim');
        }
    }

    public function imageDelete(Request $request, Project $project, ProjectImage $projectImage)
    {
        DB::beginTransaction();
        $success_trans = false;

        try {
            $projectImage = ProjectImage::find($request->image_id);

            $project->image             = null;
            $project->meta_image        = null;
            $project->update();

            $deleteImage = ImageHelper::deleteFileExists($projectImage->uri,'project',['small-thumb', 'small','normal', 'meta', 'large', 'original']);
            $projectImage->delete();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            // error page
            return redirect()->route('project.show', $project->id)->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            return redirect()->route('project.show', $project->id)->with('success', 'Berhasil terkirim');
        }
    }
}
