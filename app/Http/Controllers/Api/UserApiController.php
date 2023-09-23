<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonAddressResource;
use App\Models\CommonAddress;
use App\Models\Otp;
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
                'email' => 'unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required'
            ]);
            if ($data->fails()) {
                return response()->json(['message' => $data->messages()], 400);
            } else {
                // Find the oldest common address
                $oldestCommonAddress = CommonAddress::oldest()->first();

                if (!$oldestCommonAddress) {
                    return response()->json(['message' => 'No common addresses available.'], 400);
                }

                $user = new User();
                $user->name = $request->name;
                // $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = Hash::make($request->password);
                $user->common_address_id = $oldestCommonAddress->id; // Link user to the oldest common address
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
            'phone' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid phone or password']);
        }

        $token = $user->createToken($request->phone)->plainTextToken;
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

    //get common address
    public function getCommonAddresses()
    {
        try {
            $commonaddresses = CommonAddress::all();
            return CommonAddressResource::collection($commonaddresses);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving commonaddresses'], 500);
        }
    }

    // Add a new method for sending OTP to the user's phone number.
    public function sendOtp(Request $request)
    {
        $data = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
        ]);

        if ($data->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid Phone Number!!'], 400);
        }

        // Generate a random OTP code (you can use your own logic for this).
        $otpCode = mt_rand(1000, 9999);

        // Store the OTP code in the OTP table.
        Otp::create([
            'phone' => $request->phone,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(10), // OTP expiration time (adjust as needed).
        ]);

        // Send the OTP code to the user's phone number (you need to implement this).

        return response()->json(['success' => true, 'message' => 'OTP sent successfully'], 200);
    }

    // Add a new method to verify the OTP and change the password.
    public function forgetPassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'otp_code' => 'required',
            'new_password' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json(['success' => false, 'message' => $data->messages()], 400);
        }

        // Verify the OTP code.
        $otp = Otp::where('phone', $request->phone)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP code'], 400);
        }

        // Update the user's password.
        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Delete the used OTP.
        $otp->delete();

        return response()->json(['success' => true, 'message' => 'Password changed successfully'], 200);
    }
}
