<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Student\StudentSettingsController;
use App\Http\Controllers\BusinessOwner\BusinessOwnerController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about_us', function () {
    return view('about_us');
});
Route::get('/view_clubs', function () {
    return view('view_clubs');
});
Route::get('/view_products', function () {
    return view('view_products');
});


Route::get('/blog',[Controller::class ,'blog']);

Route::get('/contact_us', function () {
    return view('contact');
});

Route::get('/services',[Controller::class ,'services']);

Route::prefix('student')->name('student.')->group(function(){
  
    Route::middleware(['guest:web','guest:admin'])->group(function(){
        Route::view('/login','students.auth.login')->name('login');
        Route::post('/login',[LoginController::class ,'studentLogin']);

        Route::get('/register/step-1',[RegisterController::class ,'request_otp_view'])->name('register.step-1'); 
        Route::post('/register/step-1',[RegisterController::class ,'request_otp']);
        Route::get('/register/step-2',[RegisterController::class ,'verify_otp_view'])->name('register.step-2');
        Route::post('/register/step-2',[RegisterController::class ,'verify_otp']);
        Route::get('/register',[RegisterController::class ,'registerView'])->name('register');
        Route::post('/register',[RegisterController::class ,'register']);

        Route::get('/password/email',[ForgotPasswordController::class ,'request_otp_view'])->name('password.email');
        Route::post('/password/email',[ForgotPasswordController::class ,'request_otp']);
        Route::get('/password/verify',[ForgotPasswordController::class ,'verify_otp_view'])->name('password.verify');
        Route::post('/password/verify',[ForgotPasswordController::class ,'verify_otp']);
        Route::get('/password/reset',[ResetPasswordController::class ,'resetPasswordView'])->name('password.reset');
        Route::post('/password/reset',[ResetPasswordController::class ,'reset']);
    });

    Route::middleware(['auth:web'])->group(function(){
        Route::get('/dashboard',[StudentController::class ,'dashboard'])->name('dashboard');
        Route::get('/logout',[LoginController::class,'studentLogout'])->name('logout');

        Route::get('/posts',[StudentController::class ,'postsView'])->name('posts');
        Route::get('/post_edit/{id}',[StudentController::class ,'postsEdit'])->name('post_edit');
        Route::get('/post_delete/{id}',[StudentController::class ,'postDelete'])->name('post_delete');
        Route::get('/post_create',[StudentController::class ,'createPost'])->name('post_create');
        Route::post('/post',[StudentController::class ,'addPosts'])->name('post');
        Route::post('/edit_post',[StudentController::class ,'editPost'])->name('edit_post');

        Route::get('/businesses',[StudentController::class ,'businesses'])->name('businesses');

        Route::get('/clubs',[StudentController::class ,'clubs'])->name('clubs');
        Route::post('/club',[StudentController::class ,'addClub'])->name('club');
        Route::get('/club_join/{id}',[StudentController::class ,'joinClub'])->name('club_join');
        
        Route::get('/club_delete/{id}',[StudentController::class ,'clubDelete'])->name('club_delete');

        Route::get('/students',[StudentController::class ,'students'])->name('students');
        Route::get('/student_view/{id}',[StudentController::class ,'studentView'])->name('student_view');

        Route::get('/checkout/{price}',[StudentController::class ,'checkout_view'])->name('checkout');
        Route::get('/checkout_pay/{price}',[StudentController::class ,'checkout'])->name('checkout_pay');

        Route::get('/product_cart/{id}',[StudentController::class ,'productCart'])->name('product_cart');
        Route::get('/return/{id}',[StudentController::class ,'return'])->name('return');

        Route::get('/business_owner/{id}',[StudentController::class ,'business_owner'])->name('business_owner');

        Route::post('/message',[StudentController::class ,'message'])->name('message');

        Route::get('/queries',[StudentController::class ,'queries'])->name('queries');
        Route::post('/inquire',[StudentController::class ,'inquire'])->name('inquire');

        Route::get('/settings',[StudentController::class ,'settings'])->name('settings');
        Route::post('/settings/password',[StudentSettingsController::class ,'updatePassword'])->name('settings.password');
        Route::post('/settings/profile',[StudentSettingsController::class ,'updateProfile'])->name('settings.profile');
        
    });

});

Route::prefix('admin')->name('admin.')->group(function(){
       
    Route::middleware(['guest:admin', 'guest:web'])->group(function(){
          Route::view('/login','admin.auth.login')->name('login');
          Route::post('/login',[LoginController::class ,'adminLogin'])->name('check');
    });

    Route::middleware(['auth:admin'])->group(function(){
        Route::get('/dashboard',[AdminController::class ,'index'])->name('dashboard');

        Route::get('/settings',[AdminController::class ,'settingsView'])->name('settings');
        Route::post('/settings/password',[AdminController::class ,'updatePassword'])->name('settings.password');

        Route::get('/students',[AdminController::class ,'studentsView'])->name('students');
        Route::put('/students',[AdminController::class ,'studentsEdit']);
        Route::get('/students/delete/{id}',[AdminController::class ,'deleteStudent'])->name('students.delete');
        Route::get('/student/{id}',[AdminController::class ,'studentView'])->name('student');

        Route::get('/business_owners',[AdminController::class ,'businessOwnersView'])->name('business_owners');
        Route::put('/business_owners',[AdminController::class ,'businessOwnersEdit']);
        Route::get('/business_owners/delete/{id}',[AdminController::class ,'deleteBusinessOwner'])->name('business_owners.delete');
        Route::get('/business_owner/{id}',[AdminController::class ,'businessOwnerView'])->name('business_owner');

        Route::get('/posts',[AdminController::class ,'posts'])->name('posts');
        Route::get('/approve_post/{id}',[AdminController::class ,'approvePost'])->name('approve_post');

        Route::get('/clubs',[AdminController::class ,'clubs'])->name('clubs');
        Route::get('/approve_club/{id}',[AdminController::class ,'approveClub'])->name('approve_club');

        Route::get('/inquiries',[AdminController::class ,'inquiriewsView'])->name('inquiries');
        Route::get('/logout',[LoginController::class,'adminLogout'])->name('logout');

    });

});

Route::prefix('super_admin')->name('super_admin.')->group(function(){
       
    Route::middleware(['guest:super_admin', 'guest:web'])->group(function(){
          Route::view('/login','super_admin.auth.login')->name('login');
          Route::post('/login',[LoginController::class ,'superAdminLogin'])->name('check');
    });

    Route::middleware(['auth:super_admin'])->group(function(){
        Route::get('/dashboard',[SuperAdminController::class ,'index'])->name('dashboard');

        Route::get('/settings',[SuperAdminController::class ,'settingsView'])->name('settings');
        Route::post('/settings/password',[SuperAdminController::class ,'updatePassword'])->name('settings.password');

        Route::get('/students',[SuperAdminController::class ,'studentsView'])->name('students');
        Route::put('/students',[SuperAdminController::class ,'studentsEdit']);
        Route::get('/students/delete/{id}',[SuperAdminController::class ,'deleteStudent'])->name('students.delete');
        Route::get('/student/{id}',[SuperAdminController::class ,'studentView'])->name('student');

        Route::get('/business_owners',[SuperAdminController::class ,'businessOwnersView'])->name('business_owners');
        Route::put('/business_owners',[SuperAdminController::class ,'businessOwnersEdit']);
        Route::get('/business_owners/delete/{id}',[SuperAdminController::class ,'deleteBusinessOwner'])->name('business_owners.delete');
        Route::get('/business_owner/{id}',[SuperAdminController::class ,'businessOwnerView'])->name('business_owner');

        Route::get('/admins',[SuperAdminController::class ,'adminsView'])->name('admins');
        Route::put('/admins',[SuperAdminController::class ,'adminsEdit']);
        Route::get('/admins/delete/{id}',[SuperAdminController::class ,'deleteAdmin'])->name('admins.delete');
        Route::get('/admin/{id}',[SuperAdminController::class ,'adminView'])->name('admin');
        Route::get('/admin',[SuperAdminController::class ,'addAdmin'])->name('admin');
        Route::post('/admin',[SuperAdminController::class ,'createAdmin']);

        Route::get('/schools_view',[SuperAdminController::class ,'schoolsView'])->name('schools_view');
        Route::get('/school_add',[SuperAdminController::class ,'addSchool'])->name('school_add');
        Route::post('/schools_create',[SuperAdminController::class ,'createSchool'])->name('schools_create');
        Route::get('/school/{id}',[SuperAdminController::class ,'singleSchool'])->name('school');
        Route::put('/schools',[SuperAdminController::class ,'updateSchool'])->name('schools');
        Route::get('/schools/delete/{id}',[SuperAdminController::class ,'deleteSchool'])->name('schools.delete');

        Route::get('/inquiries',[SuperAdminController::class ,'inquiries'])->name('inquiries');
        Route::get('/respond/{id}',[SuperAdminController::class ,'inquiriesEdit'])->name('respond');
        Route::post('/inquiries',[SuperAdminController::class ,'inquiriesCreate'])->name('inquiries');

        Route::get('/posts',[SuperAdminController::class ,'posts'])->name('posts');
        Route::get('/approve_post/{id}',[SuperAdminController::class ,'approvePost'])->name('approve_post');

        Route::get('/clubs',[SuperAdminController::class ,'clubs'])->name('clubs');
        Route::get('/approve_club/{id}',[SuperAdminController::class ,'approveClub'])->name('approve_club');

        Route::get('/logout',[LoginController::class,'superAdminLogout'])->name('logout');
    });

});

Route::prefix('business_owner')->name('business_owner.')->group(function(){
       
    Route::middleware(['guest:web','guest:business_owner'])->group(function(){
        Route::view('/login','business_owner.auth.login')->name('login');
        Route::post('/login',[LoginController::class ,'businessOwnerLogin']);

        Route::get('/register/step-1',[RegisterController::class ,'bo_request_otp_view'])->name('register.step-1'); 
        Route::post('/register/step-1',[RegisterController::class ,'bo_request_otp']);
        Route::get('/register/step-2',[RegisterController::class ,'bo_verify_otp_view'])->name('register.step-2');
        Route::post('/register/step-2',[RegisterController::class ,'bo_verify_otp']);
        Route::get('/register',[RegisterController::class ,'boRegisterView'])->name('register');
        Route::post('/register',[RegisterController::class ,'boRegister']);

        Route::get('/password/email',[ForgotPasswordController::class ,'bo_request_otp_view'])->name('password.email');
        Route::post('/password/email',[ForgotPasswordController::class ,'bo_request_otp']);
        Route::get('/password/verify',[ForgotPasswordController::class ,'bo_verify_otp_view'])->name('password.verify');
        Route::post('/password/verify',[ForgotPasswordController::class ,'bo_verify_otp']);
        Route::get('/password/reset',[ResetPasswordController::class ,'boResetPasswordView'])->name('password.reset');
        Route::post('/password/reset',[ResetPasswordController::class ,'boReset']);
    });


    Route::middleware(['auth:business_owner'])->group(function(){
        Route::view('/dashboard','business_owner.business_owner.settings')->name('dashboard');

        Route::view('/settings','business_owner.business_owner.settings')->name('settings');
        Route::post('/settings/profile',[BusinessOwnerController::class ,'updateProfile'])->name('settings.profile');
        Route::post('/settings/password',[BusinessOwnerController::class ,'updatePassword'])->name('settings.password');

        Route::get('/students',[BusinessOwnerController::class ,'studentsView'])->name('students');
        Route::get('/student/{id}',[BusinessOwnerController::class ,'studentView'])->name('student');

        Route::get('/business',[BusinessOwnerController::class ,'businessView'])->name('business');
        Route::get('/product_view/{id}',[BusinessOwnerController::class ,'productView'])->name('product_view');
        Route::get('/product_delete/{id}',[BusinessOwnerController::class ,'productDelete'])->name('product_delete');
        Route::get('/product_advertise/{id}',[BusinessOwnerController::class ,'productAdvertise'])->name('product_advertise');
        Route::post('/product',[BusinessOwnerController::class ,'addProduct'])->name('product');
        Route::post('/business',[BusinessOwnerController::class ,'updateBusiness'])->name('business');
        Route::post('/product_edit',[BusinessOwnerController::class ,'productEdit'])->name('product_edit');

        Route::get('/students',[BusinessOwnerController::class ,'students'])->name('students');
        Route::get('/student/{id}',[BusinessOwnerController::class ,'student'])->name('student');

        Route::post('/message',[BusinessOwnerController::class ,'message'])->name('message');
        
        Route::get('/logout',[LoginController::class,'businessOwnerLogout'])->name('logout');

    });

});
