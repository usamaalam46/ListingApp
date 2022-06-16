<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;
use Illuminate\Support\Facades\Validator;
class TranslationController extends Controller
{
    //
    public $successStatus = 200;
    public $errorStatus = 404;
    public function index()
    {
        $translations = Translation::all();
        return view('admin.translation.index', compact('translations'));
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
            'translation_group' => 'required', 'string', 'max:255',
            'translation_key' => 'required', 'string', 'max:255',
            'translation_english' => 'required', 'string',
            'translation_arabic' => 'required', 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['failed' => $validator->errors()]);
        }
        $translation = new Translation();
        $translation->translation_group=$request->translation_group;
        $translation->translation_key = $request->translation_key;
        $translation->translation_english = $request->translation_english;
        $translation->translation_arabic = $request->translation_arabic;
        $translation->save();
        //Session::flash('alert-success', 'Translation created successfully');
        return redirect('/admin/translations');
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
        $category = Translation::find($id);
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

        $validator = Validator::make($request->all(), [
            'translation_group' => 'required', 'string', 'max:255',
            'translation_key' => 'required', 'string', 'max:255',
            'translation_english' => 'required', 'string',
            'translation_arabic' => 'required', 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['failed' => $validator->errors()]);
        }
        $translation = Translation::find($request->id);
        
        $translation->save();
        $translation->translation_group=$request->translation_group;
        $translation->translation_key = $request->key;
        $translation->translation_english = $request->translation_english;
        $translation->translation_arabic = $request->translation_arabic;
        $translation->save();
        //Session::flash('alert-success', 'Translation Updated successfully');
        return redirect('/admin/translations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $translation = Translation::findOrFail($request->id);
        $translation->delete();
        //Session::flash('alert-success', 'Translation deleted successfully');
        return redirect('/admin/translations');
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
    public function filterTranslation(Request $request){
        
            if($request->translation_key == 'en' || 'english'){
                $translation=Translation::select('translation_group','translation_english')->get();
                if($translation){
                return response()->json(["sataus" => "success","english translation" => $translation],$this->successStatus);
            }
            else{
                $translation=Translation::select('translation_group','translation_arabic')->get();
                return response()->json(["sataus" => "success","english translation" => $translation],$this->successStatus);
            }
            }
            
            return response()->json(["sataus" => "success",'message'=>'translation not found'],$this->successStatus);
            }
        
}

