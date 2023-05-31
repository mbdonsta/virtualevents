<template>
    <div class="yt-video">
        <youtube-media
            :player-vars="player_vars"
            :video-id="video_id"
            @ended="ended"
            @paused="paused"
            @playing="playing"
        ></youtube-media>
    </div>
</template>

<script>
export default {
    props: [
        "room_id",
        "video_id"
    ],
    data: function () {
        return {
            is_playing: false,
            seconds_played: 0,
            event: {},
            video_was_watched: false,
            seconds_in_room: 0,
            player_vars: {
                start: 0
            },
            not_showing: false
        };
    },
    mounted() {

    },
    created() {
        this.interval = setInterval(() => this.getDurations(), 1000);
        // this.watched_interval = setInterval(() => this.updateWatched(), 60000);
    },
    methods: {
        playing(event) {
            console.log(event);
            this.is_playing = true;
            this.player_vars.start = 0 - event.target.getDuration();
            this.event = event;
        },
        paused() {
            this.is_playing = false;
        },
        ended() {
            this.is_playing = false;
        },
        getDurations() {
            this.seconds_in_room++;
            if (this.is_playing) {
                this.seconds_played++;
                let current = this.formatDurations(this.event.target.getCurrentTime());
                let duration = this.formatDurations(this.event.target.getDuration());
                let percentage = (this.event.target.getCurrentTime() * 100) / this.event.target.getDuration();
                console.log("Playing: " + current + "/" + duration + "(" + percentage.toFixed(2) + "%)");
                this.checkWatchedStatus();
            }
        },
        formatDurations(seconds) {
            let sec_num = parseInt(seconds, 10); // don't forget the second param
            let hours = Math.floor(sec_num / 3600) < 10 ? "0" + Math.floor(sec_num / 3600) : Math.floor(sec_num / 3600);
            let minutes = Math.floor((sec_num - hours * 3600) / 60) < 10 ? "0" + Math.floor((sec_num - hours * 3600) / 60) : Math.floor((sec_num - hours * 3600) / 60);
            let secs = (sec_num - hours * 3600 - minutes * 60) < 10 ? "0" + (sec_num - hours * 3600 - minutes * 60) : sec_num - hours * 3600 - minutes * 60;
            let result = hours + ":" + minutes + ":" + secs;

            return result;
        },
        checkWatchedStatus() {
            var percentage = (this.seconds_played * 100) / this.event.target.getDuration();

            if (percentage > 90) {
                this.video_was_watched = true;
            }
        },
        updateWatched() {
            if (this.is_playing) {
                axios.get("/users/conf_watched?r=" + this.room_id + "&s=" + this.seconds_played)
                    .then(resp => {
                        this.seconds_played = 0;
                    });
            }
        }
    }
};
</script>
