<template>

</template>

<script>


    window.noty = function (type, msg) {
        new Noty({
            type: type,
            layout: 'bottomRight',
            theme: 'mint',
            text: msg,
            timeout: 3000,
        }).show();
    };

    export default {
        name: "noty"
    }
</script>

<style scoped>

</style>