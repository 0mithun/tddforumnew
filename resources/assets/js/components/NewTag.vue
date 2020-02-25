<template>
    <div class="panel-body" style="padding-top: 0px">
        <table class="table table-bordered table-hover table-responsive table-bordered">
            <thead>
            <tr>
                <th style="width: 80%;">Tag Name</th>
                <th >Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(tag, index) in tags" :key="index">
                <td>
                    {{ tag.name }}
                </td>
                <td style="text-align:center">
                    <button class="btn btn-default btn-sm" @click="editTag(tag.id, tag.name)">Edit</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="edit">
            <h3>Update Tag</h3>
            <div class="form-group">
                <label for="name" class="control-label">Tag Name: </label>
                <input type="text" name="name" class="form-control" id="name" v-model="name">
            </div>
            <button type="submit"
                    class="btn btn-primary"
                    @click="updateTag">Update</button>
            <button type="submit"
                    class="btn btn-danger"
                    @click="cancelEdit">Cancel</button>

        </div>
        <div v-else>
            <h3>Add New Tag</h3>
            <div class="form-group">
                <label for="name" class="control-label">Tag Name: </label>
                <input type="text" name="name" class="form-control" id="name" v-model="name">
            </div>
            <button type="submit"
                    class="btn btn-primary"
                    @click="addTag">Add New</button>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name:'',
                tags:null,
                edit:false,
                editId: null
            };
        },
        created(){
            this.fetchTags();
        },

        mounted() {
        },

        methods: {
            cancelEdit(){
              this.name = '';
              this.edit = false;
            },
            updateTag(){
                    axios.post('/admin/tags/update', { name: this.name,id:this.editId })
                    .then(({data}) => {
                        this.name = '';
                        this.fetchTags()
                        flash('Tag Update Successfully')
                        this.edit = false;
                    });

            },
            editTag(id, name){
                this.edit = true;
                this.name = name;
                this.editId = id;
            },
            fetchTags(){
                axios.get('/tags')
                    .then(({data}) => {
                        this.tags = data
                    });
            },
            addTag() {
                axios.post('/admin/tags/add', { name: this.name })
                    .then(({data}) => {
                        this.name = '';
                        this.fetchTags()
                        flash('Tag Added Successfully')
                    });
            }
        }
    }
</script>
