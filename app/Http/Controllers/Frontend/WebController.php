<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backends\About;
use App\Models\Backends\Article;
use App\Models\Backends\ArticleCategory;
use App\Models\Backends\Banner;
use App\Models\Backends\Certificate;
use App\Models\Backends\Customer;
use App\Models\Backends\Brand;
use App\Models\Backends\Partner;
use App\Models\Backends\Product;
use App\Models\Backends\ProductCategory;
use App\Models\Backends\Faq;
use App\Models\Backends\FaqCategory;
use App\Models\Backends\StudyCase;
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
        $seo                = About::where('is_active', 1)->first();
        $banners            = Banner::where('is_active', 1)->limit(5)->get();
        $productCategories  = ProductCategory::where('parent_id', null)->where('is_active', 1)->get();
        $brands             = Brand::where('is_active', 1)->get();
        $studyCases         = StudyCase::where('is_active', 1)->latest()->limit(6)->get();
        // $clients    = ClientModel::where('is_active', 1)->latest()->limit(7)->get();
        // $partners   = Partner::where('is_active', 1)->latest()->limit(7)->get();
        $articles           = Article::where('is_active', 1)->latest()->limit(8)->get();
        $title              = 'Simplo';
        $body               = 'index';
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
        return view('frontends.index', compact(['title', 'body', 'banners', 'productCategories', 'articles', 'brands', 'studyCases']));
    }

    public function story()
    {
        $about  = About::where('is_active', 1)->firstOrFail();
        $title  = $about->title;
        $body   = 'about-page';
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
        return view('frontends.story', compact(['title', 'about', 'body']));
    }

    public function product(Request $request)
    {
        $catSlug    = $request->query('cat');
        $activeCat  = null;
        $query      = Product::with('category')->latest();

        if ($catSlug) {
            $activeCat = ProductCategory::whereSlug($catSlug)->firstOrFail();
            $ids = collect([$activeCat->id])
                   ->merge($activeCat->children()->pluck('id'))
                   ->all();
            $query->whereIn('product_category_id', $ids);
        }

        $products   = $query->paginate(6)->withQueryString();

        $menuRoots  = ProductCategory::with('children')
                     ->where('parent_id', null)
                     ->orderBy('title')
                     ->get();

        $seo        = $products->first();
        $title      = 'Produk Simplo | Simplo';
        $body       = 'product-page';
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
        return view('frontends.product', compact(['products', 'title', 'body', 'menuRoots', 'activeCat']));
    }

    public function productShow(Product $product)
    {
        $seo        = $product;
        $title      = $product->title . ' | Simplo';
        $body       = 'product-detail-page';
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
        return view('frontends.product-show', compact(['product', 'title', 'body']));
    }

    public function contact()
    {
        $seo        = About::where('is_active', 1)->first();
        $title      = $seo->title . ' | Simplo';
        $body       = 'contact-page';
        $products   = Product::where('is_active', true)->pluck('title', 'title')->put('', 'Pilih Produk');
        $faqs       = FaqCategory::with('faqs')->where('is_active', true)->limit(2)->get();
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
        return view('frontends.contact', compact('title', 'body', 'products', 'faqs'));
    }

    public function addQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'name'      => 'required',
            'email'     => 'required|email:rfc,dns',
            'phone'     => 'required',
            'message'   => 'required',
        ], [
            'title.required'    => 'Title wajib diisi, agar kami tidak salah dalam menyapa anda',
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
            $customer->title        = $request->title;
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
                $m->from('noreply@arjayamarine.com', 'Simploo');
                $m->to($request->email, $request->nama)->subject('Arjaya Marine - Info Produk ' . $request->product_name);
            });
            Mail::send('emails.user', ['request' => $request], function ($m) use ($request) {
                $m->from('noreply@arjayamarine.com', 'Simploo');
                $m->to(['arjayamarine@gmail.com','chalid.alys@gmail.com'], 'Info Simploo')->subject('Arjaya Marine - Request Info Produk Dari ' . $request->name . ' mengenai ' . $request->product_name);
            });

            return redirect()->back()->with('success', 'Message sent successfully!');
        }
    }

    public function article(Request $request)
    {
        // Filter by category if available
        $query  = Article::with('category')->where('is_active', 1);
        $title  = 'Artikel';
        $body   = 'news-page';

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

        return view('frontends.article', compact('articles', 'categories', 'recentArticles', 'title', 'body'));
    }

    public function articleShow($slug)
    {
        $article    = Article::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $title      = $article->title;
        $body       = 'news-detail-page';

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

        return view('frontends.article-show', compact('article', 'categories', 'recent_articles', 'previous', 'next', 'title', 'body'));
    }

    public function faq(?string $slug = null)
    {
        // 1.  Ambil kategori sidebar (urut nama)
        $categories = FaqCategory::orderBy('name')->get();
        // 2.  Tentukan kategori aktif
        $category = $slug
            ? FaqCategory::where('slug', $slug)->firstOrFail()
            : $categories->first();                 // jika /faq tanpa slug

        // 3.  FAQ untuk kategori tsb (urut position)
        $faqs = $category->faqs;                    // relasi sudah di‑order

        $seo        = $category->first();
        $title      = 'Faq | Simplo';
        $body       = 'faq-page';
        // Use SEO metadata from first banner or fallback
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'faq', // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_image'        => $seo->meta_image, // ensure this is a relative path, e.g., 'storage/banners/xyz.jpg'
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }
        return view('frontends.faq', compact(['categories', 'category', 'faqs', 'title', 'body']));
    }

    public function studyCase(?string $slug = null)
    {
        // Filter by category if available
        $query  = StudyCase::where('slug', $slug)->firstOrFail();
        $title  = 'Study Case';
        $body   = 'about-page';
        $studyCase = $query;

        $seo = $query;
        if ($seo) {
            SeoHelper::setMeta([
                'meta_title'        => $seo->meta_title,
                'meta_tag'          => $seo->meta_tag,
                'meta_description'  => $seo->meta_description,
                'meta_keywords'     => $seo->meta_keywords,
                'meta_author'       => $seo->meta_author,
                'meta_image_path'   => 'study_case',
                'meta_image'        => $seo->meta_image,
                'meta_canonical'    => url()->current(),
                'meta_robots'       => $seo->meta_robots,
            ]);
        }

        return view('frontends.study_case', compact('studyCase', 'title', 'body'));
    }
}
