@extends('admin.layouts.admin')

@section('title', $profile->name . '\'s Profile')

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $profile->name }}</td>
            </tr>

	    <tr>
                <th>Email</th>
                <td>{{ $profile->email }}</td>
            </tr>

            <tr>
                <th>Gender</th>
                <td>{{$profile->gender  }}</td>
            </tr>

            <tr>
                <th>User ID(Firebase)</th>
                <td>{{$profile->user_id }}</td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $profile->created_at }} ({{ $profile->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>{{ $profile->updated_at }} ({{ $profile->updated_at->diffForHumans() }})</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a class="btn btn-success" href="{{ route('admin.posts', ['user_profile_id' => $profile->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">View Posts</a>
    <a class="btn btn-primary" href="{{ URL::previous() }}">Back</a>
@endsection
