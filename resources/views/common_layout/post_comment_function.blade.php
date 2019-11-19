
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
        });

        
        @if(Auth::check())
            @php( $imageUrl = "user_images/" . Auth::user()->profile_photo )
        @else
            @php( $imageUrl = "user_images/user-photo.png")
        @endif

        var user_img = '{{ asset("$imageUrl") }}';
        var login_url = "{{ url('login') }}";
        var auth_id = '{{ Auth::id() }}';

        @if(Auth::check())
        var auth_check = 1;
        @else
        var auth_check = 0;
        @endif

        $(document).on('keyup', ".input_key",function () {
            var input_id = $(this).prop('id');
            if(input_id != 'search_input') {
                if(! auth_check) {
                $(this).val('');
                swal({
                    title: "Warning!",
                    text: 'You must have to login first to comment or reply',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: 'Login',
                    closeOnConfirm: false
                },
                function(){
                    window.location.href = login_url;
                });
                }
            }
        });

        // $(document).on('keyup', "input[type='text']",function () {
        //     var input_id = $(this).prop('id');
        //     if(input_id != 'search_input') {
        //         if(! auth_check) {
        //         $(this).val('');
        //         swal({
        //             title: "Warning!",
        //             text: 'You must have to login first to comment or reply',
        //             type: "warning",
        //             showCancelButton: true,
        //             confirmButtonColor: "#DD6B55",
        //             confirmButtonText: 'Login',
        //             closeOnConfirm: false
        //         },
        //         function(){
        //             window.location.href = login_url;
        //         });
        //         }
        //     }
        // });

        @if(! Auth::check())
            $(function() {
                $('#tweet-btn').click(function() {
                    swal({
                        title: "Warning!",
                        text: 'You must have to login first to post',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: 'Login',
                        closeOnConfirm: false
                    },
                    function(){
                        window.location.href = login_url;
                    });
                });
            });
        @endif

        function edit_comment(e, comment_id) {
        e.preventDefault();

        if($('#edit_comment_'+comment_id).hasClass('in')) {
            return;
        }

        var comment_content = $('#comment_content_'+comment_id).text();

        var comment_reply_input = '<form class="">'+
            '<div class="form-group">'+
            '<div class="input-group">'+
                '<input type="text" value="' + $.trim(comment_content) + '" class="form-control input_key focusedInput" id="edit_comment_content_'+ comment_id +'" placeholder="Write a comment">'+
                '<div class="btn-primary input-group-addon" style="color: #fff; cursor: pointer; background-color: #2579a9;" onclick="edit_comment_submit('+ comment_id +')">Update</div>'+
            '</div>'+
            '</div>'+
        '</form>';

        $('#edit_comment_'+comment_id).append(comment_reply_input);
        
        $('#comment_body_'+comment_id).hide();

        $('#edit_comment_'+comment_id).collapse('show');
        }

        function edit_comment_submit(comment_id) {
        var comment_text = $('#edit_comment_content_'+comment_id).val();
        
        if(comment_text) {
            var url = "{{ url('comments') }}";

            $.ajax({
            url: url + '/' + comment_id,
            method: 'post',
            dataType: 'json',
            data: {
                _method: 'PUT',
                _token: "{{ csrf_token() }}",
                comment: comment_text,
            },
            success: function (response) {

                if(! response.error) {
                $('#comment_content_'+comment_id).text(response.data.comment);
                $('#comment_date_'+comment_id).text(response.data.updated_at);

                $('#edit_comment_'+comment_id).collapse('hide');

                $('#comment_body_'+comment_id).show();
                } else {
                swal({
                    title: "Warning",
                    text: response.msg,
                    type: "warning",
                    confirmButtonText: "OK",
                },
                function (isConfirm) {
                    // location.reload();
                });
                }


            },
            error: function (data) {
                swal({
                    title: "Warning",
                    text: 'Something not right',
                    type: "warning",
                    confirmButtonText: "OK",
                },
                function (isConfirm) {
                    location.reload();
                });
            }
        });
        }
        }

        function delete_comment(e, comment_id) {
        e.preventDefault();

        var url = '{{ url("comment") }}';

        $.ajax({
            url: url+'/'+comment_id,
            method: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                _method: 'DELETE'
            },
            success: function (response) {

                if(! response.error) {
                $('#comment_li_'+ comment_id).remove();
                            
                } else {
                swal({
                    title: "Warning",
                    text: response.msg,
                    type: "warning",
                    confirmButtonText: "OK",
                },
                function (isConfirm) {
                    location.reload();
                });
                }

            },
            error: function (data) {
                swal({
                    title: "Warning",
                    text: 'Something not right',
                    type: "warning",
                    confirmButtonText: "OK",
                },
                function (isConfirm) {
                    location.reload();
                });
            }
        });  
        }

        function comment_reply(e, comment_id, thread_id) {
        e.preventDefault();
        
        if($('#comment_reply_'+comment_id).hasClass('in')) {
            return;
        }

        var comment_reply_input = '<form class="">'+
            '<div class="form-group">'+
            '<div class="input-group">'+
                '<input type="text" class="form-control input_key" id="comment_text_'+ comment_id +'" placeholder="Write a comment">'+
                '<div class="btn-primary input-group-addon" style="cursor: pointer" onclick="reply_submit('+ comment_id +','+ thread_id +')">Submit</div>'+
            '</div>'+
            '</div>'+
        '</form>';

        if($('#reply_'+comment_id).length) {
            if(! $('#reply_'+comment_id).hasClass('in')) {
            load_reply(e, comment_id, thread_id);
            }
        }
        
        $('#comment_reply_'+comment_id).append(comment_reply_input);
        
        $('#comment_reply_'+comment_id).collapse('show');
        }

        function reply_submit(comment_id, thread_id) {
        var comment_text = $('#comment_text_'+comment_id).val();
        
        if(comment_text) {

            $.ajax({
            url: "{{ url('reply_store') }}",
            method: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                comment: comment_text,
                thread_id: thread_id,
                comment_id: comment_id
            },
            success: function (response) {

                if(! response.error) {
                // var reply_comment_text = '<ul class="media-list" id="ul_reply_'+ comment_id +'">'+
                        var reply_comment_text = '<li class="media media-replied" id="comment_li_'+ response.data.id +'">'+
                            '<a class="pull-left" href="#">'+
                            '<img class="media-object rounded-circle" src="'+ user_img +'" alt="profile" width="50px" height="50px">'+
                            '</a>'+
                            '<div class="media-body" id="comment_body_'+ response.data.id +'">'+
                            '<div class="well well-lg">'+
                                '<h4 class="media-heading reviews"><span class="fa fa-share"></span> '+response.data.user_info.name +' </h4>'+
                                '<ul class="media-date text-uppercase reviews list-inline">'+
                                    '<li class="dd" id="comment_date_'+ response.data.id +'">' + response.data.updated_at + '</li>'+
                                '</ul>'+
                                '<p class="media-comment" id="comment_content_'+ response.data.id +'">'+ response.data.comment +'</p>'+
                                '&nbsp; <a href="#" id="reply"  style="font-size: 11px;" onclick="comment_reply(event, '+ response.data.id +','+ response.data.thread_id +')" class="text-muted"><span class="fa fa-share"></span> Reply</a>';
                                if(response.data.count_reply_comment > 0) {
                                    reply_comment_text += '&nbsp; &nbsp;<a onclick="load_reply(event,'+ response.data.id+ ',' + response.data.thread_id +')" class="text-muted" href=""><span class="fa fa-comments-o"></span> '+ response.data.count_reply_comment +' comments</a>';
                                }

                                if(auth_check  && auth_id == response.data.user_id) {
                                    reply_comment_text += '&nbsp;&nbsp;<a href="#" onclick="edit_comment(event, '+ response.data.id +')" class="text-muted"><i class="fa fa-pencil"></i> Edit</a>'+
                                        '&nbsp;&nbsp;<a href="#" onclick="delete_comment(event, '+ response.data.id +')" class="text-muted"><i class="fa fa-trash"></i> Delete</a>';
                                }

                            reply_comment_text += '</div></div>'+

                            '<div class="collapse" id="edit_comment_'+ response.data.id +'"></div>';

                            if(response.data.count_reply_comment > 0) {
                            reply_comment_text += '<div id="reply_'+ response.data.id +'"></div>';
                            }
                        reply_comment_text += '<div class="" id="comment_reply_'+ response.data.id +'"></div>'+

                        '</li>';
                        // '</ul>';

                        console.log(reply_comment_text);
                        if($('#reply_'+comment_id).length) {
                        $('#ul_reply_'+comment_id).append(reply_comment_text);
                        $('#comment_text_'+comment_id).val('');
                        $('#comment_reply_'+comment_id).removeClass('in');
                        $('#comment_reply_'+comment_id).html('');

                        } else {
                        reply_comment_text = '<ul class="media-list" id="ul_reply_'+ response.data.id +'">'+reply_comment_text+'</ul>';
                        $('#comment_reply_'+comment_id).prop('id', 'reply_'+comment_id);
                        
                        $('#reply_'+comment_id).html('');
                        $('#reply_'+comment_id).append(reply_comment_text);
                        $('#reply_'+comment_id).collapse('show');
                        }

                        // $('#comment_text_'+comment_id).val('');
                
                }
            },
            error: function (data) {
                swal({
                    title: "Warning",
                    text: 'Something not right',
                    type: "warning",
                    confirmButtonText: "OK",
                },
                function (isConfirm) {
                    location.reload();
                });
            }
        });
        }
        }

        function load_reply(e, comment_id, thread_id) {
        e.preventDefault();
        
        if($('#reply_'+comment_id).hasClass('in')) {
            $('#reply_'+comment_id).collapse('hide');
            $('#reply_'+comment_id).html('');
        
        } else {

            if(comment_id > 0 && thread_id > 0) {

                $.ajax({
                    url: "{{ url('load_reply') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        comment_id: comment_id,
                        thread_id: thread_id
                    },
                    success: function (response) {

                        if(! response.error) {
                        if(response.data.length > 0) {
                            var reply_comment_text = '<ul class="media-list" id="ul_reply_'+ comment_id +'">';
                                for(var i = 0; i < response.data.length; i++) {

                                reply_comment_text += '<li class="media media-replied" id="comment_li_'+ response.data[i].id +'">'+
                                    '<a class="pull-left" href="#">'+
                                    '<img class="media-object rounded-circle" src="'+ user_img +'" alt="profile" width="50px" height="50px">'+
                                    '</a>'+
                                    '<div class="media-body" id="comment_body_'+ response.data[i].id +'">'+
                                    '<div class="well well-lg">'+
                                        '<h4 class="media-heading reviews"><span class="fa fa-share"></span> '+response.data[i].user_info.name +' </h4>'+
                                        '<ul class="media-date text-uppercase reviews list-inline">'+
                                            '<li class="dd" id="comment_date_'+ response.data[i].id +'">' + response.data[i].updated_at + '</li>'+
                                        '</ul>'+
                                        '<p class="media-comment" id="comment_content_'+ response.data[i].id +'">'+ response.data[i].comment +'</p>'+
                                        '&nbsp; <a href="#" id="reply"  style="font-size: 11px;" onclick="comment_reply(event, '+ response.data[i].id +','+ response.data[i].thread_id +')" class="text-muted"><span class="fa fa-share"></span> Reply</a>';
                                        if(response.data[i].count_reply_comment > 0) {
                                            reply_comment_text += '&nbsp; &nbsp;<a onclick="load_reply(event,'+ response.data[i].id+ ',' + response.data[i].thread_id +')" class="text-muted" href=""><span class="fa fa-comments-o"></span> '+ response.data[i].count_reply_comment +' comments</a>';
                                        }

                                        if(auth_check  && (auth_id == response.data[i].user_id)) {
                                            console.log('opp');
                                            reply_comment_text += '&nbsp;&nbsp;<a href="#" onclick="edit_comment(event, '+ response.data[i].id +')" class="text-muted"><i class="fa fa-pencil"></i> Edit</a>'+
                                                '&nbsp;&nbsp;<a href="#" onclick="delete_comment(event, '+ response.data[i].id +')" class="text-muted"><i class="fa fa-trash"></i> Delete</a>';
                                        }

                                    reply_comment_text += '</div></div>'+
                                        '<div class="collapse" id="edit_comment_'+ response.data[i].id +'"></div>';

                                    if(response.data[i].count_reply_comment > 0) {
                                    reply_comment_text += '<div id="reply_'+ response.data[i].id +'"></div>';
                                    }
                                reply_comment_text += '<div class="" id="comment_reply_'+ response.data[i].id +'"></div>'+

                                '</li>';

                                console.log(reply_comment_text);
                                
                                // $('#reply_'+comment_id).append(reply_comment_text);
                                
                                // reply_comment_text = '';
                            }
                            
                            reply_comment_text += '</ul>';
                            

                            $('#reply_'+comment_id).append(reply_comment_text);
                            $('#reply_'+comment_id).collapse('show');

                        }

                        }
                    },
                    error: function (data) {
                        swal({
                            title: "Warning",
                            text: 'Something not right',
                            type: "warning",
                            confirmButtonText: "OK",
                        },
                        function (isConfirm) {
                            location.reload();
                        });
                    }
                });
            }
        }
        }

        function comment_submit(post_id) {
            var comment_text = $('#comment_text_' + post_id).val();

            if(comment_text && post_id > 0) {
                
                $.ajax({
                    url: "{{ url('comments') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        comment: comment_text,
                        post_id: post_id
                    },
                    success: function (response) {

                    if(! response.error) {
                        var comment_insert_text = '<li class="media" id="comment_li_'+ response.data.id +'">'+
                        '<a class="pull-left" href="#">'+
                            '<img class="media-object rounded-circle" src="'+ user_img +'" alt="profile" width="50px" height="50px">'+
                        '</a>'+
                        '<div class="media-body" id="comment_body_'+ response.data.id +'">'+
                            '<div class="well well-lg">'+
                                '<p class="media-heading reviews">'+ response.data.user_info.name +' </p>'+
                                '<ul class="media-date list-inline">'+
                                '<li class="dd text-muted" id="comment_date_'+ response.data.id +'">'+ response.data.formatted_date +'</li>'+
                                '</ul>'+
                                '<p class="media-comment" id="comment_content_'+ response.data.id +'">' + response.data.comment + '</p>';
                                // '&nbsp; <a href="#" id="reply" style="font-size: 11px;" onclick="comment_reply(event, '+ response.data.id +','+ response.data.post_id +')" class="text-muted"><span class="fa fa-share"></span> Reply</a>';

                                // if(auth_check  && auth_id == response.data.user_id) {
                                //     comment_insert_text += '&nbsp;&nbsp;<a href="#" onclick="edit_comment(event, '+ response.data.id +')" class="text-muted"><i class="fa fa-pencil"></i> Edit</a>'+
                                //         '&nbsp;&nbsp;<a href="#" onclick="delete_comment(event, '+ response.data.id +')" class="text-muted"><i class="fa fa-trash"></i> Delete</a>';
                                // }

                            comment_insert_text += '</div>'+      
                        '</div>'+
                        '<div class="collapse" id="edit_comment_'+ response.data.id +'"></div>'+
                        '<div id="comment_reply_'+ response.data.id +'"></div>'+
                        '</li>';

                        $(comment_insert_text).hide().prependTo('.media-list_' + post_id).slideDown("slow");

                        $('#comment_text_' + post_id).val('');

                    }
                    },
                    error: function (data) {
                    swal({
                            title: "Warning",
                            text: 'Something not right',
                            type: "warning",
                            confirmButtonText: "OK",
                        },
                        function (isConfirm) {
                            location.reload();
                        });
                    }
                });
            }
        }

        function clickComment(postId) {
            $('#post_comment_' + postId).toggle();
        }

        $(function() {
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
