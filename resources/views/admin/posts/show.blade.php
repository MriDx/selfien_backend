@extends('admin.layouts.admin')

@section('title', 'Post')

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $post->id }}</td>
            </tr>

            <tr>
                <th>Type</th>
                <td>{{ $post->type }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td><a href="{{ route('admin.posts.show', [$post->user_profile_id->id]  ) }}">{{ $post->user_profile_id->name }}</a></td>
            </tr>

            <tr>
                <th>Text</th>
                <td>{{ $post->text }}</td>
            </tr>

            <tr>
                <th>Media Url</th>
                <td><a target="_blank" href="{{ $post->media_url }}">{{ $post->media_url }}</a></td>
            </tr>

            <tr>
                <th>Like Count</th>
                <td>{{ $post->like_count }}</td>
            </tr>

            <tr>
                <th>Dislike Count</th>
                <td>{{ $post->dislike_count }}</td>
            </tr>

            <tr>
                <th>Comment Count</th>
                <td>{{ $post->comment_count }}</td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $post->created_at }} ({{ $post->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>{{ $post->updated_at }} ({{ $post->updated_at->diffForHumans() }})</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a class="btn btn-danger" href="{{ route('admin.posts.destroy', [$post->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">Delete</a>
    <a class="btn btn-success" href="{{ route('admin.postactivities', ["post_id" => $post->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">View Activities</a>
    <a class="btn btn-success" href="{{ route('admin.comments', ["post_id" => $post->id]) }}"
       data-toggle="tooltip" data-placement="top" data-title="Delete">View Comments</a>
    <a class="btn btn-primary" href="{{ URL::previous() }}">Back</a>
@endsection
