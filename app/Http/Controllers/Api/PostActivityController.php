<?php

namespace App\Http\Controllers\Api;

use App\Models\PostActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
	$activities = PostActivity::whereHas('post',function($query) use($profile) {$query->where('user_profile_id', $profile->id);})->whereNotIn('user_profile_id', [$profile->id])->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page'));
        return response()->json($activities);
    }
}
