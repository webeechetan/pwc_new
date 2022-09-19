<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\websiteController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\case_studiesController;
use App\Http\Controllers\authController;
use App\Http\Controllers\startupController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\homepageController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\startupAuthController;
use App\Http\Controllers\pilotAuthController;
use App\Http\Controllers\CommitteeAuthController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\SeasonController;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\testController;
use Carbon\Carbon;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;
use App\Events\EventMail;
use App\Http\Controllers\KnowledgeSharingController;


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
// Committee_Pilot_Check


Route::get('/invite',function(Request $request){
    $event = new Event;
    $event->name = 'multipe attendees';
    $event->description = 'Event description';
    $date = '2021-12-23';
    $time = '14:00:00';
    $enddate = '2021-12-23';
    $endtime = '15:00:00';
    $event->startDateTime = Carbon::parse($date.' '.$time);
    $event->endDateTime = Carbon::parse($enddate.' '.$endtime);
   
    $event->addAttendee(['email' => 'chetansisodiya.rajput9@gmail.com']);
    $event->addAttendee(['email' => 'aval.chetan@gmail.com']);
    $event->addAttendee(['email' => 'coders24.online@gmail.com']);
    $event->addAttendee(['email' => 'chetan.singh@webeesocal.com']);
    
    $event->save();
});


Route::get('/queue',function(){
    
});

/*
|Website
-------- --- */
Route::get('/', [websiteController::class, 'index']);
Route::get('/season/{id}', [websiteController::class, 'index'])->name('season.id');
Route::get('/case-studies', [websiteController::class, 'caseStuides']);
Route::get('/case-studies/{id}', [websiteController::class, 'viewCaseStuides']);
Route::post('/contact', [contactController::class, 'update']);
Route::get('/knowledge_sharing',[websiteController::class,'knowledgeSharing']);
Route::get('/knowledge_sharing/{id}',[websiteController::class,'viewKnowledgeSharing']);

/*
|Website All Session Middle
--------------------------- -- */
// Route::group(['middleware'=>['AllAuthCheck']], function(){
    Route::get('/event', [websiteController::class, 'event']);
    Route::get('/event/{id}', [websiteController::class, 'viewEvent']);
    Route::post('/event/search/view', [websiteController::class, 'searchEvent']);
    Route::get('/event/register/{id}', [eventController::class, 'eventRegister']);
    
// });

/*
|Website Startup Middle
--------------------------- -- */
Route::group(['middleware'=>['StartupAuthCheck']], function(){
    
    Route::get('/auth', [startupAuthController::class, 'index']);
    Route::post('/auth/signup', [startupAuthController::class, 'create']);
    Route::post('/auth/signin', [startupAuthController::class, 'authentication']);
    Route::get('/startup/changepassword', [startupAuthController::class, 'changepassword']);
    Route::post('/startup/changepassword', [startupAuthController::class, 'updatepassword']);
    Route::get('/auth/signout', [startupAuthController::class, 'signout']);

    Route::get('/myaccount', [startupAuthController::class, 'myaccount']);
    Route::post('/myaccount/update', [startupAuthController::class, 'update']);
    Route::get('/myaccount/signout', [startupAuthController::class, 'signout']);
    
});

/*
|Website Pilot Middle
--------------------------- -- */
Route::group(['middleware'=>['PilotAuthCheck']], function(){
    Route::get('/pilot_companies', [pilotAuthController::class, 'index']);
    Route::get('/pilot_companies/changepassword', [pilotAuthController::class, 'changepassword']);
    Route::post('/pilot_companies/changepassword', [pilotAuthController::class, 'updatepassword']);
    Route::post('/pilot_companies/signin', [pilotAuthController::class, 'authentication']);
    Route::get('/pilot_companies/signout', [pilotAuthController::class, 'signout']);

    Route::get('/startups', [startupController::class, 'startupList'])->name('startup.list');
    Route::get('/startups/{id}', [startupController::class, 'startupView']);
    Route::post('/startups/search/view', [startupController::class, 'searchStartup']);
    Route::get('/startups/approved/{id}', [startupController::class, 'giveApproval']);
    Route::get('/startups/season/{season_id}', [startupController::class, 'startupListBySeason'])->name('startup.list.by.season');
});

/*
|Admin
-------- --- */
Route::post('admin/startup/download', [startupController::class, 'downloadSelected']);
Route::get('admin/startup/downloadexcel/{id}', [startupController::class, 'downloadExcel']);

Route::group(['middleware'=>['AuthCheck']], function(){

    Route::get('admin/signin/', [authController::class, 'index']);
    Route::post('admin/signin/', [authController::class, 'authentication']);
    Route::get('admin/logout/', [authController::class, 'logout']);

    Route::get('admin/', [dashboardController::class, 'index']);

    Route::get('admin/event/validate_old_data/{id}', [eventController::class, 'validate_old_data']);

    Route::group(['middleware'=>['Privilege']], function(){

        // User
        Route::get('admin/user', [adminController::class, 'index']);
        Route::get('admin/user/add', [adminController::class, 'create']);
        Route::post('admin/user/add', [adminController::class, 'create']);
        Route::get('admin/user/edit/{id}', [adminController::class, 'update']);
        Route::post('admin/user/edit/{id}', [adminController::class, 'update']);
        Route::delete('admin/user/{id}', [adminController::class, 'delete']);

        // Role
        Route::get('admin/role', [roleController::class, 'index']);
        Route::get('admin/role/add', [roleController::class, 'create']);
        Route::post('admin/role/add', [roleController::class, 'create']);
        Route::get('admin/role/edit/{id}', [roleController::class, 'update']);
        Route::post('admin/role/edit/{id}', [roleController::class, 'update']);
        Route::delete('admin/role/{id}', [roleController::class, 'delete']);

        // Contact
        Route::get('admin/contact', [contactController::class, 'index']);
        Route::delete('admin/contact/{id}', [contactController::class, 'delete']);

        // Start Up
        Route::get('admin/startup', [startupController::class, 'index'])->name('admin.startup.list');
        Route::get('admin/startup/season/{season_id}', [startupController::class, 'index'])->name('admin.startup.list.with.season');
        Route::get('admin/startup/view/{id}', [startupController::class, 'view']);
        // Route::get('admin/startup/add', [startupController::class, 'create']);
        // Route::post('admin/startup/add', [startupController::class, 'create']);
        Route::get('admin/startup/edit/{id}', [startupController::class, 'update']);
        Route::post('admin/startup/edit/{id}', [startupController::class, 'update']);
        Route::put('admin/startup/certified/{id}', [startupController::class, 'certified']);
        Route::put('admin/startup/active/{id}', [startupController::class, 'active']);
        Route::put('admin/startup/approved/{id}', [startupController::class, 'approval']);
        Route::delete('admin/startup/{id}', [startupController::class, 'delete']);

        ///pilots
        Route::get('admin/pilots/', [pilotAuthController::class, 'viewPilots']);
        Route::get('admin/pilot/{id}', [pilotAuthController::class, 'viewPilot'])->name('view_pilot');

        // Home Page
        Route::get('admin/homepage/', [homepageController::class, 'index']);
        Route::get('admin/homepage/season/{season_id}', [homepageController::class, 'index'])->name('homepage.edit.with.season.id');
        Route::post('admin/homepage/edit/{id}', [homepageController::class, 'update']);
        
        // Footer
        Route::get('admin/footer/', [FooterController::class, 'index']);
        Route::get('admin/footer/edit/{id}', [FooterController::class, 'update']);
        Route::post('admin/footer/edit/{id}', [FooterController::class, 'update']);

        // Event
        Route::get('admin/event', [eventController::class, 'index']);
        Route::get('admin/event/add', [eventController::class, 'create']);
        Route::post('admin/event/add', [eventController::class, 'create']);
        Route::get('admin/event/edit/{id}', [eventController::class, 'update']);
        Route::post('admin/event/edit/{id}', [eventController::class, 'update']);
        Route::delete('admin/event/{id}', [eventController::class, 'delete']);

        // Case Studies
        Route::get('admin/case_studies', [case_studiesController::class, 'index']);
        Route::get('admin/case_studies/add', [case_studiesController::class, 'create']);
        Route::post('admin/case_studies/add', [case_studiesController::class, 'create']);
        Route::get('admin/case_studies/edit/{id}', [case_studiesController::class, 'update']);
        Route::post('admin/case_studies/edit/{id}', [case_studiesController::class, 'update']);
        Route::delete('admin/case_studies/{id}', [case_studiesController::class, 'delete']);

        //Season

        Route::get('admin/season', [SeasonController::class, 'index']);
        Route::post('admin/season', [SeasonController::class, 'store'])->name('season.store');
        Route::get('admin/season/change_status/{id}/{status}', [SeasonController::class, 'change_status'])->name('season.change_status');

        // Knowledge Sharing
        
        Route::get('admin/knowledge_sharing',[KnowledgeSharingController::class,'index'])->name('knowledge_sharing.list');
        Route::get('admin/knowledge_sharing/add',[KnowledgeSharingController::class,'create'])->name('knowledge_sharing.create');
        Route::post('admin/knowledge_sharing/add',[KnowledgeSharingController::class,'store'])->name('knowledge_sharing.store');
        Route::get('admin/knowledge_sharing/edit/{id?}',[KnowledgeSharingController::class,'edit'])->name('knowledge_sharing.edit');
        Route::post('admin/knowledge_sharing/update',[KnowledgeSharingController::class,'update'])->name('knowledge_sharing.update');
        Route::get('admin/knowledge_sharing/delete/{id}',[KnowledgeSharingController::class,'destroy'])->name('knowledge_sharing.delete');
        Route::get('admin/knowledge_sharing/id/{id}/delete_image/{image_name}',[KnowledgeSharingController::class,'delete_image'])->name('knowledge_sharing.delete_image');

    });
});



/*
|Test Routes(like: to update pilot companies votes and all)
----------------------------------------------------------- --- */
// Route::get('/updatepilottest', [testController::class, 'index']);