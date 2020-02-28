<template>
    <div style="margin-top:10px">
        <div v-if="signedIn">
            <h5>Add Reply</h5>
            <div class="form-group">
                <textarea name="body" id="body" cols="30" rows="2" class="form-control" v-model="body"></textarea>
            </div>
            <button type="submit"
                    class="btn btn-xs btn-default"
                    @click="addReply">Reply</button>
            <button type="submit"
                    class="btn btn-xs btn-danger"
                    @click="cancelAddReply">Canel</button>
        </div>

<!--        <p class="text-center" v-else>-->
<!--            Please <a href="/login">sign in</a> to participate in this-->
<!--            discussion.-->
<!--        </p>-->
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        props:['reply'],
        data() {
            return {
                body: '',
                completed: false,
            };
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
            cancelAddReply(){
                eventBus.$emit('cancelAddReply');
            },
            addReply() {
                let url = `/replies/${this.reply.id}/new-reply`;
                axios.post(url, { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;
                        eventBus.$emit('addNestedReply', data);

                    });
            }
        }
    }
</script>