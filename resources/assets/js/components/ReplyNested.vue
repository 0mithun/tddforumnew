<template>
    <div :id="'reply-'+id"  class="panel panel-default nested-reply">
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

                <div v-if="signedIn" class="col-md-2">
                    <div class="pull-left" v-if="!authorize('owns', reply)">
                        <div class="dropdown">
                            <button class="btn btn-light btn-xs  dropdown-toggle" type="button" data-toggle="dropdown" :disabled=reply.owner.isReported><span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" @click="reportUser" >Report User  <span class="text-danger glyphicon glyphicon-flag"></span> </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="pull-right">
                        <favorite :reply="reply" type="xs"></favorite>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body reply-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea name="body" id="body" cols="30" rows="2" class="form-control" v-model="body" @keyup="bodyEditing"></textarea>
                    </div>
                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>
            <div v-if="report" style="margin-top: 10px;">
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

        <div class="panel-footer level reply-footer" >
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

    import 'jquery.caret';
    import 'at.js';

    export default {
        props: ['reply'],

        components: { Favorite, Editor, Report, NestedReply},

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
                nestedReplies: []
            };
        },
        mounted(){
            $('#body').atwho({
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
            ago() {
                return  moment(this.reply.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow() + '...';
            },
            signedIn(){
                return  (window.App.user)? true : false;
            },
        },

        created () {
            //this.loadNestedReply();
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });

        },


        methods: {
            bodyEditing(){
                $('#body').atwho({
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
              //this.userReport = true;
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
                //delete = ;
                if(confirm('Are you sure delete this reply')){
                    axios.delete('/replies/' + this.id);
                    eventBus.$emit('deleteNested', this.id);
                }

            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
