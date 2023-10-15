<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UnassignedMediaController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewsSiteController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\Translations\TranslationsController;
use Laravel\Sanctum\PersonalAccessToken;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/location', [LocationController::class, 'index'])->name('location');
Route::get('/allnews', [NewsSiteController::class, 'index'])->name('allnews');



Route::post('logout', [LogoutController::class, 'destroy'])->name('logout');
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->prefix(config('app.admin_path'))->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('faqs', [FAQController::class, 'index'])->name('media.index');

    // upload media
    Route::post('upload', [FileUploadController::class, 'upload'])->name('upload');
    Route::post('unassigned-media-upload', [UnassignedMediaController::class, 'upload'])->name('unassignedMediaUpload');
    Route::delete('unassigned-media-destroy/{id}', [UnassignedMediaController::class, 'destroy'])->name('unassignedMediaDestroy');


    // media management
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::get('media/images', [MediaController::class, 'images'])->name('media.images');
    Route::get('media/files', [MediaController::class, 'files'])->name('media.files');
    Route::post('media/update/{media}', [MediaController::class, 'updateMedia'])->name('media.update');
    
    // users crud
    Route::delete('users/bulk-destroy',  [UserController::class, 'bulkDestroy']);
    Route::resource('users', UserController::class)->parameters(['users' => 'User',]);
    Route::post('users/{User}/resend-verification-email',  [UserController::class, 'resendEmailVerificationNotification']);
    Route::post('users/bulk-deactivate', [UserController::class, 'bulkDeactivate']);
    Route::post('users/bulk-activate', [UserController::class, 'bulkActivate']);
    Route::get('users/{User}/impersonalLogin', [UserController::class, 'impersonalLogin'])->name('user.impersonalLogin');
    Route::post('users/invite-user', [UserInvitationController::class, 'inviteUser'])->name('user.invite-user');


    // permissions management
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('permissions', [PermissionController::class, 'update'])->name('permissions.update');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}/update', [RoleController::class, 'update'])->name('roles.update');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');



    // categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');
    Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::match(['put', 'patch'], 'categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');


    // news
    Route::get('news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
    Route::post('news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
    Route::get('news/export', [App\Http\Controllers\NewsController::class, 'export'])->name('news.export');
    Route::get('news/edit/{news}', [App\Http\Controllers\NewsController::class, 'edit'])->name('news.edit');
    Route::match(['put', 'patch'], 'news/{news}', [App\Http\Controllers\NewsController::class, 'update'])->name('news.update');
    Route::delete('news/{news}', [App\Http\Controllers\NewsController::class, 'destroy'])->name('news.destroy');
    Route::post('news/bulk-destroy', [App\Http\Controllers\NewsController::class, 'bulkDestroy'])->name('news.bulk-destroy');


        // pages
    Route::get('pages', [PagesController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('pages', [PagesController::class, 'store'])->name('pages.store');
    Route::get('pages/export', [PagesController::class, 'export'])->name('pages.export');
    Route::get('pages/edit/{page}', [PagesController::class, 'edit'])->name('pages.edit');
    Route::match(['put', 'patch'], 'pages/{pages}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('pages/{pages}', [PagesController::class, 'destroy'])->name('pages.destroy');
    Route::post('pages/bulk-destroy', [PagesController::class, 'bulkDestroy'])->name('pages.bulk-destroy');


    // reviews
    Route::get('reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/export', [App\Http\Controllers\ReviewController::class, 'export'])->name('reviews.export');
    Route::get('reviews/edit/{review}', [App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::match(['put', 'patch'], 'reviews/{review}', [App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-destroy', [App\Http\Controllers\ReviewController::class, 'bulkDestroy'])->name('reviews.bulk-destroy');


    // translations management
    Route::get('translations', [TranslationsController::class, 'index'])->name('translations.index');
    Route::post('translations/rescan', [TranslationsController::class, 'rescan'])->name('translations.rescan');
    Route::get('translations/export', [TranslationsController::class, 'export'])->name('translations.export');
    Route::post('translations/import', [TranslationsController::class, 'import'])->name('translations.import');
    Route::post('translations/import/conflicts', [TranslationsController::class, 'importResolvedConflicts'])->name('translations.import.conflicts');
    Route::post('translations/publish', [TranslationsController::class, 'publish'])->name('translations.publish');
    Route::post('translations/{translation}', [TranslationsController::class, 'update'])->name('translations.update');

    // tags management
    Route::post('tags', [TagsController::class, 'store'])->name('tags.store');


    

});
