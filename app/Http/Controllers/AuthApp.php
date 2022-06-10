<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class AuthApp extends Controller
{
    //1. Authentication App (task1_1 - task1_3)
    public function task1_1(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'nik'      => 'required|string|digits:16|unique:users',    //Validation nik must 16 char
            'role'     => 'required|max:1',
            'password' => 'required|string|digits:6',
        ],
        [
            'digits'    => ':attribute harus :digits karakter',         //return message in nik invalid
            'required'  => ':attribute harus diisi',
            'unique'    => ':attribute ini sudah ada, gunakan :attribute lain'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->nik = $request->nik;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(compact('user'),201);
    }

    public function task1_2(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nik'      => 'required|string|digits:16',    //Validation nik must 16 char
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $body = $request->only('nik', 'password');
        try {
            if (! $token = JWTAuth::attempt($body)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //token save in api_token database. 
        //Will be called back later
        $updatetoken = DB::table('users')->where('nik', $request->nik)->update(['api_token' => $token]); 
        $results     = DB::select('select role,nik,password from users where nik = ?', array( $request->nik));
        
        return response()->json(compact('results','token'));
    }

    public function task1_3(Request $request)
    {   
        try {
    
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
    
}