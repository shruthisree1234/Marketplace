<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\StudentController;

class StudentSettingsController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $this->validate($request,[
            "sir_name" => 'required|string',
            "other_names" => 'required|string',
            "phone_number" => 'required|numeric',
            "email" => 'required|email',
            'profile_photo' => ['mimes:jpeg,gif,bmp,png', 'max:2048'],
        ]);

        if ($request->file('profile_photo') != null) {
            $profile_photo = $request->file('profile_photo');
            //$profile_photo = $profile_photo->getPathName();

            //get the original file name and replace any spaces with _
            $profile_photo_name = time()."_".  preg_replace('/\s+/', '_', strtolower($profile_photo->getClientOriginalName()));

            //move image to the temporary storage
            $profile_photo->move(public_path('portal/images/profiles'), $profile_photo_name);

            $user->update([
                "profile_picture" => $profile_photo_name,
            ]);
        }
    
        $user =  $user->update([
            "email" => $request->email,
            "sir_name" => $request->sir_name,
            "phone_number" => $request->phone_number,
            "other_names" => $request->other_names,
        ]);
        
        return redirect()->route('student.settings')->with('success','Succesfully updated your profile information.');
        

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

            $request->user()->update([
                "password" => bcrypt($request->password) 
            ]);

            return redirect()->route('student.settings')->with('success','Password changed successfully');

    }
}
