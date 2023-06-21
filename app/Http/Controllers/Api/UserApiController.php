<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    //register user
    public function registerUser(Request $request)
    {
        try {
            $data = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required'
            ]);
            if ($data->fails()) {
                return response()->json(['message' => $data->messages()], 400);
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->save();
            }
            return response()->json(['message' => 'Registration Successful', 'success' => true], 201);
        } catch (Exception $e) {
            print($e);
        }
    }

    //login user
    public function loginUser(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password']);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(['success' => true, 'token' => $token, 'user' => $user], 200);
    }

    //logout user

    //change password
    public function changePassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($data->fails()) {
            return response()->json(['success' => false, 'message' => $data->messages()], 400);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid current password'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully'], 200);
    }
}
