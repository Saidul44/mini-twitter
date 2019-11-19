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