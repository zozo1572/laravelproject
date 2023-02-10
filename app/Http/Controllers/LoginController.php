<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Expert;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //return all users
    public function index()
    {
         return Expert::all();
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
                  $expert = Expert::create([ 'name' => $request->name,
                  'email' => $request->email,
                  'password' => Hash::make($request->password) ]);
                   $token = $expert->createToken('auth')->plainTextToken->first();

                   if (!$expert || !Hash::check($request->password, $expert->password)) {
                       throw ValidationException::withMessages([
                           'email' => ['The provided credentials are incorrect.'],
                       ]);
                   }

                    return [ 'message' => 'Sucsess Register ', 'expert' => $expert, 'token' => $token ];
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
                                 $expert = $request->expert();
                                 $token = $expert->createToken('auth')->plainTextToken;
                                 $expert = Expert::where('email', $request->email)->first();
                                  if (!$expert || !Hash::check($request->password, $expert->password)) {
                                    throw ValidationException::withMessages([
                                        'email' => ['The provided credentials are incorrect.'],
                                    ]);}
                                  $response = [ 'expert' => $expert, 'token' => $token ];


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
