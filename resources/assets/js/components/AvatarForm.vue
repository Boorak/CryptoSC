<template>
    <div>
        <div class="column">
            <img :src="avatar" :alt="user.name" class="mr-1 img-responsive img-rounded img-avatar">
        </div>
        <div class="column mr-1">
            <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
                <image-upload name="avatar" @loaded="onLoad"></image-upload>
            </form>
        </div>
    </div>
</template>

<script>

    import ImageUpload from './ImageUpload.vue';

    export default {
        name: "avatar-form",

        components: {ImageUpload},

        props: ['user'],


        data() {
            return {
                avatar: this.user.avatar_path,
            }
        },

        methods: {

            onLoad(avatar) {

                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {

                let data = new FormData();
                data.append('avatar', avatar);
                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => noty('success','پروفایل با موفقیت ویرایش شد.'));
            },

        },

        computed: {

            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },

        },

    }
</script>

<style scoped>

</style>