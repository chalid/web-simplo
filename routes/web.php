<?php

use Illuminate\Support\Facades\Route;

//Frontend

Route::get('/', [App\Http\Controllers\Frontend\WebController::class, 'index'])->name('web_index');
Route::get('/about', [App\Http\Controllers\Frontend\WebController::class, 'story'])->name('web_about');
Route::get('/product', [App\Http\Controllers\Frontend\WebController::class, 'product'])->name('web_product');
Route::get('/product/{slug}', [App\Http\Controllers\Frontend\WebController::class, 'productShow'])->name('web_product.show');
Route::get('/contact', [App\Http\Controllers\Frontend\WebController::class, 'contact'])->name('web_contact');
Route::post('/add_question', [App\Http\Controllers\Frontend\WebController::class, 'addQuestion'])->name('web_add_question');
Route::get('/article', [App\Http\Controllers\Frontend\WebController::class, 'article'])->name('web_article');
Route::get('/article/{slug}', [App\Http\Controllers\Frontend\WebController::class, 'articleShow'])->name('web_article.show');
Route::get('/faq', [App\Http\Controllers\Frontend\WebController::class, 'faq'])->name('web_faq');

// Add this instead:
Route::get('/login', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
});

// Logout route (for authenticated users)
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        
        /**
         * home
         */
        Route::get('/home', [App\Http\Controllers\Backends\HomeController::class, 'index'])->name('home');
        Route::get('/home/change_password', [App\Http\Controllers\Backends\HomeController::class, 'changePassword'])->name('home.change_password');
        Route::patch('/home/update_password', [App\Http\Controllers\Backends\HomeController::class, 'updatePassword'])->name('home.update_password');
        Route::get('/home/change_avatar', [App\Http\Controllers\Backends\HomeController::class, 'changeAvatar'])->name('home.change_avatar');
        Route::patch('/home/update_avatar', [App\Http\Controllers\Backends\HomeController::class, 'updateAvatar'])->name('home.update_avatar');
        Route::get('/chart-data', [App\Http\Controllers\Backends\HomeController::class, 'getChartData']);
        /**
         * Google Analytics
         * 
         */
        Route::prefix('analytics')->controller(App\Http\Controllers\Backends\AnalyticsController::class)->group(function () {
            Route::get('/dashboard', 'index');
            Route::get('/device-sessions', 'deviceSessions');
            Route::get('/pageviews', 'pageviews');
            Route::get('/avg-time-on-site', 'avgTimeOnSite');
            Route::get('/bounce-rate', 'bounceRate');
            Route::get('/new-sessions', 'newSessions');
            Route::get('/users-by-country', 'usersByCountry');
            Route::get('/landing-pages', 'landingPages');
            Route::get('/traffic-sources', 'trafficSources');
        });
    
    
    
        /**
         * sysparams
         */
        Route::middleware('role_or_permission:Sysparam')->group(function () {
            Route::get('/sysparam/get_data',[App\Http\Controllers\Backends\SysparamController::class,'ajaxDatatable'])->name('sysparam.get_data');
            Route::get('/sysparam', [App\Http\Controllers\Backends\SysparamController::class, 'index'])->name('sysparam');
        });
        Route::middleware('role_or_permission:Can add sysparam')->group(function () {
            Route::post('/sysparam/store', [App\Http\Controllers\Backends\SysparamController::class, 'store'])->name('sysparam.store');
        });
        Route::middleware('role_or_permission:Can edit sysparam')->group(function () {
            Route::patch('/sysparam/{sysparam}/update', [App\Http\Controllers\Backends\SysparamController::class, 'update'])->name('sysparam.update');
        });
        Route::middleware('role_or_permission:Can delete sysparam')->group(function () {
            Route::delete('/sysparam/{sysparam}/delete', [App\Http\Controllers\Backends\SysparamController::class, 'destroy'])->name('sysparam.delete');
        });
        
        /**
         * Untuk manajemen Role
         */
        Route::middleware('role_or_permission:Role')->group(function () {
            Route::get('/role/get_data',[App\Http\Controllers\Backends\RoleController::class,'ajaxDatatable'])->name('role.get_data');
            Route::get('/role',[App\Http\Controllers\Backends\RoleController::class,'index'])->name('role');
        });
        Route::middleware('role_or_permission:Can add role')->group(function () {
            Route::post('/role/store',[App\Http\Controllers\Backends\RoleController::class,'store'])->name('role.store');
        });
        Route::middleware('role_or_permission:Can edit role')->group(function () {
            Route::patch('/role/{role}/update',[App\Http\Controllers\Backends\RoleController::class,'update'])->name('role.update');
        });
        Route::middleware('role_or_permission:Can delete role')->group(function () {
            Route::delete('/role/{role}/delete',[App\Http\Controllers\Backends\RoleController::class,'destroy'])->name('role.delete');
        });
        Route::middleware('role_or_permission:Can show role permission')->group(function () {
            Route::get('/role/{role}/permission',[App\Http\Controllers\Backends\RoleController::class,'permission'])->name('role.permission');
        });
        Route::middleware('role_or_permission:Can add role permission')->group(function () {
            Route::post('/role/{role}/permission/{permission}/store',[App\Http\Controllers\Backends\RoleController::class,'permissionStore'])->name('role.permission.store');
        });
        /**
         * Untuk manajemen Permission
         */
        Route::middleware('role_or_permission:Permission')->group(function () {
            Route::get('/permission/ajax_datatable', [App\Http\Controllers\Backends\PermissionController::class,'ajaxDatatable'])->name('permission.get_data');
            Route::get('/permission',[App\Http\Controllers\Backends\PermissionController::class, 'index'])->name('permission');
        });
        Route::middleware('role_or_permission:Can add permission')->group(function () {
            Route::get('/permission/add',[App\Http\Controllers\Backends\PermissionController::class, 'create'])->name('permission.create');
            Route::post('/permission/store', [App\Http\Controllers\Backends\PermissionController::class,'store'])->name('permission.store');
        });
        Route::middleware('role_or_permission:Can edit permission')->group(function () {
            Route::get('/permission/{permission}/edit', [App\Http\Controllers\Backends\PermissionController::class,'edit'])->name('permission.edit');
            Route::patch('/permission/{permission}/update', [App\Http\Controllers\Backends\PermissionController::class,'update'])->name('permission.update');
        });
        Route::middleware('role_or_permission:Can delete permission')->group(function () {
            Route::delete('/permission/{permission}/delete', [App\Http\Controllers\Backends\PermissionController::class,'destroy'])->name('permission.delete');
        });
        Route::get('/check_permission', [App\Http\Controllers\Backends\PermissionController::class, 'checkPermission']);
                
        /** 
         * Untuk manajemen User
         */
        Route::middleware('role_or_permission:User')->group(function () {
            Route::get('/user/get_data', [App\Http\Controllers\Backends\UserController::class,'ajaxDatatable'])->name('user.get_data');
            Route::get('/user', [App\Http\Controllers\Backends\UserController::class, 'index'])->name('user');
        });
        Route::middleware('role_or_permission:Can add user')->group(function () {
            Route::get('/user/add', [App\Http\Controllers\Backends\UserController::class, 'create'])->name('user.add');
            Route::post('/user/store', [App\Http\Controllers\Backends\UserController::class, 'store'])->name('user.store');
        });
        Route::middleware('role_or_permission:Can show user')->group(function () {
            Route::get('/user/{user}', [App\Http\Controllers\Backends\UserController::class, 'show'])->name('user.show');
        });
        Route::middleware('role_or_permission:Can edit user')->group(function () {
            Route::get('/user/{user}/edit', [App\Http\Controllers\Backends\UserController::class, 'edit'])->name('user.edit');
            Route::put('/user/{user}/update', [App\Http\Controllers\Backends\UserController::class, 'update'])->name('user.update');
            Route::get('/user/{user}/change_password', [App\Http\Controllers\Backends\UserController::class, 'changePassword'])->name('user.change_password');// for admin
            Route::put('/user/{user}/update_password', [App\Http\Controllers\Backends\UserController::class, 'updatePassword'])->name('user.update_password');// for user
            Route::put('/user/{user}/update_avatar', [App\Http\Controllers\Backends\UserController::class, 'updateAvatar'])->name('user.update_avatar');// for user
        });
        Route::middleware('role_or_permission:Can delete user')->group(function () {
            Route::patch('/user/{user}/delete', [App\Http\Controllers\Backends\UserController::class, 'destroy'])->name('user.delete');
        });
        Route::middleware('role_or_permission:Can edit user role')->group(function () {
            Route::put('/user/{user}/update_role', [App\Http\Controllers\Backends\UserController::class, 'updateRole'])->name('user.update_role');// for user
        });
    
        /**
         * Front End / Website
         */
    
        /**
         * About Us
         */
        Route::middleware('role_or_permission:About')->group(function () {
            Route::get('/aboutus/ajax_datatable', [App\Http\Controllers\Backends\AboutController::class,'ajaxDatatable'])->name('about.get_data');
            Route::get('/aboutus',[App\Http\Controllers\Backends\AboutController::class, 'index'])->name('about');
        });
        Route::middleware('role_or_permission:Can add about')->group(function () {
            Route::get('/aboutus/add',[App\Http\Controllers\Backends\AboutController::class, 'create'])->name('about.create');
            Route::post('/aboutus/store', [App\Http\Controllers\Backends\AboutController::class,'store'])->name('about.store');
        });
        Route::middleware('role_or_permission:Can edit about')->group(function () {
            Route::get('/aboutus/{about}/edit', [App\Http\Controllers\Backends\AboutController::class,'edit'])->name('about.edit');
            Route::patch('/aboutus/{about}/update', [App\Http\Controllers\Backends\AboutController::class,'update'])->name('about.update');
            Route::patch('/aboutus/{about}/active', [App\Http\Controllers\Backends\AboutController::class,'active'])->name('about.active');
        });
        Route::middleware('role_or_permission:Can delete about')->group(function () {
            Route::delete('/aboutus/{about}/delete', [App\Http\Controllers\Backends\AboutController::class,'destroy'])->name('about.delete');
        });
    
        /**
         * Article
         */
        Route::middleware('role_or_permission:Article')->group(function () {
            Route::get('/article/ajax_datatable', [App\Http\Controllers\Backends\ArticleController::class,'ajaxDatatable'])->name('article.get_data');
            Route::get('/article',[App\Http\Controllers\Backends\ArticleController::class, 'index'])->name('article');
        });
        Route::middleware('role_or_permission:Can add article')->group(function () {
            Route::get('/article/add',[App\Http\Controllers\Backends\ArticleController::class, 'create'])->name('article.create');
            Route::post('/article/store', [App\Http\Controllers\Backends\ArticleController::class,'store'])->name('article.store');
        });
        Route::middleware('role_or_permission:Can edit article')->group(function () {
            Route::get('/article/{article}/edit', [App\Http\Controllers\Backends\ArticleController::class,'edit'])->name('article.edit');
            Route::patch('/article/{article}/update', [App\Http\Controllers\Backends\ArticleController::class,'update'])->name('article.update');
            Route::patch('/article/{article}/active', [App\Http\Controllers\Backends\ArticleController::class,'active'])->name('article.active');
            
        });
        Route::middleware('role_or_permission:Can show article')->group(function () {
            Route::get('/article/{article}', [App\Http\Controllers\Backends\ArticleController::class,'show'])->name('article.show');
        });
        Route::middleware('role_or_permission:Can delete article')->group(function () {
            Route::delete('/article/{article}/delete', [App\Http\Controllers\Backends\ArticleController::class,'destroy'])->name('article.delete');
        });
        Route::middleware('role_or_permission:Can set article image')->group(function () {
            Route::post('/article/{article}/image', [App\Http\Controllers\Backends\ArticleController::class,'imageAdd'])->name('article.image.store');
            Route::patch('/article/{article}/image/{image}/set_default', [App\Http\Controllers\Backends\ArticleController::class,'imageSetDefault'])->name('article.image.set_default');
            Route::delete('/article/{article}/image/{image}/delete', [App\Http\Controllers\Backends\ArticleController::class,'imageDelete'])->name('article.image.delete');
        });

        /**
         * Article Category
         */

        Route::middleware('role_or_permission:Article Category')->group(function () {
            Route::get('/article-category/ajax_datatable', [App\Http\Controllers\Backends\ArticleCategoryController::class,'ajaxDatatable'])->name('article-category.get_data');
            Route::get('/article-category',[App\Http\Controllers\Backends\ArticleCategoryController::class, 'index'])->name('article-category');
        });
        Route::middleware('role_or_permission:Can add article category')->group(function () {
            Route::post('/article-category/store', [App\Http\Controllers\Backends\ArticleCategoryController::class,'store'])->name('article-category.store');
        });
        Route::middleware('role_or_permission:Can edit article category')->group(function () {
            Route::patch('/article-category/{articleCategory}/update', [App\Http\Controllers\Backends\ArticleCategoryController::class,'update'])->name('article-category.update');
        });
        Route::middleware('role_or_permission:Can delete article category')->group(function () {
            Route::delete('/article-category/{articleCategory}/delete', [App\Http\Controllers\Backends\ArticleCategoryController::class,'destroy'])->name('article-category.delete');
        });
    
        /**
         * Banner
         */
        Route::middleware('role_or_permission:Banner')->group(function () {
            Route::get('/banner/ajax_datatable', [App\Http\Controllers\Backends\BannerController::class,'ajaxDatatable'])->name('banner.get_data');
            Route::get('/banner',[App\Http\Controllers\Backends\BannerController::class, 'index'])->name('banner');

        });
        Route::middleware('role_or_permission:Can add banner')->group(function () {
            Route::get('/banner/add',[App\Http\Controllers\Backends\BannerController::class, 'create'])->name('banner.create');
            Route::post('/banner/store', [App\Http\Controllers\Backends\BannerController::class,'store'])->name('banner.store');
        });
        Route::middleware('role_or_permission:Can edit banner')->group(function () {
            Route::get('/banner/{banner}/edit', [App\Http\Controllers\Backends\BannerController::class,'edit'])->name('banner.edit');
            Route::patch('/banner/{banner}/update', [App\Http\Controllers\Backends\BannerController::class,'update'])->name('banner.update');
            Route::patch('/banner/{banner}/active', [App\Http\Controllers\Backends\BannerController::class,'active'])->name('banner.active');
        });
        Route::middleware('role_or_permission:Can delete banner')->group(function () {
            Route::delete('/banner/{banner}/delete', [App\Http\Controllers\Backends\BannerController::class,'destroy'])->name('banner.delete');
        });
        
        /**
         * Brand
         */
        Route::middleware('role_or_permission:Brand')->group(function () {
            Route::get('/brand/ajax_datatable', [App\Http\Controllers\Backends\BrandController::class,'ajaxDatatable'])->name('brand.get_data');
            Route::get('/brand',[App\Http\Controllers\Backends\BrandController::class, 'index'])->name('brand');
            
        });
        Route::middleware('role_or_permission:Can add brand')->group(function () {
            Route::post('/brand/store', [App\Http\Controllers\Backends\BrandController::class,'store'])->name('brand.store');
        });
        Route::middleware('role_or_permission:Can edit brand')->group(function () {
            Route::get('/brand/{brand}/edit', [App\Http\Controllers\Backends\BrandController::class,'edit'])->name('brand.edit');
            Route::patch('/brand/{brand}/update', [App\Http\Controllers\Backends\BrandController::class,'update'])->name('brand.update');
            Route::patch('/brand/{brand}/active', [App\Http\Controllers\Backends\BrandController::class,'active'])->name('brand.active');

        });
        Route::middleware('role_or_permission:Can delete brand')->group(function () {
            Route::delete('/brand/{brand}/delete', [App\Http\Controllers\Backends\BrandController::class,'destroy'])->name('brand.delete');
        });
    
        /**
         * Customer
         */
        Route::middleware('role_or_permission:Customer')->group(function () {
            Route::get('/customer/ajax_datatable', [App\Http\Controllers\Backends\CustomerController::class,'ajaxDatatable'])->name('customer.get_data');
            Route::get('/customer',[App\Http\Controllers\Backends\CustomerController::class, 'index'])->name('customer');
        });
        Route::middleware('role_or_permission:Can add customer')->group(function () {
            Route::get('/customer/add',[App\Http\Controllers\Backends\CustomerController::class, 'create'])->name('customer.create');
            Route::post('/customer/store', [App\Http\Controllers\Backends\CustomerController::class,'store'])->name('customer.store');
        });
        Route::middleware('role_or_permission:Can edit customer')->group(function () {
            Route::get('/customer/{customer}/edit', [App\Http\Controllers\Backends\CustomerController::class,'edit'])->name('customer.edit');
            Route::patch('/customer/{customer}/update', [App\Http\Controllers\Backends\CustomerController::class,'update'])->name('customer.update');
        });
        Route::middleware('role_or_permission:Can delete customer')->group(function () {
            Route::delete('/customer/{customer}/delete', [App\Http\Controllers\Backends\CustomerController::class,'destroy'])->name('customer.delete');
        });
    
        /**
         * Product Category
         */
        Route::middleware('role_or_permission:Product Category')->group(function () {
            Route::get('/product-category/ajax_datatable', [App\Http\Controllers\Backends\ProductCategoryController::class,'ajaxDatatable'])->name('product-category.get_data');
            Route::get('/product-category',[App\Http\Controllers\Backends\ProductCategoryController::class, 'index'])->name('product-category');
        });
        Route::middleware('role_or_permission:Can add product category')->group(function () {
            Route::get('/product-category/add',[App\Http\Controllers\Backends\ProductCategoryController::class, 'create'])->name('product-category.create');
            Route::post('/product-category/store', [App\Http\Controllers\Backends\ProductCategoryController::class,'store'])->name('product-category.store');
        });
        Route::middleware('role_or_permission:Can edit product category')->group(function () {
            Route::get('/product-category/{productCategory}/edit', [App\Http\Controllers\Backends\ProductCategoryController::class,'edit'])->name('product-category.edit');
            Route::patch('/product-category/{productCategory}/update', [App\Http\Controllers\Backends\ProductCategoryController::class,'update'])->name('product-category.update');
        });
        Route::middleware('role_or_permission:Can delete product category')->group(function () {
            Route::delete('/product-category/{productCategory}/delete', [App\Http\Controllers\Backends\ProductCategoryController::class,'destroy'])->name('product-category.delete');
        });
    
        /**
         * Product
         */
        Route::middleware('role_or_permission:Product')->group(function () {
            Route::get('/product/ajax_datatable', [App\Http\Controllers\Backends\ProductController::class,'ajaxDatatable'])->name('product.get_data');
            Route::get('/product',[App\Http\Controllers\Backends\ProductController::class, 'index'])->name('product');
        });
        Route::middleware('role_or_permission:Can add product')->group(function () {
            Route::get('/product/add',[App\Http\Controllers\Backends\ProductController::class, 'create'])->name('product.create');
            Route::post('/product/store', [App\Http\Controllers\Backends\ProductController::class,'store'])->name('product.store');
        });
        Route::middleware('role_or_permission:Can edit product')->group(function () {
            Route::get('/product/{product}/edit', [App\Http\Controllers\Backends\ProductController::class,'edit'])->name('product.edit');
            Route::patch('/product/{product}/update', [App\Http\Controllers\Backends\ProductController::class,'update'])->name('product.update');
            Route::patch('/product/{product}/active', [App\Http\Controllers\Backends\ProductController::class,'active'])->name('product.active');
        });
        Route::middleware('role_or_permission:Can show product')->group(function () {
            Route::get('/product/{product}', [App\Http\Controllers\Backends\ProductController::class,'show'])->name('product.show');
        });
        Route::middleware('role_or_permission:Can delete product')->group(function () {
            Route::delete('/product/{product}/delete', [App\Http\Controllers\Backends\ProductController::class,'destroy'])->name('product.delete');
        });
        Route::middleware('role_or_permission:Can set product image')->group(function () {
            Route::post('/product/{product}/image', [App\Http\Controllers\Backends\ProductController::class,'imageAdd'])->name('product.image.store');
            Route::patch('/product/{product}/image/{image}/set_default', [App\Http\Controllers\Backends\ProductController::class,'imageSetDefault'])->name('product.image.set_default');
            Route::delete('/product/{product}/image/{image}/delete', [App\Http\Controllers\Backends\ProductController::class,'imageDelete'])->name('product.image.delete');
        });
        
        /**
         * StudyCase
         */
        Route::middleware('role_or_permission:Study Case')->group(function () {
            Route::get('/study-case/ajax_datatable', [App\Http\Controllers\Backends\StudyCaseController::class,'ajaxDatatable'])->name('study-case.get_data');
            Route::get('/study-case',[App\Http\Controllers\Backends\StudyCaseController::class, 'index'])->name('study-case');

        });
        Route::middleware('role_or_permission:Can add study case')->group(function () {
            Route::get('/study-case/add',[App\Http\Controllers\Backends\StudyCaseController::class, 'create'])->name('study-case.create');
            Route::post('/study-case/store', [App\Http\Controllers\Backends\StudyCaseController::class,'store'])->name('study-case.store');
        });
        Route::middleware('role_or_permission:Can edit study case')->group(function () {
            Route::get('/study-case/{studyCase}/edit', [App\Http\Controllers\Backends\StudyCaseController::class,'edit'])->name('study-case.edit');
            Route::patch('/study-case/{studyCase}/update', [App\Http\Controllers\Backends\StudyCaseController::class,'update'])->name('study-case.update');
            Route::patch('/study-case/{studyCase}/active', [App\Http\Controllers\Backends\StudyCaseController::class,'active'])->name('study-case.active');
        });
        Route::middleware('role_or_permission:Can show study case')->group(function () {
            Route::get('/study-case/{studyCase}', [App\Http\Controllers\Backends\StudyCaseController::class,'show'])->name('study-case.show');
        });
        Route::middleware('role_or_permission:Can delete study case')->group(function () {
            Route::delete('/study-case/{studyCase}/delete', [App\Http\Controllers\Backends\StudyCaseController::class,'destroy'])->name('study-case.delete');
        });

        /**
         * Faq Category
         */
        Route::middleware('role_or_permission:Faq Category')->group(function () {
            Route::get('/faq-category/ajax_datatable', [App\Http\Controllers\Backends\FaqCategoryController::class,'ajaxDatatable'])->name('faq-category.get_data');
            Route::get('/faq-category',[App\Http\Controllers\Backends\FaqCategoryController::class, 'index'])->name('faq-category');
        });
        Route::middleware('role_or_permission:Can add faq category')->group(function () {
            Route::post('/faq-category/store', [App\Http\Controllers\Backends\FaqCategoryController::class,'store'])->name('faq-category.store');
        });
        Route::middleware('role_or_permission:Can edit faq category')->group(function () {
            Route::patch('/faq-category/{faqCategory}/update', [App\Http\Controllers\Backends\FaqCategoryController::class,'update'])->name('faq-category.update');
        });
        Route::middleware('role_or_permission:Can delete faq category')->group(function () {
            Route::delete('/faq-category/{faqCategory}/delete', [App\Http\Controllers\Backends\FaqCategoryController::class,'destroy'])->name('faq-category.delete');
        });
    
        /**
         * Faq
         */
        Route::middleware('role_or_permission:Faq')->group(function () {
            Route::get('/faq/ajax_datatable', [App\Http\Controllers\Backends\FaqController::class,'ajaxDatatable'])->name('faq.get_data');
            Route::get('/faq',[App\Http\Controllers\Backends\FaqController::class, 'index'])->name('faq');

        });
        Route::middleware('role_or_permission:Can add faq')->group(function () {
            Route::get('/faq/add',[App\Http\Controllers\Backends\FaqController::class, 'create'])->name('faq.create');
            Route::post('/faq/store', [App\Http\Controllers\Backends\FaqController::class,'store'])->name('faq.store');
        });
        Route::middleware('role_or_permission:Can edit faq')->group(function () {
            Route::get('/faq/{faq}/edit', [App\Http\Controllers\Backends\FaqController::class,'edit'])->name('faq.edit');
            Route::patch('/faq/{faq}/update', [App\Http\Controllers\Backends\FaqController::class,'update'])->name('faq.update');
            Route::patch('/faq/{faq}/active', [App\Http\Controllers\Backends\FaqController::class,'active'])->name('faq.active');
        });
        Route::middleware('role_or_permission:Can show faq')->group(function () {
            Route::get('/faq/{faq}', [App\Http\Controllers\Backends\FaqController::class,'show'])->name('faq.show');
        });
        Route::middleware('role_or_permission:Can delete faq')->group(function () {
            Route::delete('/faq/{faq}/delete', [App\Http\Controllers\Backends\FaqController::class,'destroy'])->name('faq.delete');
        });
    });
});
