@extends('admin.layouts.admin')

@section('title','User Profiles')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-sm-4 pull-right">
                {{ Form::open(['route'=>['admin.profiles'],'method' => 'get']) }}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Name or User ID" name="search"
                           value="{{ app('request')->input('search') }}">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                      </span>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>@sortablelink('name', 'Name', ['page' => $profiles->currentPage()])</th>
		<th>Email</th>
                <th>Gender</th>
                <th>User ID(Firebase)</th>
                <th>Created At</th>
                <th>Update At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
		    <td>{{ $profile->email }}</td>
                    <td>{{ $profile->gender }}</td>
                    <td>{{ $profile->user_id }}</td>
                    <td>{{ $profile->created_at }}</td>
                    <td>{{ $profile->updated_at }}</td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="{{ route('admin.profiles.show', [$profile->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-xs btn-info" href="{{ route('admin.profiles.edit', [$profile->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a class="btn btn-xs btn-danger" href="{{ route('admin.profiles.destroy', [$profile->id]) }}"
                           data-toggle="tooltip" data-placement="top" data-title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $profiles->links() }}
        </div>
    </div>
@endsection
