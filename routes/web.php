<?php
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::fallback(function () {
     return view('errors.404');
});

Route::get('/login', function () {
    return redirect()->route('login');
});


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

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
    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('category/bulk-delete', [App\Http\Controllers\Admin\CategoryController::class, 'bulkDelete'])->name('category.bulk-delete');
 
    // Sub Category
    Route::resource('sub-category', App\Http\Controllers\Admin\SubCategoryController::class);
    Route::post('sub-category/bulk-delete', [App\Http\Controllers\Admin\SubCategoryController::class, 'bulkDelete'])->name('sub-category.bulk-delete');
    Route::get('sub-category/by-category/{iCategoryId}', [App\Http\Controllers\Admin\SubCategoryController::class, 'byCategory'])->name('sub-category.by-category');


    // Products
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/bulk-delete', [App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
 
    // Product Label-Value
    Route::resource('product-label-value', App\Http\Controllers\Admin\ProductLabelValueController::class);
    Route::get('product-label-value/{iProductId}', [App\Http\Controllers\Admin\ProductLabelValueController::class, 'index'])
    ->name('product-label-value.index');
    Route::post('product-label-value/bulk-delete', [App\Http\Controllers\Admin\ProductLabelValueController::class, 'bulkDelete'])->name('product-label-value.bulk-delete');
 
 

    // Product Photos
 /*   Route::resource('product-photos', App\Http\Controllers\Admin\ProductPhotoController::class);
    Route::post('product-photos/bulk-delete', [App\Http\Controllers\Admin\ProductPhotoController::class, 'bulkDelete'])->name('product-photos.bulk-delete');
 */


    Route::get('product-photos/{iProductId}', [App\Http\Controllers\Admin\ProductPhotoController::class, 'index'])
    ->name('product-photos.index');
     
    Route::get('product-photos/{iProductId}/create', [App\Http\Controllers\Admin\ProductPhotoController::class, 'create'])
        ->name('product-photos.create');
     
    Route::post('product-photos/{iProductId}', [App\Http\Controllers\Admin\ProductPhotoController::class, 'store'])
        ->name('product-photos.store');
     
    Route::get('product-photos/{iProductId}/edit/{id}', [App\Http\Controllers\Admin\ProductPhotoController::class, 'edit'])
        ->name('product-photos.edit');
     
    Route::put('product-photos/{iProductId}/update/{id}', [App\Http\Controllers\Admin\ProductPhotoController::class, 'update'])
        ->name('product-photos.update');
     
    Route::delete('product-photos/{iProductId}/destroy/{id}', [App\Http\Controllers\Admin\ProductPhotoController::class, 'destroy'])
        ->name('product-photos.destroy');
     
    Route::post('product-photos/{iProductId}/bulk-delete', [App\Http\Controllers\Admin\ProductPhotoController::class, 'bulkDelete'])
        ->name('product-photos.bulk-delete');
     
     

    // Product Gallery
    Route::resource('product-gallery', App\Http\Controllers\Admin\ProductGalleryController::class);
    Route::post('product-gallery/bulk-delete', [App\Http\Controllers\Admin\ProductGalleryController::class, 'bulkDelete'])->name('product-gallery.bulk-delete');
 
    // Product Videos
    Route::resource('product-videos', App\Http\Controllers\Admin\ProductVideoController::class);
    Route::post('product-videos/bulk-delete', [App\Http\Controllers\Admin\ProductVideoController::class, 'bulkDelete'])->name('product-videos.bulk-delete');
});
 

 
 Route::prefix('admin')->group(function () {
    Route::get('blog-category', [App\Http\Controllers\Admin\BlogCategoryController::class, 'index'])->name('blog-category.index');
    Route::post('blog-category/store', [App\Http\Controllers\Admin\BlogCategoryController::class, 'store'])->name('blog-category.store');
    Route::get('blog-category/edit/{slug}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'edit'])->name('blog-category.edit');
    Route::post('blog-category/update/{slug}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'update'])->name('blog-category.update');
    Route::get('blog-category/delete/{slug}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'destroy'])->name('blog-category.delete');
    Route::post('blog-category/bulk-delete', [App\Http\Controllers\Admin\BlogCategoryController::class, 'bulkDelete'])->name('blog-category.bulk-delete');
});
 


 Route::prefix('admin')->group(function () {
    Route::get('blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/store', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/edit/{strSlug}', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('blog.edit');
    Route::post('blog/update/{strSlug}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('blog.update');
    Route::get('blog/delete/{strSlug}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('blog.delete');
    Route::post('blog/bulk-delete', [App\Http\Controllers\Admin\BlogController::class, 'bulkDelete'])->name('blog.bulkDelete');
});


 Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class);
    Route::post('testimonials/bulk-delete', [App\Http\Controllers\Admin\TestimonialController::class, 'bulkDelete'])->name('testimonials.bulk-delete');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('specialties', App\Http\Controllers\Admin\SpecialtyController::class)->parameters([
        'specialties' => 'slug'
    ]);
    Route::post('specialties/bulk-delete', [App\Http\Controllers\Admin\SpecialtyController::class, 'bulkDelete'])->name('specialties.bulk-delete');

    Route::get('specialities/{slug}/details', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'index'])->name('specialities.details.index');


        Route::resource('specialitydetails', App\Http\Controllers\Admin\SpecialityOtherDetailController::class);
    Route::post('specialitydetails/bulk-delete', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'bulkDelete'])->name('specialitydetails.bulk-delete');


/*    Route::get('specialities/{slug}/details/create', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'create'])->name('specialities.details.create');
    Route::post('specialities/{slug}/details', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'store'])->name('specialities.details.store');
    Route::get('specialities/{slug}/details/{id}/edit', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'edit'])->name('specialities.details.edit');
    Route::put('specialities/{slug}/details/{id}', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'update'])->name('specialities.details.update');
    Route::delete('specialities/{slug}/details/{id}', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'destroy'])->name('specialities.details.destroy');
    Route::post('specialities/{slug}/details/bulk-delete', [App\Http\Controllers\Admin\SpecialityOtherDetailController::class, 'bulkDelete'])->name('specialities.details.bulk-delete');*/


});




