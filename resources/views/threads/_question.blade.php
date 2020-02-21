{{-- Editing the question. --}}

<div class="panel panel-default" >
    <div class="panel-heading">
        <div class="level">
            <h3 class="flex">Edit Thread:  <span ></span> </h3>
        </div>
    </div>

    <div class="panel-body">
        <input type="text" name="search_channel" id="search_channel"  class="form-control " autocomplete="off" placeholder="Type Channel Name" />
        <input type="hidden" name="channel_id" value="" id="channel_id" class="form-control" value="halar po hala">

        <div class="form-group">
            <label for="title" class="control-label">Title:</label>
            <input type="text" id="title" class="form-control" >
        </div>
        <div class="form-group">
            <label for="body" class="control-label">Body:</label>
            <textarea name="body" id="body" class="form-control"></textarea>
{{--            <wysiwyg v-model="form.body"></wysiwyg>--}}
        </div>

        <div class="form-group">
            <label for="location" class="control-label">Location:</label>
            <input type="text" name="location" id="location" class="form-control" >
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

    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs level-item" >Edit</button>
            <button class="btn btn-primary btn-xs level-item">Update</button>
            <button class="btn btn-xs level-item" >Cancel</button>

            @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan

        </div>
    </div>
</div>


{{-- Viewing the question. --}}
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-heading"><h3 class="flex" ></h3></div>
        <div class="media">
            <div class="media-left">

                <a href="#">
                    <img src="{{ asset($thread->creator->avatar_path) }}"
                         alt="{{ $thread->creator->name }}"
                         width="25"
                         height="25"
                         class="mr-1 avatar-photo">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    Posted by: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    {{ $thread->created_at->diffForHumans()  }}
                </h4>

            </div>
        </div>
    </div>

    <div class="panel-body" ></div>

    <div class="panel-footer">
        <button class="btn btn-xs">Edit</button>
    </div>
</div>

@section('footer_section')

    @endsection