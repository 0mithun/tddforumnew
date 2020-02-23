<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['thread','channel'],
        data(){
            return{
                active: true
            }
        },
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-danger' : 'btn-default'];
            }
        },

        methods: {
            subscribe() {
                let url = `/threads/${this.channel}/${this.thread}/subscriptions`;
                console.log(url);
                axios[
                    (this.active ? 'delete' : 'post')
                ](url);

                this.active = ! this.active;
            }
        }
    }
</script>
