<template>
    <div :id="'reply-'+id" class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left" v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
                <div class="media-content is-clipped">
                    <div class="content is-pulled-right">
                        <div class="is-inline-flex">
                            <p class="is-size-6 text-muted">
                                نوشته شده توسط
                                <!--<span v-text="ago"></span>-->
                                <a :href="'/profiles/'+reply.owner.name">
                                    {{reply.owner.name}}
                                </a>
                            </p>
                            <span class="is-size-6 text-muted mr-1by2">
                                {{reply.created_at | ago}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="media-right">
                    <figure class="image is-32x32">
                        <img :src="reply.owner.avatar_path" :alt="reply.owner.name">
                    </figure>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <!--<textarea class="form-control" v-model="body" required></textarea>-->
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>
                    <button class="btn btn-xs btn-primary">آپدیت</button>
                    <button class="btn btn-xs btn-link" @click="resetForm" type="button">خروج</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>
        <div class="panel-footer level" v-if="authorize('owns',reply) || authorize('owns',reply.thread)">
            <div v-if="authorize('owns',reply)">
                <a class="mr-1 has-text-primary" @click="editing = true">
                    <i class="fas fa-edit"></i>
                </a>
                <a class="mr-1 has-text-danger" @click="destroy">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
            <a class="mr-1 ml-a has-text-warning" @click="markBestReply"
               v-show="!isBest" v-if="authorize('owns',reply.thread)">
                <i class="fas fa-star"></i>
            </a>
        </div>
    </div>
</template>

<script>

    import Favorite from './Favorite.vue';
    import filters from './../mixins/filters'

    export default {
        name: "reply",
        props: ['reply'],
        components: {Favorite},
        mixins: [filters],

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            }
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {

            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body,
                }).catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editing = false;
            },

            destroy() {
                axios.delete('/replies/' + this.id);
                this.$emit('deleted', this.id);

                // $(this.$el).fadeOut(300, () => {
                //     flash('Your reply has been deleted.');
                // });
            },

            markBestReply() {

                this.isBest = true;

                axios.post(`/replies/${this.id}/best`);

                window.events.$emit('best-reply-selected', this.id);
            },

            resetForm() {
                this.editing = false;
                this.body = this.reply.body;
            }
        },

    }
</script>

<style scoped>

</style>