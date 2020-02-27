<template>
    <li class="dropdown" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <span class="glyphicon glyphicon-bell"></span> <span style="color:red;font-weight:bold;font-size:16px" >{{ notifications.length }}</span>
        </a>

        <ul class="dropdown-menu" v-if="notifications.length">
            <li v-for="notification in notifications" >
                <a :href="notification.data.link"
                   v-text="notification.data.message"
                   @click="markAsRead(notification)"
                ></a>
            </li>


        </ul>
        <ul class="dropdown-menu" v-else>
            <li>
                <a href="#">No Notification</a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },

        created() {
            axios.get('/profiles/' + window.App.user.username + '/notifications')
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.username + '/notifications/' + notification.id)
            }
        }
    }
</script>
