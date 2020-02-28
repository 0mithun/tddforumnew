{{-- Editing the question. --}}

<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <h3 class="flex">Edit Thread:  <span  v-text="title"></span> </h3>
        </div>
    </div>

    <div class="panel-body">
        <div class="form-group " >
            <label for="input">Channel:</label>
            <input id="input" class="form-control" type="text" placeholder="Enter channel name" v-model="defaultChannel" >
            <typeahead v-model="typeChannelId" target="#input" :data="channels" item-key="name" force-select/>
         </div>



        <div class="form-group">
            <label for="title" class="control-label">Title:</label>
            <input type="text" id="title" class="form-control" v-model="form.title">
        </div>

        <div class="form-group">
            <label for="tags" class="control-label">
               Tags
            </label>
            <v-select  v-model="tags" :options="allTags" label="name" multiple></v-select>
        </div>
        <div class="form-group">
            <label for="body" class="control-label">Body:</label>
            <editor
                    v-model="form.body"

                    api-key="{{  config('services.tiny.key')  }}}"
                    :init="{
       selector: '#tinyeditor',
             plugins: 'code',
            toolbar: 'formatselect fontsizeselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | code',
             menubar: 'tools',
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name'
       }"
            />

{{--            <wysiwyg v-model="form.body"></wysiwyg>--}}
        </div>

        <div class="form-group">
            <label for="location" class="control-label">Location:</label>
            <input type="text" name="location" id="location" class="form-control" v-model="form.location">
        </div>

        <div class="form-group">
            <label for="source" class="control-label">Source:</label>
            <input type="text" name="source" id="source" class="form-control" v-model="form.source">
        </div>

        <div class="form-group">
            <label for="main_subject" class="control-label">Main Subject:</label>
            <input type="text" name="main_subject" id="main_subject" class="form-control" v-model="form.main_subject">
            <span class="help-block">Who is this story about</span>
        </div>

        <div class="form-group">
            <label for="main_subject" class="control-label">Category:</label>
            <div class="checkbox">
                <label><input type="checkbox" value="1" name="is_famous" :checked="checked()" @change="updateChecked()">Famous</label>
                <span class="help-block">Check this box if the subject is Famous</span>
            </div>
        </div>
        <div class="form-group ">
            <label for="main_subject" class="control-label"> Upload an image </label>

            <input type="file" name="image_path" class="form-control" id="image_path" @change="onFileSelected">

            <div class="checkbox">
                <label><input type="checkbox" value="1" name="allow_image" id="allow_image"> Allow us to choose a Wikimedia Commons image</label>
            </div>
        </div>

    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs level-item" v-show="! editing">Edit</button>
            <button class="btn btn-primary btn-xs level-item" @click="update" :disabled="checkValidation">Update</button>
            <button class="btn btn-xs level-item" @click="resetForm">Cancel</button>

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
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="panel-heading" style="display: block;overflow: hidden;"> <div class="pull-left"><h4  v-text="title"></h4> </div> <div class="pull-right">
                <favorite-thread :thread="{{ $thread }}" v-if="!authorize('owns', thread) && signedIn "></favorite-thread>
            </div> </div>
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
                <h4 class="media-heading thread-info">
                    Posted by: <a href="/threads?by={{ $thread->creator->username  }}">{{ $thread->creator->name }}</a>
                    {{ $thread->created_at->diffForHumans()  }}
                </h4>
                <div>
                    @foreach($thread->tags as $tag)
                        <span> <a href="{{ route('tags.threads.list', $tag->name)  }}">{{ $tag->name  }}</a> </span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="panel-body" v-html="body"></div>



    <div v-if="report" class="panel-body">
        <div class="form-group">
            <label for="report_reason">Reason for report the thread:</label>
            <textarea name="report_reason" id="report_reason"  v-model="report_reason" cols="30" rows="2" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-xs btn-primary mr-1" @click="makeReport">Make Report</button>
            <button class="btn btn-xs btn-danger mr-1 red-bg" @click="report = false">Cancel</button>
        </div>
    </div>


    <div class="panel-footer">

        <div class="row">
            <div class=" col-md-12"  v-if="authorize('owns', thread)">
                <button class="btn btn-xs" @click="startEdit">Edit</button>
            </div>
            <div class="col-md-12" v-else>
                <div v-if=signedIn >
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group btn-group-xs pull-right" role="group" >
                            <like-button :thread="{{ $thread }}"></like-button>
{{--                            <button class="btn btn-xs btn-default ml-a  " @click="like" v-if="!report" :disabled=thread.isReported >--}}
{{--                                <span class="glyphicon glyphicon-thumbs-up like-icon"> 300</span>--}}
{{--                            </button>--}}
{{--                            <button class="btn btn-xs btn-default ml-a  " @click="like" v-if="!report" :disabled=thread.isReported >--}}
{{--                                <span class="glyphicon glyphicon-thumbs-down like-icon"> 52</span>--}}
{{--                            </button>--}}

                            <button data-toggle="tooltip" title="Report Thread" class="btn btn-xs btn-danger ml-a red-bg pull-right" @click="reportReply" v-if="!report" :disabled=thread.isReported  data-placement="left">
                                <span class="glyphicon glyphicon-flag"></span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

