<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';
    import Wysiwyg from '../components/Wysiwyg'

    export default {
        props: ['thread'],

        components: {Replies, SubscribeButton, Wysiwyg },

        data () {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                title: this.thread.title,
                body: this.thread.body,
                location: this.thread.location,
                is_famous:this.thread.is_famous,
                main_subject: this.thread.main_subject,
                image_path:this.thread.image_path,
                allow_image: this.thread.allow_image,
                form: {},
                editing: false
            };
        },

        created () {
            this.resetForm();
        },

        methods: {
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

            update () {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.title = this.form.title;
                    this.body = this.form.body;
                    this.source = this.form.source;
                    this.location = this.form.location;
                    this.is_famous = this.form.is_famous;
                    this.main_subject = this.form.main_subject;
                    this.image_path = this.form.image_path;
                    this.allow_image = this.form.allow_image;


                    flash('Your thread has been updated.');
                })
            },

            resetForm () {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                    location: this.thread.location,
                    source: this.thread.source,
                    is_famous: this.thread.is_famous,
                    main_subject: this.thread.main_subject,
                    image_path: this.thread.image_path,
                    allow_image: false,
                };

                this.editing = false;
            }
        }
    }
</script>
