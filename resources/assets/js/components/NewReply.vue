<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <!--<wysiwyg name="body" v-model="body" placeholder="Have something to say?"-->
                <!--:shouldClear="completed"></wysiwyg>-->
                <textarea name="body" id="body" v-model="body" cols="30" rows="10" class="form-control"
                          placeholder="دیدگاه خود را درباره ی این تحلیل بیان کنید..."></textarea>

            </div>
            <div class="form-group">
                <button type="submit" class="btn" @click="addReply">ارسال</button>
            </div>
        </div>
        <div v-else>
            <p class="text-center">برای ارسال نظر <a href="/login">وارد</a> شوید
            </p>
        </div>
    </div>
</template>

<script>

    import 'at.js';
    import 'jquery.caret';

    export default {
        name: "new-reply",

        data() {
            return {
                body: '',
                completed: false,
            }
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON("/api/users", {name: query}, function (usernames) {
                            callback(usernames);
                        });
                    }
                }
            });
        },

        methods: {

            addReply() {
                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(response => {
                        this.body = '';
                        this.completed = true;
                        noty('success', 'دیدگاه شما با موفقیت ثبت شد.');
                        this.$emit('created', response.data);
                    })
                    .catch(error => {
                        noty('error', error.response.data.message);
                    })
                ;
            },

        },
    }
</script>

<style scoped>

</style>