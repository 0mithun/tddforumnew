<template>
    <div class="btn-group btn-group-xs pull-left" role="group" >
        <button class="btn btn-xs btn-default ml-a  " @click="toggleLike"  >
            <span class="glyphicon glyphicon-thumbs-up like-icon" :class="likeClass">&nbsp;{{ likesCount }}</span>
        </button>
        <button class="btn btn-xs btn-default ml-a  " @click="toggleDislike"  >
            <span class="glyphicon glyphicon-thumbs-down like-icon" :class="dislikeClass">&nbsp;{{ dislikesCount }}</span>
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
                //isDesliked:false
                isLiked:  this.thread.isLiked,
                isDesliked:  this.thread.isDesliked,
                likesCount:this.thread.likesCount,
                dislikesCount:this.thread.dislikesCount
            }
        },

        computed: {
            likeClass(){
                return [
                    this.isLiked ? 'blue-icon' : 'black-icon'
                ];
            },
            dislikeClass(){
                return [
                    this.isDesliked ? 'red-icon' : 'black-icon'
                ];
            },
        },

        methods: {
            toggleDislike(){
                axios.post('/thread/' + this.thread.id + '/dislikes').then((res)=>{
                    if(this.isDesliked){
                        this.isDesliked = false;
                        this.dislikesCount--;

                    }else{
                        this.isDesliked = true;
                        if(this.isLiked){
                            this.likesCount--;
                        }
                        this.dislikesCount++

                    }
                    this.isLiked=false;
                });
            },
            toggleLike(){
                axios.post('/thread/' + this.thread.id + '/likes').then((res)=>{
                    if(this.isLiked){
                        this.isLiked = false;
                        this.likesCount--;
                    }else{
                        this.isLiked = true;
                        if(this.isDesliked){
                            this.dislikesCount--;
                        }
                        this.likesCount++
                    }
                    this.isDesliked=false;
                });
            },

        }
    }
</script>