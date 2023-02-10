<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Session;

class UserLoginController extends Controller
{
    public function index()
    {
         return User::all();
        }
         public function register(Request $request)
         {
             $validetor = Validator::make($request->all(),[
                'email' => 'required|email|unique:users,email',
                'name' => 'required|string|max:255',
                'password' => 'required|string|max:255']);
               if ($validetor->fails())
               {
                 abort(403);
                  return $validetor->errors()->all();
                 //$this->formatValidationErrors($validetor);
                 }
                  $user = User::create([ 'name' => $request->name,
                  'email' => $request->email,
                  'password' => Hash::make($request->password) ]);
                   $token = $user->createToken('auth')->plainTextToken;




                   if (!$user || !Hash::check($request->password, $user->password)) {
                    throw ValidationException::withMessages([
                        'email' => ['The provided credentials are incorrect.'],
                    ]);
                }




                    return [ 'message' => 'Sucsess Register ', 'user' => $user, 'token' => $token ];
                 }
                  // Login user
                   public function login(Request $request) {
                     $validetor = Validator::make($request->all(), [
                         'name' => 'required|string|max:255',
                          'password' => 'required|string|max:255' ]);
                          if ($validetor->fails())
                          {
                             abort(403); return $validetor->errors()->all();
                              // $this->formatValidationErrors($validetor);
                             }
                              if (Auth::attempt($request->all())) {
                                //he is a real user
                                 $user = $request->user();
                                 $token = $user->createToken('auth')->plainTextToken;
                                 if (!$user || !Hash::check($request->password, $user->password)) {
                                    throw ValidationException::withMessages([
                                        'email' => ['The provided credentials are incorrect.'],
                                    ]);
                                }
                                  $response = [ 'user' => $user, 'token' => $token ];



                                   return $response;
                                }
                            }



                            public function perform()
                                 {
                             Session::flush();

                               Auth::logout();

                               return response()->json([
                                'message'=>'you just logout'
                               ]);
                                        }
}
