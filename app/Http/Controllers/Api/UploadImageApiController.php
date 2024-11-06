<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UploadImageApiController extends Controller
{
    // Upload image
    public function uploadImage(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'description' => 'nullable|string', // Add description as optional
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = $errors->has('image') ? 'Image validation failed: ' . $errors->first('image') : 'Validation failed';
            return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], 400);
        }

        try {
            // Create a new ImageMedia record
            $imageMedia = new ImageMedia();
            $imageMedia->user_id = Auth::id();  // Automatically set the user_id of the authenticated user
            $imageMedia->description = $request->description; // Set the description if provided
            uploadYourImage($request, $imageMedia, 'image');
            // $imageMedia->status = 'on_review';
            $imageMedia->save();

            return response()->json(['success' => true, 'message' => 'Image uploaded successfully', 'data' => $imageMedia], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Image upload failed', 'error' => $e->getMessage()], 500);
        }
    }
}
