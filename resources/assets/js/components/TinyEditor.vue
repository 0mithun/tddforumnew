<template>
    <editor
            v-model="model"

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

</template>

<script>
    import Editor from '@tinymce/tinymce-vue'
    export  default {
        props: [ 'model'],
        components: {
            Editor,
        },
    }
</script>