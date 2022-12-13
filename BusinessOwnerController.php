<?php

namespace App\Http\Controllers\BusinessOwner;

use App\Models\User;
use App\Models\Chart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BusinessOwner\BusinessOwnerController;

class BusinessOwnerController extends Controller
{
    public function index()
    { 
        return view('business_owner.business_owner.dashboard');
    }

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
                "profile_photo" => $profile_photo_name,
            ]);
        }
    
        $user =  $user->update([
            "email" => $request->email,
            "sir_name" => $request->sir_name,
            "phone_number" => $request->phone_number,
            "other_names" => $request->other_names,
        ]);
        
        return redirect()->route('business_owner.settings')->with('success','Succesfully updated your profile information. Proceed to the Course Information tab and fill the form before applying for bursary');
        

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

    public function businessView()
    { 
        return view('business_owner.business_owner.business',[
            'products' => Product::where('business_id', auth()->user()->business->id)->get()
        ]);
    }

    public function addProduct(Request $request)
    { 
        $this->validate($request,[
            "name" => 'required|string',
            "category" => 'required|string',
            "description" => 'required|string',
            'price' => 'required|numeric',
            'image' => ['required','mimes:jpeg,gif,bmp,png', 'max:2048'],
        ]);

        $image = $request->file('image');
        //$profile_photo = $profile_photo->getPathName();

        //get the original file name and replace any spaces with _
        $image_name = time()."_".  preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move image to the temporary storage
        $image->move(public_path('portal/images/products'), $image_name);

        $product =  auth()->user()->business->products()->create([
            "name" => $request->name,
            "category" => $request->category,
            "description" => $request->description,
            'price' => $request->price,
            "image" => $image_name,
        ]);

        return redirect()->back()->withSuccess('Succesfully added product');
    }

    public function updateBusiness(Request $request)
    { 
        $this->validate($request,[
            "name" => 'required|string',
        ]);

        $product = auth()->user()->business->update([
            "name" => $request->name,
        ]);

        return redirect()->back()->withSuccess('Succesfully updated business');
    }

    public function productDelete($id)
    {   
        $product = Product::findOrFail($id);

        $product->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function productAdvertise($id)
    {   
        $product = Product::findOrFail($id);


        if ($product->advertised == False) {
            $product->update([
                'advertised' => TRUE
            ]);
            return redirect()->back()->withSuccess('Succesfully Advertised');
        }else {
            $product->update([
                'advertised' => False
            ]);
            return redirect()->back()->withSuccess('Advert Removed');
        }

    }

    public function productView($id)
    { 
        $product = Product::findOrFail($id);
        return view('business_owner.business_owner.product',[
            'product' => $product
        ]);
    }

    public function productEdit(Request $request)
    {   
            $this->validate($request,[
                "name" => 'required|string',
                "category" => 'required|string',
                "description" => 'required|string',
                'image' => ['mimes:jpeg,gif,bmp,png', 'max:2048'],
            ]);
    
            $product = Product::findOrFail($request->id);
    
            if ($request->file('image') != null) {
                $image = $request->file('image');
                //$profile_photo = $profile_photo->getPathName();
    
                //get the original file name and replace any spaces with _
                $image_name = time()."_".  preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
    
                //move image to the temporary storage
                $image->move(public_path('portal/images/products'), $image_name);
    
                $product->update([
                    "image" => $image_name,
                ]);
            }
        
            $product =  $product->update([
                "name" => $request->name,
                "category" => $request->category,
                "description" => $request->description,
            ]);

            return redirect()->back()->withSuccess('Succesfully Updated');

    }

    public function students()
    {
        return view('business_owner.business_owner.students',[
            'students' => User::orderByDesc('id')->get()
        ]);
    }

    public function student($id)
    {
        $ct = Chart::where('receiver_bs_id', auth()->id());
        $ct->update([
            'read' => TRUE
        ]);

        return view('business_owner.business_owner.student',[
            'user' => User::findOrFail($id),
            'charts' => Chart::where('business_owner_id', auth()->id())->orWhere('receiver_bs_id', auth()->id())->get()
        ]);
    }

    public function message(Request $request)
    {
       
        $this->validate($request,[
            "message" => 'required|string',
        ]);

        auth()->user()->charts()->create([
            "message" => $request->message,
            "receiver_id" => $request->id,
        ]);

        return redirect()->back()->withSuccess('Message sent');
    }

}
