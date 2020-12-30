@extends('admin.layouts.admin')

@section('title','Post Activities')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Post ID</th>
                <th>Posted By</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td><a href="{{ route('admin.posts.show', [$activity->post_id]  ) }}">{{ $activity->post_id }}</a></td>
                    <td><a href="{{ route('admin.profiles.show', [$activity->user_profile_id]  ) }}">{{ $activity->user_profile_id }}</a></td>
                    <td><a href="{{ route('admin.posts.show', [$activity->type]  ) }}">{{ $activity->type }}</a></td>
                    <td>{{ $activity->created_at }}</td>
                    <td>{{ $activity->updated_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-danger" href="{{ route('admin.postactivities.destroy', [$activity->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $activities->links() }}
        </div>
    </div>
@endsection