<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;
use App\Http\Controllers\Backend\EventController as BackendEventController;
use App\Http\Controllers\Backend\EventEmailController as BackendEventEmailController;
use App\Http\Controllers\Backend\EventRoomController as BackendEventRoomController;
use App\Http\Controllers\Backend\EventUserController as BackendEventUserController;
use App\Http\Controllers\Backend\EventUserImportController as BackendEventUserImportController;
use App\Http\Controllers\Backend\ExhibitionGroupController as BackendExhibitionGroupController;
use App\Http\Controllers\Backend\ExhibitionStandController as BackendExhibitionStandController;
use App\Http\Controllers\Backend\EventProgramController as BackendEventProgramController;
use App\Http\Controllers\Backend\EventRoomBannerController as BackendEventRoomBannerController;
use App\Http\Controllers\Backend\ExhibitionStandItemController as BackendExhibitionStandItemController;
use App\Http\Controllers\Backend\EventPosterController as BackendEventPosterController;
use App\Http\Controllers\Backend\EventStatsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPosterController;
use App\Http\Controllers\EventProgramController;
use App\Http\Controllers\EventRoomController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\ExhibitionStandController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['lang'])->group(function () {
//Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
    Route::middleware(['is-guest'])->group(function () {
        Route::get('/', [LoginController::class, 'getLogin'])->name('get_login');
        Route::post('/login_to_event', [LoginController::class, 'loginToEvent'])->name('login_to_event');
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/post_login', [LoginController::class, 'postLogin'])->name('post_login');
            Route::get('/register', [RegisterController::class, 'getRegister'])->name('get_register');
            Route::post('/post_register', [RegisterController::class, 'postRegister'])->name('post_register');
            Route::get('/register_success', [RegisterController::class, 'success'])->name('register_success');
        });
    });

    Route::middleware(['is-logged-in', 'is-enabled'])->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::name('frontend.')->group(function () {
            Route::prefix('watch')->name('events.')->group(function () {
                Route::get('/{slug}', [EventController::class, 'watch'])->name('watch');
                Route::get('/{slug}/room/{eventRoom}', [EventRoomController::class, 'view'])->name('room.view');
                Route::get('/{slug}/program', [EventProgramController::class, 'view'])->name('program.view');
                Route::get('/{slug}/exhibition', [ExhibitionController::class, 'index'])->name('exhibition.view');
                Route::get('/{slug}/exhibition/{exhibitionStand}', [ExhibitionStandController::class, 'view'])->name('exhibition.single');
                Route::get('/{slug}/posters', [EventPosterController::class, 'index'])->name('posters.index');
            });
            Route::prefix('account')->name('account.')->group(function () {
                Route::get('/event_invitations', [EventController::class, 'eventInvitations'])->name('event_invitations');
            });
            Route::prefix('posters')->name('posters.')->group(function () {
                Route::get('/{eventPoster}/vote', [EventPosterController::class, 'vote'])->name('vote');
            });
        });

        Route::prefix('backend')->name('backend.')->group(function () {
            Route::get('/dashboard', [BackendDashboardController::class, 'index'])->name('dashboard');

            Route::prefix('events')->name('events.')->group(function () {
                Route::get('/', [BackendEventController::class, 'index'])->name('index');
                Route::get('/create', [BackendEventController::class, 'add'])->name('add');
                Route::post('/store', [BackendEventController::class, 'store'])->name('store');
                Route::get('/{event}/edit', [BackendEventController::class, 'edit'])->name('edit');
                Route::patch('/{event}/update', [BackendEventController::class, 'update'])->name('update');
                Route::get('/{event}/delete', [BackendEventController::class, 'delete'])->name('delete');
                Route::post('/logo_upload', [BackendEventController::class, 'logoUpload'])->name('logo_upload');
                Route::patch('/{event}/update_design_settings', [BackendEventController::class, 'updateDesignSettings'])->name('design_update');
            });

            Route::prefix('stats')->name('stats.')->group(function () {
                Route::get('/{event}/view', [EventStatsController::class, 'eventStats'])->name('event');
            });

            Route::prefix('program')->name('program.')->group(function () {
                Route::get('/{event}/index', [BackendEventProgramController::class, 'index'])->name('index');
                Route::get('/{event}/add', [BackendEventProgramController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendEventProgramController::class, 'store'])->name('store');
                Route::get('/{eventProgram}/edit', [BackendEventProgramController::class, 'edit'])->name('edit');
                Route::post('/{eventProgram}/update', [BackendEventProgramController::class, 'update'])->name('update');
                Route::get('/{eventProgram}/delete', [BackendEventProgramController::class, 'delete'])->name('delete');
                Route::post('/image_upload', [BackendEventProgramController::class, 'programImageUpload'])->name('image_upload');
            });

            Route::prefix('rooms')->name('rooms.')->group(function () {
                Route::get('/{event}/list', [BackendEventRoomController::class, 'index'])->name('index');
                Route::get('/{event}/create', [BackendEventRoomController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendEventRoomController::class, 'store'])->name('store');
                Route::get('/{eventRoom}/edit', [BackendEventRoomController::class, 'edit'])->name('edit');
                Route::patch('/{eventRoom}/update', [BackendEventRoomController::class, 'update'])->name('update');
                Route::get('/{eventRoom}/delete', [BackendEventRoomController::class, 'delete'])->name('delete');
                Route::post('/{event}/banner_upload', [BackendEventRoomController::class, 'bannerUpload'])->name('banner_upload');
            });

            Route::prefix('posters')->name('posters.')->group(function () {
                Route::get('/{event}/list', [BackendEventPosterController::class, 'index'])->name('index');
                Route::get('/{event}/create', [BackendEventPosterController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendEventPosterController::class, 'store'])->name('store');
                Route::get('/{eventPoster}/edit', [BackendEventPosterController::class, 'edit'])->name('edit');
                Route::patch('/{eventPoster}/update', [BackendEventPosterController::class, 'update'])->name('update');
                Route::get('/{eventPoster}/delete', [BackendEventPosterController::class, 'delete'])->name('delete');
                Route::post('/{event}/image_upload', [BackendEventPosterController::class, 'imageUpload'])->name('image_upload');
                Route::post('/{event}/reorder', [BackendEventPosterController::class, 'reorder'])->name('reorder');
            });

            Route::prefix('room_banners')->name('room_banners.')->group(function () {
                Route::get('/{eventRoom}/add', [BackendEventRoomBannerController::class, 'add'])->name('add');
                Route::post('/{eventRoom}/store', [BackendEventRoomBannerController::class, 'store'])->name('store');
                Route::post('/{eventRoom}/file_upload', [BackendEventRoomBannerController::class, 'fileUpload'])->name('file_upload');
                Route::post('/{eventRoom}/banner_upload', [BackendEventRoomBannerController::class, 'bannerUpload'])->name('banner_upload');
                Route::post('/{eventRoomBanner}/delete', [BackendEventRoomBannerController::class, 'delete'])->name('delete');
                Route::post('/{eventRoom}/reorder', [BackendEventRoomBannerController::class, 'reorder'])->name('reorder');
            });

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/{event}/list', [BackendEventUserController::class, 'index'])->name('index');
                Route::get('/{event}/add', [BackendEventUserController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendEventUserController::class, 'store'])->name('store');
                Route::get('/{eventUser}/edit', [BackendEventUserController::class, 'edit'])->name('edit');
                Route::patch('/{eventUser}/update', [BackendEventUserController::class, 'update'])->name('update');
                Route::get('/{event}/import', [BackendEventUserController::class, 'import'])->name('import');
                Route::post('/{event}/import/post', [BackendEventUserController::class, 'importPost'])->name('import.post');
                Route::get('/{eventUser}/delete', [BackendEventUserController::class, 'delete'])->name('delete');
                Route::get('/{event}/list/json', [BackendEventUserController::class, 'getList'])->name('get_list');
            });

            Route::prefix('users_import')->name('users_import.')->group(function () {
                Route::post('/{event}/check_file', [BackendEventUserImportController::class, 'checkFile'])->name('check_file');
                Route::post('/{event}/import', [BackendEventUserImportController::class, 'import'])->name('import');
            });

            Route::prefix('emails')->name('emails.')->group(function () {
                Route::get('/{event}/edit', [BackendEventEmailController::class, 'edit'])->name('edit');
                Route::patch('/{eventEmail}/update', [BackendEventEmailController::class, 'update'])->name('update');
                Route::post('/{eventEmail}/send_test', [BackendEventEmailController::class, 'sendTest'])->name('send.test');
            });

            Route::prefix('groups')->name('groups.')->group(function () {
                Route::get('/{event}/list', [BackendExhibitionGroupController::class, 'index'])->name('index');
                Route::get('/{event}/create', [BackendExhibitionGroupController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendExhibitionGroupController::class, 'store'])->name('store');
                Route::get('/{exhibitionGroup}/edit', [BackendExhibitionGroupController::class, 'edit'])->name('edit');
                Route::patch('/{exhibitionGroup}/update', [BackendExhibitionGroupController::class, 'update'])->name('update');
                Route::get('/{exhibitionGroup}/delete', [BackendExhibitionGroupController::class, 'delete'])->name('delete');
            });

            Route::prefix('stands')->name('stands.')->group(function () {
                Route::get('/{event}/list', [BackendExhibitionStandController::class, 'index'])->name('index');
                Route::get('/{event}/create', [BackendExhibitionStandController::class, 'add'])->name('add');
                Route::post('/{event}/store', [BackendExhibitionStandController::class, 'store'])->name('store');
                Route::get('/{exhibitionStand}/edit', [BackendExhibitionStandController::class, 'edit'])->name('edit');
                Route::patch('/{exhibitionStand}/update', [BackendExhibitionStandController::class, 'update'])->name('update');
                Route::get('/{exhibitionStand}/delete', [BackendExhibitionStandController::class, 'delete'])->name('delete');
                Route::post('/{event}/image_upload', [BackendExhibitionStandController::class, 'logoUpload'])->name('logo_upload');
            });

            Route::prefix('stand_items')->name('stand_items.')->group(function () {
                Route::get('/{exhibitionStand}/add', [BackendExhibitionStandItemController::class, 'add'])->name('add');
                Route::post('/{exhibitionStand}/store', [BackendExhibitionStandItemController::class, 'store'])->name('store');
                Route::get('/{exhibitionStandItem}/edit', [BackendExhibitionStandItemController::class, 'edit'])->name('edit');
                Route::patch('/{exhibitionStandItem}/update', [BackendExhibitionStandItemController::class, 'update'])->name('update');
                Route::post('/{exhibitionStand}/image_upload', [BackendExhibitionStandItemController::class, 'imageUpload'])->name('image_upload');
                Route::post('/{exhibitionStand}/file_upload', [BackendExhibitionStandItemController::class, 'fileUpload'])->name('file_upload');
                Route::get('/{exhibitionStandItem}/delete', [BackendExhibitionStandItemController::class, 'delete'])->name('delete');
                Route::post('/{exhibitionStand}/reorder', [BackendExhibitionStandItemController::class, 'reorder'])->name('reorder');
            });
        });
    });
});
