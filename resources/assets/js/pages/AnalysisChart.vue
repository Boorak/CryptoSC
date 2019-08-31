<template>
    <div>
        <div id="tv_chart_container"></div>
        <a v-if="signedIn" class="float" @click="showModal = true">
            <i class="fa fa-plus my-float" id="v-step-0"></i>
        </a>
        <a href="/login" class="float" v-else>
            <i class="fas fa-sign-in-alt my-float"></i>
        </a>
        <div class="label-container">
            <div class="label-text">ثبت آنالیز</div>
        </div>
        <div class="modal is-active" v-if="showModal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">تحلیل</p>
                    <button class="delete" aria-label="close" @click="showModal = false"></button>
                </header>
                <section class="modal-card-body">
                    <div v-if="isSaveClicked">
                        <div v-if="imageUrl">
                            <p class="content">{{message}}</p>
                            <figure class="image">
                                <img :src="imageUrl" alt="نحلیل ارز دیجیتال">
                            </figure>
                        </div>
                        <div v-else class="loader">
                        </div>
                    </div>
                    <div v-else>
                        <p>در صورت اطمینان از تحلیل خود گزینه ارسال، و در غیر این صورت گزینه انصراف را کلیک کنید.</p>
                        <a href="/" class="is-size-7">بازگشت به صفحه ی اصلی</a>
                    </div>

                </section>
                <footer class="modal-card-foot">
                    <button class="button is-primary" @click="add" v-if="!analysisId">ارسال</button>
                    <button class="button mr-1" @click="showModal = false" v-if="!analysisId">انصراف</button>
                    <a :href="threadUrl" class="button is-success mr-1" v-if="analysisId">بعدی</a>
                </footer>
            </div>
            <button class="modal-close is-large" aria-label="close" @click="showModal = false"></button>
        </div>
        <v-tour name="analysis-chart" :steps="steps"></v-tour>
    </div>
</template>

<script>

    import VueTour from 'vue-tour';

    require('vue-tour/dist/vue-tour.css');

    export default {

        name: "analysis-chart",

        data() {

            return {

                showModal: false,
                analysisImageUrl: '',
                isSaveClicked: false,
                message: '',
                analysisId: '',

                steps: [
                    {
                        target: '#v-step-0',  // We're using document.querySelector() under the hood
                        content: 'با استفاده از این دکمه می توانید تحلیل خود را ثبت کنید.',
                        params: {
                            placement: 'left'
                        }
                    },
                ],

            };

        },

        mounted: function () {
            this.$tours['analysis-chart'].start()
        },

        created() {

            this.onChartReady();

        },

        methods: {

            onChartReady() {

                TradingView.onready(this.prepareWidget);

            },

            prepareWidget() {

                let widget = window.tvWidget = new TradingView.widget({
                    // debug: true, // uncomment this line to see Library errors and warnings in the console
                    fullscreen: true,
                    symbol: 'AAPL',
                    interval: 'D',
                    container_id: "tv_chart_container",
                    //	BEWARE: no trailing slash is expected in feed URL
                    datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo_feed.tradingview.com"),
                    library_path: "/chart/charting_library/",
                    locale: this.getParameterByName('lang') || "en",
                    //	Regression Trend-related functionality is not implemented yet, so it's hidden for a while
                    drawings_access: {type: 'black', tools: [{name: "Regression Trend"}]},
                    disabled_features: ["use_localstorage_for_settings"],
                    enabled_features: ["study_templates"],
                    charts_storage_url: 'http://saveload.tradingview.com',
                    charts_storage_api_version: "1.1",
                    client_id: 'tradingview.com',
                    user_id: 'public_user_id'
                });
            },

            getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            },

            add() {

                this.isSaveClicked = true;

                const vm = this;

                tvWidget.onChartReady(function () {

                    tvWidget.chart().executeActionById('takeScreenshot');

                    tvWidget.subscribe("onScreenshotReady", (url) => {

                        vm.analysisImageUrl = url;

                        tvWidget.save(function (data) {

                            let params = {

                                analysis_data: data,
                                image_url: url,

                            };

                            axios.post('/analysis/chart', params).then((response) => {

                                console.log(response.data);
                                vm.analysisId = response.data.analysis_id;
                                vm.message = "تحلیل شما با موفقیت ثبت شد. لطفا برای ادامه گزینه بعدی را کلیک کنید.";


                            }).catch((error) => {
                                vm.message = "خطایی پیش آمده است.";
                            });

                        });

                    });

                });

            },

        },


        computed: {

            imageUrl() {

                return this.analysisImageUrl ? 'https://www.tradingview.com/x/' + this.analysisImageUrl : '';
            },

            threadUrl() {
                return '/threads/create?analysis_id=' + this.analysisId;
            }

        },
    }
</script>

<style scoped>

</style>

