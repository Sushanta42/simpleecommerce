<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarouselResource;
use App\Http\Resources\LegalResource;
use App\Models\AboutUs;
use App\Models\Carousel;
use App\Models\Faq;
use App\Models\PrivacyPolicy;
use App\Models\Term;
use Illuminate\Http\Request;

class LegalApiController extends Controller
{
    //get Carousels details
    public function getCarouselsHome()
    {
        try {
            $carousels = Carousel::where('status', 'active')
                ->whereIn('display_on', ['home', 'both'])
                ->get();

            return CarouselResource::collection($carousels);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving carousels'], 500);
        }
    }

    //get Carousels details
    public function getCarouselsSub()
    {
        try {
            $carousels = Carousel::where('status', 'active')
                ->whereIn('display_on', ['subscription', 'both'])
                ->get();

            return CarouselResource::collection($carousels);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving carousels'], 500);
        }
    }

    //get Faqs details
    public function getFaqs()
    {
        try {
            $faqs = Faq::all();
            // return response()->json($faqs);
            return LegalResource::collection($faqs);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving faqs'], 500);
        }
    }

    //get Faqs details
    public function getTerms()
    {
        try {
            $terms = Term::all();
            // return response()->json($terms);
            return LegalResource::collection($terms);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving terms and conditions'], 500);
        }
    }

    //get Faqs details
    public function getPrivacy()
    {
        try {
            $privacypolicies = PrivacyPolicy::all();
            // return response()->json($privacypolicies);
            return LegalResource::collection($privacypolicies);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving Privacy Policies'], 500);
        }
    }

    //get Faqs details
    public function getAboutUs()
    {
        try {
            $aboutus = AboutUs::all();
            // return response()->json($aboutus);
            return LegalResource::collection($aboutus);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving about us'], 500);
        }
    }
}
