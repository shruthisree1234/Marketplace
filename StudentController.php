<?php

namespace App\Http\Controllers\Student;

use App\Models\Cart;
use App\Models\Club;
use App\Models\Post;
use App\Models\User;
use App\Models\Chart;
use App\Models\Query;
use App\Models\Product;
use App\Models\Business;
use App\Models\CheckOut;
use App\Models\ClubUser;
use Illuminate\Http\Request;
use App\Models\BusinessOwner;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    
    public function dashboard()
    { 
        return view('students.students.dashboard',[
            'products' => Product::orderByDesc('id')->get(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
            
        ]);
    }

    public function checkout_view()
    { 
        return view('students.students.checkout',[
            'products' => Product::orderByDesc('id')->get(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
            'businesses' => Business::all(),
            
        ]);
    }

    public function settings()
    { 
        return view('students.students.settings',[
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }
    public function postsView()
    { 
        return view('students.students.posts',[
            'posts' => Post::where('user_id', auth()->user()->id)->get(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }


    public function addPosts(Request $request)
    { 
        $this->validate($request,[
            "title" => 'required|string',
            "description" => 'required|string',
            'image' => ['required','mimes:jpeg,gif,bmp,png', 'max:2048'],
        ]);

        $image = $request->file('image');
        //$profile_photo = $profile_photo->getPathName();

        //get the original file name and replace any spaces with _
        $image_name = time()."_".  preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move image to the temporary storage
        $image->move(public_path('portal/images/posts'), $image_name);

        $product =  auth()->user()->posts()->create([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $image_name,
        ]);

        return redirect()->back()->withSuccess('Succesfully added product');
    }

    public function editPost(Request $request)
    { 
        $this->validate($request,[
            "title" => 'required|string',
            "description" => 'required|string',
            'image' => ['required','mimes:jpeg,gif,bmp,png', 'max:2048'],
        ]);

        $image = $request->file('image');
        //$profile_photo = $profile_photo->getPathName();

        //get the original file name and replace any spaces with _
        $image_name = time()."_".  preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move image to the temporary storage
        $image->move(public_path('portal/images/posts'), $image_name);

        $post = Post::findOrFail($request->id);

        $post->update([
            "title" => $request->title,
            "description" => $request->description,
            "image" => $image_name,
        ]);

        return redirect()->back()->withSuccess('Succesfully added product');
    }

    public function postDelete($id)
    {   
        $post = Post::findOrFail($id);

        $post->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function createPost()
    {
        return view('students.students.create_post',[
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    public function postsEdit($id)
    {
        return view('students.students.edit_post',[
            'post' => Post::findOrFail($id),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    public function businesses()
    {
        return view('students.students.businesses',[
            'businesses' => Business::all(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    public function clubs()
    {
        return view('students.students.clubs',[
            'clubs' => Club::all(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    public function addClub(Request $request)
    { 
        $this->validate($request,[
            "name" => 'required|string',
        ]);

        $product =  auth()->user()->clubs()->create([
            "name" => $request->name,
        ]);

        ClubUser::create([
            'user_id' => auth()->id(),
            'club_id' => $product->create([])
        ]);

        return redirect()->back()->withSuccess('Succesfully added club');
    }

    public function clubDelete($id)
    {   
        $post = Club::findOrFail($id);

        $post->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function joinClub(Request $request, $id)
    {
        $club = ClubUser::where('user_id', auth()->id())->where('club_id', $id)->get();
    
        

        if ($club->count() > 0) {
            ClubUser::where('user_id', auth()->id())->where('club_id', $id)->delete();
            return redirect()->back()->withSuccess('Successfully left the club');
        }else {
            ClubUser::create([
                'user_id' => auth()->id(),
                'club_id' => $id
            ]);
            return redirect()->back()->withSuccess('Successfully joined the club');
        }

    }

    public function students()
    {
        return view('students.students.students',[
            'students' => User::all(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    

    public function studentView($id)
    {
        return view('students.students.student_view',[
            'student' => User::findOrFail($id),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
        ]);
    }

    public function productCart(Request $request, $id)
    {
        $club = Cart::where('user_id', auth()->id())->where('product_id', $id)->where('bought', FALSE)->get();
    
        

        if ($club->count() > 0) {
            Cart::where('user_id', auth()->id())->where('product_id', $id)->delete();
            return redirect()->back()->withSuccess('Successfully left the club');
        }else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $id
            ]);
            return redirect()->back()->withSuccess('Added to cart');
        }

    }


    public function checkout($price)
    {
        $checkout = CheckOut::create([
            'price' => $price
        ]);

        $club = Cart::where('user_id', auth()->id())->where('bought', FALSE)->update([
            'check_out_id' => $checkout->id,
            'bought' => True
        ]);
    
        

        if ($club) {
            return redirect()->back()->withSuccess('Successfully purchased');
        }

    }

    public function return($id)
    {   
        $post = CheckOut::findOrFail($id);

        $post->delete();
       
        return redirect()->back()->withSuccess('Succesfully deleted.');
    }

    public function business_owner($id)
    {
        $ct = Chart::where('receiver_id', auth()->id());
        $ct->update([
            'read' => TRUE
        ]);
        return view('students.students.business',[
            'user' => BusinessOwner::findOrFail($id),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
            'charts' => Chart::where('user_id', auth()->id())->orWhere('receiver_id', auth()->id())->get()
        ]);
    }

    public function message(Request $request)
    {
       
        $this->validate($request,[
            "message" => 'required|string',
        ]);

        auth()->user()->charts()->create([
            "message" => $request->message,
            "receiver_bs_id" => $request->id,
        ]);

        return redirect()->back()->withSuccess('Message sent');
    }

    public function queries()
    { 
        return view('students.students.queries',[
            'inquiries' => Query::orderByDesc('id')->get(),
            'carts' => Cart::orderByDesc('id')->get(),
            'checkout' => Checkout::orderByDesc('id')->get(),
            
        ]);
    }

    public function inquire(Request $request)
    {
       
        $this->validate($request,[
            "message" => 'required|string',
        ]);

        auth()->user()->inquiries()->create([
            "message" => $request->message,
        ]);

        return redirect()->back()->withSuccess('Message sent');
    }
}
