@extends('admin.layouts.admin')

@section('title','Comments')

@section('content')
    <div class="row">
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Post ID</th>
                <th>Posted By</th>
                <th>Text</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>{{ $comment->post_id }}</td>
                    <td><a href="{{ route('admin.profiles.show', [$comment->user_profile_id->id]  ) }}">{{ $comment->user_profile_id->name }}</a></td>
                    <td>{{ str_limit($comment->text, $limit = 20, $end = '...') }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->updated_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.comments.show', [$comment->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-xs btn-danger" href="{{ route('admin.comments.destroy', [$comment->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $comments->links() }}
        </div>
    </div>
@endsection