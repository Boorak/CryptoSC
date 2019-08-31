<template>
    <div class="section">
        <div class="field">
            <label class="label">آدرس تحلیل یا تصویر (اختیاری)</label>
            <div class="control">
                <input class="input" type="text" name="image_url" v-model="url" @keyup="attach">
            </div>
            <p class="help">در صورت نیاز به تصویر تحلیل با مراجعه به صفحه نمودار و کپی کردن آدرس تصویر در این قسمت،
                تصویر تحلیل شما در قسمت کامنت نمایش خواهد داده شد. <a href="/analysis/chart">(نمودار)</a>
            </p>
        </div>
        <div v-if="isComment">
            <div class="field">
                <label class="label">توضیحات</label>
                <div class="control">
                    <textarea class="textarea" name="body" v-model="body"></textarea>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-info" @click="add">ثبت کامنت</button>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="field">
                <figure class="image">
                    <img :src="imageUrl" alt="نحلیل ارز دیجیتال">
                </figure>
            </div>
            <div class="field">
                <div class="control">
                    <textarea class="textarea" v-model="body" placeholder="توضیحات..."></textarea>
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-info" @click="add">ثبت تحلیل</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        name: "new-threads-comment",

        props: ['thread'],

        data() {
            return {
                url: '',
                body: '',
                attachedThread: '',
                isComment: true,
            }
        },

        methods: {

            attach() {
                axios.get(this.url + '/attach')
                    .then(response => {
                        this.attachedThread = response.data;
                        this.isComment = false;
                    }).catch(error => {
                    this.isComment = true;
                });
            },

            add() {

                let data = this.prepareData();

                axios.post(`/analysis/${this.thread.slug}/comment`, data)
                    .then(response => {
                        Event.$emit('addComment', {comment: response.data.comment});
                        noty('success', response.data.message);
                    })
                    .catch(error => {
                        noty('error', error.response.data.message);
                    })
                ;
            },

            prepareData() {

                if (this.attachedThread) {
                    return {
                        image_url: this.imageUrl,
                        body: this.body,
                        thread_url: this.url,
                    };
                } else {
                    return {
                        image_url: this.url,
                        body: this.body,
                    };
                }

            }
        },

        computed: {
            imageUrl() {
                return 'https://www.tradingview.com/x/' + this.attachedThread.analysis.image_url;
            },
        }

    }
</script>

<style scoped>

</style>