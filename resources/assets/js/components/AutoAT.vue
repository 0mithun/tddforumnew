<template>
    <at-ta :members="members">
        <textarea class="editor" v-text="text"></textarea>
    </at-ta>
</template>

<script>
    import AtTa from 'vue-at/dist/vue-at-textarea'

    export default {
        components: { AtTa },
        data () {
            return {
                text: 'Hello World! @Roxie Miles .\n@grace.carroll @小浩 lol',
                members: ['Roxie Miles', 'grace.carroll', '小浩']
            }
        }
    }
</script>