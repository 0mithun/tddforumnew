<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';
    import Editor from '@tinymce/tinymce-vue'

    export default {
        props: ['thread'],

        components: {Replies, SubscribeButton, Editor,  },

        data () {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                channel_id : this.thread.channel_id,
                title: this.thread.title,

                body: this.thread.body,
                location: this.thread.location,
                is_famous:this.thread.is_famous,
                main_subject: this.thread.main_subject,
                image_path:null,
                allow_image: this.thread.allow_image,
                selectFile: null,
                formData: new FormData,
                form: {},
                editing: false,

                model: '',
                states: [],
                report: false,
                report_reason: ''

            };
        },

        created () {
            this.resetForm();
            this.channelTypeHead();
        },


        methods: {
            reportReply(){
                this.report = true;
            },
            makeReport(){
                axios.post('/threads/report',{
                    id: this.thread.id,
                    reason:this.report_reason,
                }).then((res=>{

                    this.report =false;
                    this.thread.isReportd = true;
                }));
            },
            channelTypeHead(){
                this.states = [];
                axios.post('/channel/search', {
                    channel_name: this.channel_name
                }).then((res)=>{
                    res.data.forEach((channel)=>{
                        this.states.push(channel)
                    })
                });
            },
            toggleLock () {
                let uri = `/locked-threads/${this.thread.slug}`;

                axios[this.locked ? 'delete' : 'post'](uri);

                this.locked = ! this.locked;
            },
            checked(){
                return (this.form.is_famous == 1 );
            },
            updateChecked(){
                this.form.is_famous = !this.form.is_famous;

            },
            onFileSelected(event){
                this.selectFile = event.target.files[0];
                console.log(this.selectFile);

                this.formData.append('image_path', this.selectFile);
            },
            appendData(){
                this.formData.append('title', this.form.title);
                this.formData.append('channel_id', this.form.channel_id);
                this.formData.append('body', this.form.body);
                this.formData.append('is_famous', this.form.is_famous);
                this.formData.append('source', this.form.source);
                this.formData.append('location', this.form.location);
                this.formData.append('main_subject', this.form.main_subject);
            },
            update () {
                this.appendData();
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;


                axios.post(uri, this.formData).then(() => {
                    this.editing = false;
                    this.channel_id = this.form.channel_id,
                    this.title = this.form.title;
                    this.body = this.form.body;
                    this.is_famous = this.form.source;
                    this.location = this.form.location;
                    this.is_famous = this.form.is_famous;
                    this.main_subject = this.form.main_subject;
                    this.source = this.form.source;
                    this.image_path = this.form.image_path;
                    this.allow_image = this.form.allow_image;


                    flash('Your thread has been updated.');
                })
            },

            resetForm () {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                    channel_id: this.thread.channel_id,
                    location: this.thread.location,
                    source: this.thread.source,
                    is_famous: this.thread.is_famous,
                    main_subject: this.thread.main_subject,
                    image_path: null,
                    allow_image: false,
                };

                this.editing = false;
            }
        }
    }
</script>
