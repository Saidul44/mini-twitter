<div class="col-md-5 mt-2">
    @if(Auth::check())
        <input type="text" class="form-control" placeholder="Search Twitter" style="background: rgb(230, 236, 240); border-radius: 23px; border: 1px solid rgb(230, 236, 240);">

        @if(isset($unfollowingUsers))
            <div class="row border-bottom mt-3 ml-2 pt-3 pb-1 bg-light-blue-custom">
                <div class="col-md-12">
                    <h5 class="">Who to Follow</h5>
                </div>
            </div>
            @foreach($unfollowingUsers as $unfollUser)
                <div class="row border-bottom py-3 ml-2 bg-light-blue-custom">
                    <div class="col-md-3 text-center">
                        @if($unfollUser->profile_photo)
                            @php( $imageUrl = "user_images/" . $unfollUser->profile_photo )
                            <img src='{{ asset("$imageUrl") }}' width="50px" height="50px" alt="..." class="rounded-circle">
                        @else
                            <img src='{{ asset("img/user-photo.png" ) }}' width="50px" height="50px" alt="..." class="rounded-circle">
                        @endif
                    </div>

                    <div class="col-md-5">
                        <h5 class="">{{ $unfollUser->name }}</h5>
                        <h5 class="text-muted" style="font-size: 14px;">{{ '@' . $unfollUser->username }}</h5>
                    </div>

                    <div class="col-md-4 text-right">
                    
                        @php( $followingUrl = "follow/" . $unfollUser->id )
                        <a href="{{ url($followingUrl) }}" class="btn btn-outline-primary" style="border-radius: 23px;">Follow</a>
                        
                    </div>
                </div>
            @endforeach
        @endif
    @endif
</div>