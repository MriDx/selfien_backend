@extends('admin.layouts.admin')

@section('title','Posts')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Post Type</th>
                <th>Posted By</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->type }}</td>
                    <td><a href="{{ route('admin.profiles.show', [$post->user_profile_id->id]  ) }}">{{ $post->user_profile_id->name }}</a></td>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.posts.show', [$post->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-xs btn-danger" href="{{ route('admin.posts.destroy', [$post->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $posts->links() }}
        </div>
    </div>
@endsection