<template>
    <div class="btn-group btn-group-xs pull-right" role="group" >
        <button class="btn btn-xs btn-default ml-a  " @click="toggleLike"  >
            <span class="glyphicon glyphicon-thumbs-up like-icon" :class="classes">&nbsp;{{ likesCount }}</span>
        </button>
        <button class="btn btn-xs btn-default ml-a  " @click="toggleDislike"  >
            <span class="glyphicon glyphicon-thumbs-down like-icon"> {{ dislikesCount }}</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            thread:{
                type:Object
            }
        },


        data() {
            return {
                active:  this.thread.isLiked,
                likesCount:this.thread.likesCount,
                dislikesCount:this.thread.dislikesCount
            }
        },

        computed: {
            classes() {
                return [
                    this.active ? 'blue-icon' : 'black-icon'
                ];
            },

            endpoint() {
                return '/thread/' + this.thread.id + '/likes';
            }

        },

        methods: {
            toggle(type) {
                this.active ? this.destroy(type) : this.create(type);
            },

            toggleDislike(){
                axios.post('/thread/' + this.thread.id + '/dislikes').then((res)=>{
                    console.log(res)
                    //this.active = true;
                   // flash('You are successfully favorite this thread','success')
                    //this.count++;
                });
            },
            toggleLike(){
                axios.post('/thread/' + this.thread.id + '/likes').then((res)=>{
                    console.log(res)
                    //this.active = true;
                   // flash('You are successfully favorite this thread','success')
                    //this.count++;
                });
            },

            create(type) {
                axios.post(this.endpoint,{
                    type
                }).then((res)=>{
                    console.log(res)
                    this.active = true;
                    flash('You are successfully favorite this thread','success')
                    this.count++;
                });



            },

            destroy(type) {
                axios.delete(this.endpoint,{
                    type
                }).then((res)=>{

                    console.log(res)
                    this.active = false;
                    flash('You are successfully un favorite this thread','success')
                    this.count--;
                });


            }

        }
    }
</script>