@extends('admin.layouts.admin')

@section('title', 'Update Profile')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {{ Form::open(['route'=>['admin.profiles.update', $profile->id],'method' => 'put','class'=>'form-horizontal form-label-left']) }}

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                    Name
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="name" type="text"
                           class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                           name="name" value="{{ $profile->name }}" required>
                    @if($errors->has('name'))
                        <ul class="parsley-errors-list filled">
                            @foreach($errors->get('name') as $error)
                                <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">
                    Gender
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="gender" name="gender" class="select2" style="width: 100%" autocomplete="off">
                        <option value="">Select</option>
                        <option {{ $profile->gender == 'm' ? 'selected':'' }} value="m">Male</option>
                        <option {{ $profile->gender == 'f' ? 'selected':'' }} value="f">Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">
                    User ID(Firebase)
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="user_id" type="text"
                           class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                           name="user_id" value="{{ $profile->user_id }}" required>
                    @if($errors->has('user_id'))
                        <ul class="parsley-errors-list filled">
                            @foreach($errors->get('user_id') as $error)
                                <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a class="btn btn-primary" href="{{ URL::previous() }}">Cancel</a>
                    <button type="submit" class="btn btn-success"> Save</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/users/edit.css')) }}
@endsection

@section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/users/edit.js')) }}
@endsection