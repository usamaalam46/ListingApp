<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Translation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function userList(){
        $users=User::where('role','user')->orderBy('created_at','Desc')->paginate(10);
        return view('user.index',compact('users'));
    }
    public function dashboard(){
        $product_count=Product::count();
        $user_count =User::count();
        $category_count =Category::count();
        $translation_count=Translation::count();
        return view('layouts.app',compact('product_count','user_count','category_count','translation_count'));
    }
}
