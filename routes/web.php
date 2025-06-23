<?php

use Illuminate\Support\Facades\Route;

//Frontend

Route::get('/', [App\Http\Controllers\Frontend\WebController::class, 'index'])->name('web_index');
Route::get('/story', [App\Http\Controllers\Frontend\WebController::class, 'story'])->name('web_story');
Route::get('/facility', [App\Http\Controllers\Frontend\WebController::class, 'facility'])->name('web_facility');
Route::get('/product', [App\Http\Controllers\Frontend\WebController::class, 'product'])->name('web_product');
Route::get('/project', [App\Http\Controllers\Frontend\WebController::class, 'project'])->name('web_project');
Route::get('/project/{slug}', [App\Http\Controllers\Frontend\WebController::class, 'projectShow'])->name('web_project.show');
Route::get('/contact', [App\Http\Controllers\Frontend\WebController::class, 'contact'])->name('web_contact');
Route::post('/add_question', [App\Http\Controllers\Frontend\WebController::class, 'addQuestion'])->name('web_add_question');
Route::get('/xvessel', [App\Http\Controllers\Frontend\WebController::class, 'xvessel'])->name('web_xvessel');
Route::get('/article', [App\Http\Controllers\Frontend\WebController::class, 'article'])->name('web_article');
Route::get('/article/{slug}', [App\Http\Controllers\Frontend\WebController::class, 'articleShow'])->name('web_article.show');
Route::get('/partner', [App\Http\Controllers\Frontend\WebController::class, 'partner'])->name('web_partner');
Route::get('/client', [App\Http\Controllers\Frontend\WebController::class, 'client'])->name('web_client');

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
         * Certificate
         */
        Route::middleware('role_or_permission:Certificate')->group(function () {
            Route::get('/certificate/ajax_datatable', [App\Http\Controllers\Backends\CertificateController::class,'ajaxDatatable'])->name('certificate.get_data');
            Route::get('/certificate',[App\Http\Controllers\Backends\CertificateController::class, 'index'])->name('certificate');

        });
        Route::middleware('role_or_permission:Can add certificate')->group(function () {
            Route::get('/certificate/add',[App\Http\Controllers\Backends\CertificateController::class, 'create'])->name('certificate.create');
            Route::post('/certificate/store', [App\Http\Controllers\Backends\CertificateController::class,'store'])->name('certificate.store');
        });
        Route::middleware('role_or_permission:Can edit certificate')->group(function () {
            Route::get('/certificate/{certificate}/edit', [App\Http\Controllers\Backends\CertificateController::class,'edit'])->name('certificate.edit');
            Route::patch('/certificate/{certificate}/update', [App\Http\Controllers\Backends\CertificateController::class,'update'])->name('certificate.update');
            Route::patch('/certificate/{certificate}/active', [App\Http\Controllers\Backends\CertificateController::class,'active'])->name('certificate.active');
        });
        Route::middleware('role_or_permission:Can delete certificate')->group(function () {
            Route::delete('/certificate/{certificate}/delete', [App\Http\Controllers\Backends\CertificateController::class,'destroy'])->name('certificate.delete');
        });
    
        /**
         * partner
         */
        Route::middleware('role_or_permission:Partner')->group(function () {
            Route::get('/partner/ajax_datatable', [App\Http\Controllers\Backends\PartnerController::class,'ajaxDatatable'])->name('partner.get_data');
            Route::get('/partner',[App\Http\Controllers\Backends\PartnerController::class, 'index'])->name('partner');
            
        });
        Route::middleware('role_or_permission:Can add partner')->group(function () {
            Route::get('/partner/add',[App\Http\Controllers\Backends\PartnerController::class, 'create'])->name('partner.create');
            Route::post('/partner/store', [App\Http\Controllers\Backends\PartnerController::class,'store'])->name('partner.store');
        });
        Route::middleware('role_or_permission:Can edit partner')->group(function () {
            Route::get('/partner/{partner}/edit', [App\Http\Controllers\Backends\PartnerController::class,'edit'])->name('partner.edit');
            Route::patch('/partner/{partner}/update', [App\Http\Controllers\Backends\PartnerController::class,'update'])->name('partner.update');
            Route::patch('/partner/{partner}/active', [App\Http\Controllers\Backends\PartnerController::class,'active'])->name('partner.active');

        });
        Route::middleware('role_or_permission:Can delete partner')->group(function () {
            Route::delete('/partner/{partner}/delete', [App\Http\Controllers\Backends\PartnerController::class,'destroy'])->name('partner.delete');
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
         * Ex Vessel
         */
        Route::middleware('role_or_permission:ExVessel')->group(function () {
            Route::get('/exvessel/ajax_datatable', [App\Http\Controllers\Backends\ExVesselController::class,'ajaxDatatable'])->name('exvessel.get_data');
            Route::get('/exvessel',[App\Http\Controllers\Backends\ExVesselController::class, 'index'])->name('exvessel');
            
        });
        Route::middleware('role_or_permission:Can add exvessel')->group(function () {
            Route::get('/exvessel/add',[App\Http\Controllers\Backends\ExVesselController::class, 'create'])->name('exvessel.create');
            Route::post('/exvessel/store', [App\Http\Controllers\Backends\ExVesselController::class,'store'])->name('exvessel.store');
        });
        Route::middleware('role_or_permission:Can edit exvessel')->group(function () {
            Route::get('/exvessel/{exVessel}/edit', [App\Http\Controllers\Backends\ExVesselController::class,'edit'])->name('exvessel.edit');
            Route::patch('/exvessel/{exVessel}/update', [App\Http\Controllers\Backends\ExVesselController::class,'update'])->name('exvessel.update');
            Route::patch('/exvessel/{exVessel}/active', [App\Http\Controllers\Backends\ExVesselController::class,'active'])->name('exvessel.active');
        });
        Route::middleware('role_or_permission:Can show exvessel')->group(function () {
            Route::get('/exvessel/{exVessel}', [App\Http\Controllers\Backends\ExVesselController::class,'show'])->name('exvessel.show');
        });
        Route::middleware('role_or_permission:Can delete exvessel')->group(function () {
            Route::delete('/exvessel/{exVessel}/delete', [App\Http\Controllers\Backends\ExVesselController::class,'destroy'])->name('exvessel.delete');
        });
        Route::middleware('role_or_permission:Can set exvessel image')->group(function () {
            Route::post('/exvessel/{exVessel}/image', [App\Http\Controllers\Backends\ExVesselController::class,'imageAdd'])->name('exvessel.image.store');
            Route::patch('/exvessel/{exVessel}/image/{exVesselImage}/set_default', [App\Http\Controllers\Backends\ExVesselController::class,'imageSetDefault'])->name('exvessel.image.set_default');
            Route::delete('/exvessel/{exVessel}/image/{exVesselImage}/delete', [App\Http\Controllers\Backends\ExVesselController::class,'imageDelete'])->name('exvessel.image.delete');
        });
    
        /**
         * Facility
         */
        Route::middleware('role_or_permission:Facility')->group(function () {
            Route::get('/facility/ajax_datatable', [App\Http\Controllers\Backends\FacilityController::class,'ajaxDatatable'])->name('facility.get_data');
            Route::get('/facility',[App\Http\Controllers\Backends\FacilityController::class, 'index'])->name('facility');
        });
        Route::middleware('role_or_permission:Can add facility')->group(function () {
            Route::get('/facility/add',[App\Http\Controllers\Backends\FacilityController::class, 'create'])->name('facility.create');
            Route::post('/facility/store', [App\Http\Controllers\Backends\FacilityController::class,'store'])->name('facility.store');
        });
        Route::middleware('role_or_permission:Can edit facility')->group(function () {
            Route::get('/facility/{facility}/edit', [App\Http\Controllers\Backends\FacilityController::class,'edit'])->name('facility.edit');
            Route::patch('/facility/{facility}/update', [App\Http\Controllers\Backends\FacilityController::class,'update'])->name('facility.update');
            Route::patch('/facility/{facility}/active', [App\Http\Controllers\Backends\FacilityController::class,'active'])->name('facility.active');
        });
        Route::middleware('role_or_permission:Can show facility')->group(function () {
            Route::get('/facility/{facility}', [App\Http\Controllers\Backends\FacilityController::class,'show'])->name('facility.show');
        });
        Route::middleware('role_or_permission:Can delete facility')->group(function () {
            Route::delete('/facility/{facility}/delete', [App\Http\Controllers\Backends\FacilityController::class,'destroy'])->name('facility.delete');
        });
        Route::middleware('role_or_permission:Can set facility image')->group(function () {
            Route::post('/facility/{facility}/image', [App\Http\Controllers\Backends\FacilityController::class,'imageAdd'])->name('facility.image.store');
            Route::patch('/facility/{facility}/image/{image}/set_default', [App\Http\Controllers\Backends\FacilityController::class,'imageSetDefault'])->name('facility.image.set_default');
            Route::delete('/facility/{facility}/image/{image}/delete', [App\Http\Controllers\Backends\FacilityController::class,'imageDelete'])->name('facility.image.delete');
        });
    
        /**
         * Motto
         */
        Route::middleware('role_or_permission:Motto')->group(function () {
            Route::get('/motto/ajax_datatable', [App\Http\Controllers\Backends\MottoController::class,'ajaxDatatable'])->name('motto.get_data');
            Route::get('/motto',[App\Http\Controllers\Backends\MottoController::class, 'index'])->name('motto');
        });
        Route::middleware('role_or_permission:Can add motto')->group(function () {
            Route::get('/motto/add',[App\Http\Controllers\Backends\MottoController::class, 'create'])->name('motto.create');
            Route::post('/motto/store', [App\Http\Controllers\Backends\MottoController::class,'store'])->name('motto.store');
        });
        Route::middleware('role_or_permission:Can edit motto')->group(function () {
            Route::get('/motto/{motto}/edit', [App\Http\Controllers\Backends\MottoController::class,'edit'])->name('motto.edit');
            Route::patch('/motto/{motto}/update', [App\Http\Controllers\Backends\MottoController::class,'update'])->name('motto.update');
            Route::patch('/motto/{motto}/active', [App\Http\Controllers\Backends\MottoController::class,'active'])->name('motto.active');
        });
        Route::middleware('role_or_permission:Can delete motto')->group(function () {
            Route::delete('/motto/{motto}/delete', [App\Http\Controllers\Backends\MottoController::class,'destroy'])->name('motto.delete');
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
         * project Category
         */
        Route::middleware('role_or_permission:Project Category')->group(function () {
            Route::get('/project-category/ajax_datatable', [App\Http\Controllers\Backends\ProjectCategoryController::class,'ajaxDatatable'])->name('project-category.get_data');
            Route::get('/project-category',[App\Http\Controllers\Backends\ProjectCategoryController::class, 'index'])->name('project-category');
        });
        Route::middleware('role_or_permission:Can add project category')->group(function () {
            Route::get('/project-category/add',[App\Http\Controllers\Backends\ProjectCategoryController::class, 'create'])->name('project-category.create');
            Route::post('/project-category/store', [App\Http\Controllers\Backends\ProjectCategoryController::class,'store'])->name('project-category.store');
        });
        Route::middleware('role_or_permission:Can edit project category')->group(function () {
            Route::get('/project-category/{projectCategory}/edit', [App\Http\Controllers\Backends\ProjectCategoryController::class,'edit'])->name('project-category.edit');
            Route::patch('/project-category/{projectCategory}/update', [App\Http\Controllers\Backends\ProjectCategoryController::class,'update'])->name('project-category.update');
        });
        Route::middleware('role_or_permission:Can delete project category')->group(function () {
            Route::delete('/project-category/{projectCategory}/delete', [App\Http\Controllers\Backends\ProjectCategoryController::class,'destroy'])->name('project-category.delete');
        });
    
        /**
         * Project
         */
        Route::middleware('role_or_permission:Project')->group(function () {
            Route::get('/project/ajax_datatable', [App\Http\Controllers\Backends\ProjectController::class,'ajaxDatatable'])->name('project.get_data');
            Route::get('/project',[App\Http\Controllers\Backends\ProjectController::class, 'index'])->name('project');

        });
        Route::middleware('role_or_permission:Can add project')->group(function () {
            Route::get('/project/add',[App\Http\Controllers\Backends\ProjectController::class, 'create'])->name('project.create');
            Route::post('/project/store', [App\Http\Controllers\Backends\ProjectController::class,'store'])->name('project.store');
        });
        Route::middleware('role_or_permission:Can edit project')->group(function () {
            Route::get('/project/{project}/edit', [App\Http\Controllers\Backends\ProjectController::class,'edit'])->name('project.edit');
            Route::patch('/project/{project}/update', [App\Http\Controllers\Backends\ProjectController::class,'update'])->name('project.update');
            Route::patch('/project/{project}/active', [App\Http\Controllers\Backends\ProjectController::class,'active'])->name('project.active');
        });
        Route::middleware('role_or_permission:Can show project')->group(function () {
            Route::get('/project/{project}', [App\Http\Controllers\Backends\ProjectController::class,'show'])->name('project.show');
        });
        Route::middleware('role_or_permission:Can delete project')->group(function () {
            Route::delete('/project/{project}/delete', [App\Http\Controllers\Backends\ProjectController::class,'destroy'])->name('project.delete');
        });
        Route::middleware('role_or_permission:Can set project image')->group(function () {
            Route::post('/project/{project}/image', [App\Http\Controllers\Backends\ProjectController::class,'imageAdd'])->name('project.image.store');
            Route::patch('/project/{project}/image/{image}/set_default', [App\Http\Controllers\Backends\ProjectController::class,'imageSetDefault'])->name('project.image.set_default');
            Route::delete('/project/{project}/image/{image}/delete', [App\Http\Controllers\Backends\ProjectController::class,'imageDelete'])->name('project.image.delete');
        });
    
        /**
         * Client
         */
        Route::middleware('role_or_permission:Client')->group(function () {
            Route::get('/client/ajax_datatable', [App\Http\Controllers\Backends\ClientController::class,'ajaxDatatable'])->name('client.get_data');
            Route::get('/client',[App\Http\Controllers\Backends\ClientController::class, 'index'])->name('client');
        });
        Route::middleware('role_or_permission:Can add client')->group(function () {
            Route::get('/client/add',[App\Http\Controllers\Backends\ClientController::class, 'create'])->name('client.create');
            Route::post('/client/store', [App\Http\Controllers\Backends\ClientController::class,'store'])->name('client.store');
        });
        Route::middleware('role_or_permission:Can edit client')->group(function () {
            Route::get('/client/{client}/edit', [App\Http\Controllers\Backends\ClientController::class,'edit'])->name('client.edit');
            Route::patch('/client/{client}/update', [App\Http\Controllers\Backends\ClientController::class,'update'])->name('client.update');
            Route::patch('/client/{client}/active', [App\Http\Controllers\Backends\ClientController::class,'active'])->name('client.active');
        });
        Route::middleware('role_or_permission:Can delete client')->group(function () {
            Route::delete('/client/{client}/delete', [App\Http\Controllers\Backends\ClientController::class,'destroy'])->name('client.delete');
        });
    
        /**
         * Vision
         */
        Route::middleware('role_or_permission:Vision')->group(function () {
            Route::get('/vision/ajax_datatable', [App\Http\Controllers\Backends\VisionController::class,'ajaxDatatable'])->name('vision.get_data');
            Route::get('/vision',[App\Http\Controllers\Backends\VisionController::class, 'index'])->name('vision');

        });
        Route::middleware('role_or_permission:Can add vision')->group(function () {
            Route::get('/vision/add',[App\Http\Controllers\Backends\VisionController::class, 'create'])->name('vision.create');
            Route::post('/vision/store', [App\Http\Controllers\Backends\VisionController::class,'store'])->name('vision.store');
        });
        Route::middleware('role_or_permission:Can edit vision')->group(function () {
            Route::get('/vision/{vision}/edit', [App\Http\Controllers\Backends\VisionController::class,'edit'])->name('vision.edit');
            Route::patch('/vision/{vision}/update', [App\Http\Controllers\Backends\VisionController::class,'update'])->name('vision.update');
            Route::patch('/vision/{vision}/active', [App\Http\Controllers\Backends\VisionController::class,'active'])->name('vision.active');
        });
        Route::middleware('role_or_permission:Can delete vision')->group(function () {
            Route::delete('/vision/{vision}/delete', [App\Http\Controllers\Backends\VisionController::class,'destroy'])->name('vision.delete');
        });
    });
});
