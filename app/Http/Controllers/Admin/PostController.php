<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::sortable(['name' => 'asc']);
        if($request->user_profile_id) {
            $posts = $posts->where('user_profile_id', $request->user_profile_id);
        }
        return view('admin.posts.index', ['posts' => $posts->paginate()]);
    }

    public function show(Post $post)
    {
        $countsQuery = [
            'post_activities as like_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_LIKE'));
            },
            'post_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_DISLIKE'));
            },
            'post_activities as comment_count' => function ($query) {
                $query->where('type', config('constants.POST_ACTIVITY_COMMENT'));
            }
        ];
        return view('admin.posts.show', ['post' => Post::where('id', $post->id)->withCount($countsQuery)->first()]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('admin.posts'));
    }
}
