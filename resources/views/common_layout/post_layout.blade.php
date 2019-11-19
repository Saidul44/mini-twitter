@foreach($posts as $key => $post)
    <div class="row border-bottom py-3">

        @php( $usernameUrl = url($post->user->username) )

        <div class="col-md-2 text-center">
            @if($post->user->profile_photo)
                @php( $imageUrl = "user_images/" . $post->user->profile_photo )
                <a href='{{ $usernameUrl }}'><img src='{{ asset("$imageUrl") }}' width="50px" height="50px" alt="..." class="rounded-circle"></a>
            @else
                <img src='{{ asset("img/user-photo.png" ) }}' width="50px" height="50px" alt="..." class="rounded-circle">
            @endif
        </div>
        <div class="col-md-10">
            
            <h5><a href='{{ "$usernameUrl" }}' style="color: #212529;">{{ $post->user->name }} <span class="text-muted" style="font-weight: 300;">{{ '@'.$post->user->username .' . ' .dayBefore($post->created_at) }}</span></a></h5>

            <p>{{ $post->content }}</p>
            
            @if($post->photo)
                <img src='{{ asset("post_images/$post->photo" ) }}' width="100%" height="300px" alt="..." class="rounded">
            @endif
            
            <div class="row mt-3 text-muted">
                <div class="col-md-3" onclick="clickComment('{{ $post->id }}')">
                    <i class="fa fa-comment-o"></i>&nbsp; {{ $post->comments->count() }}
                </div>
                <div class="col-md-3">
                    <i class="fa fa-refresh"></i>&nbsp; 5
                </div>
                <div class="col-md-3">
                    <i class="fa fa-heart-o"></i>&nbsp; 5
                </div>
                <div class="col-md-3">
                    <i class="fa fa-upload"></i>&nbsp; 3
                </div>
            </div>

            <div class="row" id="post_comment_{{ $post->id }}" style="display: none;">
                <div class="col-sm-12 my-3">
                    <form class="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input_key" id="comment_text_{{ $post->id }}" placeholder="Write a comment">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white" id="basic-addon2"style="cursor: pointer" onclick="comment_submit('{{ $post->id }}')">Send</span>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <ul class="media-list_{{ $post->id }}">

                    @foreach($post->comments as $comment_key => $comment)
                        <?php $count_reply_comment = 0; ?>
                        <li class="media mb-2" id="comment_li_{{ $comment->id }}" style="border-bottom: 1px solid #dee2e6;">
                            
                            @php( $usernameUrl = url($comment->user->username) )

                            @if($comment->user->profile_photo)
                                <a class="pull-left" href='{{ "$usernameUrl" }}'>
                                    @php( $imageUrl = "user_images/" . $comment->user->profile_photo )
                                    <img class="media-object rounded-circle" src="{{ $imageUrl }}" alt="profile" width="50px" height="50px">
                                </a>

                            @else
                                <a class="pull-left" href='{{ "$usernameUrl" }}'>
                                    <img src='{{ asset("img/user-photo.png" ) }}' width="50px" height="50px" alt="..." class="rounded-circle">
                                </a>
                            @endif

                            <div class="media-body" id="comment_body_{{ $comment->id }}">
                                <div class="well well-lg">
                                    <p class="media-heading reviews">
                                        <a style="color: #212529;" href='{{ "$usernameUrl" }}'>{{ $comment->user->name }} </a>
                                    </p>
                                    <ul class="media-date list-inline">
                                        <li class="dd text-muted" id="comment_date_{{ $comment->id }}">{{ dayBefore($comment->updated_at) }}</li>
                                    </ul>
                                    <p class="media-comment" id="comment_content_{{ $comment->id }}">
                                    {{ $comment->comment }}
                                    </p>
                                    {{--
                                    &nbsp; <a href="#" id="reply" style="font-size: 11px;" onclick="comment_reply(event, '{{ $comment->id }}',  '{{ $comment->post_id }}')" class="text-muted"><span class="fa fa-share"></span> Reply</a>
                                    @if( $count_reply_comment > 0)
                                    &nbsp; &nbsp;<a onclick="load_reply(event, '{{ $comment->id }}','{{ $comment->post_id }}')" class="text-muted" href="#"><span class="fa fa-comments-o"></span> {{ $count_reply_comment }} comments</a>
                                    @endif
                                    
                                    @if(Auth::check() && (Auth::id() == $comment->user_id))
                                    &nbsp;&nbsp;<a href="#" onclick="edit_comment(event, '{{ $comment->id }}')" class="text-muted"><i class="fa fa-pencil"></i> Edit</a>
                                    &nbsp;&nbsp;<a href="#" onclick="delete_comment(event, '{{ $comment->id }}')" class="text-muted"><i class="fa fa-trash"></i> Delete</a>
                                    @endif --}}
                                </div>              
                            </div>
                            
                            <div class="collapse" id="edit_comment_{{ $comment->id }}">

                            </div>

                            @if($count_reply_comment > 0)
                            <div class="collapse" id="reply_{{ $comment->id }}">
                            
                            </div>
                            @endif
                            <div class="collapse" id="comment_reply_{{ $comment->id }}">

                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach