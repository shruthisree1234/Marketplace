<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function services(Type $var = null)
    {
        return view('services',[
            'products' => Product::orderByDesc('id')->get()
        ]);
    }

    public function blog(Type $var = null)
    {
        return view('blog',[
            'posts' => Post::orderByDesc('id')->get()
        ]);
    }
}
