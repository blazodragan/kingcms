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
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\Translations\TranslationsController;
use App\Http\Controllers\TrustReviewController;
use App\Http\Controllers\BlockController;
use App\Models\Page;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NewsController;
use App\Models\Post;
use App\Models\Review;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\AuthorController;
use App\Models\User;

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

Route::get('invite-user/{email}', [UserController::class, 'createInviteAcceptationUser'])->name('invite-user.create');
Route::post('invite-user', [UserController::class, 'storeInviteAcceptationUser'])->name('invite-user.store');

Route::post('logout', [LogoutController::class, 'destroy'])->name('logout');


Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->prefix(config('app.admin_path'))->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    

    Route::get('faqs', [FAQController::class, 'index'])->name('faq.index');

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
    Route::match(['put', 'patch'], 'users/{user}/activate', [UserController::class, 'activate'])->name('user.activate');
    Route::get('users/{User}/impersonalLogin', [UserController::class, 'impersonalLogin'])->name('user.impersonalLogin');
    Route::post('users/invite-user', [UserController::class, 'inviteUser'])->name('invite-user');
    


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
    Route::get('category/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::match(['put', 'patch'], 'categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');

    // blocks
    Route::get('blocks', [BlockController::class, 'index'])->name('blocks.index');
    Route::get('blocks/create', [BlockController::class, 'create'])->name('blocks.create');
    Route::post('blocks', [BlockController::class, 'store'])->name('blocks.store');
    Route::get('blocks/edit/{block}', [BlockController::class, 'edit'])->name('blocks.edit');
    Route::match(['put', 'patch'], 'blocks/{block}', [BlockController::class, 'update'])->name('blocks.update');
    Route::delete('blocks/{block}', [BlockController::class, 'destroy'])->name('blocks.destroy');
    Route::post('blocks/bulk-destroy', [BlockController::class, 'bulkDestroy'])->name('blocks.bulk-destroy');


    // trust_reviews
    Route::get('trust_reviews', [TrustReviewController::class, 'index'])->name('trust_reviews.index');
    Route::get('trust_reviews/create', [TrustReviewController::class, 'create'])->name('trust_reviews.create');
    Route::post('trust_reviews', [TrustReviewController::class, 'store'])->name('trust_reviews.store');
    Route::get('trust_reviews/export', [TrustReviewController::class, 'export'])->name('trust_reviews.export');
    Route::get('trust_reviews/edit/{trust_review}', [TrustReviewController::class, 'edit'])->name('trust_reviews.edit');
    Route::match(['put', 'patch'], 'trust_reviews/{trust_review}', [TrustReviewController::class, 'update'])->name('trust_reviews.update');
    Route::delete('trust_reviews/{trust_review}', [TrustReviewController::class, 'destroy'])->name('trust_reviews.destroy');
    Route::post('trust_reviews/bulk-destroy', [TrustReviewController::class, 'bulkDestroy'])->name('trust_reviews.bulk-destroy');


    // news
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');
    Route::get('news/export', [NewsController::class, 'export'])->name('news.export');
    Route::get('news/edit/{news}', [NewsController::class, 'edit'])->name('news.edit');
    Route::match(['put', 'patch'], 'news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::post('news/bulk-destroy', [NewsController::class, 'bulkDestroy'])->name('news.bulk-destroy');

    // posts
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('post', [PostController::class, 'store'])->name('post.store');
    Route::get('posts/export', [PostController::class, 'export'])->name('posts.export');
    Route::get('post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::match(['put', 'patch'], 'post/{post}/date', [PostController::class, 'date'])->name('post.date');
    Route::match(['put', 'patch'], 'post/{post}', [PostController::class, 'update'])->name('post.update');
    
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/{post}', [PostController::class, 'clone'])->name('post.clone');
    Route::post('posts/bulk-destroy', [PostController::class, 'bulkDestroy'])->name('posts.bulk-destroy');


    // pages
    Route::get('pages', [PagesController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('pages', [PagesController::class, 'store'])->name('pages.store');
    Route::get('pages/export', [PagesController::class, 'export'])->name('pages.export');
    Route::get('page/edit/{page}', [PagesController::class, 'edit'])->name('page.edit');
    Route::match(['put', 'patch'], 'pages/{pages}/date', [PagesController::class, 'date'])->name('pages.date');
    Route::match(['put', 'patch'], 'pages/{pages}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('pages/{pages}', [PagesController::class, 'destroy'])->name('pages.destroy');
    Route::get('page/{page}', [App\Http\Controllers\PagesController::class, 'clone'])->name('page.clone');
    Route::post('pages/bulk-destroy', [PagesController::class, 'bulkDestroy'])->name('pages.bulk-destroy');


    // reviews
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/export', [ReviewController::class, 'export'])->name('reviews.export');
    Route::get('review/edit/{review}', [ReviewController::class, 'edit'])->name('review.edit');
    Route::match(['put', 'patch'], 'reviews/{review}/date', [ReviewController::class, 'date'])->name('reviews.date');
    Route::match(['put', 'patch'], 'reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('review/{review}', [ReviewController::class, 'clone'])->name('review.clone');
    Route::post('reviews/bulk-destroy', [ReviewController::class, 'bulkDestroy'])->name('reviews.bulk-destroy');


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


Route::get('/author/{slug}', [AuthorController::class, 'show'])->name('showAuthor');

Route::get('/reviews/{slug}', [ReviewController::class, 'show'])->name('showReview');

Route::get('/blog/{slug}', [PostController::class, 'show'])->name('showBlogPost');

Route::get('{parentSlug}/{childSlug}', [PagesController::class, 'showChild'])->name('showChild');

Route::get('{parentSlug}', [PagesController::class, 'showParent'])->name('showParent');







