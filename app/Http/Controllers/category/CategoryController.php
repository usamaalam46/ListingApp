<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helper\Slug;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public $successStatus = 200;
    public $errorStatus = 404;
    public function __construct(Slug $slug)
    {
        $this->slug = $slug;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cateogry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $validator = Validator::make($data, [
        'title' => 'required','string', 'max:255',
        'title_arabic' => 'required', 'string', 'max:255',
        'description' => 'required','string',
        'description_arabic' => 'required','string',
        'is_featured' => 'required','string',
        'show_in_menu' => 'string','required',
        'active'=> 'required','string'
    ]);
    if($validator->fails()){
        return response()->json(['failed' => $validator->errors()]);
    }
        $category = new Category();
        $category->title = $request->title;
        $category->title_arabic = $request->title_arabic;
        $category->description = $request->description;
        $category->description_arabic = $request->description_arabic;
        isset($request->is_featured) ? $category->is_featured=$request->is_featured : false;
        isset($request->show_in_menu) ? $category->show_in_menu=$request->show_in_menu : false;
        $category->slug = $this->slug->createSlug('category', $request->title);
        isset($request->active) ? $category->active=$request->active : false;
        $category->save();
        //Session::flash('alert-success', 'Category created successfully');
        return redirect('/admin/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.cateogry.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data=$request->all();
        $validator = Validator::make($data, [
        'title' => 'required','string', 'max:255',
        'title_arabic' => 'required', 'string', 'max:255',
        'description' => 'required','string',
        'description_arabic' => 'required','string',
        'is_featured' => 'required','string',
        'show_in_menu' => 'string','required',
        'active'=> 'required','string'
    ]);
    if($validator->fails()){
        return response()->json(['failed' => $validator->errors()]);
    }
        $category = Category::find($request->id);
        $category->title = $request->title;
        $category->title_arabic = $request->title_arabic;
        $category->description = $request->description;
        $category->description_arabic = $request->description_arabic;
        isset($request->is_featured) ? $category->is_featured=$request->is_featured : false;
        isset($request->show_in_menu) ? $category->show_in_menu=$request->show_in_menu : false;
        $category->slug = $this->slug->createSlug('category', $request->title);
        isset($request->status) ? $category->status=$request->status : false;
        $category->save();
        //Session::flash('alert-success', 'Category updated successfully');
        return redirect('/admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      
        $category = Category::findOrFail($request->id);
        $category->delete();
        return redirect('/admin/categories');
    }

    public function randstr($len=5, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ")
    {
        $letters = str_split($abc);
        $str = "";
        for ($i=0; $i<=$len; $i++) {
            $str .= $letters[rand(0, count($letters)-1)];
        };
        return $str;
    }
    public function list(){
        if(Auth::check()){
            $user=Auth::User();
            if($user->role=='user'){
                $categories=Category::orderBy('created_at','Desc')->get();
                if($categories->isNotEmpty()){
                return response()->json(["sataus" => "success","categories" => $categories],$this->successStatus);
            }
            return response()->json(["sataus" => "categories not found"],$this->successStatus);
            }
        }
    }
}
