<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backends\About;
use App\Models\Backends\Article;
use App\Models\Backends\ArticleCategory;
use App\Models\Backends\Banner;
use App\Models\Backends\Certificate;
use App\Models\Backends\ClientModel;
use App\Models\Backends\Customer;
use App\Models\Backends\ExVessel;
use App\Models\Backends\Facility;
use App\Models\Backends\Motto;
use App\Models\Backends\Partner;
use App\Models\Backends\Product;
use App\Models\Backends\ProductCategory;
use App\Models\Backends\Project;
use App\Models\Backends\ProjectCategory;
use App\Models\Backends\Vision;
use App\Http\Helpers\SeoHelper;
use Illuminate\Http\Request;
use DB;
use Mail;
use Validator;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seo        = About::where('is_active', 1)->first();
        $banners    = Banner::where('is_active', 1)->limit(3)->get();
        $visions    = Vision::where('is_active', 1)->limit(3)->get();
        $mottos     = Motto::where('is_active', 1)->limit(3)->get();
        $projects   = Project::where('is_active', 1)->latest()->limit(5)->get();
        $clients    = ClientModel::where('is_active', 1)->latest()->limit(7)->get();
        $partners   = Partner::where('is_active', 1)->latest()->limit(7)->get();
        $articles   = Article::where('is_active', 1)->latest()->limit(7)->get();
        $title      = 'PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'about', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.index', compact(['title', 'banners', 'visions', 'mottos', 'projects', 'clients', 'articles', 'partners']));
    }

    public function story()
    {
        $about          = About::where('is_active', 1)->first();
        $certificates   = Certificate::where('is_active', 1)->get();
        $clients        = ClientModel::where('is_active', 1)->get();
        $partners       = Partner::where('is_active', 1)->get();
        $title          = 'Tentang PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($about) {
            SeoHelper::setMeta([
                'meta_title'        => $about->meta_title,
                'meta_description'  => $about->meta_description,
                'meta_keywords'     => $about->meta_keywords,
                'meta_author'       => $about->meta_author,
                'meta_image_path'   => 'about', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $about->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $about->meta_robots,
            ]);
        }
        return view('frontends.story', compact(['title', 'about', 'certificates', 'clients', 'partners']));
    }

    public function facility()
    {
        $facilities = Facility::where('is_active', 1)->paginate(4);
        $seo        = $facilities->first();
        $title      = 'Fasilitas PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'facility', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.facility', compact(['facilities', 'title']));
    }

    public function product()
    {
        $products   = Product::where('is_active', 1)->paginate(4);
        $seo        = $products->first();
        $title      = 'Produk PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'product', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.product', compact(['products', 'title']));
    }

    public function project()
    {
        $projects   = Project::where('is_active', 1)->paginate(4);
        $seo        = $projects->first();
        $title      = 'Proyek PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'project', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.project', compact(['projects', 'title']));
    }

    public function projectShow($slug)
    {
        $project    = Project::where('slug', $slug)->firstOrFail();
        $title      = 'Detail Proyek PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        if ($project) {
            SeoHelper::setMeta([
                'meta_title'        => $project->meta_title,
                'meta_description'  => $project->meta_description,
                'meta_keywords'     => $project->meta_keywords,
                'meta_author'       => $project->meta_author,
                'meta_image_path'   => 'project', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $project->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $project->meta_robots,
            ]);
        }
        return view('frontends.project-show', compact('project', 'title'));
    }

    public function contact()
    {
        $seo    = About::where('is_active', 1)->first();
        $title  = 'Hubungi Kami PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'about', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.contact', compact('title'));
    }

    public function addQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email:rfc,dns',
            'phone'     => 'required',
            'message'   => 'required',
        ], [
            'name.required'     => 'Nama wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email belum sesuai',
            'phone.required'    => 'No Hp wajib diisi',
            'message.required'  => 'Pesan wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors())
                        ->withInput();
        }

        DB::beginTransaction();
        $success_trans = false;

        try {

            $customer               = new Customer();
            $customer->name         = $request->name;
            $customer->email        = $request->email;
            $customer->phone        = $request->phone;
            $customer->product_name = $request->product_name;
            $customer->message      = $request->message;
            $customer->is_active    = true;
            $customer->save();

            DB::commit();
            $success_trans = true;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($success_trans == true) {
            Mail::send('emails.customer', ['request' => $request], function ($m) use ($request) {
                $m->from('noreply@arjayamarine.com', 'PT. Arjaya Berkah Marine');
                $m->to($request->email, $request->nama)->subject('Arjaya Marine - Info Produk ' . $request->product_name);
            });
            Mail::send('emails.user', ['request' => $request], function ($m) use ($request) {
                $m->from('noreply@arjayamarine.com', 'PT. Arjaya Berkah Marine');
                $m->to(['arjayamarine@gmail.com','chalid.alys@gmail.com'], 'Info Arjaya')->subject('Arjaya Marine - Request Info Produk Dari ' . $request->name . ' mengenai ' . $request->product_name);
            });

            return redirect()->back()->with('success', 'Message sent successfully!');
        }
    }

    public function xvessel()
    {
        $exVessels  = ExVessel::where('is_active', 1)->paginate(4);
        $seo        = $exVessels->first();
        $title      = 'Kapal Second PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'exvessel', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.xvessel', compact(['exVessels', 'title']));
    }

    public function article(Request $request)
    {
        // Filter by category if available
        $query  = Article::with('category')->where('is_active', 1);
        $title  = 'Artikel PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';

        if ($request->has('category')) {
            $query->where('article_category_id', $request->category);
        }

        $articles = $query->latest()->paginate(6)->withQueryString();

        $seo = $articles->first();
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'article',
                'meta_image'        => $seo->meta_image,
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }

        $categories     = ArticleCategory::all();
        $recentArticles = Article::where('is_active', 1)->latest()->take(3)->get();

        return view('frontends.article', compact('articles', 'categories', 'recentArticles', 'title'));
    }

    public function articleShow($slug)
    {
        $article    = Article::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $title      = 'Detail Artikel PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';

        // Sidebar Data
        $categories = ArticleCategory::withCount('articles')->get();
        $recent_articles = Article::where('is_active', 1)->latest()->take(3)->get();

        // Previous & Next
        $previous = Article::where('id', '<', $article->id)->orderBy('id', 'desc')->first();
        $next     = Article::where('id', '>', $article->id)->orderBy('id', 'asc')->first();

        SeoHelper::setMeta([
            'meta_title'        => $article->meta_title,
            'meta_description'  => $article->meta_description,
            'meta_keywords'     => $article->meta_keywords,
            'meta_author'       => $article->meta_author,
            'meta_image_path'   => 'article',
            'meta_image'        => $article->meta_image,
            'meta_canonical'    => url()->current(),
            'meta_robots'       => $article->meta_robots,
        ]);

        return view('frontends.article-show', compact('article', 'categories', 'recent_articles', 'previous', 'next', 'title'));
    }

    public function partner()
    {
        $partners   = Partner::where('is_active', 1)->get();
        $seo        = About::where('is_active', 1)->first();
        $title      = 'Partner PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'about', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.partner', compact(['partners', 'title']));
    }

    public function client()
    {
        $clients    = ClientModel::where('is_active', 1)->get();
        $seo        = About::where('is_active', 1)->first();
        $title      = 'Klien PT. Arjaya Berkah Marine | PT. Arjaya Berkah Marine';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'about', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.client', compact(['clients', 'title']));
    }
}
