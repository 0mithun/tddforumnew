<template>
    <section>
        <h3 id="test">Hello</h3>
        <label for="input">Choose a channel:</label>
        <input  id="input"  class="form-control" type="text" placeholder="Type to search..." v-on:input="testing()">
        <typeahead v-model="model" target="#input" :data="states" item-key="name"/>
        <alert v-show="model">You selected {{model.id}}</alert>

        <input type="text" name="channel_id" id="channel_id"  v-model="model.id" :data-channel-id="model.id">


    </section>
</template>
<script>
    //import states from '../../assets/data/states.json'

    export default {
        name: 'Typehead' ,
        data () {
            return {
                model: '',
                states: [],
                channel_id: 'aaa'
            }
        },
        created() {
            this.states = [];
            axios.post('/channel/search', {
                channel_name: this.channel_name
            }).then((res)=>{
                res.data.forEach((channel)=>{
                    this.states.push(channel)
                })
            })
        },
        methods: {
            testing(){
                // console.log();
                let channel = $('#channel_id')
            }
        }
    }
</script>

<style>

</style>