<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'student/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function adminLoginView()
    {
        return view('admin.auth.login');
    }

    public function superAdminLoginView()
    {
        return view('super_admin.auth.login');
    }

    public function businessOwnerLoginView()
    {
        return view('business_owner.auth.login');
    }

    public function loginView()
    {
        return view('students.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('fail','Incorrect credentials');
    }

    public function superAdminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        if (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('super_admin.dashboard');
        }
        return redirect()->route('super_admin.login')->with('fail','Incorrect credentials');
    }

    public function businessOwnerLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        
        if (Auth::guard('business_owner')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('business_owner.dashboard');
        }
        return redirect()->route('business_owner.login')->with('fail','Incorrect credentials');
    }

    public function studentLogin(Request $request)
    {
        $this->validate($request, [
            'admission_number' => 'required',
            'password' => 'required'
        ]);
        
        if (Auth::guard('web')->attempt(['admission_number' => $request->admission_number, 'password' => $request->password])) {
            return redirect()->route('student.dashboard');
        }
        return redirect()->route('student.login')->with('fail','Incorrect credentials');
    }


    function studentLogout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('student/login');
    }

    function adminLogout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('admin/login');
    }

    function superAdminLogout(Request $request){
        Auth::guard('super_admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('super_admin/login');
    }

    function businessOwnerLogout(Request $request){
        Auth::guard('business_owner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('business_owner/login');
    }
}
