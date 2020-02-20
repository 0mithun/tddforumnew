<template>
    <div class="form-group">
        <input type="text" name="channel_id" id="channel_id"  class="form-control" autocomplete="off" placeholder="Enter your channel" v-on:keyup="getResults()" v-model="channel_name">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="(result, index) in results" :key="index">{{result.name}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                channel_name: '',
                results: []
            }
        },
        methods:{
            getResults(){
                this.results = [];
                axios.post('/channel/search', {
                    channel_name: this.channel_name
                }).then((res)=>{
                    console.log(res)
                    res.data.forEach((channel)=>{
                        this.results.push(channel)
                    })
                })
            }
        }
    }
</script>