<?php
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\InquiryController;


Route::fallback(function () {
     return view('errors.404');
});

Route::get('/login', function () {
    return redirect()->route('login');
});


Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', RolesController::class);

// Permissions
Route::resource('permissions', PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});


Route::prefix('admin')->name('admin.')->group(function () {
 
    // Category
    Route::resource('category', CategoryController::class);
    Route::post('category/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulk-delete');
 
    // Sub Category
    Route::resource('sub-category', SubCategoryController::class);
    Route::post('sub-category/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('sub-category.bulk-delete');
    Route::get('sub-category/by-category/{iCategoryId}', [SubCategoryController::class, 'byCategory'])->name('sub-category.by-category');


});
 
    Route::prefix('admin/video')->name('admin.video.')->group(function () {
        Route::get('/',            [VideoController::class, 'index'])->name('index');
        Route::post('/',           [VideoController::class, 'store'])->name('store');
        Route::put('/{video}',     [VideoController::class, 'update'])->name('update');
        Route::delete('/{video}',  [VideoController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete',[VideoController::class, 'bulkDelete'])->name('bulk-delete');
        Route::patch('/{video}/toggle-status', [VideoController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::get('/admin/fetch-subcategories/{category}', function ($categoryId) {
        return response()->json(
            \App\Models\SubCategory::where('iCategoryId', $categoryId)
                ->where('isDelete', 0)
                ->orderBy('strSubCategoryName')
                ->get(['iSubCategoryId','strSubCategoryName'])
        );
    })->name('admin.fetch-subcategories');



    Route::prefix('admin/podcast')->name('admin.podcast.')->group(function () {
        Route::get('/',            [PodcastController::class, 'index'])->name('index');
        Route::post('/',           [PodcastController::class, 'store'])->name('store');
        Route::put('/{podcast}',     [PodcastController::class, 'update'])->name('update');
        Route::delete('/{podcast}',  [PodcastController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete',[PodcastController::class, 'bulkDelete'])->name('bulk-delete');
        Route::patch('/{podcast}/toggle-status', [PodcastController::class, 'toggleStatus'])->name('toggle-status');
    });


    Route::prefix('admin/gallery')->name('admin.gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('bulk-delete');
        Route::patch('/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('toggle-status');
    });



    Route::prefix('admin/document')->name('admin.document.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('update');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [DocumentController::class, 'bulkDelete'])->name('bulk-delete');
        Route::patch('/{document}/toggle-status', [DocumentController::class, 'toggleStatus'])->name('toggle-status');
    });

Route::prefix('admin')->name('Inquiry.')->middleware('auth')->group(function () {
        Route::get('Inquiry/index', [InquiryController::class, 'index'])->name('index');
        Route::delete('/Inquiry-delete', [InquiryController::class, 'delete'])->name('delete');
        Route::get('Inquiry/view/{id?}', [InquiryController::class, 'view'])->name('view');
});

