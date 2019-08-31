export default {

    filters: {
        ago(time) {
            Moment.locale('fa');
            return Moment(time).startOf('hour').fromNow();
        },
    }

}