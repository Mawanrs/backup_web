<?php

// Route::get('/', "Frontend@about")->name("frontend");
// Route::get('/', "Frontend@service")->name("frontend");
// Route::get('/Frontend@portfolio')->name('Frontend@portfolio');
// Route::post('/subscribe')->name('Frontend@subscribe');
// Route::redirect('/', '/login');

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/rooms', function () {
    return view('layouts.Rooms');
})->name('rooms');

// Route::get('/booking-form', function() {
//     return view('layouts.booking-form');
// });
Route::get('/booking-form', "Frontend@getpost")->name("layouts.booking-form");
Route::post('/booking-form', "Frontend@post")->name("booking.post");


// Route::get('/register', "Frontend@register")->name("layouts.register");

Route::get('/login', [Frontend::class, 'login'])->name('layouts.login');

// Route::get('/masuk', function() {
//     return view('layouts.login');
// });
// Route::get('/register', function() {
//     return view('layouts.register');
// });

Route::resource('bookings', BookingController::class);
// Route::post('/book', [BookingController::class, 'store'])->name('book.store');;
Route::get('/', "Frontend@getdb")->name("layouts.index");
Route::get('/portfolio/{id}', 'PortfolioController@show')->name('portfolio');
// Route::post('/register', [RegisterController::class, 'submitForm'])->name('register.submit');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});


Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Sosial Media
    Route::delete('sosial-media/destroy', 'SosialMediaController@massDestroy')->name('sosial-media.massDestroy');
    Route::resource('sosial-media', 'SosialMediaController');

    // Footer
    Route::delete('footers/destroy', 'FooterController@massDestroy')->name('footers.massDestroy');
    Route::post('footers/media', 'FooterController@storeMedia')->name('footers.storeMedia');
    Route::post('footers/ckmedia', 'FooterController@storeCKEditorImages')->name('footers.storeCKEditorImages');
    Route::resource('footers', 'FooterController');

    // Profile
    Route::delete('profiles/destroy', 'ProfileController@massDestroy')->name('profiles.massDestroy');
    Route::post('profiles/media', 'ProfileController@storeMedia')->name('profiles.storeMedia');
    Route::post('profiles/ckmedia', 'ProfileController@storeCKEditorImages')->name('profiles.storeCKEditorImages');
    Route::resource('profiles', 'ProfileController');

    // About
    Route::delete('abouts/destroy', 'AboutController@massDestroy')->name('abouts.massDestroy');
    Route::post('abouts/media', 'AboutController@storeMedia')->name('abouts.storeMedia');
    Route::post('abouts/ckmedia', 'AboutController@storeCKEditorImages')->name('abouts.storeCKEditorImages');
    Route::resource('abouts', 'AboutController');

    // Gallery
    Route::delete('galleries/destroy', 'GalleryController@massDestroy')->name('galleries.massDestroy');
    Route::post('galleries/media', 'GalleryController@storeMedia')->name('galleries.storeMedia');
    Route::post('galleries/ckmedia', 'GalleryController@storeCKEditorImages')->name('galleries.storeCKEditorImages');
    Route::resource('galleries', 'GalleryController');

    // Gallery
    Route::delete('homes/destroy', 'Home2_Controller@massDestroy')->name('homes.massDestroy');
    Route::post('homes/media', 'Home2_Controller@storeMedia')->name('homes.storeMedia');
    Route::post('homes/ckmedia', 'Home2_Controller@storeCKEditorImages')->name('homes.storeCKEditorImages');
    Route::resource('homes', 'Home2_Controller');

       // Home
       Route::delete('services/destroy', 'ServiceController@massDestroy')->name('services.massDestroy');
       Route::post('services/media', 'ServiceController@storeMedia')->name('services.storeMedia');
       Route::post('services/ckmedia', 'ServiceController@storeCKEditorImages')->name('services.storeCKEditorImages');
       Route::resource('services', 'ServiceController');
   

    // Tim
    Route::delete('tims/destroy', 'TimController@massDestroy')->name('tims.massDestroy');
    Route::post('tims/media', 'TimController@storeMedia')->name('tims.storeMedia');
    Route::post('tims/ckmedia', 'TimController@storeCKEditorImages')->name('tims.storeCKEditorImages');
    Route::resource('tims', 'TimController');

    // Blog
    Route::delete('blogs/destroy', 'BlogController@massDestroy')->name('blogs.massDestroy');
    Route::post('blogs/media', 'BlogController@storeMedia')->name('blogs.storeMedia');
    Route::post('blogs/ckmedia', 'BlogController@storeCKEditorImages')->name('blogs.storeCKEditorImages');
    Route::resource('blogs', 'BlogController');

    // Daftar Layanan
    Route::delete('daftar-layanans/destroy', 'DaftarLayananController@massDestroy')->name('daftar-layanans.massDestroy');
    Route::post('daftar-layanans/media', 'DaftarLayananController@storeMedia')->name('daftar-layanans.storeMedia');
    Route::post('daftar-layanans/ckmedia', 'DaftarLayananController@storeCKEditorImages')->name('daftar-layanans.storeCKEditorImages');
    Route::resource('daftar-layanans', 'DaftarLayananController');

    // Tables
    Route::delete('tables/destroy', 'TablesController@massDestroy')->name('tables.massDestroy');
    Route::post('tables/media', 'TablesController@storeMedia')->name('tables.storeMedia');
    Route::post('tables/ckmedia', 'TablesController@storeCKEditorImages')->name('tables.storeCKEditorImages');
    Route::resource('tables', 'TablesController');

    // Booking
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');

    // Price
    Route::delete('prices/destroy', 'PriceController@massDestroy')->name('prices.massDestroy');
    Route::resource('prices', 'PriceController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
