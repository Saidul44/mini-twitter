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
    <div class="col-md-8 main-content">
        <div class="row post-border-bottom">
            <div class="col-md-8">
                <div class="content-header">
                    <h5 class="content-header-text"><a href="{{ url('home') }}"><i class="fa fa-arrow-left"></i></a>&nbsp;&nbsp; {{ $user->name }}</h5>
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

        @foreach($followingUsers as $follUser)
            <div class="row border-bottom py-3">
                <div class="col-md-2 text-center">
                    @if($follUser->following_user->profile_photo)
                        @php( $imageUrl = "user_images/" . $follUser->following_user->profile_photo )
                        <img src='{{ asset("$imageUrl") }}' width="50px" height="50px" alt="..." class="rounded-circle">
                    @else
                        <img src='{{ asset("img/user-photo.png" ) }}' width="50px" height="50px" alt="..." class="rounded-circle">
                    @endif
                </div>

                <div class="col-md-7">
                    <h5 class="">{{ $follUser->following_user->name }}</h5>
                    <h5 class="text-muted" style="font-size: 14px;">{{ '@' . $follUser->following_user->username }}</h5>
                </div>

                <div class="col-md-3 text-right">
                    @php( $unfollowUrl = "unfollow/" . $follUser->following_user->id )
                    <a href='{{ url($unfollowUrl) }}' class="btn btn-primary following-btn" style="border-radius: 23px;">Following</a>
                </div>
            </div>
        @endforeach
        
        
    </div>

    <div class="col-md-4">
    </div>


    <div class="modal fade" id="tweet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="post_form" action="{{ url('posts') }}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="exampleModalLabel">Tweet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <textarea class="form-control" name="post_content" id="post_content" placeholder="What's Happening?"></textarea>
                            <span id="post_content_error" class="text-danger"></span>
                        </div>

                        <div class="form-group required">
                            <div class="row">
                                <div class="col-md-5">

                                    <div class="form-control-static">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new img-thumbnail" style="width: 210px;">
                                                
                                                    <img src="{{ url('img/default.png') }}"
                                                        alt="No Photo">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists img-thumbnail"
                                                style="width: 210px;"></div>
                                            <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">
                                                    <input type="file" name="image" value="upload"
                                                        data-buttonText="<?= trans('choose_file') ?>"
                                                        id="photo"/>
                                                    <span class="fileinput-exists">Change</span>
                                                </span>
                                                <a href="#" class="btn btn-default fileinput-exists"
                                                data-dismiss="fileinput">Remove</a>
                                            </span>
                                            </div>
                                            <span class="text-danger" id="file_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tweet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('script')

    <script>
        $(function() {
            $('#post_form').submit(function(e) {
                e.preventDefault();
                
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('post_content', $('#post_content').val());
                formData.append('file', $('#photo')[0].files[0]);

                $.ajax({
                    url: "{{ url('posts') }}",
                    method: 'post',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        window.location.href = "{{ url('home') }}";
                    },
                    error: function (errors) {
                        console.log(errors.responseJSON);
                        $.each(errors.responseJSON.errors, function (key, error) {
                            console.log(key);
                            $('#' + key + '_error').text(error[0]);
                        });
                    }
                });
            });

            $( ".following-btn" ).hover(function() {
                $(this).text('Unfollow');
                $( this ).removeClass( "btn-primary" );
                $( this ).addClass( "btn-danger" );
            });

            $( ".following-btn" ).mouseleave(function() {
                $(this).text('Following');
                $( this ).removeClass( "btn-danger" );
                $( this ).addClass( "btn-primary" );
            });
        });
        
    </script>

@endsection
