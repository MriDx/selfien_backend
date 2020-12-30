<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\Post;
use App\Models\PostActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class PostActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $postactivities = PostActivity::sortable(['name' => 'asc']);
        if($request->user_profile_id) {
            $postactivities = $postactivities->orWhere('user_profile_id', $request->user_profile_id);
        }
        if($request->post_id) {
            $postactivities = $postactivities->orWhere('post_id', $request->post_id);
        }
        return view('admin.postactivities.index', ['activities' => $postactivities->paginate()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostActivity $activity)
    {
        $activity->delete();
        return redirect(route('admin.postactivities'));
    }
}
