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

        <ul class="nav nav-tabs nav-justified mt-2" style="font-size: 16px;">
            <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'followers') ? 'active' : '' }}" href='{{ url("$user->username/followers") }}'>Followers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (\Request::route()->getName() == 'following') ? 'active' : '' }}" href='{{ url("$user->username/following") }}'>Following</a>
            </li>
        </ul>

        @foreach($followers as $follUser)
            <div class="row border-bottom py-3">
                <div class="col-md-2 text-center">
                    @if($follUser->user->profile_photo)
                        @php( $imageUrl = "user_images/" . $follUser->user->profile_photo )
                        <img src='{{ asset("$imageUrl") }}' width="50px" height="50px" alt="..." class="rounded-circle">
                    @else
                        <img src='{{ asset("img/user-photo.png" ) }}' width="50px" height="50px" alt="..." class="rounded-circle">
                    @endif
                </div>

                <div class="col-md-7">
                    <h5 class="">{{ $follUser->user->name }}</h5>
                    <h5 class="text-muted" style="font-size: 14px;">{{ '@' . $follUser->user->username }}</h5>
                </div>

                <div class="col-md-3 text-right">
                    @if(followingCheck($user->id, $follUser->user->id))
                        @php( $unfollowUrl = "unfollow/" . $follUser->user->id )
                        <a href='{{ url($unfollowUrl) }}' class="btn btn-primary following-btn" style="border-radius: 23px;">Following</a>
                    @else 
                        @php( $followingUrl = "follow/" . $follUser->user->id )
                        <a href="{{ url($followingUrl) }}" class="btn btn-outline-primary" style="border-radius: 23px;">Follow</a>
                    @endif
                </div>
            </div>
        @endforeach
        
        
    </div>

    @include('common_layout.right_side_bar', ['unfollowingUsers' => $unfollowingUsers])


    
</div>

@endsection
