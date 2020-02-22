@extends('layouts.app')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact Us</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('contactadmin') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }}">
                                <label for="from" class="col-md-3 control-label">From</label>

                                <div class="col-md-9">
                                    <input id="from" type="text" class="form-control" name="from" value="{{ old('from') }}"  autofocus>

                                    @if ($errors->has('from'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('from') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="subject" class="col-md-3 control-label">Subject</label>

                                <div class="col-md-9">
                                    <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}" >

                                    @if ($errors->has('subject'))
                                        <span class="help-block ">
                                        <strong class="">{{ $errors->first('subject') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="subject" class="col-md-3 control-label">Body</label>

                                <div class="col-md-9">
                                    <textarea name="body" id="body" cols="30" rows="10">{{ old('body') }}</textarea>



                                    @if ($errors->has('body'))
                                        <span class="help-block ">
                                        <strong class="">{{ $errors->first('body') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group  {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} recaptcha" style="margin-bottom: 40px">
                                <div class="col-md-9 col-md-offset-3">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site')  }}">

                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block ">
                                        <strong class="">{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
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
    <script>
        tinymce.init({
            selector: '#body',
            plugins: 'code',
            height : "400",
            toolbar: 'formatselect fontsizeselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | code',
            menubar: 'tools',


            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>


@endsection