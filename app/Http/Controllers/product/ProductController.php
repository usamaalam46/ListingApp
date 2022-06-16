<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Helper\Slug;
use Illuminate\Support\Facades\Validator;
use Auth;

class ProductController extends Controller
{


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
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required', 'string', 'max:255',
            'title_arabic' => 'required', 'string', 'max:255',
            'description' => 'required', 'string',
            'description_arabic' => 'required', 'string',
            'is_featured' => 'required', 'string',
            'price' => 'int', 'required',
            'active' => 'required', 'string',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['failed' => $validator->errors()]);
        }

        $path = storage_path();
        $product = new Product();
        $product->sku = $request->sku;
        $product->slug = $this->slug->createSlug('product', $request->title);
        $product->title = $request->title;
        $product->title_arabic = $request->title_arabic;
        $product->description = $request->description;
        $product->description_arabic = $request->description_arabic;
        // dd($request->image);

        if ($request->hasFile('picture')) {
            //upload new file
            $extension = $request->picture->extension();
            $filename = time() . "_." . $extension;
            $request->picture->move(storage_path('/app/public/products'), $filename);
            $product->image = $filename;
        }
        $product->price = $request->price;
        if (isset($is_discounted)) {
            $product->is_discounted = $request->is_discounted;
            $product->discounted_price = $request->discounted_price;
        }
        isset($request->is_featured) ? $product->is_featured = $request->is_featured : false;
        isset($request->active) ? $product->active = $request->active : false;
        $product->search_counter = 0;
        $product->save();
        //Session::flash('alert-success', 'Product created successfully');
        return redirect('/admin/products');
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
        $category = Product::find($id);
        return view('admin.categories.edit', compact('category'));
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
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required', 'string', 'max:255',
            'title_arabic' => 'required', 'string', 'max:255',
            'description' => 'required', 'string',
            'description_arabic' => 'required', 'string',
            'is_featured' => 'required', 'string',
            'price' => 'int', 'required',
            'active' => 'required', 'string',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['failed' => $validator->errors()]);
        }
        $product = Product::find($request->id);
        //dd($product);
        $product->sku = $request->sku;
        $product->slug = $this->slug->createSlug('product', $request->title);
        $product->title = $request->title;
        $product->title_arabic = $request->title_arabic;
        $product->description = $request->description;
        $product->description_arabic = $request->description_arabic;
        if ($request->hasFile('picture')) {

            //code for remove old file
            //return $data['image'];
            if ($product->image != null) {
                $url_path = parse_url($product->image, PHP_URL_PATH);
                $basename = pathinfo($url_path, PATHINFO_BASENAME);
                $file_old =  storage_path("/app/public/products/$basename");
                unlink($file_old);
            }
            //upload new file
            $extension = $request->picture->extension();
            $filename = time() . "_." . $extension;
            $request->picture->move(storage_path('app/public/products'), $filename);
            $product->image = $filename;
        }
        $product->price = $request->price;
        if (isset($is_discounted)) {
            $product->is_discounted = $request->is_discounted;
            $product->discounted_price = $request->discounted_price;
        }
        isset($request->is_featured) ? $product->is_featured = $request->is_featured : false;
        isset($request->active) ? $product->active = $request->active : false;
        $product->save();
        //Session::flash('alert-success', 'Product created successfully');
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Product::findOrFail($request->id);
        $category->delete();
        //Session::flash('alert-success', 'Prouct deleted successfully');
        return redirect('/admin/categories');
    }

    public function randstr($len = 5, $abc = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ")
    {
        $letters = str_split($abc);
        $str = "";
        for ($i = 0; $i <= $len; $i++) {
            $str .= $letters[rand(0, count($letters) - 1)];
        };
        return $str;
    }
    public function list(){
        if(Auth::check()){
            $user=Auth::User();
            if($user->role=='user'){
                $products=Product::orderBy('created_at','Desc')->paginate(10);
                if($products->isNotEmpty()){
                return response()->json(["sataus" => "success","products" => $products],$this->successStatus);
            }
            return response()->json(["sataus" => "success",'message'=>'product not found'],$this->successStatus);
            }
        }
    }
    public function search(Request $request){
       
        if(Auth::check()){
            $user=Auth::User();
            if($user->role=='user'){
                $products=isset($request->title) ? Product::where('title',$request->name)->paginate(10):'';
                $products= isset($request->price) ? Product::where('price',$request->price)->paginate(10):'';
                $products= isset($request->order)=='asc' ? Product::orderBy('created_at','asc')->paginate(10):'';
                $products=isset($request->desc)=='desc' ? Product::orderBy('created_at','Desc')->paginate(10): '';
                if($products){
                return response()->json(["sataus" => "success","products" => $products],$this->successStatus);
            }
            return response()->json(["sataus" => "success",'message'=>'product not found'],$this->successStatus);
            }
        }
    }
}
