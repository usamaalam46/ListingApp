<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendMailAdmin;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    //
    public $successStatus = 200;
    public $errorStatus = 404;
    public function register(Request $request)
    {


        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'unique:users|required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required_with:password|same:password|min:8',
            'role' => 'required',
            'image' => 'required'
        ]);

        //If any Validation fail
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        //If user has image
        if ($request->hasFile('image')) {
            $extension = $request->image->extension();
            $filename = time() . "_." . $extension;
            $path = $request->image->move(storage_path('/app/public/users'), $filename);
            $input['image'] = $filename;
        }

        //Convert Password into hash
        //dd(isset($request->role));
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $input['password'] = bcrypt($input['password']);
        $user->password = $input['password'];
        $user->role = isset($request->role) ? $input['role'] : 'user';
        $user->image = $input['image'];
        $user->save();
        $api_token = $user->createToken('MyApp')->plainTextToken;

        $userCheck = User::find($user->id);
        if ($userCheck) {
            $userCheck->notify(
                new SendMailAdmin($user)
            );
        }


        if ($userCheck) {

            return response()->json([
                "userdata" => $user,
                "message" => "User Registered Successfully",
                "status" => 'success'
            ], $this->successStatus);
        }
    }

    public function login(Request $request)
    {

        $user_data =  User::where('email', request('email'))->first();

        if (!$user_data) {
            return response()->json(
                [
                    "message" => "User not found by this email",
                    "status" => 'error'
                ],
                $this->errorStatus
            );
        }
        // if($user_data->email_verified_at == null)
        // {       $user_data->update(['stripe_status'=>'false']);
        //          return response()->json([
        //             "message" => "User not verified",
        //             "status" => 'error'
        //         ]
        //         , $this->errorStatus);

        // }


        $data = ['email' => request('email'), 'password' => request('password')];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('App');
            $user->save();
            return response()->json(
                [
                    'userdata' => $user,
                    'token' => $token->plainTextToken,
                    "message" => "User Logged In Successfully",
                    "status" => 'success'
                ],
                $this->successStatus
            );
        } else {
            return response()->json(['message' => 'Invalid Username or Password', 'status' => 'error'], 401);
        }
    }
    public function updateUser(Request $request){
        $user =Auth::user();
        if (!$user) {
            return response()->json(['message' => "User Not found", 'status' => 'error'], $this->errorStatus);
        }
        
        if ($request) {
            $requests = $request->except('password_confirmation');
            $input = $requests;

            if ($request->hasFile('image')) {

                //code for remove old file
               
                if ($user->image != null) {
                    $url_path = parse_url($user->image, PHP_URL_PATH);
                    $basename = pathinfo($url_path, PATHINFO_BASENAME);
                    $file_old =  public_path("assets/images/user/$basename");
                    unlink($file_old);
                }
                //upload new file
                $extension = $request->image->extension();
                $filename = time() . "_." . $extension;
                $request->image->move(public_path('/assets/images/user'), $filename);
                $input['image'] = $filename;
            }
            
            if($request->password != null && $request->password_confirmation != null)
            {
                if($request->password_confirmation == $request->password)
                    $input['password'] = Hash::make($request->password); 
                else
                 return response()->json(['message' => 'Your Password and Confirm are mismatch', 'status' => 'error'], $this->errorStatus);
            }

            //prevent user not update email
                $input['email'] = $user->email;
            //   if ($input['company_name'] != null)
            //   {
            //   $input['name'] = $input['company_name'];
            //   }
                User::where('id', $user->id)->update($input);
                $userdata= User::find($user->id);

            return response()->json(['userdata' => $userdata,'message' => "User Data Updated Successfully", 'status' => 'success'],$this->successStatus);
        } else {
            return response()->json(['error' => "User Data was not Updated ", 'status' => 'error'],$this->errorStatus);
        }
    }
}
