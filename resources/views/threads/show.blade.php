@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include ('threads._question')
<<<<<<< HEAD
=======
                    <hr>
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
>>>>>>> dev
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                            </p>
<<<<<<< HEAD
=======

>>>>>>> dev
                            <p>
                                <button class="btn btn-default"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
<<<<<<< HEAD

=======
@section('footer_script')

    <script>
        tinymce.init({
            selector: '#tinyeditor',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('#bodyedit').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });

            $('#tags').select2({
                placeholder: 'Select tags',
                cache:true
            });
        })
    </script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    @endsection
>>>>>>> dev
