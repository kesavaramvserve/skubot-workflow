<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebsiteController; 
use App\Http\Controllers\WebsiteListController; 
use App\Http\Controllers\BatchListController; 
use App\Http\Controllers\SingleWorkflowController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\Scraper\ScraperController;
use App\Http\Controllers\Support\SupportController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Reviewer\ReviewerController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\TL\TLController;
use App\Http\Controllers\PA\PAController;
use App\Http\Controllers\QC\QCController;
use App\Http\Controllers\QA\QAController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class,'customLogin']);
Route::get('/home', [LoginController::class,'customLogin']);
Route::get('/data_import', [WebsiteController::class,'data_import'])->name('data_import');
Route::get('/add_data_history', [WebsiteController::class,'add_data_history'])->name('add_data_history');
Auth::routes();

// General with Authentication
Route::group(['middleware' => ['auth']], function() {
    Route::get('/customlogout', [LoginController::class,'logout'])->name('customlogout');
    Route::resource('website', WebsiteController::class);
    Route::get('/data_history', [WebsiteController::class,'data_history'])->name('data_history');
    Route::post('/save_notes', [WebsiteController::class,'save_notes'])->name('save_notes');
    Route::post('/download_batch', [ExportController::class,'download_batch'])->name('download_batch');
    Route::resource('website_list', WebsiteListController::class);
    Route::post('/import_client_file', [WebsiteListController::class,'import_client_file'])->name('import_client_file');
    Route::resource('batch_list', BatchListController::class);
    Route::post('/update_batches', [BatchListController::class,'update_batches'])->name('update_batches');
    Route::get('/common_sku_export/{id}', [WebsiteController::class,'common_sku_export'])->name('common_sku_export');
    Route::get('/get_scrapper_list', [WebsiteController::class,'get_scrapper_list'])->name('get_scrapper_list');
    Route::get('/get_pa_list', [WebsiteController::class,'get_pa_list'])->name('get_pa_list');
    Route::get('/get_qc_list', [WebsiteController::class,'get_qc_list'])->name('get_qc_list');
    Route::get('/get_qa_list', [WebsiteController::class,'get_qa_list'])->name('get_qa_list');
    Route::get('/download_client_file/{id}', [WebsiteListController::class,'download_client_file'])->name('download_client_file');
    Route::post('/assign_users', [WebsiteListController::class,'assign_users'])->name('assign_users');
    Route::post('single_assign_users', [TLController::class,'single_assign_users'])->name('single_assign_users');
    Route::post('/scraper_upload', [ScraperController::class,'store'])->name('scraper_upload');
    Route::post('/assign_tl', [WebsiteController::class,'assign_tl'])->name('assign_tl');
    Route::post('/assign_file_users', [WebsiteListController::class,'assign_file_users'])->name('assign_file_users');
    Route::get('/website_list/view_client_files/{id}', [WebsiteListController::class,'view_client_files'])->name('website_list.view_client_files');
    Route::post('/enhance_data', [SupportController::class,'enhance_data'])->name('enhance_data');
    Route::get('/sku/{id}', [SingleWorkflowController::class,'sku'])->name('sku');
    Route::post('/update_sku', [SingleWorkflowController::class,'update_sku'])->name('update_sku');
});

// Super Admin
Route::group(['middleware' => ['auth','role:Super Admin']], function() {
    Route::resource('super-admin', SuperAdminController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/user/create_client', [UserController::class,'create_client'])->name('user.create_client');
    Route::post('/user/store_client', [UserController::class,'store_client'])->name('user.store_client');
    Route::post('/super-admin/store_project', [SuperAdminController::class,'store_project'])->name('super-admin.store_project');
    Route::post('/manage_content', [SuperAdminController::class,'manage_content'])->name('manage_content');
});

// Scraper
// Route::group(['middleware' => ['auth','role:Scraper|Power User|Operation']], function() {
//     Route::post('/scraper_upload', [ScraperController::class,'store'])->name('scraper_upload');
// });

// PM
Route::group(['middleware' => ['auth','role: PM|Power User']], function() {
    Route::resource('support', SupportController::class);
    Route::post('/import_scrape_data', [SupportController::class,'import_scrape_data'])->name('import_scrape_data');
   
    Route::get('/delete_scrape_data/{id}', [SupportController::class,'delete_scrape_data'])->name('delete_scrape_data');
    Route::get('/download_client_data/{id}', [SupportController::class,'download_client_data'])->name('download_client_data');
    Route::post('/validate_website', [WebsiteController::class,'validate_website'])->name('validate_website');
    Route::post('/add_more', [WebsiteController::class,'add_more'])->name('add_more');
    // Route::post('/assign_tl', [WebsiteController::class,'assign_tl'])->name('assign_tl');
    Route::post('/project_settings', [WebsiteController::class,'project_settings'])->name('project_settings');
});

// Team Lead
Route::group(['middleware' => ['auth','role:Team Lead']], function() {
    Route::resource('tl', TLController::class);
    Route::get('split_sku/{id}', [TLController::class,'split_sku'])->name('split_sku');
    Route::post('create_batch', [TLController::class,'create_batch'])->name('create_batch');
    Route::get('batches/{id}', [TLController::class,'batches'])->name('batches');
    Route::get('unassign_batches/{id}', [TLController::class,'unassign_batches'])->name('unassign_batches');
    Route::post('split_skus', [TLController::class,'split_skus'])->name('split_skus');
    // Route::post('assign_users', [TLController::class,'assign_users'])->name('assign_users');
    // Route::post('/enhance_data', [TLController::class,'enhance_data'])->name('enhance_data');
    Route::post('/update_to_live', [TLController::class,'update_to_live'])->name('update_to_live');
    Route::post('/enhance_result_filter', [SupportController::class,'enhance_result_filter'])->name('enhance_result_filter');
});

// PA
Route::group(['middleware' => ['auth','role:PA']], function() {
    Route::resource('pa', PAController::class);
    Route::get('qc_reject', [PAController::class,'qc_reject'])->name('qc_reject');
    Route::get('pa_complete', [PAController::class,'pa_complete'])->name('pa_complete');
});

// QC
Route::group(['middleware' => ['auth','role:QC']], function() {
    Route::resource('qc', QCController::class);
    Route::get('qa_reject', [QCController::class,'qa_reject'])->name('qa_reject');
    Route::get('qc_complete', [QCController::class,'qc_complete'])->name('qc_complete');
});

// QA
Route::group(['middleware' => ['auth','role:QA']], function() {
    Route::resource('qa', QAController::class);
    Route::get('qa_complete', [QAController::class,'qa_complete'])->name('qa_complete');
});

// Support and Reviewer
Route::group(['middleware' => ['auth','role: PM|Reviewer|Power User']], function() {
    Route::get('/enhance_result/{id}', [SupportController::class,'enhance_result'])->name('enhance_result');
    Route::get('/set_range/{id}', [SupportController::class,'set_range'])->name('set_range');
    Route::get('/scrape_view', [SupportController::class,'scrape_view'])->name('scrape_view');
    Route::get('/send_mail/{id}', [SupportController::class,'send_mail'])->name('send_mail');
});

// Reviewer
Route::group(['middleware' => ['auth','role:Reviewer|Power User|PM']], function() {
    Route::get('/send_enhance_mail/{id}', [ReviewerController::class,'send_enhance_mail'])->name('send_enhance_mail');
});

// Client
Route::get('/client_register', [ClientController::class,'create'])->name('client_register');
Route::get('/client_register_plan/{plan}', [ClientController::class,'client_register_plan'])->name('client_register_plan');
Route::resource('clients', ClientController::class);
Route::group(['middleware' => ['auth','role:Client']], function() {
    
    Route::get('/client/{id}', [ClientController::class,'client_dashboard'])->name('client');
    Route::post('/client/view_cost', [ClientController::class,'view_cost'])->name('client.view_cost');
    Route::post('/client/client_request', [ClientController::class,'client_request'])->name('client.client_request');
    Route::get('/client/result/{id}', [ClientController::class,'client_result'])->name('client.result');
    Route::post('/download_sku', [ClientController::class,'download_sku'])->name('download_sku');
    Route::post('/sku_selection', [ClientController::class,'sku_selection'])->name('sku_selection');
    Route::get('/sku_upload_view', [ClientController::class,'sku_upload_view'])->name('sku_upload_view');
    Route::get('/sku_selection_view', [ClientController::class,'sku_selection_view'])->name('sku_selection_view');
    Route::post('/payment', [ClientController::class,'payment'])->name('payment');
    Route::post('/post_payment', [ClientController::class,'post_payment'])->name('post_payment');
});

// Clear application cache:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function() {
	Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
 	Artisan::call('config:cache');
 	return 'Config cache has been cleared';
}); 

// Clear view cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});