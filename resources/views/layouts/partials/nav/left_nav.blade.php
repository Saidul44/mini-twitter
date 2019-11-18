<nav class="nav flex-column ml-3">
  <a class="nav-link" style="color: rgba(29,161,242,1.00)" href="#"><i class="fa fa-twitter" style="font-size: 1.5em;"></i></a>
  <a class="nav-link active" href="#"><i class="fa fa-home"></i>&nbsp; Home</a>
  <a class="nav-link" href="#"><i class="fa fa-hashtag"></i>&nbsp; Explore</a>
  <a class="nav-link" href="#"><i class="fa fa-bell-o"></i>&nbsp; Notifications</a>
  <a class="nav-link" href="#"><i class="fa fa-envelope-o"></i>&nbsp; Messages</a>
  <a class="nav-link" href="#"><i class="fa fa-bookmark-o"></i>&nbsp; Bookmarks</a>
  <a class="nav-link" href="#"><i class="fa fa-list"></i>&nbsp; List</a>
  <a class="nav-link" href="#"><i class="fa fa-user-o"></i>&nbsp; Profile</a>
  <a class="nav-link" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off"></i>&nbsp; Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  </a>
</nav>

<div class="col-md-10 text-center mt-2">
  <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#tweet" style="border-radius: 23px;">Tweet</button>
</div>