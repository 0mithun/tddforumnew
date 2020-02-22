<template>
    <div>
        <div v-if="signedIn" style="border-top:1px solid #333">
            <h3>Add New Reply</h3>
            <div class="form-group">
                <textarea name="nameeee" id="boddd" cols="30" rows="10" class="form-control"></textarea>
                <editor
                        @onKeyUp="typeReply"
                        class="at-who"
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
            Editor,
        },

        mounted() {
            let body =$('.mce-content-body ').text()
            console.log(body)
            $('#boddd').atwho({
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
            typeReply(e){
                console.log(e)
            },
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
