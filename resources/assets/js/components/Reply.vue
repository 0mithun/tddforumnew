<template>
    <div :id="'reply-'+id"  class="panel panel-default panel-no-margin ">
        <div class="panel-heading reply-heading">
            <div class="level">
                <h5 class="flex">
                    <img :src="reply.owner.profileAvatarPath"
                         alt=""
                         width="25"
                         height="25"
                         class="mr-1 avatar-photo">
                    <a :href="reply.ownerThreadUrl"
                        v-text="reply.owner.name">
                    </a>
                    said <span v-text="ago"></span>
                </h5>

<!--                <div class="media">-->
<!--                    <div class="media-left">-->

<!--                        <a href="#">-->
<!--                            <img src="{{ asset($thread->creator->avatar_path) }}"-->
<!--                                 alt="{{ $thread->creator->name }}"-->
<!--                                 width="25"-->
<!--                                 height="25"-->
<!--                                 class="mr-1 avatar-photo">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="media-body">-->
<!--                        <h4 class="media-heading thread-info">-->
<!--                            Posted by: <a href="{{ route('profile', $thread->creator->username) }}">{{ $thread->creator->name }}</a>-->
<!--                            {{ $thread->created_at->diffForHumans()  }}-->
<!--                        </h4>-->



<!--                    </div>-->
<!--                </div>-->

                <div v-if="signedIn" class="col-md-2">
                    <div class="pull-left" v-if="!authorize('owns', reply)">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm  dropdown-toggle" type="button" data-toggle="dropdown" :disabled=reply.owner.isReported><span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" @click="reportUser" >Report User  <span class="text-danger glyphicon glyphicon-flag"></span> </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="pull-right">
                        <favorite :reply="reply" type="sm"></favorite>
                    </div>
<!--                    <report :reply="reply"></report>-->
                </div>
            </div>
        </div>

        <div class="panel-body reply-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea name="body" id="bodyedit" cols="30" rows="3" class="form-control" v-model="body" @keyup="bodyChange"></textarea>
                    </div>
                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>


            <div class="" style="margin-top: 10px" >
                <div class="col-md-1 no-margin" v-if="nestedReplyCount >0">
                    <button class="btn btn-default btn-xs" @click="showNested = !showNested">
                        <span class="caret"></span>
                    </button>
                </div>

                <div class="div" v-else>
                    <NestedReply v-if="addNested" :reply="reply"></NestedReply>
                    <div v-if="signedIn">

                        <button class="btn btn-xs mr-1 btn-default" @click="addNestedReply" v-if="!addNested">Reply</button>
                    </div>
                </div>
                <div class="col-md-11 no-margin" v-if="showNested">
                    <ReplyNested v-for="(nestedReply, index) in nestedReplies" :reply="nestedReply" :key="index"></ReplyNested>
                    <NestedReply v-if="addNested" :reply="reply"></NestedReply>
                    <div class="col-md-12 no-margin" >
                        <div v-if="signedIn">
                            <button class="btn btn-xs mr-1 btn-default" @click="addNestedReply" v-if="!addNested">Reply</button>
                        </div>
                    </div>
                </div>


            </div>

            <div v-if="report" style="margin-top: 10px;overflow: hidden;display:block;width:100%">
                <div class="form-group">
                    <label for="report_reason">Reason for report the reply:</label>
                    <textarea name="report_reason" id="report_reason" cols="30" rows="2" v-model="report_reason" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-xs btn-primary mr-1" @click="makeReport">Make Report</button>
                    <button class="btn btn-xs btn-danger mr-1 red-bg" @click="report = false">Cancel</button>
                </div>
            </div>
        </div>

        <div class="panel-footer level reply-footer reply-footer" >
            <div class="col-md-12" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
                <div v-if="authorize('owns', reply)">
                    <button class="btn btn-xs mr-1" @click="editing = true" v-if="! editing">Edit</button>
                    <button class="btn btn-xs btn-danger red-bg mr-1" @click="destroy">Delete</button>
                </div>

            </div>
<!--            <div class="col-md-12" v-else>-->
<!--                <div v-if="signedIn">-->
<!--                    <button class="btn btn-xs mr-1 btn-default" @click="addNestedReply" v-if="!addNested">Reply</button>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div  class="col-md-12" v-if="!authorize('owns', reply)">-->
            <div  class="col-md-12" v-if=signedIn>
                <button class="btn btn-xs btn-danger ml-a red-bg pull-right" @click="reportReply" v-if="!report" :disabled=reply.isReported >
                    <span class="glyphicon glyphicon-flag"></span>
                </button>
            </div>

<!--            <button class="btn btn-xs btn-default ml-a" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>-->
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Report from './Report'
    import moment from 'moment';
    import Editor from '@tinymce/tinymce-vue'
    import NestedReply from './NestedReply'
    import ReplyNested from  './ReplyNested.vue'

    import 'jquery.caret';
    import 'at.js';

    export default {
        props: ['reply'],

        components: { Favorite, Editor, Report, NestedReply,ReplyNested},

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
                report: false,
                report_reason: '',
                report_user_reason: '',
                addNested: false,
                nestedReplies: [],
                showNested: false,
            };
        },
        mounted(){
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
        },


        computed: {
            nestedReplyCount(){
              return this.nestedReplies.length;
            },
            ago() {
                return  moment(this.reply.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow() + '...';
            },
            signedIn(){
                return  (window.App.user)? true : false;
            },
        },

        created () {
            this.loadNestedReply();
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
            eventBus.$on('cancelAddReply',()=>{
                this.addNested = false;
                console.log('cancel')
            });

            eventBus.$on('addNestedReply',data=>{
                this.loadNestedReply();
                this.addNested = false;
                flash('Your reply has been posted.');
            });


            eventBus.$on('deleteNested',(id)=>{
                let newData = this.nestedReplies.filter(item=>{
                    return item.id !=id;
                });
                this.nestedReplies = newData;
                flash('Your reply has been deleted.');
            });

        },


        methods: {
            bodyChange(){
                console.log('editing')
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
            },
            loadNestedReply(){
              let url = `/replies/${this.reply.id}/load-reply`;
                axios.get(url).then(({data})=>{
                    // console.log(data)
                    this.nestedReplies = data
                });
            },
            addNestedReply(){
                this.addNested = true;
            },
            reportReply(){
                this.report = true;
            },
            makeReport(){
                axios.post('/replies/' + this.id + '/report',{
                    reason:this.report_reason
                }).then((res=>{
                    this.report = false;
                    flash('Your have successfully report to this reply','success')
                }));
            },
            reportUser(){
                axios.post('/api/users/report',{
                    user_id: this.reply.owner.id
                }).then((res=>{
                    flash('Your have successfully report to this user','success')
                }));
            },

            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                if(confirm('Are you sure delete this reply')){
                    axios.delete('/replies/' + this.id);
                    this.$emit('deleted', this.id);
                }

            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');
                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
