<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $milestones = Milestone::all();
        return view('admin.milestone.index', compact('milestones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.milestone.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subscriptions,name|max:255', // Add validation rules for name field
            'goal' => 'required|numeric',
            'duration' => 'required',
            'plan' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'status' => 'required',
        ], [
            'name.required' => 'The Subscription name field is required.', // Custom error message for name field
            'goal.required' => 'The Goal field is required.', // Custom error message for price field
            'duration.required' => 'The duration field is required.', // Custom error message for duration field
            'plan.required' => 'The plan field is required.', // Custom error message for plan field
            'image.required' => 'The image field is required.', // Custom error message for image field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'status.required' => 'The status field is required.', // Custom error message for plan field
        ]);
        try {
            $milestone = new Milestone();
            $milestone->name = $request->name;
            $milestone->plan = $request->plan;
            $milestone->goal = $request->goal;
            $milestone->duration = $request->duration;
            $milestone->description = $request->description;
            // $milestone->type = $request->type;
            $milestone->status = $request->status;

            //Image Upload Code
            uploadMilestoneImage($request, $milestone, 'image');

            $milestone->save();
            Session::flash('success', 'Milestone added successfully!'); // Add success message to flash session
            return redirect()->route('milestone.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $milestone = Milestone::find($id);
        return view('admin.milestone.edit', compact('milestone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:subscriptions,name|max:255', // Add validation rules for name field
            'goal' => 'required|numeric',
            'duration' => 'required',
            'plan' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'status' => 'required',
        ], [
            'name.required' => 'The Subscription name field is required.', // Custom error message for name field
            'goal.required' => 'The Goal field is required.', // Custom error message for price field
            'duration.required' => 'The duration field is required.', // Custom error message for duration field
            'plan.required' => 'The plan field is required.', // Custom error message for plan field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'status.required' => 'The status field is required.', // Custom error message for plan field
        ]);
        try {
            $milestone = Milestone::find($id);
            $milestone->name = $request->name;
            $milestone->plan = $request->plan;
            $milestone->goal = $request->goal;
            $milestone->duration = $request->duration;
            $milestone->description = $request->description;
            // $milestone->type = $request->type;
            $milestone->status = $request->status;

            //Image Upload Code
            uploadMilestoneImage($request, $milestone, 'image');

            $milestone->update();
            Session::flash('success', 'Milestone updated successfully!'); // Add success message to flash session
            return redirect()->route('milestone.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $milestone = Milestone::findOrFail($id);
            $file = public_path($milestone->image);
            if (file_exists($file)) {
                unlink($file);
            }
            $milestone->delete();
            return redirect()->route('milestone.index')->with('error', 'Milestone deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete milestone');
        }
    }
}
