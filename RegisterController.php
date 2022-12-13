<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use App\Models\BoVerificationCode;
use App\Http\Controllers\Controller;
use App\Models\UserVerificationCode;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'student/dashboard';
    protected $boRedirectTo = 'business_owner/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function request_otp_view()
    {
        return view('students.auth.registration.step-1');
    }

    public function bo_request_otp_view()
    {
        return view('business_owner.auth.registration.step-1');
    }

    public function verify_otp_view()
    {
        if (!session('email')) {
            return redirect('student/register/step-1');
        }
        return view('students.auth.registration.step-2');
    }

    public function bo_verify_otp_view()
    {
        if (!session('email')) {
            return redirect('business_owner/register/step-1');
        }
        return view('business_owner.auth.registration.step-2');
    }

    public function request_otp(Request $request)
    {
        //validate the email
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

        $code = $this->generateRandomString();

        //create email for otp
        $email = UserVerificationCode::create([
            'email' => $request->email,
            'verification_code' => $code,
            'verification_code_expires_at' => Carbon::now()->addMinutes(30)->timestamp,
        ]);

        $this->sendMail($email);

        return redirect('student/register/step-2')->with(['email' => $email, 'code' => $code]);

    }

    public function bo_request_otp(Request $request)
    {
        //validate the email
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:business_owners'],
            ]);

        $code = $this->generateRandomString();
        //create email for otp
        $email = BoVerificationCode::create([
            'email' => $request->email,
            'verification_code' => $code,
            'verification_code_expires_at' => Carbon::now()->addMinutes(30)->timestamp,
        ]);

        $this->BOsendMail($email);

        return redirect('business_owner/register/step-2')->with(['email' => $email, 'code' => $code]);

    }

    private function sendMail(UserVerificationCode $email)
    {
        $verification_data = [
            'body' => "Your Email verification code is ". $email->verification_code ,
            'text' => $email->verification_code,
            'url' => url('/'),
            'thankyou' => "You have 30 minutes to verify after which the code will expire"
        ];

        $email->notify(new EmailVerification($verification_data));
    }
    private function BOsendMail(BoVerificationCode $email)
    {
        $verification_data = [
            'body' => "Your Email verification code is ". $email->verification_code ,
            'text' => $email->verification_code,
            'url' => url('/'),
            'thankyou' => "You have 30 minutes to verify after which the code will expire"
        ];

        $email->notify(new EmailVerification($verification_data));
    }

    protected  function generateRandomString() {
        $numbers = substr(str_shuffle('0123456789'), 0, 3);
        $uc_letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
        $lc_letters = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3);
        return substr(str_shuffle($numbers."".$uc_letters."".$lc_letters), 0, 8);
    }

    public function verify_otp(Request $request)
    {
        //validate the email
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

        $email = UserVerificationCode::where('email' ,$request->email)->latest()->first();

    

        if (Carbon::now()->gt($email->verification_code_expires_at)) {
            return redirect()->route('student.register.step-2')->with('fail','Verification Code expired');
        }
      
        if ($request->verification_code !== $email->verification_code) {
            return redirect()->route('student.register.step-2')->with(['fail' =>'Incorrect Code', 'email' => $email]);
        }

        return redirect()->route('student.register')->with('email', $email->email);
    }

    public function bo_verify_otp(Request $request)
    {
       
        //validate the email
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:business_owners'],
         ]);
            

        $email = BoVerificationCode::where('email' ,$request->email)->latest()->first();

            

        if (Carbon::now()->gt($email->verification_code_expires_at)) {
            return redirect()->route('business_owner.register.step-2')->with('fail','Verification Code expired');
        }
      
        if ($request->verification_code !== $email->verification_code) {
            return redirect()->route('business_owner.register.step-2')->with(['fail' =>'Incorrect Code', 'email' => $email]);
        }

        return redirect()->route('business_owner.register')->with('email', $email->email);
    }

    public function registerView()
    {
        if (!session('email')) {
            return redirect('student/register/step-1');
        }
        return view('students.auth.register');
    }

    public function boRegisterView()
    {
        if (!session('email')) {
            return redirect('business_owner/register/step-1');
        }
        return view('business_owner.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'sir_name' => ['required', 'string', 'max:255'],
            'other_names' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'admission_number' => ['required', 'string', 'max:255', 'unique:users'],
            'gender' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:2006-01-01'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'dob.before' => 'Give us your correct date of birth!',
            'type.required' => 'You have to choose type of the file!'
        ]);
        

        if ($validator->fails()) {
            $arr = Arr::flatten($data);
          
            session(['email' => $arr[1]]);
        }

        

        return $validator;
    }

    protected function boValidator(array $data)
    {
        $validator = Validator::make($data, [
            'sir_name' => ['required', 'string', 'max:255'],
            'other_names' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', 'unique:business_owners'],
            'name' => ['required', 'string', 'max:255', 'unique:businesses'],
            'gender' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:2006-01-01'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:business_owners'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'dob.before' => 'Give us your correct date of birth!',
            'type.required' => 'You have to choose type of the file!'
        ]);
        

        if ($validator->fails()) {
            $arr = Arr::flatten($data);
          
            session(['email' => $arr[1]]);
        }

        

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        UserVerificationCode::where('email' ,$data['email'])->delete();
        session()->forget('email');
        Session::flush();
        return User::create([
            'sir_name' => $data['sir_name'],
            'other_names' => $data['other_names'],
            'phone_number' => $data['phone_number'],
            'admission_number' => $data['admission_number'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function boCreate(array $data)
    {
        BoVerificationCode::where('email' ,$data['email'])->delete();
        session()->forget('email');
        Session::flush();
        $bo =  BusinessOwner::create([
            'sir_name' => $data['sir_name'],
            'other_names' => $data['other_names'],
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $bo->business()->create([
            'name' => $data['name']
        ]);

        return $bo;
    }
}
