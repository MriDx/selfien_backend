<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PostHelper;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\CommentActivity;
use App\Models\Post;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($post) {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $countsQuery = [
            'comment_activities as like_count' => function ($query) {
                $query->where('type', config('constants.COMMENT_ACTIVITY_LIKE'));
            },
            'comment_activities as dislike_count' => function ($query) {
                $query->where('type', config('constants.COMMENT_ACTIVITY_DISLIKE'));
            },
            'comment_activities as liked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.COMMENT_ACTIVITY_LIKE'));
            },
            'comment_activities as disliked' => function ($query) use ($profile) {
                $query->where('user_profile_id', $profile->id)
                    ->where('type', config('constants.COMMENT_ACTIVITY_DISLIKE'));
            }
        ];

        $comments = Comment::where('post_id', $post)->orderBy('created_at', 'desc')->withCount($countsQuery)->paginate(config('constants.paginate_per_page'));
        return response()->json($comments);
    }

    public function like(Comment $comment) {
        $status = $this->likeDislikeComment($comment, config('constants.COMMENT_ACTIVITY_LIKE'));
        return response()->json(array("id" => $comment->id, "status" => $status), 200);
    }

    public function dislike(Comment $comment) {
        $status = $this->likeDislikeComment($comment, config('constants.COMMENT_ACTIVITY_DISLIKE'));
        return response()->json(array("id" => $comment->id, "status" => $status), 200);
    }

    public function store(Post $post, CreateCommentRequest $request) {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        $comment = new Comment();
        $comment->text = $request->text;
        $comment->post_id = $post->id;
        $comment->user_profile_id = $profile->id;
        $comment->save();

 	if($post->user_profile_id->user_profile_id == $profile->id) { return 1; }
	
        PostHelper::createPostActivity($profile, $post->id, config('constants.POST_ACTIVITY_COMMENT'));

        return response()->json(Comment::find($comment->id));
    }

    public function destroy(Comment $comment) {
        $deleted = $comment->delete();
        $status = $deleted ? 200 : 400;
        return response()->json(null, $status);
    }

    private function likeDislikeComment($comment, $type)
    {
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        $previousActivity = CommentActivity::where('user_profile_id', $profile->id)
            ->where('comment_id', $comment->id)
            ->whereIn('type', array(config('constants.COMMENT_ACTIVITY_LIKE'), config('constants.COMMENT_ACTIVITY_DISLIKE')))
            ->first();

        if ($previousActivity) {
            $previousActivity->delete();

            if ($previousActivity->type == $type) {
                return -1;
            }
        }
	
#	if($comment->user_profile_id->user_profile_id == $profile->id) { return 1; }

        PostHelper::createCommentActivity($profile, $comment->id, $type);
        return 1;
    }
}
