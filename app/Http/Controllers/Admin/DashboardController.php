<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\Comment;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = DB::table('posts')
            ->select('created_at', DB::raw('count(*) as total'))
            ->groupBy('created_at')
            ->orderBY('created_at', 'desc')
            ->take(20)
            ->get();

        $posts_chart_data = [];
        foreach($posts as $data) {
            array_push($posts_chart_data, [$data->created_at, $data->total]);
        }

        $data = [
            'total_users' => UserProfile::count(),
            'total_posts' => Post::count(),
            'total_comments' => Comment::count(),
            'total_likes_dislikes' => PostActivity::count(),
            'posts_chart_data' => $posts_chart_data
        ];

        return view('admin.dashboard', $data);
    }
}
