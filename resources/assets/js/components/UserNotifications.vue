<template>
    <li class="dropdown" v-if="notifications.length">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false" @click="showNotificationModal = true">
            <i :data-count="notifyCount" class="glyphicon glyphicon-bell notification-icon"></i>
        </a>
        <div class="modal is-active" v-if="showNotificationModal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="card" v-for="notification in notifications">
                    <div class="card-content">
                        <a :href="notification.data.link" @click="markAsRead(notification)">
                            {{notification.data.message}}
                        </a>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click="showNotificationModal = false"></button>
        </div>
    </li>
</template>

<script>
    export default {

        name: "user-notifications",

        data() {
            return {
                notifications: false,
                showNotificationModal: false,
            }
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data)
            ;
        },

        methods: {

            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
                this.showNotificationModal = false;
            },

        },

        computed: {

            notifyCount() {
                return this.notifications.length;
            }

        }
    }
</script>

<style scoped>

</style>