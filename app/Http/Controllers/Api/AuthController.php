<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:customer,Email',
            'phone' => 'required|string|max:11',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $customer = Customer::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Phone' => $request->phone,
            'Password' => Hash::make($request->password)
        ]);

       
        $token = $customer->createToken('auth_token')->plainTextToken;

      
        return response()->json([
            'data' => $customer,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $customer = Customer::where('Email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->Password)) {
            return response()->json(['message' => 'Invalid credentials']);
        }
      
        $token = $customer->createToken('auth_token')->plainTextToken;
     
        return response()->json([
            'data' => $customer,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}
