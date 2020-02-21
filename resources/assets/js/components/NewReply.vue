<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
<!--                <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>-->
<!--                <TinyEditor :model="reply_body"></TinyEditor>-->
<!--                <textarea name="body" id="tinyeditor" cols="30" rows="10"></textarea>-->
                <tinymce id="d1"
                         :other_options="tinyOptions"
                         v-model="body"
                ></tinymce>
            </div>


            <button type="submit"
                    class="btn btn-default"
                    @click="addReply">Post</button>
        </div>

        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this
            discussion.
        </p>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';
    import Editor from '@tinymce/tinymce-vue'

    import Wysiwyg from './Wysiwyg';

    import  TinyEditor from './TinyEditor'
    import tinymce from 'vue-tinymce-editor'

    export default {
        data() {
            return {
                body: '',
                completed: false,
                tinyOptions:{
                    plugins: 'codesample code',
                    codesample_languages: [
                        {text: 'HTML/XML', value: 'markup'},
                        {text: 'CSS', value: 'css'},
                    ],
                    toolbar: 'codesample code',
                }
            };
        },
        components:{
            Wysiwyg,
            TinyEditor,
            Editor,
            tinymce
        },

        mounted() {
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

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
