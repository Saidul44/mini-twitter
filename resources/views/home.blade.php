@extends('layouts.app')

@section('style')

    <link href="{{ asset('css/post_comment.css') }}" rel="stylesheet">

@endsection

@section('content')


<div class="row">
    <div class="col-md-7 main-content">
        <div class="row post-border-bottom">
            <div class="col-md-8">
                <div class="content-header" style="{{ (! Auth::check()) ? 'padding: 10px 0' : '' }}">
                    <h5 class="content-header-text">
                        @if(Auth::check())
                            Home
                        @else 
                            <i class="fa fa-twitter text-primary" style="font-size: 35px;"></i>
                        @endif
                    </h5>
                </div>
            </div>
            <div class="col-md-4 text-center" style="padding: 9px 0;">
                <button class="btn btn-info" data-toggle="modal" id="tweet-btn" data-target="#tweet" style="border-radius: 23px; color: white;">Tweet</button>
            </div>
        </div>

        @include('common_layout.post_layout', ['posts' => $posts])
        
    </div>

    @include('common_layout.right_side_bar', ['unfollowingUsers' => $unfollowingUsers])

</div>

@endsection
