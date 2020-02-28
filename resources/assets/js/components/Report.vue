<template>
  <div>
      <div v-if=report>
          <h4>Hello Report</h4>
      </div>

      <button type="submit" class="btn btn-danger" @click="makeReport">
         <span class=" glyphicon glyphicon-ban-circle"></span>
          <span v-text="count"></span>
      </button>


  </div>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
                report: false,
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            makeReport() {
                this.report = true;
               // alert('Are you sure to report this reply')
            },

            create() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            },

            destroy() {
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            }
        }
    }
</script>