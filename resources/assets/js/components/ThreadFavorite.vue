<template>
    <nav class="level is-mobile">
        <div class="level-left">
            <a class="level-item">
                <span class="icon is-small"><i class="fas fa-reply"></i></span>
            </a>
            <a class="level-item">
                <span class="icon is-small"><i class="fas fa-retweet"></i></span>
            </a>
            <a class="level-item" @click="toggle">
                <span class="icon is-small"><i class="fas fa-heart"></i></span>
            </a>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "thread-favorite",

        props: ['thread'],

        data() {
            return {
                favoritesCount: this.thread.favoritesCount,
                isFavorited: this.thread.isFavorited,
            }
        },

        computed: {
            classes() {
                return ['btn', this.isFavorited ? 'btn-primary' : 'btn-default'];
            },

            endpoint() {
                return '/threads/' + this.thread.slug + '/favorites';
            },
        },

        methods: {
            toggle() {
                return this.isFavorited ? this.destory() : this.create();
            },

            destory() {
                axios.delete(this.endpoint);
                this.isFavorited = false;
                this.favoritesCount--;
            },

            create() {
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.favoritesCount++;
            },
        }
    }
</script>

<style scoped>

</style>