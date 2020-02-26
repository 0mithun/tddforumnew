@extends('layouts.app')

@section ('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Post a New Anecdote</div>

                    <div class="panel-body">
                        <form method="POST" action="/threads" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('channel_id') ? ' has-error' : '' }}" >
{{--                                <Typhaed></Typhaed>--}}
                                <label for="search_channel">Channel: </label>
                                <input type="text" name="channel" id="channel" id="search_channel" class="form-control " autocomplete="off" placeholder="Type Channel Name" />
                                <input type="hidden" name="channel_id" value="" id="channel_id" class="form-control">
                                @if ($errors->has('channel_id'))
                                    <span class="help-block ">
                                        <strong class="">{{ $errors->first('channel_id') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group  {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}" >
                                @if ($errors->has('title'))
                                    <span class="help-block ">
                                        <strong class="">{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('tags') ? ' has-error' : '' }}">
                                <label for="tags" class="control-label">Tags: </label>
                                <select class="form-control  " id="tags" name="tags[]" multiple="multiple">
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id  }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tags'))
                                    <span class="help-block ">
                                        <strong class="">{{ $errors->first('tags') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group  {{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body ">Body:</label>
{{--                                <wysiwyg name="body"></wysiwyg>--}}
                                <textarea name="body" id="tinyeditor" cols="30" rows="10"></textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block ">
                                        <strong class="">{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="location" class="control-label">Location:</label>
                                <input type="text" name="location" id="location" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="source" class="control-label">Source:</label>
                                <input type="text" name="source" id="source" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="main_subject" class="control-label">Main Subject:</label>
                                <input type="text" name="main_subject" id="main_subject" class="form-control">
                                <span class="help-block">Who is this story about</span>
                            </div>

                            <div class="form-group">
                                <label for="main_subject" class="control-label">Category:</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" value="1" name="is_famous">Famous</label>
                                    <span class="help-block">Check this box if the subject is Famous</span>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="main_subject" class="control-label"> Upload an image </label>

                                <input type="file" name="image_path" class="form-control" id="image_path">

                                <div class="checkbox">
                                    <label><input type="checkbox" value="1" name="allow_image" id="allow_image"> Allow us to choose a Wikimedia Commons image</label>
                                </div>


                            </div>

                            <div class="form-group  {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} recaptcha" style="margin-bottom: 40px">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site')  }}">

                                </div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block ">
                                        <strong class="">{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        tinymce.init({
            selector: '#tinyeditor',
            plugins: 'code',
            toolbar: 'formatselect fontsizeselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | code',
            menubar: 'tools',


            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>


    <script type="text/javascript">
        (function($) {
            $(document).ready(function () {
                $("#image_path").change(function (){
                    var fileName = $(this).val();
                    console.log('file Selected');
                    $('#allow_image').attr('disabled', true);
                });


            });
        })(jQuery);
    </script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#channel').typeahead({
                afterSelect(item){
                    console.log(item.id)
                    $('#channel_id').val(item.id);
                },
                source: function(query, result)
                {
                    $.ajax({
                        url: "{{ route('chanel.search')  }}",
                        method:"POST",
                        data:{
                            query:query
                        },
                        dataType:"json",
                        success:function(data)
                        {
                            result($.map(data, function(item){
                                return item;
                            }));
                        }
                    })
                }
            });


            $(document).ready(function() {
                $('#tags').select2({
                    placeholder: 'Select tags',
                    cache:true
                });
            });
        });
    </script>

@endsection