<template>
    <div :id="'reply-'+id"  class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + reply.owner.name"
                        v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
<!--                    <report :reply="reply"></report>-->
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">

                        <select name="body" cllass="form-control" id="tinyeditor">hello</select>

                        <editor
                                v-model="body"
                                api-key="l1vdc832pqx5u7o6t5umdpxns0sak10bu9mrtb0m1qbspk9g"
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


                    </div>

                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>

            <hr>
            <div v-if="report">
                <div class="form-group">
                    <label for="report_reason">Reason for report:</label>

                    <editor
                            v-model="report_reason"
                            api-key="l1vdc832pqx5u7o6t5umdpxns0sak10bu9mrtb0m1qbspk9g"
                            :init="{
                                   selector: '#report_reason',
                                        plugins: 'code',
                                        toolbar: 'formatselect fontsizeselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | code',
                                         menubar: 'tools',
                                        toolbar_drawer: 'floating',
                                        tinycomments_mode: 'embedded',
                                        tinycomments_author: 'Author name'
                                   }"
                    />
                </div>

                <div class="form-group">
                    <button class="btn btn-xs btn-primary mr-1" @click="makeReport">Make Report</button>
                    <button class="btn btn-xs btn-danger mr-1 red-bg" @click="report = false">Cancel</button>
                </div>

            </div>
        </div>

        <div class="panel-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-xs mr-1" @click="editing = true" v-if="! editing">Edit</button>
                <button class="btn btn-xs btn-danger red-bg mr-1" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-xs btn-danger ml-a red-bg" @click="reportReply" v-if="!report">
                <span class="glyphicon glyphicon-ban-circle
"></span>
            </button>
<!--            <button class="btn btn-xs btn-default ml-a" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>-->
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Report from './Report'
    import moment from 'moment';
    import Editor from '@tinymce/tinymce-vue'
    export default {
        props: ['reply'],

        components: { Favorite, Editor, Report },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
                report: false,
                report_reason: ''
            };
        },


        computed: {
            ago() {
                return  moment(this.reply.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow() + '...';
            }
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            reportReply(){
                this.report = true;
            },
            makeReport(){
                axios.post('/replies/' + this.id + '/report').then((res=>{
                    console.log(res);
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
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
