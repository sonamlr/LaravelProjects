<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', 
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
    
        // Create the user
        try {
            $user = User::create($input);
            $token = $user->createToken('MyApp')->plainTextToken;
            return response()->json([
                'success' => true,
                'result' => [
                    'token' => $token,
                    'name'  => $user->name,
                ],
                'msg' => 'User created successfully',
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'An error occurred while creating the user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
     public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'msg' => 'Invalid credentials',
            ], 401); 
        }
        $token = $user->createToken('MyApp')->plainTextToken;
        return response()->json([
            'success' => true,
            'result' => [
                'token' => $token,
                'name' => $user->name,
            ],
            'msg' => 'User login successfully',
        ], 200); 
    }
   public function logout(Request $request){
        $user = Auth::User();
        $user->tokens->each(function ($token) {
            $token->delete(); 
        });
        return response()->json([
            'success' => true,
            'msg' => 'User logged out successfully',
        ], 200);
    }
   

}
