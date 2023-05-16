<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



class UserSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersubscriptions = UserSubscription::all();

        foreach ($usersubscriptions as $usersubscription) {
            $end_date = $usersubscription->end_date;
            $today = now();
            if ($end_date < $today && $usersubscription->status !== 'expired') {
                $usersubscription->status = 'expired';
                $usersubscription->save();
            }
        }
        return view('admin.usersubscription.index', compact('usersubscriptions'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriptions = Subscription::all();
        $users = User::all();
        return view('admin.usersubscription.create', compact('subscriptions', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //         'subscription_id' => 'required',
    //         'status' => 'required',
    //         'paid' => 'required',
    //     ], [
    //         'user_id.required' => 'The user id field is required.',
    //         'subscription_id.required' => 'The subscription plan field is required.',
    //         'status.required' => 'The Status field is required.',
    //         'paid.required' => 'The Paid field is required.',
    //     ]);
    //     try {
    //         $subscription = Subscription::findOrFail($request->subscription_id);

    //         $usersubscription = new UserSubscription();
    //         // $usersubscription->user_id = Auth::user()->id;
    //         $usersubscription->user_id = $request->user_id;
    //         $usersubscription->subscription_id = $subscription->id;
    //         $usersubscription->start_date = now();
    //         $usersubscription->end_date = $this->calculateEndDate($subscription->duration, $subscription->type);
    //         $usersubscription->status = $request->status;
    //         $usersubscription->paid = $request->paid;
    //         $usersubscription->save();

    //         Session::flash('success', 'User Subscription added successfully!'); // Add success message to flash session
    //         return redirect()->route('usersubscription.index');
    //     } catch (\Exception $e) {
    //         // Handle the exception and show error message
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'subscription_id' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ], [
            'user_id.required' => 'The user id field is required.',
            'subscription_id.required' => 'The subscription plan field is required.',
            'status.required' => 'The Status field is required.',
            'paid.required' => 'The Paid field is required.',
        ]);

        try {
            $subscription = Subscription::findOrFail($request->subscription_id);

            $existingSubscription = UserSubscription::where('user_id', $request->user_id)
                ->where('status', '!=', 'expired')
                ->first();

            if ($existingSubscription) {
                throw new \Exception('The user already has an active subscription.');
            }

            $usersubscription = new UserSubscription();
            $usersubscription->user_id = $request->user_id;
            $usersubscription->subscription_id = $subscription->id;
            $usersubscription->start_date = now();
            $usersubscription->end_date = $this->calculateEndDate($subscription->duration, $subscription->type);
            $usersubscription->status = $request->status;
            $usersubscription->paid = $request->paid;
            $usersubscription->save();

            Session::flash('success', 'User Subscription added successfully!'); // Add success message to flash session
            return redirect()->route('usersubscription.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    private function calculateEndDate($duration, $type)
    {
        $endDate = now();
        switch ($type) {
            case 'days':
                $endDate = $endDate->addDays($duration);
                break;
            case 'months':
                $endDate = $endDate->addMonths($duration);
                break;
            case 'year':
                $endDate = $endDate->addYears($duration);
                break;
        }
        return $endDate;
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
        $usersubscription = UserSubscription::find($id);

        $subscriptions = Subscription::all();
        $users = User::all();
        return view('admin.usersubscription.edit', compact('usersubscription', 'subscriptions', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            // 'user_id' => 'required',
            // 'subscription_id' => 'required',
            'status' => 'required',
            'paid' => 'required',
        ], [
            // 'user_id.required' => 'The user id field is required.',
            // 'subscription_id.required' => 'The subscription plan field is required.',
            'status.required' => 'The Status field is required.',
            'paid.required' => 'The Paid field is required.',
        ]);
        try {
            $subscription = Subscription::findOrFail($request->subscription_id);

            $usersubscription = UserSubscription::find($id);
            // $usersubscription->user_id = Auth::user()->id;
            $usersubscription->user_id = $request->user_id;
            $usersubscription->subscription_id = $subscription->id;
            // $usersubscription->start_date = now();
            // $usersubscription->end_date = $this->calculateEndDate($subscription->duration, $subscription->type);
            $usersubscription->status = $request->status;
            $usersubscription->paid = $request->paid;
            $usersubscription->setRenewalDateAttribute($request->renewal_date);

            // // Update the status to "expired" if the end date has passed
            // if ($usersubscription->end_date < now()) {
            //     $usersubscription->status = 'expired';
            // }

            $usersubscription->update();

            Session::flash('success', 'User Subscription updated successfully!'); // Add success message to flash session
            return redirect()->route('usersubscription.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $usersubscription = UserSubscription::findOrFail($id);
            $usersubscription->delete();
            return redirect()->route('usersubscription.index')->with('error', 'User Subscription plan deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
