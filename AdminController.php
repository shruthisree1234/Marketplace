<?php

namespace App\Http\Controllers\Admin;

use App\Models\Club;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use App\Models\School;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    { 
        return view('admin.admin.dashboard', [
            'users' => User::orderByDesc('id')->get(),
            'admins' => Admin::orderByDesc('id')->get(),
            'super_admins' => SuperAdmin::orderByDesc('id')->get(),
            'business_owners' => BusinessOwner::orderByDesc('id')->get(),
            'schools' => School::orderByDesc('id')->get()
        ]);
    }

    public function settingsView()
    {   
        return view('admin.admin.settings');
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

            auth()->user('admin')->update([
                "password" => bcrypt($request->password) 
            ]);

            return redirect()->route('admin.settings')->with('success','Password changed successfully');

    }

    public function studentsView()
    {   
        return view('admin.admin.students',[
            'users' => User::orderByDesc('id')->get(),
        ]);
    }

    public function studentView($id)
    {   
        return view('admin.admin.student',[
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
        return view('admin.admin.business_owners',[
            'users' => BusinessOwner::orderByDesc('id')->get(),
        ]);
    }

    public function businessOwnerView($id)
    {   
        return view('admin.admin.business_owner',[
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

    public function posts()
    {
        return view('admin.admin.posts',[
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
        return view('admin.admin.clubs',[
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
