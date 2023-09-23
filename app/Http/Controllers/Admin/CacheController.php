<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function clearCache()
    {
        // Run the clear:cache Artisan command
        Artisan::call('cache:clear');

        // Redirect back to the admin dashboard or any other desired page
        return redirect()->route('admin.dashboard')->with('success', 'Cache has been cleared.');
    }
}
