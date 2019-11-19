@extends('layouts.app')

@section('style')

    <style>
        .nav-tabs .nav-link.active {
            color: rgb(29, 161, 242) !important;
        }
    </style>

@endsection


@section('content')


<div class="row">
    <div class="col-md-7 main-content">
        <div class="row post-border-bottom">
            <div class="col-md-8">
                <div class="content-header">
                    <h5 class="content-header-text"><a href="{{ url('/') }}"><i class="fa fa-arrow-left"></i></a>&nbsp;&nbsp; {{ $user->name }}</h5>
                </div>
            </div>
        </div>

        <h5 class="text-center border-bottom mt-2"><a class="nav-link active" href='{{ url("settings") }}'>Settings</a></h5>

        <div class="row border-bottom py-3 justify-content-md-center">
            <div class="col-md-10">

                <form class="" role="form" method="POST" action="{{ url('settings') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">Name</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">Email</label>
                        
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>
                            
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">UserName</label>

                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control" name="username" value="{{ old('username') ? old('username') : $user->username }}" required autofocus>

                            @if ($errors->has('username'))
                                <span class="text-danger">
                                    {{ $errors->first('username') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row required">
                        <label for="name" class="col-md-4 col-form-label">Profile Photo</label>
                        <div class="col-lg-6">

                            <div class="form-control-static">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new img-thumbnail" style="width: 210px;">
                                        @if ($user->profile_photo)
                                            <img src='{{ url("user_images/$user->profile_photo") }}'
                                                    alt="No Photo">
                                        @else
                                            <img src="{{ url('img/default.png') }}"
                                                    alt="No Photo">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists img-thumbnail"
                                        style="width: 210px;"></div>
                                    <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">
                                            <input type="file" name="file" value="upload"
                                                data-buttonText="<?= trans('choose_file') ?>"
                                                id="photo"/>
                                            <span class="fileinput-exists">Change</span>
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists"
                                        data-dismiss="fileinput">Remove</a>
                                    </span>
                                    </div>

                                    @if ($errors->has('file'))
                                        <span class="text-danger">
                                            {{ $errors->first('file') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>

    @include('common_layout.right_side_bar', ['unfollowingUsers' => $unfollowingUsers])

@endsection

