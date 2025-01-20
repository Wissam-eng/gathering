<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:api')->group(function () {


    Route::get('/user', function (Request $request) {
        return $request->user();
    });



    //--------home
    Route::post('home', [HomeController::class, 'store']);
    Route::post('home/{id}', [HomeController::class, 'update']);
    Route::delete('home/{id}', [HomeController::class, 'destroy']);


    //--------about
    Route::post('about', [AboutController::class, 'store']);
    Route::post('about/{id}', [AboutController::class, 'update']);
    Route::delete('about/{id}', [AboutController::class, 'destroy']);

    //--------goals
    Route::post('goals', [GoalsController::class, 'store']);
    Route::post('goals/{id}', [GoalsController::class, 'update']);
    Route::delete('goals/{id}', [GoalsController::class, 'destroy']);


    //--------supervisor_speech
    Route::post('supervisor_speech', [SupervisorSpeechController::class, 'store']);
    Route::post('supervisor_speech/{id}', [SupervisorSpeechController::class, 'update']);
    Route::delete('supervisor_speech/{id}', [SupervisorSpeechController::class, 'destroy']);


    //--------organizing_entity
    Route::post('organizing_entity', [OrganizingEntityController::class, 'store']);
    Route::post('organizing_entity/{id}', [OrganizingEntityController::class, 'update']);
    Route::delete('organizing_entity/{id}', [OrganizingEntityController::class, 'destroy']);

    //--------Forum_management
    Route::post('Forum_management', [ForumManagementController::class, 'store']);
    Route::post('Forum_management/{id}', [ForumManagementController::class, 'update']);
    Route::delete('Forum_management/{id}', [ForumManagementController::class, 'destroy']);

    //--------Media_partner
    Route::post('Media_partner', [MediaPartnerController::class, 'store']);
    Route::post('Media_partner/{id}', [MediaPartnerController::class, 'update']);
    Route::delete('Media_partner/{id}', [MediaPartnerController::class, 'destroy']);

    //--------Key_speakers
    Route::post('Key_speakers', [KeySpeakersController::class, 'store']);
    Route::post('Key_speakers/{id}', [KeySpeakersController::class, 'update']);
    Route::delete('Key_speakers/{id}', [KeySpeakersController::class, 'destroy']);

    //--------Sponsorship
    Route::post('Sponsorship', [SponsorshipController::class, 'store']);
    Route::post('Sponsorship/{id}', [SponsorshipController::class, 'update']);
    Route::delete('Sponsorship/{id}', [SponsorshipController::class, 'destroy']);



    //--------Latest_news
    Route::post('Latest_news', [LatestNewsController::class, 'store']);
    Route::post('Latest_news/{id}', [LatestNewsController::class, 'update']);
    Route::delete('Latest_news/{id}', [LatestNewsController::class, 'destroy']);



    //--------target_group
    Route::post('target_group', [TargetGroupController::class, 'store']);
    Route::post('target_group/{id}', [TargetGroupController::class, 'update']);
    Route::delete('target_group/{id}', [TargetGroupController::class, 'destroy']);


    //--------Photo_gallery
    Route::post('Photo_gallery', [PhotoGalleryController::class, 'store']);
    Route::post('Photo_gallery/{id}', [PhotoGalleryController::class, 'update']);
    Route::delete('Photo_gallery/{id}', [PhotoGalleryController::class, 'destroy']);

    //--------video_gallery
    Route::post('video_gallery', [VideoGalleryController::class, 'store']);
    Route::post('video_gallery/{id}', [VideoGalleryController::class, 'update']);
    Route::delete('video_gallery/{id}', [VideoGalleryController::class, 'destroy']);

    //--------partners
    Route::post('partners', [PartnersController::class, 'store']);
    Route::post('partners/{id}', [PartnersController::class, 'update']);
    Route::delete('partners/{id}', [PartnersController::class, 'destroy']);

    //--------registerIn

    Route::delete('registerIn/{id}', [RegisterInController::class, 'destroy']);
    Route::get('registerIn', [RegisterInController::class, 'index']);


    //--------contct_footer
    Route::post('contct_footer', [ContctFooterController::class, 'store']);
    Route::post('contct_footer/{id}', [ContctFooterController::class, 'update']);
    Route::delete('contct_footer/{id}', [ContctFooterController::class, 'destroy']);



    //logout
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::post('registerIn', [RegisterInController::class, 'store']);



Route::post('registerIn/{id}', [RegisterInController::class, 'update']);

//--------home
Route::get('main', [HomeController::class, 'index']);


Route::get('home', [HomeController::class, 'home']);

//--------about
Route::get('about', [AboutController::class, 'index']);

//--------goals
Route::get('goals', [GoalsController::class, 'index']);


//--------supervisor_speech
Route::get('supervisor_speech', [SupervisorSpeechController::class, 'index']);

//--------organizing_entity
Route::get('organizing_entity', [OrganizingEntityController::class, 'index']);


//--------Forum_management
Route::get('Forum_management', [ForumManagementController::class, 'index']);


//--------Media_partner
Route::get('Media_partner', [MediaPartnerController::class, 'index']);


//--------Key_speakers
Route::get('Key_speakers', [KeySpeakersController::class, 'index']);

//--------Sponsorship
Route::get('Sponsorship', [SponsorshipController::class, 'index']);

//--------Latest_news
Route::get('Latest_news', [LatestNewsController::class, 'index']);

//--------target_group
Route::get('target_group', [TargetGroupController::class, 'index']);

//--------Photo_gallery
Route::get('Photo_gallery', [PhotoGalleryController::class, 'index']);

//--------video_gallery
Route::get('video_gallery', [VideoGalleryController::class, 'index']);

//--------partners
Route::get('partners', [PartnersController::class, 'index']);

//-------contct_footer
Route::get('contct_footer', [ContctFooterController::class, 'index']);


//---------auth
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
