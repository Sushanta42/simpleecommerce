<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\User;
use App\Models\UserMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserMilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usermilestones = UserMilestone::all();
        foreach ($usermilestones as $usermilestone) {
            $end_date = $usermilestone->end_date;
            $today = now();
            if ($end_date < $today && $usermilestone->status !== 'expired') {
                $usermilestone->status = 'expired';
                $usermilestone->save();
            }

            // Check if the milestone is active and has a 'delivered' order within its duration
            if ($usermilestone->status === 'active') {
                $user = $usermilestone->user;
                $start_date = $usermilestone->start_date;

                $orders = $user->orders()->where('status', 'delivered')
                    ->where('delivered_time', '>=', $start_date)
                    ->where('delivered_time', '<=', $end_date)
                    ->get();

                // Calculate the total amount of orders and set it as the amount of the user milestone
                $totalAmount = $orders->sum('total');
                $usermilestone->amount = $totalAmount;
                $usermilestone->save();

                // Get the corresponding milestone
                $milestone = $usermilestone->milestone;

                // Check if the user milestone amount is greater or equal to the milestone goal
                if ($usermilestone->amount >= $milestone->goal) {
                    $usermilestone->destination = 'reached';
                    $usermilestone->save();
                }
            }
        }
        return view('admin.usermilestone.index', compact('usermilestones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $milestones = Milestone::all();
        $users = User::all();
        return view('admin.usermilestone.create', compact('milestones', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'milestone_id' => 'required',
            'status' => 'required',
        ], [
            'user_id.required' => 'The user id field is required.',
            'milestone_id.required' => 'The milestone plan field is required.',
            'status.required' => 'The Status field is required.',
        ]);
        try {
            $milestone = Milestone::findOrFail($request->milestone_id);

            $usermilestone = new UserMilestone();
            $usermilestone->user_id = $request->user_id;
            $usermilestone->milestone_id = $milestone->id;
            // $usermilestone->amount = $request->amount;
            $usermilestone->start_date = now();
            $usermilestone->end_date = now()->addDays($milestone->duration);
            $usermilestone->status = $request->status;

            $usermilestone->save();
            Session::flash('success', 'User Milestone added successfully!'); // Add success message to flash session
            return redirect()->route('usermilestone.index');
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
        $usermilestone = UserMilestone::find($id);

        $milestones = Milestone::all();
        $users = User::all();
        return view('admin.usermilestone.edit', compact('usermilestone', 'milestones', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $milestone = Milestone::findOrFail($request->milestone_id);

            $usermilestone = UserMilestone::find($id);
            $usermilestone->user_id = $request->user_id;
            $usermilestone->milestone_id = $milestone->id;
            // $usermilestone->amount = $request->amount;
            $usermilestone->status = $request->status;
            $usermilestone->reward = $request->reward;

            $usermilestone->update();
            Session::flash('success', 'User Milestone updated successfully!'); // Add success message to flash session
            return redirect()->route('usermilestone.index');
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
            $usermilestone = UserMilestone::findOrFail($id);
            $usermilestone->delete();
            return redirect()->route('usermilestone.index')->with('error', 'User milestone plan deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
