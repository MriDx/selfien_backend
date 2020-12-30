<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PaymentRequest;
use App\Http\Requests\UserProfileRequest;
use App\Models\UserProfile;
use Cartalyst\Stripe\Api\EphemeralKey;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth1\Client\Server\User;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function store(UserProfileRequest $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        if (!$profile) {
            $profile = new UserProfile();
        }

        $profile->user_id = $user->id;

        if ($request->update == "1") {
            $profile->name = $request->name ? $request->name : $user->name;
            $profile->image = $request->image ? $request->image : $user->image;
            $profile->gender = $request->gender;
            $profile->fcm_registration_id = $request->fcm_registration_id;
            $profile->notification_on_like = $request->notification_on_like;
            $profile->notification_on_dislike = $request->notification_on_dislike;
            $profile->notification_on_comment = $request->notification_on_comment;
        } else {
            $profile->name = $profile->name ? $profile->name : $user->name;
            $profile->email = $profile->email ? $profile->email : $user->email;
            $profile->image = $profile->image ? $profile->image : $user->image;
            $profile->gender = $profile->gender ? $profile->gender : $request->gender;
            $profile->fcm_registration_id = $request->fcm_registration_id; //always give preference to request
            $profile->notification_on_like = $profile->notification_on_like ? $profile->notification_on_like : $request->notification_on_like;
            $profile->notification_on_dislike = $profile->notification_on_dislike ? $profile->notification_on_dislike : $request->notification_on_dislike;
            $profile->notification_on_comment = $profile->notification_on_comment ? $profile->notification_on_comment : $request->notification_on_comment;
        }

        $profile->save();

        /*if($user->email === 'mayur.dhande@mralab.com') {
            $profile->is_admin = 1;
            $profile->save();
        } else {
            $adminProfile = UserProfile::where('is_admin', 1)->first();
            $profile->follow($adminProfile);
        }*/

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];
        return response()->json(UserProfile::where('id', $profile->id)->withCount($countsQuery)->firstOrFail());
    }

    public function show(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'posts as posts_count',
            'activities as like_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'activities as dislike_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'activities as comment_count' => function ($query) {
                $query->where('post_activities.type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];
        return response()->json(UserProfile::where('id', $userProfile->id)->withCount($countsQuery)->firstOrFail());
    }


    public function follow(UserProfile $userProfile)
    {
        $success = 0; // no action
        $user = Auth::user();
        $currentProfile = UserProfile::where('user_id', $user->id)->first();
        if ($currentProfile->isFollowing($userProfile)) {
            $currentProfile->unfollow($userProfile);
            $success = 1; // unfollow
        } else {
            $currentProfile->follow($userProfile);
            $success = 2; // follow
        }
        return response()->json(array("success" => $success));
    }

    public function followers(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $ids = $userProfile->followers()->pluck('user_profile_id')->all();

        $profiles = UserProfile::whereIn('id', $ids);

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];


        return response()->json($profiles->withCount($countsQuery)->paginate(config('constants.paginate_per_page')));
        //return response()->json($userProfile->followers()->withCount($countsQuery)->get());
        //return response()->json($userProfile->followers()->get());

    }

    public function following(UserProfile $userProfile)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $ids = $userProfile->followings()->pluck('id')->all();

        $profiles = UserProfile::whereIn('id', $ids);

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];


        return response()->json($profiles->withCount($countsQuery)->paginate(config('constants.paginate_per_page')));

        //return response()->json($userProfile->followings()->get());
    }

    public function activities()
    {
        //$user = Auth::user();
        //$profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        $profile = UserProfile::find(8);

        return response()->json($profile->activities()->orderBy('created_at', 'desc')->paginate(config('constants.paginate_per_page')));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'followers as is_following' => function ($query) use ($profile) {
                $query->where('followables.user_profile_id', $profile->id);
            },
            'following as following_count',
            'followers as followers_count'
        ];

        $search = $request->search;
        $profiles = UserProfile::where('name', 'like', '%' . $search . '%')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($profiles);
    }

    public function create_payment(PaymentRequest $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        try {
            $token = $request->token;
            $charge = Stripe::charges()->create([
                'amount' => 100,
                'currency' => 'usd',
                'description' => 'Registration charge',
                'source' => $token,
            ]);
            $profile->is_paid = true;
            $profile->save();
            return response()->json($charge);
        } catch(\Exception $ex) {
            abort(400);
        }
    }
}
