<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ImageMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imagemedias = ImageMedia::all();
        return view('admin.uploadimage.index', compact('imagemedias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.uploadimage.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required', // Add validation rules for coordinate field
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ], [
            'image.required' => 'The image field is required.', // Custom error message for image field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, gif image.',
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $imagemedia = new ImageMedia();
            $imagemedia->user_id = $request->user_id;
            $imagemedia->status = $request->status;
            $imagemedia->description = $request->description;

            //House Image Upload Code
            uploadYourImage($request, $imagemedia, 'image');

            $imagemedia->save();
            Session::flash('success', 'Upload details added successfully!'); // Add success message to flash session
            return redirect()->route('imagemedia.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            // return redirect()->back()->with($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $imagemedia = ImageMedia::find($id);
        $users = User::all();
        return view('admin.uploadimage.view', compact('imagemedia', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $imagemedia = ImageMedia::find($id);
        $users = User::all();
        return view('admin.uploadimage.edit', compact('imagemedia', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required', // Add validation rules for coordinate field
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field

        ], [
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $imagemedia = ImageMedia::find($id);
            $imagemedia->user_id = $request->user_id;
            $imagemedia->status = $request->status;
            $imagemedia->description = $request->description;

            //House Image Upload Code
            uploadYourImage($request, $imagemedia, 'image');

            $imagemedia->update();
            Session::flash('success', 'Upload Details updated successfully!'); // Add success message to flash session
            // return redirect()->route('imagemedia.index');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception and show error message
            // return redirect()->back()->with($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $imagemedia = ImageMedia::findOrFail($id);
            $file = public_path($imagemedia->image);
            if (file_exists($file)) {
                unlink($file);
            }
            $imagemedia->delete();
            return redirect()->route('imagemedia.index')->with('error', 'Upload details deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete address');
        }
    }
}
