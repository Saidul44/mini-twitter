@extends('layouts.app')

@section('style')

    <link href="{{ asset('css/post_comment.css') }}" rel="stylesheet">

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

        <div class="row mt-3">
            <div class="col-md-12">

                @if($user->profile_photo)
                    @php( $imageUrl = "user_images/" . $user->profile_photo )
                    <img src='{{ asset("$imageUrl") }}' width="130px" height="130px" alt="..." class="rounded-circle">
                @else
                    <img src='{{ asset("img/user-photo.png" ) }}' width="130px" height="130px" alt="..." class="rounded-circle">
                @endif

                <h5 class="mt-1 ml-4">{{ $user->name }}</h5>
                <h5 class="text-muted mt-1 ml-4">{{ '@' . $user->username }}</h5>
                <p class="text-muted mt-1 ml-4"><i class="fa fa-calendar"></i> Joined {{ date('F Y', strtotime($user->created_at)) }}</p>
                @if(Auth::check() && (Auth::id() != $user->id))
                    <p style="float: right;">
                        @if(followingCheck(Auth::id(), $user->id))
                            @php( $unfollowUrl = "unfollow/" . $user->id )
                            <a href='{{ url($unfollowUrl) }}' class="btn btn-primary following-btn" style="border-radius: 23px;">Following</a>
                        @else 
                            @php( $followingUrl = "follow/" . $user->id )
                            <a href="{{ url($followingUrl) }}" class="btn btn-outline-primary" style="border-radius: 23px;">Follow</a>
                        @endif
                    </p>
                @endif
                <p class="mt-1 ml-4">
                    <b>{{ $followingCount }}</b> <a href='{{ url("$user->username/following") }}' class="text-muted">Following</a> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>{{ $followersCount }}</b> <a href='{{ url("$user->username/followers") }}' class="text-muted">Followers</a>
                </p>
            </div>
        </div>

        <h5 class="text-primary"><a href="{{ url($user->username) }}" style="text-decoration: underline;">Tweets</a></h5>

        @include('common_layout.post_layout', ['posts' => $posts])
        
    </div>

    @include('common_layout.right_side_bar', ['unfollowingUsers' => $unfollowingUsers])

</div>

@endsection
