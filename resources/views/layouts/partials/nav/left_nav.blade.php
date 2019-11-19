<nav class="nav flex-column ml-3">
  <a class="nav-link" style="color: rgba(29,161,242,1.00)" href="{{ url('/') }}"><i class="fa fa-twitter" style="font-size: 1.5em;"></i></a>
  @if(! Auth::check())
    <a class="nav-link" href="{{ url('login') }}"><i class="fa fa-sign-in"></i>&nbsp; Log in</a>
    <a class="nav-link" href="{{ url('register') }}"><i class="fa fa-sign-out"></i>&nbsp; Sign up</a>
  @endif

  @if(Auth::check())
    <a class="nav-link" href="{{ url('home') }}"><i class="fa fa-home"></i>&nbsp; Home</a>
    <!-- <a class="nav-link" href="#"><i class="fa fa-hashtag"></i>&nbsp; Explore</a>
    <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>&nbsp; Notifications</a>
    <a class="nav-link" href="#"><i class="fa fa-envelope-o"></i>&nbsp; Messages</a>
    <a class="nav-link" href="#"><i class="fa fa-bookmark-o"></i>&nbsp; Bookmarks</a>
    <a class="nav-link" href="#"><i class="fa fa-list"></i>&nbsp; List</a> -->
    
    @if(Auth::user()->profile_photo)
    @php( $imageUrl = "user_images/" . Auth::user()->profile_photo )
    <a class="nav-link" href="{{ url(Auth::user()->username) }}">
      <img src='{{ asset("$imageUrl") }}' width="25px" height="25px" alt="..." class="rounded-circle">&nbsp; Profile
    </a>
    @else
    <a class="nav-link" href="{{ url(Auth::user()->username) }}">
      <img src='{{ asset("img/user-photo.png") }}' width="25px" height="25px" alt="..." class="rounded-circle">&nbsp; Profile
    </a>
    @endif

    <a class="nav-link" href="{{ url('settings') }}"><i class="fa fa-cog"></i>&nbsp; Settings</a>

    <a class="nav-link" href="{{ route('logout') }}"
          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
          <i class="fa fa-power-off"></i>&nbsp; Logout
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </a>
  @endif
</nav>

@if(Auth::check())
  <div class="col-md-10 text-center mt-2">
    <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#tweet" style="border-radius: 23px;">Tweet</button>
  </div>
@endif