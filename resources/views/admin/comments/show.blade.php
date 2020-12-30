@extends('admin.layouts.admin')

@section('title', 'Comment')

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $comment->id }}</td>
            </tr>

            <tr>
                <th>Text</th>
                <td>{{ $comment->text }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td><a href="{{ route('admin.posts.show', [$comment->user_profile_id->id]  ) }}">{{ $comment->user_profile_id->name }}</a></td>
            </tr>
            
            <tr>
                <th>Created At</th>
                <td>{{ $comment->created_at }} ({{ $comment->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>{{ $comment->updated_at }} ({{ $comment->updated_at->diffForHumans() }})</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a class="btn btn-danger" href="{{ route('admin.comments.destroy', [$comment->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">Delete</a>
    <a class="btn btn-success" href="{{ route('admin.commentsactivities', ["comment_id" => $comment->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">View Activities</a>
    <a class="btn btn-primary" href="{{ URL::previous() }}">Back</a>
@endsection