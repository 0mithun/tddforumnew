@extends('layouts.app')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Post a New Anecdote</div>

                    <div class="panel-body">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel:</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>

                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
{{--                                <wysiwyg name="body"></wysiwyg>--}}
{{--                                <Editor api-key="config('tiny.api_key')"--}}
{{--                                        :init="{--}}
{{--                                             height: 200,--}}
{{--                                             menubar: false,--}}
{{--                                             plugins: [--}}
{{--                                               'advlist autolink lists link image charmap print preview anchor',--}}
{{--                                               'searchreplace visualblocks code fullscreen',--}}
{{--                                               'insertdatetime media table paste code help wordcount'--}}
{{--                                             ],--}}
{{--                                             toolbar:--}}
{{--                                               'undo redo | formatselect | bold italic backcolor | \--}}
{{--                                               alignleft aligncenter alignright alignjustify code'--}}
{{--                                           }"--}}

{{--                                ></Editor>--}}
                                <textarea name="body" id="tinyeditor" cols="30" rows="10"></textarea>
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
                                    <label><input type="checkbox" value="" name="is_famous">Famous</label>
                                    <span class="help-block">Check this box if the subject is Famous</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="main_subject" class="control-label"> Upload an image </label>


                                <div class="checkbox">
                                    <label><input type="checkbox" value="" name=""> Allow us to choose a Wikimedia Commons image</label>
                                </div>

                                <input type="file" name="image_path" class="form-control">
                            </div>


                            <div class="form-group ">
                                <div class="g-recaptcha recaptcha" data-sitekey="{{ config('services.recaptcha.site')  }}"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if (count($errors))
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
