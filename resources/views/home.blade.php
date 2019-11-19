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
                    <h5 class="content-header-text">Home</h5>
                </div>
            </div>
            <div class="col-md-4 text-center" style="padding: 9px 0;">
                <button class="btn btn-info" data-toggle="modal" data-target="#tweet" style="border-radius: 23px; color: white;">Tweet</button>
            </div>
        </div>

        @include('common_layout.post_layout', ['posts' => $posts])
        
    </div>

    @include('common_layout.right_side_bar', ['unfollowingUsers' => $unfollowingUsers])

</div>

@endsection
