<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subscriptions,name|max:255', // Add validation rules for name field
            'price' => 'required|numeric',
            'duration' => 'required',
            'plan' => 'required',
            'active' => 'required',
        ], [
            'name.required' => 'The Subscription name field is required.', // Custom error message for name field
            'price.required' => 'The price field is required.', // Custom error message for price field
            'duration.required' => 'The duration field is required.', // Custom error message for duration field
            'plan.required' => 'The plan field is required.', // Custom error message for plan field
            'active.required' => 'The active field is required.', // Custom error message for plan field
        ]);
        try {
            $subscription = new Subscription();
            $subscription->name = $request->name;
            $subscription->description = $request->description;
            $subscription->price = $request->price;
            $subscription->duration = $request->duration;
            $subscription->type = $request->type;
            $subscription->plan = $request->plan;
            $subscription->active = $request->active;

            $subscription->save();
            Session::flash('success', 'Subscription added successfully!'); // Add success message to flash session
            return redirect()->route('subscription.index');
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
        $subscription = Subscription::find($id);
        return view('admin.subscription.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
            'price' => 'required|numeric',
            'duration' => 'required',
            'plan' => 'required',
            'active' => 'required',
        ], [
            'name.required' => 'The Subscription name field is required.', // Custom error message for name field
            'price.required' => 'The price field is required.', // Custom error message for price field
            'duration.required' => 'The duration field is required.', // Custom error message for duration field
            'plan.required' => 'The plan field is required.', // Custom error message for plan field
            'active.required' => 'The active field is required.', // Custom error message for plan field
        ]);
        try {
            $subscription = Subscription::find($id);
            $subscription->name = $request->name;
            $subscription->description = $request->description;
            $subscription->price = $request->price;
            $subscription->duration = $request->duration;
            $subscription->type = $request->type;
            $subscription->plan = $request->plan;
            $subscription->active = $request->active;

            $subscription->update();
            return redirect()->back()->with('success', 'Subscription Plan Updated successfully!');
            // Session::flash('success', 'Subscription Plan Updated successfully!'); // Add success message to flash session
            // return redirect()->route('subscription.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update Name. Subscription name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();
            return redirect()->route('subscription.index')->with('error', 'Subscription plan deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete Subscription plan due to its relation in Subscription User');
        }
    }
}
