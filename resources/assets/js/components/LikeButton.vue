<template>
    <div class="btn-group btn-group-xs pull-right" role="group" >
        <button class="btn btn-xs btn-default ml-a  " @click="toggle"  >
            <span class="glyphicon glyphicon-thumbs-up like-icon" :class="classes">&nbsp;{{ likesCount }}</span>
        </button>
        <button class="btn btn-xs btn-default ml-a  " @click="toggle"  >
            <span class="glyphicon glyphicon-thumbs-down like-icon"> 52</span>
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
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint).then((res)=>{
                    console.log(res)
                    this.active = true;
                    flash('You are successfully favorite this thread','success')
                    this.count++;
                });



            },

            destroy() {
                axios.delete(this.endpoint).then((res)=>{
                    console.log(res)
                    this.active = false;
                    flash('You are successfully un favorite this thread','success')
                    this.count--;
                });


            }

        }
    }
</script>