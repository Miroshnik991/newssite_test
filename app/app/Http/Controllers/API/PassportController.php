<?php

namespace App\Http\Controllers\API;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Validator;
 
class PassportController extends Controller
{ 
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;
            return response()->json(['user' => $user, 'token'=>$token], JsonResponse::HTTP_OK);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], JsonResponse::HTTP_UNAUTHORIZED);
        }
    }
 
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], JsonResponse::HTTP_BAD_REQUEST);            
        }
 
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token =  $user->createToken('MyApp')->accessToken;
 
        return response()->json(['user'=>$user, 'token'=>$token], JsonResponse::HTTP_CREATED);
    }
 
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetails()
    {
        
        $user = Auth::user();
        return response()->json(['user' => $user], JsonResponse::HTTP_OK);
    }
}
