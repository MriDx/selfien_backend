<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role\Role;
use App\Models\Auth\User\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $profiles = UserProfile::sortable(['created_at' => 'desc']);
        if($request->search) {
            $profiles= $profiles->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('user_id', 'like', '%' . $request->search . '%');
        }
        return view('admin.userprofiles.index', ['profiles' => $profiles->paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        dd;
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(UserProfile $profile)
    {
        return view('admin.userprofiles.show', ['profile' => $profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $profile)
    {
        return view('admin.userprofiles.edit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return mixed
     */
    public function update(Request $request, UserProfile $profile)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'gender' => ['required', Rule::in(config('constants.enums.gender'))],
            'user_id' => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $profile->name = $request->get('name');
        $profile->gender = $request->get('gender');
        $profile->user_id = $request->get('user_id');

        $profile->save();

        return redirect()->intended(route('admin.profiles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $profile)
    {
        $profile->delete();
        return redirect(route('admin.profiles'));
    }
}
