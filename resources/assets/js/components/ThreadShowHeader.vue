<template>
    <section class="hero is-primary is-bold">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column">
                        <div class="content">
                            <h3 class="has-text-white">
                                {{title}}
                            </h3>
                            <div class="is-inline-flex is-black">
                                <div class="tags has-addons">
                                    <span class="tag is-light">
                                        <span class="icon has-text-black">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </span>
                                    <span class="tag is-info">
                                        {{threadVisitsCount}}
                                    </span>
                                </div>
                                <div class="tags has-addons mg-r-5">
                                    <span class="tag is-light">
                                        <span class="icon has-text-black">
                                           <i class="fas fa-trophy"></i>
                                        </span>
                                    </span>
                                    <span class="tag is-info">
                                        {{thread.owner.reputation}}
                                    </span>
                                </div>
                                <div class="mg-r-5">
                                    <p class="has-text-light">
                                        {{thread.created_at | ago}}
                                    </p>
                                </div>
                                <div class="is-clearfix"></div>
                            </div>
                            <p>
                                <button class="button is-white" @click="copy">آدرس تحلیل</button>
                            </p>
                        </div>
                    </div>
                    <div class="column is-narrow">
                        <div class="box">
                            <article class="media">
                                <figure class="media-left">
                                    <p class="image is-64x64">
                                        <a :href="profileLink">
                                            <img :src="thread.owner.avatar_path" :alt="thread.owner.name">
                                        </a>
                                    </p>
                                </figure>
                                <div class="media-content">
                                    <div class="content">
                                        <p>
                                            <a :href="profileLink">{{thread.owner.name}}</a>
                                            <small>@{{thread.owner.name}}</small>
                                            <br>
                                            <span class="text-muted">{{thread.owner.created_at | ago}}</span> عضویت
                                        </p>
                                    </div>
                                    <thread-favorite :thread="thread"></thread-favorite>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import ThreadFavorite from './ThreadFavorite.vue'
    import filters from './../mixins/filters';
    import VueClipboard from 'vue-clipboard2'

    Vue.use(VueClipboard);

    export default {
        name: "thread-show-header",

        components: {ThreadFavorite},

        mixins: [filters],

        props: ['thread', 'threadVisitsCount'],

        data() {
            return {
                title: this.thread.title,
            }
        },

        created() {

            Event.$on('ThreadUpdated', (data) => {
                this.title = data.title;
            })
            ;

        },

        methods: {
            copy() {
                let link = window.location.href;
                this.$copyText(link).then(function (e) {
                    Swal({
                        title: "عملیات موفق",
                        text: "لینک تحلیل با موفقیت ذخیره شد.",
                        icon: "success",
                        button: "خروج",
                    });
                }, function (e) {
                    Swal({
                        title: "عملیات ناموفق",
                        text: "خطایی پیش آمده است.",
                        icon: "error",
                        button: "خروج",
                    });
                })
            },
        },

        computed: {

            profileLink() {
                return "/profiles/" + this.thread.owner.name;
            }

        }


    }
</script>

<style scoped>

</style>