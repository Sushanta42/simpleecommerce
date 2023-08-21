<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserMilestoneResource;
use App\Models\UserMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserMilestoneApiController extends Controller
{
    //Get UserMilestone Details
    public function getUserMilestone()
    {
        try {
            $usermilestone = UserMilestone::where('user_id', Auth::user()->id)->get();
            return UserMilestoneResource::collection($usermilestone);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving user milestone'], 500);
        }
    }
}
