<template>
    <draggable v-model="banners" class="room-banners" @end="reorderBanners()">
        <transition-group>
            <div v-for="(banner, index) in banners" v-if="banner.banner_image_url" :key="banner.id"
                 class="banner-item">
                <button class="remove-item" @click="deleteBanner(banner, index)">
                    <i class="las la-times"></i>
                </button>
                <div class="image-holder">
                    <img :src="banner.banner_image_url" alt="">
                </div>
            </div>
        </transition-group>
    </draggable>
</template>

<script>
import draggable from 'vuedraggable';

export default {
    components: {
        draggable
    },
    props: [
        'banners_json',
        'reorder_route'
    ],
    data: function () {
        return {
            banners: this.banners_json ? JSON.parse(this.banners_json) : []
        };
    },
    mounted() {
    },
    methods: {
        deleteBanner(banner, index) {
            axios.post(banner.delete_route, {})
                .then(resp => {
                    this.banners.splice(index, 1);
                })
        },
        reorderBanners() {
            axios.post(this.reorder_route, {
                banners: this.banners
            });
        }
    }
};
</script>
