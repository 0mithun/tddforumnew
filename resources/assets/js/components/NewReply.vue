+<template>
    <div>
        <div v-if="signedIn" >
            <h3>Add New Reply</h3>
            <div class="form-group">
<<<<<<< HEAD
                <editor
                        v-model="body"

                        api-key="l1vdc832pqx5u7o6t5umdpxns0sak10bu9mrtb0m1qbspk9g"
                        :init="{
                       selector: '#tinyeditor',
                            plugins: 'a11ychecker advcode casechange formatpainter linkchecker lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
                            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
                            toolbar_drawer: 'floating',
                            tinycomments_mode: 'embedded',
                            tinycomments_author: 'Author name'
                       }"
                />
=======
                <textarea name="body" id="body" cols="30" rows="3" class="form-control" v-model="body"></textarea>
>>>>>>> dev
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
<<<<<<< HEAD

=======
    import Editor from '@tinymce/tinymce-vue'
>>>>>>> dev

    export default {
        data() {
            return {
                body: '',
                completed: false,
            };
        },
<<<<<<< HEAD
        components:{
            TinyEditor
        },
=======
>>>>>>> dev

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                            console.log('Hello')
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
