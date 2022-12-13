<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Club;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use App\Models\Query;
use App\Models\School;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    { 
        return view('super_admin.super_admin.dashboard', [
            'users' => User::orderByDesc('id')->get(),
            'admins' => Admin::orderByDesc('id')->get(),
            'super_admins' => SuperAdmin::orderByDesc('id')->get(),
            'business_owners' => BusinessOwner::orderByDesc('id')->get(),
            'schools' => School::orderByDesc('id')->get()
        ]);
    }

    public function settingsView()
    {   
        return view('super_admin.super_admin.settings');
    }

    public function updatePassword(Request $request)
    {
        
        //current password
        //new password
        //password confirmation
        
        $this->validate($request,[
            'current_password' => ['required',new MatchOldPassword],
            'password' => [
                'required', 
                'confirmed',
                Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised(),
                 new CheckSamePassword
                 ]
            ]);

            auth()->user()->update([
                "password" => bcrypt($request->password) 
            ]);

            return redirect()->route('super_admin.settings')->with('success','Password changed successfully');

    }

    public function studentsView()
    {   
        return view('super_admin.super_admin.students',[
            'users' => User::orderByDesc('id')->get(),
        ]);
    }

    public function studentView($id)
    {   
        return view('super_admin.super_admin.student',[
            'user' => User::findOrFail($id),
        ]);
    }

    public function studentsEdit(Request $request)
    {   
        $user = User::findOrFail($request->id);

        $this->validate($request,[
            "sir_name" => 'required|string',
            "other_names" => 'required|string',
            "phone_number" => 'required|numeric',
            "email" => 'required|email',
        ]);
    
        $user =  $user->update([
            "email" => $request->email,
            "sir_name" => $request->sir_name,
            "phone_number" => $request->phone_number,
            "other_names" => $request->other_names,
        ]);
        
        return redirect()->back()->withSuccess('Succesfully updated profile information.');
    }

    public function deleteStudent($id)
    {   
        $user = User::findOrFail($id);

        $user->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function businessOwnersView()
    {   
        return view('super_admin.super_admin.business_owners',[
            'users' => BusinessOwner::orderByDesc('id')->get(),
        ]);
    }

    public function businessOwnerView($id)
    {   
        return view('super_admin.super_admin.business_owner',[
            'user' => BusinessOwner::findOrFail($id),
        ]);
    }

    public function businessOwnersEdit(Request $request)
    {   
        $user = BusinessOwner::findOrFail($request->id);

        $this->validate($request,[
            "sir_name" => 'required|string',
            "other_names" => 'required|string',
            "phone_number" => 'required|numeric',
            "email" => 'required|email',
        ]);
    
        $user =  $user->update([
            "email" => $request->email,
            "sir_name" => $request->sir_name,
            "phone_number" => $request->phone_number,
            "other_names" => $request->other_names,
        ]);
        
        return redirect()->back()->withSuccess('Succesfully updated profile information.');
    }

    public function deleteBusinessOwner($id)
    {   
        $user = BusinessOwner::findOrFail($id);

        $user->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function adminsView()
    {   
        return view('super_admin.super_admin.admins',[
            'users' => Admin::orderByDesc('id')->get(),
        ]);
    }

    public function adminView($id)
    {   
        return view('super_admin.super_admin.admin',[
            'user' => Admin::findOrFail($id),
        ]);
    }

    public function adminsEdit(Request $request)
    {   
        $user = Admin::findOrFail($request->id);

        $this->validate($request,[
            "name" => 'required|string',
            "phone_number" => 'required|numeric',
            "email" => 'required|email',
        ]);
    
        $user =  $user->update([
            "email" => $request->email,
            "name" => $request->name,
            "phone_number" => $request->phone_number,
        ]);
        
        return redirect()->back()->withSuccess('Succesfully updated profile information.');
    }

    public function deleteAdmin($id)
    {   
        $user = Admin::findOrFail($id);

        $user->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function addAdmin()
    {
        return view('super_admin.super_admin.add_admin');
    }

    public function createAdmin(Request $request)
    {
        $this->validate($request,[
            "name" => 'required|string',
            "phone_number" => 'required|numeric',
            "email" => 'required|email|unique:admins',
            "password" => 'required|string'
        ]);

        Admin::create([
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return view('super_admin.super_admin.admins',[
            'users' => Admin::orderByDesc('id')->get(),
        ])->withSuccess('Succesfully added');
    }

    public function schoolsView()
    {
        return view('super_admin.super_admin.schools',[
            'schools' => School::orderByDesc('id')->get()
        ]);
    }

    public function singleSchool($id)
    {   
        return view('super_admin.super_admin.school',[
            'school' => School::findOrFail($id),
        ]);
    }

    public function addSchool()
    {
        return view('super_admin.super_admin.add_school');
    }

    public function updateSchool(Request $request)
    {   
        $school = School::findOrFail($request->id);

        $this->validate($request,[
            "name" => 'required|string'
        ]);
    
        $school =  $school->update([
            "name" => $request->name
        ]);
        
        return redirect()->back()->withSuccess('Succesfully updated school.');
    }

    public function deleteSchool($id)
    {   
        $school = School::findOrFail($id);

        $school->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function createSchool(Request $request)
    {
        $this->validate($request,[
            "name" => 'required|string'
        ]);

        School::create([
            "name" => $request->name,
        ]);

        return view('super_admin.super_admin.schools',[
            'schools' => School::orderByDesc('id')->get(),
        ])->withSuccess('Succesfully added');
    }

    public function inquiries()
    {
        {
            return view('super_admin.super_admin.inquiries',[
                'inquiries' => Query::orderByDesc('id')->get()
            ]);
        }
    }

    public function inquiriesEdit($id)
    {
        $inquiry = Query::findOrFail($id);
    
        return view('super_admin.super_admin.respond',[
            'inquiry' => $inquiry
        ]);
    }

    public function inquiriesCreate(Request $request)
    {
        $this->validate($request,[
            "response" => 'required|string',
        ]);

        $id = Query::findOrFail($request->id);

        $id->update([
            "response" => $request->response,
        ]);

        return redirect()->back()->withSuccess('Response sent');
    }

    public function posts()
    {
        return view('super_admin.super_admin.posts',[
            'posts' => Post::orderByDesc('id')->get(),
        ]);
    }

    public function approvePost($id)
    {

        $post = Post::findOrFail($id);

        $post->update([
            'published' => TRUE
        ]);
       
        return redirect()->back()->withSuccess('Succesfully Published');
    }

    public function clubs()
    {
        return view('super_admin.super_admin.clubs',[
            'clubs' => Club::orderByDesc('id')->get(),
        ]);
    }

    public function approveClub($id)
    {

        $post = Club::findOrFail($id);
        

        $post->update([
            'published' => TRUE
        ]);
       
        return redirect()->back()->withSuccess('Succesfully Published');
    }
}
