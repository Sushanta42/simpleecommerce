<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Http\Resources\UserSubscriptionResource;
use App\Models\Milestone;
use App\Models\Subscription;
use App\Models\UserMilestone;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SubscriptionApiController extends Controller
{
    //get subscription details
    public function getSubscriptions()
    {
        try {
            $subscriptions = Subscription::all();
            return SubscriptionResource::collection($subscriptions);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving subscriptions'], 500);
        }
    }

    public function getSubscription($id)
    {
        $subscription = Subscription::find($id);
        return SubscriptionResource::collection([$subscription]);
    }

    // Add user subscription
    public function addUserSubscription(Request $request)
    {
        try {
            $subscription = Subscription::findOrFail($request->subscription_id);

            $existingSubscription = UserSubscription::where('user_id', Auth::user()->id)
                ->where('status', '=', 'active')
                ->first();

            if ($existingSubscription) {
                throw new \Exception('The user already has an active subscription.');
            }

            $usersubscription = new UserSubscription();
            $usersubscription->user_id = Auth::user()->id;
            $usersubscription->subscription_id = $subscription->id;
            $usersubscription->start_date = now();
            $usersubscription->end_date = $this->calculateEndDate($subscription->duration, $subscription->type);
            $usersubscription->status = 'active'; // Assuming the default status is 'active' for a new subscription
            $usersubscription->paid = false; // Assuming the default paid status is false
            $usersubscription->save();

            // Check if active UserMilestone already exists for the user
            $activeUserMilestone = UserMilestone::where('user_id', Auth::user()->id)
                ->where('status', '=', 'active')
                ->first();

            // Create user milestones for active milestones if not exists
            if (!$activeUserMilestone) {
                $this->createUserMilestonesForActiveMilestones(Auth::user()->id);
            }

            return response()->json(['success' => true, 'message' => 'User subscription added successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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

    // Create user milestones for active milestones
    private function createUserMilestonesForActiveMilestones($userId)
    {
        $activeMilestones = Milestone::where('status', '=', 'active')->get();
        foreach ($activeMilestones as $milestone) {
            $userMilestone = new UserMilestone();
            $userMilestone->user_id = $userId;
            $userMilestone->milestone_id = $milestone->id;
            $userMilestone->amount = 0; // Set initial amount to 0
            $userMilestone->start_date = now(); // Set the start date to the current date
            $userMilestone->end_date = now()->addDays($milestone->duration);
            $userMilestone->status = 'active'; // Assuming the default status is 'active' for a new milestone
            $userMilestone->save();
        }
    }

    // Get User Subscription
    public function getUserSubscription()
    {
        // try {
        //     $user = Auth::user();

        //     $subscription = UserSubscription::where('user_id', $user->id)
        //         ->where('status', '!=', 'expired')
        //         ->first();

        //     if ($subscription) {
        //         return new UserSubscriptionResource($subscription);
        //     } else {
        //         return response()->json(['success' => false, 'message' => 'User has no active subscriptions'], 404);
        //     }
        // } catch (\Exception $e) {
        //     return response()->json(['success' => false, 'message' => 'An error occurred while retrieving user subscription'], 500);
        // }


        try {
            $usersubscription = UserSubscription::where('user_id', Auth::user()->id)->get();
            return UserSubscriptionResource::collection($usersubscription);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving user subscriptions'], 500);
        }
    }
}
