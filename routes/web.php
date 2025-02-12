<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\SupervisorSpeechController;
use App\Http\Controllers\OrganizingEntityController;
use App\Http\Controllers\ForumManagementController;
use App\Http\Controllers\MediaPartnerController;
use App\Http\Controllers\KeySpeakersController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\LatestNewsController;
use App\Http\Controllers\TargetGroupController;
use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\VideoGalleryController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\RegisterInController;
use App\Http\Controllers\ContctFooterController;
use App\Http\Controllers\headercontroller;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactusController;


use App\Exports\membersExport;
use App\Exports\newsletterExport;
use App\Exports\ContactUsExport;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and are assigned to the
| "web" middleware group. Make something great!
|
*/



// Public route for login page
Route::get('/', function () {
    return view('auth.login');
})->name('login');



Route::get('/export-contact-us', function () {
    return Excel::download(new ContactUsExport, 'contact_us.xlsx');
});


Route::get('/export-members', function () {
    return Excel::download(new membersExport, 'members.xlsx');
});


Route::get('/export-newsletter', function () {
    return Excel::download(new newsletterExport, 'newsletter.xlsx');
});


// Authenticated user routes
Route::middleware(['auth'])->group(function () {


    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('register_user', [HomeController::class, 'register'])->name('register_user');
    Route::post('store_user', [HomeController::class, 'store_user'])->name('store_user');
    Route::post('update_profile', [HomeController::class, 'update_profile'])->name('update_profile');

    Route::get('users', [HomeController::class, 'users'])->name('users');
    Route::get('members', [HomeController::class, 'members'])->name('members');


    Route::get('profile', [HomeController::class, 'profile'])->name('profile');

    // RESTful resource routes
    Route::resource('header', headercontroller::class);
    Route::resource('main', HomeController::class);
    Route::resource('goals', GoalsController::class);
    Route::resource('about', AboutController::class);
    Route::resource('partners', PartnersController::class);


    Route::resource('register_in', RegisterInController::class);
    // Route::resource('newsletter', NewsletterController::class);

    Route::get('newsletter', [NewsletterController::class , 'index'] )->name('newsletter');
    Route::get('contact', [ContactusController::class , 'index'] )->name('contact');


    Route::get('export_contact', [ContactusController::class , 'export_contact'] )->name('export_contact');
    // Route::post('newsletter', [NewsletterController::class , 'update'] )->name('newsletter');
    // Route::delete('newsletter', [NewsletterController::class , 'destroy'] )->name('newsletter');


    Route::resource('latest_news', LatestNewsController::class);
    Route::resource('sponsorship', SponsorshipController::class);
    Route::resource('key_speakers', KeySpeakersController::class);
    Route::resource('target_group', TargetGroupController::class);
    Route::resource('photo_gallery', PhotoGalleryController::class);
    Route::resource('video_gallery', VideoGalleryController::class);
    Route::resource('media_partner', MediaPartnerController::class);
    Route::resource('contct_footer', ContctFooterController::class);
    Route::resource('Forum_management', ForumManagementController::class);
    Route::resource('organizing_entity', OrganizingEntityController::class);
    Route::resource('supervisor_speech', SupervisorSpeechController::class);
});

// Route for home (optional)
// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Laravel's authentication routes
Auth::routes();
