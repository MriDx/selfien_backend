<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PostHelper;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        //$profile = UserProfile::where('user_id', 'hX87SFJ1NSMRpf1FsP0IyyOswbW2')->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as favorited' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_FAVORITE'));
            }
        ];
        if ($request->treding === "1") {
            $posts = Post::orderBy('created_at', 'desc');
        } else {
            $following = array_merge($profile->followings()->pluck('id')->all(), [$profile->id]);
            $posts = Post::whereIn('user_profile_id', $following)->orderBy('created_at', 'desc');
        }
        if ($request->type) {
            $posts = $posts->where('type', $request->type)->orderBy('created_at', 'desc');
        }
        if ($request->user_profile_id) {
            $posts = $posts->where('user_profile_id', $request->user_profile_id)->orderBy('created_at', 'desc');
        }
        $posts = $posts->where('is_story', false)->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }

    public function show(Post $post)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];
        return response()->json(Post::where('id', $post->id)->where('is_story', false)->withCount($countsQuery)->first());
    }

    public function myposts(Request $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            },
            'post_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as commented' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];

        $posts = Post::where('user_profile_id', $profile->id)->where('is_story', false);

        if ($request->type) {
            $posts = $posts->where('type', $request->type);
        }

        $posts = $posts->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($posts);
    }

    public function storyUsers()
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        $following = array_merge($profile->followings()->pluck('id')->all(), [$profile->id]);
        $users = Post::whereIn('user_profile_id', $following)->where('is_story', true)->get()->pluck('user_profile_id')->all();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return response()->json(UserProfile::whereIn('id', $userIds)->get());
    }

    public function stories(UserProfile $userProfile)
    {
        $posts = Post::where('user_profile_id', $userProfile->id)->where('is_story', true)
            ->orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }

    public function like(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_LIKE'));
        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    private function likeDislikePost($post, $type)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        //$profile = UserProfile::where('user_id', 'hX87SFJ1NSMRpf1FsP0IyyOswbW2')->firstOrFail();

        $previousActivity = PostActivity::where('user_profile_id', $profile->id)
            ->where('post_id', $post->id)
            ->whereIn('type', array(config('constants.POST_ACTIVITY_LIKE'), config('constants.POST_ACTIVITY_DISLIKE')))
            ->first();

            //return $previousActivity;

        if ($previousActivity) {
            $previousActivity->delete();

            if ($previousActivity->type == $type) {
                return -1; // unlike or undislike
            }
        }

        PostHelper::createPostActivity($profile, $post->id, $type);
        return 1; // like or dislike
    }

    public function dislike(Post $post)
    {
        $status = $this->likeDislikePost($post, config('constants.POST_ACTIVITY_DISLIKE'));

        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    //FAV
    public function favorite(Post $post)
    {
        //return $post;
        $status = $this->favoriteOrUnfavorite($post, config('constants.POST_ACTIVITY_FAVORITE'));
        return response()->json(array("id" => $post->id, "status" => $status), 200);
    }

    private function favoriteOrUnfavorite($post, $type)
    {
        $user = Auth::user();
        //$user = User::where('id',) -> first();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();
        //$profile = UserProfile::where('user_id', 'hX87SFJ1NSMRpf1FsP0IyyOswbW2')->firstOrFail();
        //return $profile;
        $previousActivity = PostActivity::where('user_profile_id', $profile->id)
            ->where('post_id', $post->id)
            ->whereIn('type', array(config('constants.POST_ACTIVITY_FAVORITE')))
            ->first();

        //return $previousActivity;

        if ($previousActivity) {
            $previousActivity->delete();

            return -1; //just delete the favorite
            /* if ($previousActivity->type == $type) {
                return -1; // unlike or undislike
            } */
        }

        PostHelper::createPostActivity($profile, $post->id, $type);
        return 1; // like or dislike
    }


    public function share(Post $post)
    {
        $post->share_count = $post->share_count + 1;
        $post->save();
        return response()->json(null, 200);
    }

    public function store(CreatePostRequest $request)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        $post = new Post();
        $post->title = $request->title;
        $post->text = $request->text;
        $post->media_url = $request->media_url;
        $post->type = $request->type;
        $post->user_profile_id = $profile->id;
        $post->video_thumbnail_url = $request->video_thumbnail_url;
        $post->is_story = $request->is_story ? true : false;
        $post->save();

        return response()->json(Post::find($post->id));
    }

    public function destroy(Post $post)
    {
        $deleted = $post->delete();
        $status = $deleted ? 200 : 400;
        return response()->json(null, $status);
    }
}
