<template>
    <section>
        <label for="input">Channel:</label>
        <input id="input" class="form-control" type="text" placeholder="Enter channel name">
        <typeahead v-model="model" target="#input" :data="channels" item-key="name"/>
    </section>
</template>
<script>
    import {Typeahead} from 'uiv'
    //import states from '../../assets/data/states.json'

    export default {
        components: {Typeahead},
        data () {
            return {
                model: '',
                target:null,
                channels:null,
                states: [
                    {
                        'name': 'Alabama',
                        'abbr': 'Al'
                    }
                ]
            }
        },
        created(){
          this.fetchChannel();
        },
        methods:{
            fetchChannel(){
                let url  = '/channel/search';
                axios.post('/channel/search')
                    .then((res=>{
                        console.log(res)
                        this.channels = res.data
                }));
            }
        }
    }
</script>
<!-- typeahead-example.vue -->