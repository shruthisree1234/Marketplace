<?php

use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Student\StudentController;
use App\Http\Controllers\Api\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Api\Student\StudentSettingsController;
use App\Http\Controllers\Api\BusinessOwner\BusinessOwnerController;


Route::get('/products',[Controller::class ,'products'])->name('products');

/*
    STUDENTS END POINTS MUST BE PREFIXED WITH STUDENT FOR EXAMPLE LOGIN ENDPOINT WILL BE
    http://127.0.0.1:8000/api/student/login
    THE SAME APPLIES TO ADMINS, SUPER ADMINS AND BUSINESS OWNERS
*/
Route::prefix('student')->name('student.')->group(function(){
  
    Route::middleware(['guest:sanctum','guest:admin'])->group(function(){
        //http://127.0.0.1:8000/api/student/register/step-1
        Route::post('/login',[LoginController::class ,'studentLogin']);
        //http://127.0.0.1:8000/api/student/
        Route::post('/register/step-1',[RegisterController::class ,'request_otp']);
        Route::post('/register/step-2',[RegisterController::class ,'verify_otp']);
        Route::post('/register',[RegisterController::class ,'register']);

    });

    Route::middleware(['auth:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/student/cart
        Route::get('/cart',[StudentController::class ,'cart'])->name('cart');
        Route::get('/checkout',[StudentController::class ,'checkout_view'])->name('checkout');
   
        Route::get('/logout',[LoginController::class,'studentLogout'])->name('logout');

        Route::get('/posts',[StudentController::class ,'postsView'])->name('posts');
        Route::get('/single_post/{id}',[StudentController::class ,'postsEdit'])->name('single_post');
        Route::get('/post_delete/{id}',[StudentController::class ,'postDelete'])->name('post_delete');
        Route::post('/post',[StudentController::class ,'addPosts'])->name('post');
        Route::post('/edit_post',[StudentController::class ,'editPost'])->name('edit_post');

        Route::get('/businesses',[StudentController::class ,'businesses'])->name('businesses');

        Route::get('/clubs',[StudentController::class ,'clubs'])->name('clubs');
        Route::post('/club',[StudentController::class ,'addClub'])->name('club');
        Route::get('/club_join/{id}',[StudentController::class ,'joinClub'])->name('club_join');
        
        Route::get('/club_delete/{id}',[StudentController::class ,'clubDelete'])->name('club_delete');

        Route::get('/students',[StudentController::class ,'students'])->name('students');
        Route::get('/student_view/{id}',[StudentController::class ,'studentView'])->name('student_view');

        Route::get('/checkout/{price}',[StudentController::class ,'checkout'])->name('checkout');

        Route::get('/product_cart/{id}',[StudentController::class ,'productCart'])->name('product_cart');
        Route::get('/return/{id}',[StudentController::class ,'return'])->name('return');

        Route::get('/business_owner/{id}',[StudentController::class ,'business_owner'])->name('business_owner');

        Route::post('/message',[StudentController::class ,'message'])->name('message');

        Route::get('/inquiries',[StudentController::class ,'queries'])->name('queries');
        Route::post('/inquire',[StudentController::class ,'inquire'])->name('inquire');
        
    });

});

Route::prefix('admin')->name('admin.')->group(function(){
       
    Route::middleware(['guest:admin', 'guest:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/admin/login
          Route::post('/login',[LoginController::class ,'adminLogin'])->name('check');
    });

    Route::middleware(['auth:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/admin/users
        Route::get('/users',[SuperAdminController::class ,'users'])->name('users');
        Route::get('/schools',[SuperAdminController::class ,'schools'])->name('schools');
        Route::get('/business_owners',[SuperAdminController::class ,'business_owners'])->name('business_owners');
        Route::get('/super_admins',[SuperAdminController::class ,'super_admins'])->name('super_admins');
        Route::get('/admins',[SuperAdminController::class ,'admins'])->name('admins');

        //http://127.0.0.1:8000/api/admin/students
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
       
    Route::middleware(['guest:super_admin', 'guest:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/super_admin/login
          Route::post('/login',[LoginController::class ,'superAdminLogin'])->name('check');
    });

    Route::middleware(['auth:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/super_admin/users
        Route::get('/users',[SuperAdminController::class ,'users'])->name('users');
        Route::get('/schools',[SuperAdminController::class ,'schools'])->name('schools');
        Route::get('/business_owners',[SuperAdminController::class ,'business_owners'])->name('business_owners');
        Route::get('/super_admins',[SuperAdminController::class ,'super_admins'])->name('super_admins');
        Route::get('/admins',[SuperAdminController::class ,'admins'])->name('admins');

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
        //http://127.0.0.1:8000/api/super_admin/logout
        Route::get('/logout',[LoginController::class,'superAdminLogout'])->name('logout');
    });

});

Route::prefix('business_owner')->name('business_owner.')->group(function(){
       
    Route::middleware(['guest:sanctum','guest:business_owner'])->group(function(){
          //http://127.0.0.1:8000/api/business_owner/login
        Route::post('/login',[LoginController::class ,'businessOwnerLogin']);
        //http://127.0.0.1:8000/api/business_owner/register/step-1
        Route::post('/register/step-1',[RegisterController::class ,'bo_request_otp']);
        Route::post('/register/step-2',[RegisterController::class ,'bo_verify_otp']);
        Route::post('/register',[RegisterController::class ,'boRegister']);


    });


    Route::middleware(['auth:sanctum'])->group(function(){
        //http://127.0.0.1:8000/api/business_owner/students
        Route::get('/students',[BusinessOwnerController::class ,'studentsView'])->name('students');
        Route::get('/student/{id}',[BusinessOwnerController::class ,'studentView'])->name('student');
        //http://127.0.0.1:8000/api/business_owner/business
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
        //http://127.0.0.1:8000/api/business_owner/logout
        Route::get('/logout',[LoginController::class,'businessOwnerLogout'])->name('logout');

    });

});
