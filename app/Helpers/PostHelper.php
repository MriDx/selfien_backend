<?php
/**
 * Created by PhpStorm.
 * User: ujjwal
 * Date: 12/6/17
 * Time: 8:17 PM
 */

namespace App\Helpers;

use App\Models\Post;
use App\Models\UserProfile;
use App\Models\CommentActivity;
use App\Models\PostActivity;

class PostHelper
{
    static function createPostActivity($profile, $postId, $type)
    {
        $activity = new PostActivity();
        $activity->user_profile_id = $profile->id;
        $activity->post_id = $postId;
        $activity->type = $type;
        $activity->save();

	if(Post::find($postId)->user_profile_id->id == $profile->id) { return 1; }

        $title = "New Activity on your post";
        $body = null;
        $data = array();
        switch($type) {
            case config('constants.POST_ACTIVITY_LIKE'):
                if(!$profile->notification_on_like) {
                    return;
                }
                $body = "Someone liked your post";
                $data = ["post_id" => $postId];
                break;
            case config('constants.POST_ACTIVITY_DISLIKE'):
                if(!$profile->notification_on_dislike) {
                    return;
                }
                $body = "Someone disliked your post";
                $data = ["post_id" => $postId];
                break;
            case config('constants.POST_ACTIVITY_COMMENT'):
                if(!$profile->notification_on_comment) {
                    return;
                }
                $body = "Someone commented on your post";
                $data = ["post_id" => $postId];
                break;
        }
	$notifyUser = UserProfile::find(Post::find($postId)->user_profile_id)->first();
        PushNotificationHelper::send($notifyUser->fcm_registration_id, $title, $body, $data);
    }

    static function createCommentActivity($profile, $commentId, $type)
    {
        $activity = new CommentActivity();
        $activity->user_profile_id = $profile->id;
        $activity->comment_id = $commentId;
        $activity->type = $type;
        $activity->save();

	if(Comment::find($commentId)->user_profile_id->id == $profile->id) { return 1; }

        $title = "New Activity on your post";
        $body = "";
        $data = array();
        switch($type) {
            case config('constants.POST_ACTIVITY_LIKE'):
                $body = "Someone liked your comment";
                $data = ["comment_id" => $commentId];
                break;
            case config('constants.POST_ACTIVITY_DISLIKE'):
                $body = "Someone disliked your comment";
                $data = ["comment_id" => $commentId];
                break;
        }
	$notifyUser = UserProfile::find(Comment::find($commentId)->user_profile_id)->first();
        PushNotificationHelper::send($notifyUser->fcm_registration_id, $title, $body, $data);
    }
}
