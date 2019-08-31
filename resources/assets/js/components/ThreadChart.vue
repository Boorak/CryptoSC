<template>
    <div>
        <div id="tv_chart_container"></div>
    </div>
</template>

<script>
    export default {

        name: "thread-chart",

        props: ['thread'],

        data() {
            return {}
        },

        created() {

            let vm = this;

            function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            TradingView.onready(function () {
                var widget = window.tvWidget = new TradingView.widget({
                    // debug: true, // uncomment this line to see Library errors and warnings in the console
                    fullscreen: false,
                    symbol: 'AAPL',
                    interval: 'D',
                    container_id: "tv_chart_container",
                    //	BEWARE: no trailing slash is expected in feed URL
                    datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo_feed.tradingview.com"),
                    library_path: "/chart/charting_library/",
                    locale: getParameterByName('lang') || "en",
                    //	Regression Trend-related functionality is not implemented yet, so it's hidden for a while
                    drawings_access: {type: 'black', tools: [{name: "Regression Trend"}]},
                    disabled_features: ["use_localstorage_for_settings", "header_widget", "timeframes_toolbar", "left_toolbar"],
                    enabled_features: ["study_templates"],
                    charts_storage_url: 'http://saveload.tradingview.com',
                    charts_storage_api_version: "1.1",
                    client_id: 'tradingview.com',
                    user_id: 'public_user_id',
                    width: '100%',
                });

                widget.onChartReady(function () {

                    widget.load(vm.thread.analysis.analysis_data);

                });

            });

        },
    }

</script>

<style scoped>

</style>